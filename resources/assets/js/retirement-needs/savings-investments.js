
(function($){
  $(function(){
    var savingsInvestments = $('.retirement-needs-type-savings-investements');

    $(savingsInvestments).on('change', 'input', function() {
        var wrapper = $(this).closest('.ficheck-section-type');

        var currentValueEmployeeRetirementSavings = (wrapper.find('[name=current_value_employee_retirement_savings]').val() || 0) / 1;
        var currentValuePersonalRetirementSavings = (wrapper.find('[name=current_value_personal_retirement_savings]').val() || 0) / 1;
        var currentValueInvestments = (wrapper.find('[name=current_value_investments]').val() || 0) / 1;
        var currentValueSavingsAndInvestmentsElement = wrapper.find('[name=current_value_savings_and_investments]');

        var currentValueSavingsAndInvestments = Math.round((currentValueEmployeeRetirementSavings + currentValuePersonalRetirementSavings + currentValueInvestments) * 100) / 100;
        currentValueSavingsAndInvestmentsElement.val(currentValueSavingsAndInvestments);

        wrapper.next('.ficheck-section-type').find('[name="retirment_years_factor"]').trigger('change');
    });
  });
}(jQuery));
