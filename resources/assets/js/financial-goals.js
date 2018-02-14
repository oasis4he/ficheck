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
        goals = $('<div class="body"/>');
        template.before(goals);
      }

      newRecord.addClass('new');

      goals.append(newRecord);

      newRecord.find('input:visible').first().trigger('focus');

      $(this).remove();

      return false;
    });

      $('.page-financial-goals  a[href=#collapse]').click(function(){
          $('.financial-goals .financial-goal').slideUp();
      });

      $('.page-financial-goals  a[href=#expand]').click(function(){
          $('.financial-goals .financial-goal').slideDown();
      });

      $('.page-financial-goals  h2').on('click', function(e){
          $('form', $(this).closest('.ficheck-section-type')).slideToggle();

          return false;
      });

  });
  $('[name=date]').datepicker();
}(jQuery));
