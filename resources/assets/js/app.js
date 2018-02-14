//http://stackoverflow.com/questions/15762768/javascript-math-round-to-two-decimal-places
  function roundTo(n, digits) {
     if (digits === undefined) {
       digits = 0;
     }

     var multiplicator = Math.pow(10, digits);
     n = parseFloat((n * multiplicator).toFixed(11));
     var test =(Math.round(n) / multiplicator);
     return +(test.toFixed(2));
   }

   function roundedValue(number) {
       var value = parseFloat(number);
       return Number(Math.round(value+'e2')+'e-2').toFixed(2);
   }

(function($){
   $('body').on('change', '[type="number"]', function() {

     $(this).val(roundedValue($(this).val()));

   }).find('[type="number"]').trigger('change');

    $('body').on('focus', '[type="number"]', function() {

        $(this).select();

    });
})(jQuery);