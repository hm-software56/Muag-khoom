(function ($) {
    $(function () {
            
        var initSelect2DropStyle = function(id, kvClose, ev){
            initS2Open(id, kvClose, ev);
        };
        var addFormGroup = function (event) {
            event.preventDefault();
           // $(this).autoNumeric('init', {aSign: '', pSign: 's'});
           $(this).autoNumeric();
          // alert('sssss');
        };
        $(document).on('focusin', '.money_format', addFormGroup);

    });
})(jQuery);
