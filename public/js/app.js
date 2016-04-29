
(function($){
  $(function(){
    // store the financialGoalsContainer
    var financialGoalsContainer = $('.financial-goals');

    // handler for the add tracking record control
    financialGoalsContainer.on('click', 'a[href=#add]', function(e){
      var goalWrapper = $(this).closest('.financial-goal-type');
      var goals = goalWrapper.find('.body').last();
      var template = goalWrapper.find('.template');
      var newRecord = template.find('form').clone();

      if(!goals.length) {
        console.log('no goals for you');
        goals = $('<div class="body"/>');
        template.before(goals);
      }

      newRecord.addClass('new');

      goals.append(newRecord);

      newRecord.find('input:visible').first().trigger('focus');

      $(this).remove();

      return false;
    });
  });
}(jQuery));

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
          result = liability.val() / asset.val();
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

(function($){
  $(function(){
    var ficheckSections = $('.ficheck-sections');

    ficheckSections.on('click', 'a[href=#expand]', function(e){
      $('.body,[href=#add]', ficheckSections).slideDown();

      return false;
    });

    ficheckSections.on('click', 'a[href=#collapse]', function(e){
      $('.body,[href=#add]', ficheckSections).slideUp();

      return false;
    });

    ficheckSections.on('click', 'h2', function(e){
      $('.body,[href=#add]', $(this).closest('.ficheck-section-type')).slideToggle();

      return false;
    });

    var helpControls = $('.help-controls', ficheckSections).on('click', 'a', function(){
      var ratioElement = $(this).closest('.financial-section-type');
      var row = $(this).closest('.row');
      var description = row.find('.description')

      $('.help-controls .hide', row).removeClass('hide');
      $(this).addClass('hide');

      if($(this).attr('href').search('show')>=0) {
        description.show();
      } else {
        description.hide();
      }

      return false;
    });
  });
}(jQuery));

(function($){
  // store the monthlyTrackingContainer
  var monthlyTrackingContainer = $('.monthly-tracking')

  // handler for the add tracking record control
  // monthlyTrackingContainer.on('click', 'button.add', function(e){
  //   var currentRecord = $(this).closest('form');
  //   var newRecord = currentRecord.clone();
  //
  //   $(':input', newRecord).val('').removeAttr('disabled').closest('form').removeClass('changed');
  //
  //   currentRecord.after(newRecord);
  //
  //   newRecord.find('input:visible').first().trigger('focus');
  //
  //   return false;
  // });

  // disable in/out if other if filled in  (only one or the other should be active)
  monthlyTrackingContainer.on('change', '[name=in],[name=out]', function(){
    var form = $(this).closest('form');

    var sibling = form.find('[name=in],[name=out]').not(this);

    if($(this).val()) {
      sibling.attr('disabled', true);
    } else {
      sibling.removeAttr('disabled');
    }
  }).find('[name=in],[name=out]').trigger('change');

  // if an input changes and the form is valid, submit it via ajax
  monthlyTrackingContainer.on('change', '.row:not(.new) input', function(){
    var form = $(this).closest('form');

    var changed = false;
    $('input', form).each(function(){
        changed = this.value != this.defaultValue;

        return !changed; // return if at least one control has changed value
    });

    if(changed) {
      form.addClass('changed');
    }

    if(form.hasClass('changed') && form.find('[name=date]').val() && (form.find('[name=in]').val() || form.find('[name=out]').val())) {
      var form = $(this).closest('form');
      var data = form.serialize();

      $.ajax({
        url: form.action,
        data: data,
        method: "post",
        success: function() {
          form.removeClass('changed');

          if(form.hasClass('new')) {
            form.removeClass('new');
          }
        }
      });
    }
  });

  // track the active form (show controls via css)
  monthlyTrackingContainer.on('focus', 'form input', function() {
    monthlyTrackingContainer.find('form').removeClass('active');

    $(this).closest('form').addClass('active');
  });
}(jQuery));

//# sourceMappingURL=app.js.map
