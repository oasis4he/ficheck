
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
