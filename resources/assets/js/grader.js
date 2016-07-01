(function($) {
    $(function() {
        var graderModeEnabled = $('.grader-mode-enabled');

        var modalHtml = '<div class="modal fade" tabindex="-1" role="dialog">  <div class="modal-dialog">    <div class="modal-content">      <div class="modal-header">        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        <h4 class="modal-title">Review Mode</h4>      </div>      <div class="modal-body">        <p>You cannot save anything while viewing another user\'s data.</p>      </div>      <div class="modal-footer">        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>        <a type="button" class="btn btn-primary" href="/">Exit Review Mode</a>      </div>    </div><!-- /.modal-content -->  </div><!-- /.modal-dialog --></div><!-- /.modal -->';

        var modal = $(modalHtml).appendTo('body');

        $('form', graderModeEnabled).on('submit', function(e) {
            e.stopPropagation();
            e.preventDefault();

            $(modal).modal({backdrop: false});

            return false;
        });
    });
})(jQuery);
