$(function() {
    var form = $('#registerForm'); // Changed to match the updated form ID
    var formMessages = $('#form-messages');

    $(form).submit(function(e) {
        e.preventDefault();
        var formData = $(form).serialize();

        $.ajax({
            type: 'POST',
            url: $(form).attr('action'), // Ensures the form submits to 'login.php'
            data: formData
        })
        .done(function(response) {
            $(formMessages).removeClass('error').addClass('success').text(response);
            $('#name, #email, #message').val('');
        })
        .fail(function(data) {
            $(formMessages).removeClass('success').addClass('error');
            $(formMessages).text(data.responseText || 'Error: Message could not be sent.');
        });
    });
});
