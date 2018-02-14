
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

        if(factor) {
            var goal = Math.round(additionalAnnualIncomeRequired * factor * 100) / 100;

            var retirementGoal = $('[name="retirement_goal"]', wrapper);
            var oldGoal = parseFloat(retirementGoal.val());
            if (oldGoal != goal) {
                retirementGoal.val(goal);
                var annualSavingsRetirementGoal = $('[name="entered_retirement_goal"]');
                annualSavingsRetirementGoal.val(goal).trigger('change');

            }
        }

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
