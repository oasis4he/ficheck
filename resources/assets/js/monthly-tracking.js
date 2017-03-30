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
  monthlyTrackingContainer.on('blur', 'form', function(){
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

            var entry = `<form method="post" class="edit">
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
                        form.remove();
                      } else {
                        form[0].reset();
                      }

                      return false;
                    }
                  });

                  if(!inserted){
                    panel.find('.panel-collapse .panel-body .body').append(entry);
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
                     form.remove();
                   } else {
                     form[0].reset();
                   }

                   inserted = true;

                   return false;
                 }
               });
               if(!inserted) {
                 newPanel.find('.panel-body .body').append(entry);
                 $('.panel-group').append(newPanel);

                 if(form.hasClass('edit')){
                   form.remove();
                 } else {
                   form[0].reset();
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

        },
        error: function(e) {
          $('#errorModal .modal-title').text('Error Updating Entry');
          $('#errorModal .modal-body p').text(e.message);
          $('#errorModal').modal('show');
        }
      });
    }
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
    $('#trackedMonthDropdown').html($(this).text() + "<i class='fa fa-chevron-down dropdown-caret' aria-hidden='true'></i>");

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

  monthlyTrackingContainer.on('change', '[name=out]', getExpenseCategories);

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




}(jQuery));
