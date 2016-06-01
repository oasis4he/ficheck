
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
