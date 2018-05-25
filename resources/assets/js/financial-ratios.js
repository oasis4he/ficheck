(function($){
  $(function(){
    // store the financialGoalsContainer
    var financialRatiosContainer = $('.financial-ratios');

    $('.ficheck-section-type', financialRatiosContainer).on('change', 'input', function() {

      var wrapper = $(this).closest('.ficheck-section-type');
      var asset = wrapper.find('[name=asset]');
      var liability = wrapper.find('[name=liability]');
      var ratio = wrapper.find('[name=ratio]');
      var result = 0;

      if(asset.val() && liability.val()) {
        if(wrapper.hasClass('financial-ratio-type-basic-liquidity')) {
          if(liability.val() != 0) {
            result = asset.val() / liability.val();
          }
        } else if(wrapper.hasClass('financial-ratio-type-asset-to-debt')) {
          if(liability.val() != 0) {
            result = asset.val() / liability.val();
          }
        } else if(wrapper.hasClass('financial-ratio-type-debt-payment-to-income')) {
          if(liability.val() != 0) {
            result = liability.val() / asset.val();
          }
        }
      }

      result = Math.round(result * 100) / 100;
      ratio.val(result);

      $(this).val(roundedValue($(this).val()));
    });

  });
}(jQuery));
