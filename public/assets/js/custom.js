$(document).ready(function() {
    $('#form-select').submit(function() {
        $('#submitButton').prop('disabled', true).hide();
        $('#loader').show();
    });

    $('#form-logout').submit(function() {
        $('#logoutButton').prop('disabled', true).hide();
        $('#logout_loader').show();
    });

    $('#form-import').submit(function() {
        $('#importButton').prop('disabled', true).hide();
        $('#import_loader').show();
    });

    $("#download-sample").click(function(){
        let button = $(this);
        button.addClass('disabled').css('pointer-events','none').html('Please wait !');

        setTimeout(function(){
            button.removeClass('disabled').css('pointer-events','auto').html('Download Sample File !')
        },5000);
    });
});
