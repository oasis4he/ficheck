
(function($){
  $(function(){
    var expenses = $('.life-insurance-type-expenses');

    $(expenses).on('change', 'input', function() {
        var wrapper = $(this).closest('.ficheck-sections');

        var funeralExpense = wrapper.find("[name=funeral_expenses]").val();
        var debt = wrapper.find("[name=debt]").val();
        var otherExpenses = wrapper.find("[name=other_expenses]").val();

        var enteredTotalIncomeForReplacement = $('[name=entered_total_income_replacement]').val();

        var totalExpenses = wrapper.find('[name=total_expenses]');
        totalExpenses.val(Number(funeralExpense) + Number(debt) + Number(otherExpenses) + Number(enteredTotalIncomeForReplacement));

        var enteredTotalExpenses = $('[name=entered_total_expenses]');
        enteredTotalExpenses.val(totalExpenses.val());
        enteredTotalExpenses.trigger("change");

    });

  });
}(jQuery));
