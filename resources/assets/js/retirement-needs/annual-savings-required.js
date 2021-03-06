
(function($){
  $(function(){
    var retirementGoals = $('.retirement-needs-type-annual-savings-required');
    var retirementNeedsContainer = $('.retirement-needs');

    $(retirementGoals).on('change', 'input', function() {
        var wrapper = $(this).closest('.ficheck-section-type');

        var enteredretirementGoal = (wrapper.find('[name=entered_retirement_goal]').val() || 0) / 1;
        var enteredFutureValueOfSavingsAndInvestments = (wrapper.find('[name=entered_future_value_of_savings_and_investments]').val() || 0) / 1;
        var additionalSavingsNeededForRetirementElement = wrapper.find('[name=additional_savings_needed_for_retirement]');

        var additionalSavingsNeededForRetirement = enteredretirementGoal - enteredFutureValueOfSavingsAndInvestments;
        additionalSavingsNeededForRetirementElement.val(additionalSavingsNeededForRetirement);

        var factor = $('[name="entered_retirement_age_factor"]', wrapper).val();

        if(factor) {
            var goal = Math.round(additionalSavingsNeededForRetirement / factor * 100) / 100;

            var additionAnnualSavingsRequired = $('[name="addition_annual_savings_required"]', wrapper);
            additionAnnualSavingsRequired.val(goal);
        }
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
