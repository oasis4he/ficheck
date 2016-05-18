// remove fields or add datepicker (mm/dd/yyyy) - jquery UI
// monthly tracking hide categories link
// delete button on right side of category field (removes row)
// reset button on monthly tracker, with are you sure dialog
// stage for george

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

        var enteredRetirmentGoal = (wrapper.find('[name=entered_retirment_goal]').val() || 0) / 1;
        var enteredFutureValueOfSavingsAndInvestments = (wrapper.find('[name=entered_future_value_of_savings_and_investments]').val() || 0) / 1;
        var additionalSavingsNeededForRetirementElement = wrapper.find('[name=additional_savings_needed_for_retirement]');

        console.log(additionalSavingsNeededForRetirementElement);

        var additionalSavingsNeededForRetirement = enteredRetirmentGoal - enteredFutureValueOfSavingsAndInvestments;
        additionalSavingsNeededForRetirementElement.val(additionalSavingsNeededForRetirement);

        var factor = $('[name="retirment_age_factor"]', wrapper).val();
        var goal = Math.round(additionalSavingsNeededForRetirement * factor * 100) / 100;

        var additionAnnualSavingsRequired = $('[name="addition_annual_savings_required"]', wrapper);
        additionAnnualSavingsRequired.val(goal);
    });

    $(retirementGoals).on('change', 'select', function() {
        var value = parseInt($(this).val(), 10);

        var factor = $(':selected', this).data('factor') / 1;

        var wrapper = $(this).closest('.row');
        var factorElement = $('[name="entered_retirment_age_factor"]', wrapper);

        factorElement.val(factor).trigger('change');
    });

  });
}(jQuery));


(function($){
  $(function(){
    var futureSavingsInvestments = $('.retirement-needs-type-future-savings-investments');

    $(futureSavingsInvestments).on('change', 'input', function() {
        var wrapper = $(this).closest('.ficheck-sections');
        var currentValueSavingsAndInvestments = wrapper.find('[name=current_value_savings_and_investments]').val() / 1;

        var factor = $('[name="retirment_years_factor"]', wrapper).val();
        var goal = Math.round(currentValueSavingsAndInvestments * factor * 100) / 100;

        var futureValueSavingsAndInvestmentsElement = $('[name="future_value_of_savings_and_investments"]', wrapper);
        futureValueSavingsAndInvestmentsElement.val(goal);
    });

    $(futureSavingsInvestments).on('change', 'select', function() {
        var factor = $(':selected', this).data('factor');

        var wrapper = $(this).closest('.row');
        var factorElement = $('[name="retirment_years_factor"]', wrapper);

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

        var additionalAnnualIncomeRequired = annualIncome - annualSsBenefit - annualEmployerBenefit;
        additionalAnnualIncomeRequiredElement.val(additionalAnnualIncomeRequired);

        var factor = $('[name="retirment_age_factor"]', wrapper).val();
        var goal = Math.round(additionalAnnualIncomeRequired * factor * 100) / 100;

        var retirmentGoal = $('[name="retirment_goal"]', wrapper);
        retirmentGoal.val(goal);
    });

    $(retirementGoals).on('change', 'select', function() {
        var value = parseInt($(this).val(), 10);

        var factor = $(':selected', this).data('factor') / 1;

        var wrapper = $(this).closest('.row');
        var factorElement = $('[name="retirment_age_factor"]', wrapper);

        factorElement.val(factor).trigger('change');
    });

  });
}(jQuery));


(function($){
  $(function(){
    var savingsInvestments = $('.retirement-needs-type-savings-investements');

    $(savingsInvestments).on('change', 'input', function() {
        var wrapper = $(this).closest('.ficheck-section-type');

        var currentValueEmployeeRetirementSavings = (wrapper.find('[name=employee_retirment_savings]').val() || 0) / 1;
        var currentValuePersonalRetirementSavings = (wrapper.find('[name=personal_retirment_savings]').val() || 0) / 1;
        var currentValueInvestments = (wrapper.find('[name=investements_value]').val() || 0) / 1;
        var currentValueSavingsAndInvestmentsElement = wrapper.find('[name=retirement_savings_and_investments]');

        var currentValueSavingsAndInvestments = Math.round((currentValueEmployeeRetirementSavings + currentValuePersonalRetirementSavings + currentValueInvestments) * 100) / 100;
        currentValueSavingsAndInvestmentsElement.val(currentValueSavingsAndInvestments);

        wrapper.next('.ficheck-section-type').find('[name="retirment_years_factor"]').trigger('change');
    });
  });
}(jQuery));

//# sourceMappingURL=app.js.map
