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
  monthlyTrackingContainer.on('blur', '.edit input', function(){
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
        },
        error: function(e) {
          $('#errorModal .modal-title').text('Error Updating Entry');
          $('#errorModal .modal-body p').text(e.message);
          $('#errorModal').modal('show');
        }
      });
    }
  });

  monthlyTrackingContainer.on('click', '[href=#delete]', function(){
    var form = $(this).closest('form');
    var id = form.find('[name=id]').val();

    $.ajax({
      url: '/monthly-tracking/delete/' + id,
      method: "get",
      success: function() {

        if(!form.siblings('form').length) {
          form.closest('.monthly-tracking-section').remove();
        }

        form.remove();

      },
      error: function(e) {
        $('#errorModal .modal-title').text('Error Deleting Entry');
        $('#errorModal .modal-body p').text(e.message);
        $('#errorModal').modal('show');
      }
    });
  })

  // track the active form (show controls via css)
  monthlyTrackingContainer.on('focus', 'form input', function() {
    monthlyTrackingContainer.find('form').removeClass('active');

    $(this).closest('form').addClass('active');
  });

  // track the active form (show controls via css)
  monthlyTrackingContainer.on('focus', 'form [name=category]', function() {
    var form = $(this).closest('form');

    if(form.find('[name=in]').val()) {
      getIncomeCategories();
    }

    if(form.find('[name=out]').val()) {
      getExpenseCategories();
    }

    $(this).closest('form').addClass('active');
  });

  $('.dropdown-menu a').click(function() {
    var collapse = $(this).attr('href');
    $(collapse).collapse('show');
    $('.panel-collapse:not('+collapse+')').collapse('hide');
    $('#trackedMonthDropdown').html($(this).text() + "<i class='fa fa-chevron-down dropdown-caret' aria-hidden='true'></i>");

    $('html, body').animate({
        scrollTop: $(collapse).offset().top
    }, 1000);
  });

  $('.page-monthly-tracking a[href=#collapse]').click(function(){
    $('.monthly-tracking .panel-collapse').collapse('hide');
  });

  $('.page-monthly-tracking a[href=#expand]').click(function(){
    $('.monthly-tracking .panel-collapse').collapse('show');
  });

  monthlyTrackingContainer.on('change', '[name=in]', getIncomeCategories);

  monthlyTrackingContainer.on('change', '[name=out]', getExpenseCategories);

  function getExpenseCategories() {
    $.ajax({
      url: "/categories/expense",
      method: "get",
      dataType: 'json',
      success: function(data) {
        $( "[name=category]" ).autocomplete({
          source: data
        });
      }
    });
  }

  function getIncomeCategories() {
    $.ajax({
      url: "/categories/income",
      method: "get",
      dataType: 'json',
      success: function(data) {
        $( "[name=category]" ).autocomplete({
          source: data
        });
      }
    });
  }




}(jQuery));
