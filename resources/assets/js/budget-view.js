(function($){
  $(function(){

    var planned = "planned";
    var actual = "actual";
    var difference = "difference";
    var active = "active";

    var activeClass = "planned";

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
      var plannedValue = plannedRow.find("input").val();
      var actualValue = actualRow.find("input").val();

      //update difference value based on planned and actual values
      differenceRow.find("input").val(plannedValue - actualValue);

      sumTotal(row);
      sumTotal(differenceRow);
    });

    //function to sum total for a type
    function sumTotal(element)
    {
      var type = getType (element);
      var monthlyBudgetType = element.parents(".monthly-budget-type");

      var inputsToUpdate = monthlyBudgetType.find(".valueType." + type);

      var total = 0;

      $.each(inputsToUpdate, function(index, input){
        var inputTotal = Number($(input).find(".valueInput").val());
        total += inputTotal;
      });

      var totalInput = monthlyBudgetType.find("." + type + " .totalInput");

      totalInput.val(total.toFixed(2));
    }

    //editable labels
    $(".budget-view").on("click", ".editLabel", function(){
      var inputId = $(this).attr("input-id");
      var recordId = $(this).attr("record-id");
      var editableContainer = $(this).closest(".editable");
      var value = editableContainer.find("label[for='" + inputId + "']").text().trim();
      $(this).text() == "Edit" ? $(this).text("Finished Editing") : $(this).text("Edit");

      if (editableContainer.find("input").length) {
        editableContainer.find("input").toggle();
        editableContainer.find("label").toggle();
        editableContainer.find("label").text(editableContainer.find("input").val());
      }
      else
      {
        editableContainer.append("<input type='text' name='names[" + recordId + "]' value='" + value + "' class='form-control'>");
        editableContainer.find("label").hide();
      }

    });

    //Add new field
    var newInputCount = 0;
    $(".budget-view").on("click", ".newItem", function(event){
       event.preventDefault()
       //Set up Planned row
       var planned = $(this).closest(".monthly-budget-type").find(".valueTypeTemplate").clone();
       var recordId =  "new_" + newInputCount;
       var inputId = "new_" + 0;
       planned.attr("data-record-id", recordId);
       planned.find("label").attr("for", "value_" + inputId);
       planned.find("button").attr("record-id", recordId);
       planned.find("button").attr("input-id", "value_" + inputId);
       planned.find("input").attr("id", "value_" + inputId);
       planned.find("input").attr("name", "newValues[" + recordId + "][" + inputId + "]");
       planned.addClass("planned");
       planned.removeClass("valueTypeTemplate");
       $(this).before(planned);

       //Set up actual Row
       var actual = $(this).closest(".monthly-budget-type").find(".valueTypeTemplate").clone();
       inputId = "new_" + 1;
       actual.addClass("actual");
       actual.removeClass("valueTypeTemplate");
       actual.attr("data-record-id", recordId);
       actual.find("label").attr("for", "value_" + inputId);
       actual.find("button").attr("record-id", recordId);
       actual.find("button").attr("input-id", "value_" + inputId);
       actual.find("input").attr("id", "value_" + inputId);
       actual.find("input").attr("name", "newValues[" + recordId + "][" + inputId + "]");
       $(this).before(actual);

       //Set up difference row
       var difference = $(this).closest(".monthly-budget-type").find(".valueTypeTemplate").clone();
       inputId = "new_" + 2;
       difference.addClass("difference");
       difference.removeClass("valueTypeTemplate");
       difference.attr("data-record-id", recordId);
       difference.find("label").attr("for", "value_" + inputId);
       difference.find("button").attr("record-id", recordId);
       difference.find("button").attr("input-id", "value_" + inputId);
       difference.find("input").attr("id", "value_" + inputId);
       difference.find("input").attr("name", "newValues[" + recordId + "][" + inputId + "]");
       difference.find("input").attr("readonly", "readonly");
       $(this).before(difference);

       //add active to active class
       $(".valueType." + activeClass).addClass(active);
       var newRow = $(".valueType." + activeClass + "[data-record-id='" + recordId + "']");
       newRow.find("input").focus();
       newRow.show();

      newInputCount++;
    });

    //hide empty fields
    $(".budget-view").on("click", ".hide-empty-fields", function(){
      event.preventDefault()

      var rows = $(this).closest(".monthly-budget-type").find(".valueType");
      $.each(rows, function(index, row) {
        var rowVal = $(row).find("input").val();
        if(rowVal == "" || rowVal == 0)
        {
          $(row).hide();
        }
      })
    });

    //show all fields
    $(".budget-view").on("click", ".show-all-fields", function(){
      event.preventDefault()

      var rows = $(this).closest(".monthly-budget-type").find(".valueType." + activeClass).show();

    })

  });
}(jQuery));
