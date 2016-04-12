
(function($){
  $('.monthly-tracking.container').on('click', 'button.add', function(e){
    var currentRecord = $(this).closest('.new-record-template');
    var newRecord = currentRecord.clone();

    $(':input', newRecord).val('');

    currentRecord.after(newRecord);
    $(this).remove();

    return false;
  });
}(jQuery));

//# sourceMappingURL=app.js.map
