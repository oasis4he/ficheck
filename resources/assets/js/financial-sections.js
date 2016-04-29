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
