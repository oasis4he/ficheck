// remove fields or add datepicker (mm/dd/yyyy) - jquery UI
// monthly tracking hide categories link
// delete button on right side of category field (removes row)
// reset button on monthly tracker, with are you sure dialog
// stage for george

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
          result = liability.val() / asset.val();
        } else if(wrapper.hasClass('financial-ratio-type-debt-payment-to-income')) {
          result = liability.val() / asset.val();
        }
      }

      if(result) {
        result = Math.round(result * 100) / 100;
        ratio.val(result);
      }
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

(function($){
  $(function(){
    
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
  monthlyTrackingContainer.on('change', '.row:not(.new) input', function(){
    var form = $(this).closest('form');

    var changed = false;
    $('input', form).each(function(){
        changed = this.value != this.defaultValue;

        return !changed; // return if at least one control has changed value
    });

    if(changed) {
      form.addClass('changed');
    }

    if(form.hasClass('changed') && form.find('[name=date]').val() && (form.find('[name=in]').val() || form.find('[name=out]').val())) {
      var form = $(this).closest('form');
      var data = form.serialize();

      $.ajax({
        url: form.action,
        data: data,
        method: "post",
        success: function() {
          form.removeClass('changed');

          if(form.hasClass('new')) {
            form.removeClass('new');
          }
        }
      });
    }
  });

  // track the active form (show controls via css)
  monthlyTrackingContainer.on('focus', 'form input', function() {
    monthlyTrackingContainer.find('form').removeClass('active');

    $(this).closest('form').addClass('active');
  });
}(jQuery));


(function($){
  $(function(){
    var retirementGoals = $('.retirement-needs-type-annual-savings-required');

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
