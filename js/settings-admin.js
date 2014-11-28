$(document).ready(function () {

    //noinspection JSJQueryEfficiency
    $('#imapauth').find('input').keyup($.debounce(1000, function () {
        var field = $(this);
        //noinspection SpellCheckingInspection
        OC.AppConfig.setValue('user_imapauth', field.attr('name'), field.val());

        $('#imap_settings_msg').fadeIn('slow').delay(1000).fadeOut('slow');
    }));

    //noinspection JSJQueryEfficiency
    $('#imapauth').submit(function (e) {
        //return false; Old way for disabling a form.
        e.preventDefault();
    });

});
