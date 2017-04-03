// remove fields or add datepicker (mm/dd/yyyy) - jquery UI
// monthly tracking hide categories link
// delete button on right side of category field (removes row)
// reset button on monthly tracker, with are you sure dialog
// stage for george


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
     var value = roundTo(number, 2);
     if((value.toString().split('.')[1] || []).length == 1){
       value = value + "0";
     }
     return value;
   }

   $('body').on('change', '[type=number]', function() {

     $(this).val(roundedValue($(this).val()));

   });
