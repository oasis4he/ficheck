(function($){
  $(function(){
    // store the financialGoalsContainer
    var financialRatiosContainer = $('.financial-ratios');

    $('.ficheck-section-type', financialRatiosContainer).on('change', 'input', function() {
      var wrapper = $(this).closest('.ficheck-section-type');
      var asset = wrapper.find('[name=asset]');
      var liability = wrapper.find('[name=liability]');
      var ratio = wrapper.find('[name=ratio]');
      var result;

      if(asset.val() && liability.val()) {
        if(wrapper.hasClass('financial-ratio-type-basic-liquidity')) {
          result = asset.val() / liability.val();
        } else if(wrapper.hasClass('financial-ratio-type-debt-to-asset')) {
          result = asset.val() / liability.val();
        } else if(wrapper.hasClass('financial-ratio-type-debt-payment-to-income')) {
          result = liability.val() / asset.val();
        }
      }

      if(result) {
        result = Math.round(result * 100) / 100;
        ratio.val(result);
      }
    });

  });
}(jQuery));
