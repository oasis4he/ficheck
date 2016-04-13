(function($){
  var monthlyTrackingContainer = $('.monthly-tracking').on('click', 'button.add', function(e){
    console.log('here');

    var currentRecord = $(this).closest('form');
    var newRecord = currentRecord.clone();

    $(':input', newRecord).val('').removeAttr('disabled').closest('form').removeClass('changed');

    currentRecord.after(newRecord);

    newRecord.find('input:visible').first().trigger('focus');

    return false;
  });

  // disable in/out if other if filled in
  monthlyTrackingContainer.on('change', '[name=in],[name=out]', function(){
    var form = $(this).closest('form');

    var sibling = form.find('[name=in],[name=out]').not(this);

    if($(this).val()) {
      sibling.attr('disabled', true);
    } else {
      sibling.removeAttr('disabled');
    }
  })

  monthlyTrackingContainer.find('[name=in],[name=out]').trigger('change');

  monthlyTrackingContainer.on('change', 'input', function(){
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
            console.log(form.find('.add').trigger('click'));
            form.removeClass('new');
          }
        }
      });
    }
  });

  monthlyTrackingContainer.on('focus', 'form input', function() {
    monthlyTrackingContainer.find('form').removeClass('active');

    $(this).closest('form').addClass('active');
  });
}(jQuery));
