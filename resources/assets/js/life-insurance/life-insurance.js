(function($){
  $(function(){
    var lifeInsurace = $('.life-insurance-type-income-replacement');

    $(lifeInsurace).on('change', 'input', function() {
        var wrapper = $(this).closest('.ficheck-section-type');

        var enteredAnnualIncome = (wrapper.find('[name=annual_income]').val() || 0) / 1;

        var insuranceNeeds = $('[name="insurance_needs"]', wrapper);
        insuranceNeeds.val(enteredAnnualIncome * .75);

        var totalIncomeForReplacement = wrapper.find('[name=total_income_replacement]');
        var factorElement = $('[name="income_replacement_factor"]', wrapper);

        totalIncomeForReplacement.val(insuranceNeeds.val() * factorElement.val());

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

  });
}(jQuery));
