
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
