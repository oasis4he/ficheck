(function($){
  $(function(){

    var planned = "planned";
    var actual = "actual";
    var difference = "difference";
    var active = "active";

    var activeClass = "planned";

    //whether the page only should show actual
    var onlyActual = $(".budget-view").hasClass("onlyActual") ? true : false;

    if (onlyActual)
    {
      activeClass = "actual";
    }

    sumSections();

    //loop through all sections and sum
    function sumSections()
    {
      var sections = $(".monthly-budget-type");
      $.each(sections, function(index, section){
        $.each($(section).find(".valueType"), function(index, element){
          sumTotal($(element));
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
      var plannedRow = $(".budget-view ." + planned + ".valueType[data-record-id='" + recordId + "']");
      var actualRow = $(".budget-view ." + actual + ".valueType[data-record-id='" + recordId + "']");
      var differenceRow = $(".budget-view ." + difference + ".valueType[data-record-id='" + recordId + "']");

      //get planned and actual values
      var plannedValue = plannedRow.find(".valueInput").val();
      var actualValue = actualRow.find(".valueInput").val();

      //update difference value based on planned and actual values
      differenceRow.find(".valueInput").val(plannedValue - actualValue);

      sumTotal(row);
      sumTotal(differenceRow);
    });

    //function to sum total for a type
    function sumTotal(element)
    {
      var type = getType (element);
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

    //editable labels
    $(".budget-view").on("click", ".editLabel", function(){
      var inputId = $(this).attr("input-id");
      var recordId = $(this).attr("record-id");
      var editableContainer = $(this).closest(".editable");
      var value = editableContainer.find("label[for='" + inputId + "']").text().trim();

      $(this).toggleClass("glyphicon-ok");
      $(this).toggleClass("glyphicon-pencil");

      if (editableContainer.find("input").length) {
        editableContainer.find(".input-group").toggle();
        editableContainer.find("label").toggle();
        editableContainer.find("label").text(editableContainer.find("input").val());
      }
      else
      {
        editableContainer.find(".input-group").show();
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
      var rowTypes = [
        "planned",
        "actual",
        "difference"
      ];

      var category = getCategoryForSave(thisElement);
      var type = getTypeForSave(thisElement);

      var recordId =  "new_" + category + "_" + type + "_" + newInputCount;

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
         clone.find("input").attr("name", "names[" + recordId + "][" + inputId + "][values]");

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
    //calculate totals
    var actualIncomeInputs = $(".ficheck-section-type[data-type='income'] .valueType.actual .valueInput");
    var actualExpenseInputs = $(".ficheck-section-type[data-type='expense'] .valueType.actual .valueInput");
    var incomeTotal = 0;
    var expenseTotal = 0;

    $.each(actualIncomeInputs, function(index, input) {
      console.log($(input).val());
      incomeTotal += Number($(input).val());
    });


    $("#incomeTotal").val(incomeTotal.toFixed(2));

    $.each(actualExpenseInputs, function(index, input) {
      expenseTotal += Number($(input).val());
    });

    $("#expenseTotal").val(expenseTotal.toFixed(2));

    $("#netTotal").val((incomeTotal - expenseTotal).toFixed(2));
  }




}(jQuery));
