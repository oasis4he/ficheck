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
