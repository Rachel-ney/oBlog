var app = {
    back: '',

    init: function() {
        app.back = $('.container-fluid').data('back');
        $('.lost-password').on('submit', app.handleCheckFormLost);
    },

    handleCheckFormLost: function(evt) {
        evt.preventDefault();

        var email = $.trim($('#email').val());
        $('.error').remove();

        if (email === '')
        {
            var div = $('<div>').addClass('error m-2 border text-light bg-danger rounded p-2 ').html('Vous ne pouvez pas laisser de champ vide');
            div.appendTo('.lost-password');
        }
        else
        {
            app.sendMailUser(email);
        }
    },

    sendMailUser(mailUser) {
    var jqxhr = $.ajax({
        url:  app.back +'/lost-password', 
        method: 'GET', 
        dataType: 'json',
        data: {
            email: mailUser,
        } 
        });
        // Je déclare la méthode done, celle-ci sera executée si la réponse est satisfaisante
        jqxhr.done(function (response) {
        if (response.success)
        {
            var div = $('<div>').html('Un mail vous a été envoyé pour réinitialiser votre mot de passe').addClass('error bg-success text-light text-center rounded p-2 mt-2 mb-2');
            div.appendTo($('.lost-password'));
        }
        else 
        {
            var div = $('<div>').html(response.msg).addClass('error bg-danger text-light text-center rounded p-2 mt-2 mb-2');
            div.appendTo($('.lost-password'));
        }
        });
        // Je déclare la méthode fail, celle-ci sera executée si la réponse est insatisfaisante
        jqxhr.fail(function () {
        alert('Requête échouée');
        });
    },
};
$(app.init);