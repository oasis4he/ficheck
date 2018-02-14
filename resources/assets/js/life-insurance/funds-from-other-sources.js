
(function($){
  $(function(){
    var fundsFromOtherSources = $('.life-insurance-type-other-sources');
    $(fundsFromOtherSources).on('change', 'input', function() {
        var wrapper = $(this).closest('.ficheck-section-type');

        var governmentBenefits = (wrapper.find('[name=government_benefits]').val());
        var otherFunds = (wrapper.find('[name=other_funds]').val());

        var totalFundsFromOtherSources = (wrapper.find('[name=total_funds_from_other_sources]'));
        var totalFundsValue = roundedValue(Number(governmentBenefits) + Number(otherFunds))
        totalFundsFromOtherSources.val(totalFundsValue);

        var enteredTotalFundsFromOtherSources = $('[name=entered_total_funds_from_other_sources]');
        enteredTotalFundsFromOtherSources.val(totalFundsFromOtherSources.val());
        enteredTotalFundsFromOtherSources.trigger("change");

    });

  });
}(jQuery));
