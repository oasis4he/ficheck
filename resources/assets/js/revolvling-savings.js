
(function($){
    $(function(){
        var revolvingSavingsContainer = $('.page-revolving-savings .ficheck-sections');
        var totalsContainer = $('.budget-sums', revolvingSavingsContainer);
        var wrapper = $('.ficheck-section-type', revolvingSavingsContainer);

        $('.ficheck-section-type', revolvingSavingsContainer).on('change', 'input', function() {

            var inputs = $(wrapper).find('input[type="number"]');
            var sum = 0;

            inputs.each(function(a){
                var value = parseFloat($(a).val());
                sum += value;
            });

            var monthly = roundedValue(sum / 12);

            $('#perYearTotal', totalsContainer).val(sum);
            $('#perMonthTotal', totalsContainer).val(monthly);
        });

    });
}(jQuery));
