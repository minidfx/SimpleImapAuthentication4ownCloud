$(document).ready(function () {

    $('#imapauth input').change(function () {
        var value = 'no';
        if (this.checked) {
            value = 'yes';
        }
        OC.AppConfig.setValue('user_imapauth', $(this).attr('name'), value);
    });

});
