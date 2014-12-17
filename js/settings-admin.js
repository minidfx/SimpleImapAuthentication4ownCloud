$(document).ready(function () {
    var defaultTimeout = 1500;

    var updateSettings = function () {
        //noinspection JSJQueryEfficiency
        var field = $(this);

        if (field.is('input:checkbox')) {
            if (typeof field.attr('checked') != 'undefined') {
                //noinspection SpellCheckingInspection
                OC.AppConfig.setValue('user_imapauth', field.attr('name'), true);
            }
            else {
                //noinspection SpellCheckingInspection
                OC.AppConfig.setValue('user_imapauth', field.attr('name'), false);
            }
        }
        else {
            //noinspection SpellCheckingInspection
            OC.AppConfig.setValue('user_imapauth', field.attr('name'), field.val());
        }

        $('#imap_settings_msg').fadeIn('slow').delay(1000).fadeOut('slow');
    };

    //noinspection JSJQueryEfficiency
    $('#imapauth').find('input:text').keyup($.debounce(defaultTimeout, updateSettings));
    //noinspection JSJQueryEfficiency
    $('#imapauth').find('input[type=number]').change($.debounce(defaultTimeout, updateSettings));
    //noinspection JSJQueryEfficiency
    $('#imapauth').find('input:checkbox').change($.debounce(defaultTimeout, updateSettings));

    //noinspection JSJQueryEfficiency
    $('#imapauth').submit(function (e) {
        //return false; Old way for disabling a form.
        e.preventDefault();
    });

});
