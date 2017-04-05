// remove fields or add datepicker (mm/dd/yyyy) - jquery UI
// monthly tracking hide categories link
// delete button on right side of category field (removes row)
// reset button on monthly tracker, with are you sure dialog
// stage for george


//http://stackoverflow.com/questions/15762768/javascript-math-round-to-two-decimal-places
  function roundTo(n, digits) {
     if (digits === undefined) {
       digits = 0;
     }

     var multiplicator = Math.pow(10, digits);
     n = parseFloat((n * multiplicator).toFixed(11));
     var test =(Math.round(n) / multiplicator);
     return +(test.toFixed(2));
   }

   function roundedValue(number) {
     var value = roundTo(number, 2);
     if((value.toString().split('.')[1] || []).length == 1){
       value = value + "0";
     }
     return value;
   }

   $('body').on('change', '[type=number]', function() {

     $(this).val(roundedValue($(this).val()));

   });

(function($){
  $(function(){

    var planned = "planned";
    var actual = "actual";
    var difference = "difference";
    var active = "active";

    var activeClass = "planned";

    //whether the page only should show actual
    var revolvingSavings = $(".budget-view").hasClass("revolving-savings") ? true : false;
    var onlyActual = $(".budget-view").hasClass("onlyActual") ? true : false;

    if (onlyActual)
    {
      activeClass = "actual";
    }

    sumSections();
    sumStatementSections();

    //loop through all sections and sum
    function sumSections()
    {
      var sections = $(".monthly-budget-type");
      $.each(sections, function(index, section){
        $.each($(section).find(".valueType .valueContainer"), function(index, element){
          sumTotal($(element));
        })
      });
    }

    function sumStatementSections() {
      var sections = $(".monthly-budget-type");
      $.each(sections, function(index, section){
        $.each($(section).find(".valueType"), function(index, element){
          sumStatmentTotal($(element));
        })
      });
    }

    //determine whether an element is planned actual or difference
    function getType (element)
    {
      if($(element).hasClass(planned))
      {
        return planned;
      }
      else if($(element).hasClass(actual))
      {
        return actual;
      }
      else if($(element).hasClass(difference))
      {
        return difference;
      }
    }

    // Toggle Planned actual and active inputs
    $(".budget-view").on("click", ".toggleBudgetInputs", function(){

      $(".valueType, .valueTypeTotal, .toggleBudgetInputs").removeClass(active);

      $(this).removeClass("toggleBudgetInputs");
      activeClass = $(this).attr("class");
      $(this).addClass("toggleBudgetInputs");

      var type = getType(this);

      $(".valueType." + type + ", .valueTypeTotal." + type + ", .toggleBudgetInputs." + type).addClass(active);

    });

    //on input change of planned or actual update the value of difference
    $(".budget-view").on("change", ".valueInput", function(){
      //get the record id of the changed input's parent row
      var row = $(this).parents(".valueType");
      var recordId = $(row).attr("data-record-id");
      //get planned, actual and difference rows
      var plannedRow = $(".budget-view .valueType[data-record-id='" + recordId + "'] ." + planned );
      var actualRow = $(".budget-view .valueType[data-record-id='" + recordId + "'] ." + actual);
      var differenceRow = $(".budget-view .valueType[data-record-id='" + recordId + "'] ." + difference );

      //get planned and actual values
      var plannedValue = plannedRow.find(".valueInput").val();
      var actualValue = actualRow.find(".valueInput").val();

      //update difference value based on planned and actual values
      var differenceValue = roundedValue(plannedValue - actualValue);

      differenceRow.find(".valueInput").val(differenceValue);

      sumSections();
      sumStatementSections();
    });

    //function to sum total for a type
    function sumTotal(element)
    {
      var type = getType (element);
      if(type)
      {
        var monthlyBudgetType = element.closest(".monthly-budget-type");

        var inputsToUpdate = monthlyBudgetType.find(".valueType ." + type);

        var total = 0;

        $.each(inputsToUpdate, function(index, input){
          var inputTotal = Number($(input).find(".valueInput").val());
          total += inputTotal;
        });

        var totalInput = monthlyBudgetType.find("." + type + " .totalInput");

        totalInput.val(total.toFixed(2));
      }

    }

    //editable labels
    $(".budget-view").on("click", ".editLabel", function(){
      var inputId = $(this).attr("input-id");
      var recordId = $(this).attr("record-id");
      var editableContainer = $(this).closest(".editable");
      var value = editableContainer.find("label[for='" + inputId + "']").text().trim();

      $(this).toggleClass("glyphicon-ok");
      $(this).toggleClass("glyphicon-pencil");

      if (editableContainer.find("input").length) {
        editableContainer.find(".input-group").toggleClass("deleteShow");
        editableContainer.find("label").toggle();
        editableContainer.find("label").text(editableContainer.find("input").val());
      }
      else
      {
        editableContainer.find(".input-group").toggleClass("deleteShow");
        editableContainer.find(".input-group").prepend("<input type='text' name='names[" + recordId + "][name]' value='" + value + "' class='form-control'>");
        editableContainer.find("label").hide();
      }

      editableContainer.find("input").focus().select();

    });

    //delete field
    $(".budget-view").on("click", ".editable .deleteRow", function(event){
      var recordId = $(this).attr("data-record-id");

      //if it is an id that needs to be deleted from db (not new_id)
      if (!isNaN(parseFloat(recordId)) && isFinite(recordId))
      {
        var hiddenInput = "<input type='hidden' value='" + recordId + "' name=deletedIds[]>";
        $(".budget-view").append(hiddenInput);
      }

      //remove row from html
      $(".valueType[data-record-id='" + recordId + "']").remove();
    });

    //Add new field
    var newInputCount = 0;

    $(".budget-view").on("change", ".newItem", function(event){
      addNewRows(this);
    });

    $(".budget-view").on("click", ".newItem", function(event){
      event.preventDefault();
      addNewRows(this);
    });

    function getCategoryForSave(element)
    {
      return $(element).closest(".ficheck-section-type").attr("data-category");
    }

    function getTypeForSave(element)
    {
      return $(element).closest(".ficheck-section-type").attr("data-type");
    }

    function addNewRows(thisElement)
    {
      if (onlyActual)
      {
        var rowTypes = ["actual"];
      }
      else
      {
        var rowTypes = [
          "planned",
          "actual",
          "difference"
        ];
      }


      var category = getCategoryForSave(thisElement);
      var type = getTypeForSave(thisElement);

      if (revolvingSavings)
      {
        var month = $(thisElement).closest(".month").attr("data-month");

        var recordId =  "new_" + month + "_" + newInputCount;
      }
      else
      {
        var recordId =  "new_" + category + "_" + type + "_" + newInputCount;
      }

      for (var i = 0; i < rowTypes.length; i++) {
         var inputId = rowTypes[i] + "_" + newInputCount;

         var template = $(thisElement).closest(".monthly-budget-type").find(".valueTypeTemplate");
         template.find("input").attr("value", $(thisElement).find("input").val());
         $(thisElement).find("input").val("");

         var clone = $(thisElement).closest(".monthly-budget-type").find(".valueTypeTemplate").clone();

         clone.attr("data-record-id", recordId);
         clone.find("label").attr("for", "value_" + inputId);
         clone.find(".deleteRow").attr("data-record-id", recordId);
         clone.find(".editLabel").attr("record-id", recordId);
         clone.find(".editLabel").attr("input-id", "value_" + inputId);
         clone.find("input").attr("id", "value_" + inputId);

         if (!revolvingSavings)
         {
           clone.find("input").attr("name", "names[" + recordId + "][" + inputId + "][values]");
         }
         else
         {
           clone.find("input").attr("name", "names[" + recordId + "][value]");
         }


         if (rowTypes[i] == "difference")
         {
           clone.find("input").attr("readonly", "readonly");
         }

         //Set up  row to clone
         clone.removeClass("valueTypeTemplate");
         clone.addClass(rowTypes[i]);
         $(thisElement).before(clone);

         template.find("input").removeAttr("readonly");

      }

      //add active to active class
      $(".valueType." + activeClass).addClass(active);
      var newActiveRow = $(".valueType." + activeClass + "[data-record-id='" + recordId + "']");
      newActiveRow.find(".editLabel").click();
      newActiveRow.show();
      newActiveRow.find(".valueInput").trigger("change");

      newInputCount++;
    }

    //update corresponding hidden inputs/labels as you update a label
    $(".budget-view").on("change", ".editable input", function() {
      var newValue = $(this).val();
      var row = $(this).closest(".valueType");
      var recordId = row.attr("data-record-id");

      //find all rows with this record id and change their values
      var matchingRows = $(".valueType[data-record-id='" + recordId + "']");
      matchingRows.find(".editable label").text(newValue);
      matchingRows.find(".editable input").val(newValue);

    })


    //hide empty fields
    $(".budget-view").on("click", ".hide-empty-fields", function(){
      event.preventDefault()

      var rows = $(this).closest(".monthly-budget-type").find(".valueType." + activeClass);
      $.each(rows, function(index, row) {
        var rowVal = $(row).find("input[type='number']").val();
        if((rowVal == "" || rowVal == 0))
        {
          $(row).slideUp("fast");
        }
      })
    });

    //show all fields
    $(".budget-view").on("click", ".show-all-fields", function(){
      event.preventDefault()

      var rows = $(this).closest(".monthly-budget-type").find(".valueType." + activeClass).slideDown("fast");

    })

  });

  //If this page is readonly (income and expense)
  var isReadOnly = $(".budget-view").hasClass("readonly") ? true : false;

  if (isReadOnly)
  {
    //hide editing controls and make inputs readonly
    $(".budget-view input").attr("readonly", "readonly");
    $(".budget-view .editLabel").hide();
  }

  //if we should calculate totals do it
  if ($(".budget-sums").length)
  {
    var revolvingSavings = $(".budget-view").hasClass("revolving-savings") ? true : false;

    if (revolvingSavings)
    {
      $(".ficheck-section-type").on("change", ".valueInput", function() {

          var allInputs = $(".ficheck-section-type .valueType.actual .valueInput");
          var yearlyTotal = 0;

          $.each(allInputs, function(index, input) {
            yearlyTotal += Number($(input).val());
          });

          $("#perYearTotal").val(yearlyTotal.toFixed(2));
          $("#perMonthTotal").val((yearlyTotal/12).toFixed(2));
      });

      $(".valueInput").trigger("change");

    }
    else
    {
      $(".ficheck-section-type").on("change", ".valueInput", function() {

        //calculate totals
        var actualIncomeInputs = $(".ficheck-section-type[data-type='income'] .valueType.actual .valueInput");
        var actualExpenseInputs = $(".ficheck-section-type[data-type='expense'] .valueType.actual .valueInput");
        var incomeTotal = 0;
        var expenseTotal = 0;

        $.each(actualIncomeInputs, function(index, input) {
          incomeTotal += Number($(input).val());
        });


        $("#incomeTotal").val(incomeTotal.toFixed(2));

        $.each(actualExpenseInputs, function(index, input) {
          expenseTotal += Number($(input).val());
        });

        $("#expenseTotal").val(expenseTotal.toFixed(2));

        $("#netTotal").val((incomeTotal - expenseTotal).toFixed(2));

      });

      $(".valueInput").trigger("change");

    }

  }

  //function to sum total for a type
  function sumStatmentTotal(element)
  {
    var type = 'actual';
    if(type)
    {
      var monthlyBudgetType = element.closest(".monthly-budget-type");

      var inputsToUpdate = monthlyBudgetType.find(".valueType." + type);

      var total = 0;

      $.each(inputsToUpdate, function(index, input){
        var inputTotal = Number($(input).find(".valueInput").val());
        total += inputTotal;
      });

      var totalInput = monthlyBudgetType.find("." + type + " .totalInput");

      totalInput.val(total.toFixed(2));
    }

  }


}(jQuery));

(function($){
  $(function(){
    // store the financialGoalsContainer
    var financialGoalsContainer = $('.financial-goals');

    // handler for the add tracking record control
    financialGoalsContainer.on('click', 'a[href=#add]', function(e){
      var goalWrapper = $(this).closest('.financial-goal-type');
      var goals = goalWrapper.find('.body').last();
      var template = goalWrapper.find('.template');
      var newRecord = template.find('form').clone();

      if(!goals.length) {
        console.log('no goals for you');
        goals = $('<div class="body"/>');
        template.before(goals);
      }

      newRecord.addClass('new');

      goals.append(newRecord);

      newRecord.find('input:visible').first().trigger('focus');

      $(this).remove();

      return false;
    });

  });
}(jQuery));

(function($){
  $(function(){
    // store the financialGoalsContainer
    var financialRatiosContainer = $('.financial-ratios');

    $('.ficheck-section-type', financialRatiosContainer).on('change', 'input', function() {
      var wrapper = $(this).closest('.ficheck-section-type');
      var asset = wrapper.find('[name=asset]');
      var liability = wrapper.find('[name=liability]');
      var ratio = wrapper.find('[name=ratio]');
      var result;

      if(asset.val() && liability.val()) {
        if(wrapper.hasClass('financial-ratio-type-basic-liquidity')) {
          result = asset.val() / liability.val();
        } else if(wrapper.hasClass('financial-ratio-type-debt-to-asset')) {
          result = asset.val() / liability.val();
        } else if(wrapper.hasClass('financial-ratio-type-debt-payment-to-income')) {
          result = liability.val() / asset.val();
        }
      }

      if(result) {
        result = Math.round(result * 100) / 100;
        ratio.val(result);
      }
    });

    financialRatiosContainer.on('change', 'input', function() {

      $(this).val(roundedValue($(this).val()));

    });

  });
}(jQuery));

(function($){
  $(function(){
    var ficheckSections = $('.ficheck-sections');

    ficheckSections.on('click', 'a[href=#expand]', function(e){
      $('.body,[href=#add]', ficheckSections).slideDown();

      return false;
    });

    ficheckSections.on('click', 'a[href=#collapse]', function(e){
      $('.body,[href=#add]', ficheckSections).slideUp();

      return false;
    });

    ficheckSections.on('click', 'h2', function(e){
      $('.body,[href=#add]', $(this).closest('.ficheck-section-type')).slideToggle();

      return false;
    });

    var helpControls = $('.help-controls', ficheckSections).on('click', 'a', function(){
      var ratioElement = $(this).closest('.financial-section-type');
      var row = $(this).closest('.row');
      var description = row.find('.description')

      $('.help-controls .hide', row).removeClass('hide');
      $(this).addClass('hide');

      if($(this).attr('href').search('show')>=0) {
        description.show();
      } else {
        description.hide();
      }

      return false;
    });
  });
}(jQuery));

(function($) {
    $(function() {
        var graderModeEnabled = $('.grader-mode-enabled');

        var modalHtml = '<div class="modal fade" tabindex="-1" role="dialog">  <div class="modal-dialog">    <div class="modal-content">      <div class="modal-header">        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        <h4 class="modal-title">Review Mode</h4>      </div>      <div class="modal-body">        <p>You cannot save anything while viewing another user\'s data.</p>      </div>      <div class="modal-footer">        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>        <a type="button" class="btn btn-primary" href="/">Exit Review Mode</a>      </div>    </div><!-- /.modal-content -->  </div><!-- /.modal-dialog --></div><!-- /.modal -->';

        var modal = $(modalHtml).appendTo('body');

        $('form', graderModeEnabled).on('submit', function(e) {
            e.stopPropagation();
            e.preventDefault();

            $(modal).modal({backdrop: false});

            return false;
        });
    });
})(jQuery);

(function($){
  $(function(){
    $('.toggleBudgetInputs.actual').trigger('click');
  });
}(jQuery));

(function($){
  // store the monthlyTrackingContainer
  var monthlyTrackingContainer = $('.monthly-tracking')

  // handler for the add tracking record control
  // monthlyTrackingContainer.on('click', 'button.add', function(e){
  //   var currentRecord = $(this).closest('form');
  //   var newRecord = currentRecord.clone();
  //
  //   $(':input', newRecord).val('').removeAttr('disabled').closest('form').removeClass('changed');
  //
  //   currentRecord.after(newRecord);
  //
  //   newRecord.find('input:visible').first().trigger('focus');
  //
  //   return false;
  // });

  // disable in/out if other if filled in  (only one or the other should be active)
  monthlyTrackingContainer.on('change', '[name=in],[name=out]', function(){
    var form = $(this).closest('form');

    var sibling = form.find('[name=in],[name=out]').not(this);

    if($(this).val()) {
      sibling.attr('disabled', true);
    } else {
      sibling.removeAttr('disabled');
    }
  }).find('[name=in],[name=out]').trigger('change');

  // if an input changes and the form is valid, submit it via ajax
  monthlyTrackingContainer.on('blur', '.edit', function(){
    var form = $(this).closest('form');
    var changed = false;
    $('input', form).each(function(){
        changed = this.value != this.defaultValue;

        return !changed; // return if at least one control has changed value
    });

    if(changed) {
      form.addClass('changed');
    }

    if(form.hasClass('changed') && form.find('[name=date]').val() && (form.find('[name=in]').val() || form.find('[name=out]').val()) && form.find('[name=category]').val()) {
      saveEntry(form, false, false);
    }
  });

  monthlyTrackingContainer.on('click', '[href=#add]', function(){

    var form = $(this).closest('form');

    saveEntry(form, true, true);

  });

  monthlyTrackingContainer.on('click', '[href=#newEntryModal]', function(){

    $('.clicked').removeClass('clicked');
    $(this).addClass('clicked');

  });

  monthlyTrackingContainer.on('click', '[href=#delete]', function(){
    var form = $(this).closest('form');
    var id = form.find('[name=id]').val();

    $.ajax({
      url: '/monthly-tracking/delete/' + id,
      method: "get",
      success: function() {

        if(!form.siblings('form').length) {
          form.closest('.monthly-tracking-section').remove();
        }

        form.next().find('[name=date]').focus();
        form.remove();

      },
      error: function(e) {
        $('#errorModal .modal-title').text('Error Deleting Entry');
        $('#errorModal .modal-body p').text(e.message);
        $('#errorModal').modal('show');
      }
    });
  })

  // track the active form (show controls via css)
  monthlyTrackingContainer.on('focus', 'form input', function() {
    monthlyTrackingContainer.find('form').removeClass('active');

    $(this).closest('form').addClass('active');
  });

  // track the active form (show controls via css)
  monthlyTrackingContainer.on('focus', 'form [name=category]', function() {
    var form = $(this).closest('form');

    if(form.find('[name=in]').val()) {
      getIncomeCategories();
    }

    if(form.find('[name=out]').val()) {
      getExpenseCategories();
    }

    $(this).closest('form').addClass('active');
  });

  $('.dropdown-menu a').click(function() {
    var collapse = $(this).attr('href');
    $(collapse).collapse('show');
    $('.panel-collapse:not('+collapse+')').collapse('hide');
    $('#trackedMonthDropdown').html($(this).find('span:not(.hide)').text() + "<i class='fa fa-chevron-down dropdown-caret' aria-hidden='true'></i>");

    $('html, body').animate({
        scrollTop: $(collapse).offset().top
    }, 1000);
  });

  $('.page-monthly-tracking a[href=#collapse]').click(function(){
    $('.monthly-tracking .panel-collapse').collapse('hide');
  });

  $('.page-monthly-tracking a[href=#expand]').click(function(){
    $('.monthly-tracking .panel-collapse').collapse('show');
  });

  monthlyTrackingContainer.on('change', '[name=in]', function() {

    var value = roundTo($(this).val(), 2);
    if((value.toString().split('.')[1] || []).length == 1){
      value = value + "0";
    }
    $(this).val(value);

    getIncomeCategories();
  });

  monthlyTrackingContainer.on('change', '[name=out]', function() {

    var value = roundTo($(this).val(), 2);
    if((value.toString().split('.')[1] || []).length == 1){
      value = value + "0";
    }
    $(this).val(value);

    getIncomeCategories();
  });

  function getExpenseCategories() {
    $.ajax({
      url: "/categories/expense",
      method: "get",
      dataType: 'json',
      success: function(data) {
        $( "[name=category]" ).autocomplete({
          source: data
        });
      }
    });
  }

  function getIncomeCategories() {
    $.ajax({
      url: "/categories/income",
      method: "get",
      dataType: 'json',
      success: function(data) {
        $( "[name=category]" ).autocomplete({
          source: data
        });
      }
    });
  }

//http://stackoverflow.com/questions/15762768/javascript-math-round-to-two-decimal-places
  function roundTo(n, digits) {
     if (digits === undefined) {
       digits = 0;
     }

     var multiplicator = Math.pow(10, digits);
     n = parseFloat((n * multiplicator).toFixed(11));
     var test =(Math.round(n) / multiplicator);
     return +(test.toFixed(2));
   }


   function saveEntry(form, addForm, closeModal) {
     var data = form.serialize();

     $.ajax({
       url: form.action,
       data: data,
       method: "post",
       dataType: "json",
       success: function(data) {
         form.removeClass('changed');

         if(form.hasClass('new')) {
           form.removeClass('new');
         }

         var month = form.find('[name=month_id]').val();
         var monthName = '';


         if(data.records.tracked_month.id != month) {
           var panel = $('#' + data.records.tracked_month.id)

           var entry = `<form method="post" class="edit active">
             <input class="form-control" name="_token" type="hidden" value="`+ form.find('[name=_token]').val()+`">

             <input class="form-control" name="id" type="hidden" value="`+ data.records.id +`">
             <input class="form-control" name="month_id" type="hidden" value="`+ data.records.month_id +`">

             <div class="row">
               <div class="col-xs-4"><input class="form-control" name="date" type="date" aria-labelledby="dateTrack" value="`+ data.records.occurred_at+`"></div>
               <div class="col-xs-2"><input class="form-control" name="in" type="text" aria-labelledby="inTrack" value="`+ (parseFloat(data.records.value) > 0 ? parseFloat(data.records.value) : "") +`"></div>
               <div class="col-xs-2"><input class="form-control" name="out" type="text" aria-labelledby="inTrack" value="`+ (parseFloat(data.records.value) < 0 ? parseFloat(data.records.value) : "") +`"></div>
               <div class="col-xs-4"><input class="form-control" name="category" type="text" aria-labelledby="categoryTrack" value="`+ data.records.category +`"></div>
               <div class="control">
                 <a href="#delete" class="btn btn-danger delete" class="submit">Delete</a>
               </div>
             </div>
           </form>`;

           var newPanel = $(`<div class="panel panel-default monthly-tracking-section" id="` + data.records.month_id + `">
           <span class="panel-month hide">` + data.records.tracked_month.month + `</span>
           <span class="panel-year hide">` + data.records.tracked_month.year + `</span>
           <div class="panel-heading">
             <h4 class="panel-title">
               <a data-toggle="collapse" data-parent="#accordion" href="#`+ data.months[data.records.tracked_month.month] +``+data.records.tracked_month.year+`" aria-expanded="false" class="collapsed">
                 `+ data.months[data.records.tracked_month.month] +` `+data.records.tracked_month.year+`</a>
                 <!-- Trigger the modal with a button -->
                 <a type="button" class="pull-right" data-toggle="modal" data-target="#newEntryModal"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
               </h4>
             </div>
             <div id="`+ data.months[data.records.tracked_month.month] +``+data.records.tracked_month.year+`" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
               <div class="panel-body">
                 <div class="row header">
                   <div class="col-xs-4" id="dateTrack">Date</div>
                   <div class="col-xs-2" id="inTrack">In</div>
                   <div class="col-xs-2" id="outTrack">Out</div>
                   <div class="col-xs-4" id="categoryTrack">Category</div>
                 </div>

                 <div class="body"></div>

               </div>
             </div>
           </div>`);


           if(panel.length){
             var inserted = false;
               if(data.records.tracked_month.id != month) {
                 panel.find('form').each(function(index) {
                   if(data.records.occurred_at >= $(this).find('[name=date]').val()) {
                     $(this).before(entry);
                     inserted = true;

                     if(form.hasClass('edit')){
                       form.next().find('[name=date]').focus();
                       form.remove();
                     } else {
                       form[0].reset();
                       form.find('input:disabled').removeAttr('disabled');
                     }

                     return false;
                   }
                 });

                 if(!inserted){
                   panel.find('.panel-collapse .panel-body .body').append(entry);
                   form.next().find('[name=date]').focus();
                   form.remove();
                 }
               }
           } else {
             var inserted = false;
             var dropdownItem = false;
              $('.panel-month').each(function(index) {
                if(data.records.tracked_month.month > $(this).text() && data.records.tracked_month.year == $(this).siblings('.panel-year').text()) {
                  newPanel.find('.panel-body .body').append(entry);
                  $(this).closest('.panel').before(newPanel);

                  if(form.hasClass('edit')){
                    form.next().find('[name=date]').focus();
                    form.remove();
                  } else {
                    form[0].reset();
                    form.find('input:disabled').removeAttr('disabled');
                  }

                  inserted = true;

                  return false;
                }
              });
              if(!inserted) {
                newPanel.find('.panel-body .body').append(entry);
                $('.panel-group').append(newPanel);

                if(form.hasClass('edit')){
                  form.next().find('[name=date]').focus();
                  form.remove();
                } else {
                  form[0].reset();
                  form.find('input:disabled').removeAttr('disabled');
                }
              }

              $('.dropdown-item').each(function(index){
                if(data.records.tracked_month.month > $(this).find('.dropdown-month').text() && data.records.tracked_month.year == $(this).find('.dropdown-year').text()) {
                  $(this).before(`<a  class="dropdown-item" data-parent="#accordion" href="`+ data.months[data.records.tracked_month.month] +``+data.records.tracked_month.year +`{{$trackedMonth->year}}">
                    <span class="dropdown-month hide">`+data.records.tracked_month.month+`</span>
                    <span class="dropdown-year hide">`+data.records.tracked_month.year+`</span>
                      `+ data.months[data.records.tracked_month.month] +` `+ data.records.tracked_month.year+`
                  </a>`);

                  dropdowmItem = true;
                }
              });

              if(!dropdownItem) {
                $('.dropdown-menu').append(`<a  class="dropdown-item" data-parent="#accordion" href="`+ data.months[data.records.tracked_month.month] +``+data.records.tracked_month.year +`{{$trackedMonth->year}}">
                  <span class="dropdown-month hide">`+data.records.tracked_month.month+`</span>
                  <span class="dropdown-year hide">`+data.records.tracked_month.year+`</span>
                    `+ data.months[data.records.tracked_month.month] +` `+ data.records.tracked_month.year+`
                </a>`)
              }
          }
         }

         if(addForm) {
           form.find('[name=date]').focus();

         }

         if(closeModal) {
           $('#newEntryModal').modal('hide');
           $('.clicked').focus();
           $('.clicked').removeClass('clicked');
         }
       },
       error: function(e) {
         $('#errorModal .modal-title').text('Error Updating Entry');
         $('#errorModal .modal-body p').text(e.message);
         $('#errorModal').modal('show');
       }
     });

   }


}(jQuery));


(function($){
  $(function(){
    var expenses = $('.life-insurance-type-expenses');

    $(expenses).on('change', 'input', function() {
        var wrapper = $(this).closest('.ficheck-sections');

        var funeralExpense = wrapper.find("[name=funeral_expenses]").val();
        var debt = wrapper.find("[name=debt]").val();
        var otherExpenses = wrapper.find("[name=other_expenses]").val();

        var enteredTotalIncomeForReplacement = $('[name=entered_total_income_replacement]').val();

        var totalExpenses = wrapper.find('[name=total_expenses]');
        var totalExpensesValue = roundedValue(Number(funeralExpense) + Number(debt) + Number(otherExpenses) + Number(enteredTotalIncomeForReplacement));
        totalExpenses.val(totalExpensesValue);

        var enteredTotalExpenses = $('[name=entered_total_expenses]');
        enteredTotalExpenses.val(totalExpenses.val());
        enteredTotalExpenses.trigger("change");

    });

  });
}(jQuery));


(function($){
  $(function(){
    var fundsFromOtherSources = $('.life-insurance-type-other-sources');
    $(fundsFromOtherSources).on('change', 'input', function() {
        var wrapper = $(this).closest('.ficheck-section-type');

        var governmentBenefits = (wrapper.find('[name=government_benefits]').val());
        var otherFunds = (wrapper.find('[name=other_funds]').val());

        var totalFundsFromOtherSources = (wrapper.find('[name=total_funds_from_other_sources]'));
        var totalFundsValue = roundedValue(Number(governmentBenefits) + Number(otherFunds))
        totalFundsFromOtherSources.val(totalFundsValue);

        var enteredTotalFundsFromOtherSources = $('[name=entered_total_funds_from_other_sources]');
        enteredTotalFundsFromOtherSources.val(totalFundsFromOtherSources.val());
        enteredTotalFundsFromOtherSources.trigger("change");

    });

  });
}(jQuery));


(function($){
  $(function(){
    var insuranceNeeded = $('.life-insurance-type-insurance-needed');

    $(insuranceNeeded).on('change', 'input', function() {
        var wrapper = $(this).closest('.ficheck-section-type');

        var enteredTotalExpenses = wrapper.find('[name=entered_total_expenses]').val();
        var enteredTotalFundsFromOtherSources = wrapper.find('[name=entered_total_funds_from_other_sources]').val();

        var insuranceNeededValue = roundedValue(Number(enteredTotalExpenses) - Number(enteredTotalFundsFromOtherSources));

        wrapper.find("[name=insurance_needed]").val(insuranceNeededValue);
    });
  });
}(jQuery));

(function($){
  $(function(){
    var lifeInsurace = $('.life-insurance-type-income-replacement');
    var lifeInsuranceContainer = $('.life-insurance');

    $(lifeInsurace).on('change', 'input', function() {
        var wrapper = $(this).closest('.ficheck-section-type');

        var enteredAnnualIncome = (wrapper.find('[name=annual_income]').val() || 0) / 1;

        var insuranceNeeds = $('[name="insurance_needs"]', wrapper);

        var insureanceNeedValue = roundedValue(enteredAnnualIncome * .75);

        insuranceNeeds.val(insureanceNeedValue);

        var totalIncomeForReplacement = wrapper.find('[name=total_income_replacement]');
        var factorElement = $('[name="income_replacement_factor"]', wrapper);

        var totalIncomeReplacementValue = roundedValue(insuranceNeeds.val() * factorElement.val());

        totalIncomeForReplacement.val(totalIncomeReplacementValue);

        var enteredTotalIncomeForReplacement = $('[name=entered_total_income_replacement]');

        enteredTotalIncomeForReplacement.val(totalIncomeForReplacement.val());
        enteredTotalIncomeForReplacement.trigger("change");
    });

    $(lifeInsurace).on('change', 'select', function() {
        var wrapper = $(this).closest('.ficheck-section-type');

        var value = $(this).val();

        var factor = $(':selected', this).data('factor') / 1;

        var factorElement = $('[name="income_replacement_factor"]', wrapper);

        factorElement.val(factor).trigger('change');

    });

    lifeInsuranceContainer.on('change', 'input', function() {

      $(this).val(roundedValue($(this).val()));

    });

  });
}(jQuery));


(function($){
  $(function(){
    var retirementGoals = $('.retirement-needs-type-annual-savings-required');
    var retirementNeedsContainer = $('.retirement-needs');

    $(retirementGoals).on('change', 'input', function() {
        var wrapper = $(this).closest('.ficheck-section-type');

        var enteredretirementGoal = (wrapper.find('[name=entered_retirement_goal]').val() || 0) / 1;
        var enteredFutureValueOfSavingsAndInvestments = (wrapper.find('[name=entered_future_value_of_savings_and_investments]').val() || 0) / 1;
        var additionalSavingsNeededForRetirementElement = wrapper.find('[name=additional_savings_needed_for_retirement]');

        console.log(additionalSavingsNeededForRetirementElement);

        var additionalSavingsNeededForRetirement = enteredretirementGoal - enteredFutureValueOfSavingsAndInvestments;
        additionalSavingsNeededForRetirementElement.val(additionalSavingsNeededForRetirement);

        var factor = $('[name="entered_retirement_age_factor"]', wrapper).val();
        var goal = Math.round(additionalSavingsNeededForRetirement / factor * 100) / 100;

        var additionAnnualSavingsRequired = $('[name="addition_annual_savings_required"]', wrapper);
        additionAnnualSavingsRequired.val(goal);
    });

    $(retirementGoals).on('change', 'select', function() {
        var value = parseInt($(this).val(), 10);

        var factor = $(':selected', this).data('factor') / 1;

        var wrapper = $(this).closest('.row');
        var factorElement = $('[name="entered_retirement_age_factor"]', wrapper);

        factorElement.val(factor).trigger('change');
    });

    retirementNeedsContainer.on('change', 'input', function() {

      $(this).val(roundedValue($(this).val()));

    });

  });
}(jQuery));


(function($){
  $(function(){
    var futureSavingsInvestments = $('.retirement-needs-type-future-savings-investments');

    $(futureSavingsInvestments).on('change', 'input', function() {
        var wrapper = $(this).closest('.ficheck-sections');
        var currentValueSavingsAndInvestments = wrapper.find('[name=retirement_savings_and_investments]').val() / 1;

        var factor = $('[name="retirement_years_factor"]', wrapper).val();
        var goal = Math.round(currentValueSavingsAndInvestments * factor * 100) / 100;

        var futureValueSavingsAndInvestmentsElement = $('[name="future_value_of_savings_and_investments"]', wrapper);
        futureValueSavingsAndInvestmentsElement.val(goal);

        var annualSavingsFutureSavings = $('[name="entered_future_value_of_savings_and_investments"]');
        annualSavingsFutureSavings.val(goal);
    });

    $(futureSavingsInvestments).on('change', 'select', function() {
        var factor = $(':selected', this).data('factor');

        var wrapper = $(this).closest('.row');
        var factorElement = $('[name="retirement_years_factor"]', wrapper);

        factorElement.val(factor).trigger('change');
    });

  });
}(jQuery));


(function($){
  $(function(){
    var retirementGoals = $('.retirement-needs-type-retirement-goal');

    $(retirementGoals).on('change', 'input', function() {
        var wrapper = $(this).closest('.ficheck-section-type');

        var annualIncome = (wrapper.find('[name=annual_income]').val() || 0) / 1;
        var annualSsBenefit = (wrapper.find('[name=annual_ss_benefit]').val() || 0) / 1;
        var annualEmployerBenefit = (wrapper.find('[name=annual_employer_benefit]').val() || 0) / 1;
        var additionalAnnualIncomeRequiredElement = wrapper.find('[name=additional_annual_income_required]');

        var additionalAnnualIncomeRequired = Math.round((annualIncome - annualSsBenefit - annualEmployerBenefit) * 100) / 100;
        additionalAnnualIncomeRequiredElement.val(additionalAnnualIncomeRequired);

        var factor = $('[name="retirement_age_factor"]', wrapper).val();
        var goal = Math.round(additionalAnnualIncomeRequired * factor * 100) / 100;

        var retirementGoal = $('[name="retirement_goal"]', wrapper);
        retirementGoal.val(goal);

        var annualSavingsRetirementGoal = $('[name="entered_retirement_goal"]');
        annualSavingsRetirementGoal.val(goal);
    });

    $(retirementGoals).on('change', 'select', function() {
        var value = parseInt($(this).val(), 10);

        var factor = $(':selected', this).data('factor') / 1;

        var wrapper = $(this).closest('.row');
        var factorElement = $('[name="retirement_age_factor"]', wrapper);

        factorElement.val(factor).trigger('change');
    });

  });
}(jQuery));


(function($){
  $(function(){
    var savingsInvestments = $('.retirement-needs-type-savings-investements');

    $(savingsInvestments).on('change', 'input', function() {
        var wrapper = $(this).closest('.ficheck-section-type');

        var currentValueEmployeeRetirementSavings = (wrapper.find('[name=employee_retirement_savings]').val() || 0) / 1;
        var currentValuePersonalRetirementSavings = (wrapper.find('[name=personal_retirement_savings]').val() || 0) / 1;
        var currentValueInvestments = (wrapper.find('[name=investements_value]').val() || 0) / 1;
        var currentValueSavingsAndInvestmentsElement = wrapper.find('[name=retirement_savings_and_investments]');

        var currentValueSavingsAndInvestments = Math.round((currentValueEmployeeRetirementSavings + currentValuePersonalRetirementSavings + currentValueInvestments) * 100) / 100;
        currentValueSavingsAndInvestmentsElement.val(currentValueSavingsAndInvestments);

        wrapper.next('.ficheck-section-type').find('[name="retirement_years_factor"]').trigger('change');
    });
  });
}(jQuery));

//# sourceMappingURL=app.js.map
