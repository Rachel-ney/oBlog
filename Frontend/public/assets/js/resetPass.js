var app = {
    back: '',
    id: '',
    token: '',

    init: function() {
        app.back = $('.container-fluid').data('back');
        app.id = $('.data').data('id');
        app.token = $('.data').data('token');
        $('.reset-password').on('submit', app.handleCheckFormPass);
    },

    handleCheckFormPass: function(evt) {
        evt.preventDefault();
        $('.error').remove();
        var data = {
            password: $.trim($('.password').val()),
            passwordConfirm: $.trim($('.password-confirm').val())
        };

        var notEmpty = true;

        for (var index in data)
        {
            if (data[index] === '' )
            {
                notEmpty = false;
            }
        }

        if (!notEmpty)
        {
            var div = $('<div>').html('Vous ne pouvez pas laisser de champs vide').addClass('error bg-warning p-2 mt-2 text-center rounded');
            div.appendTo($(evt.target));
        }
        else if (data['password'] !== data['passwordConfirm'])
        {
            var div = $('<div>').html('Le mot de passe et sa confirmation doivent êtres identiques').addClass('error bg-warning p-2 mt-2 text-center rounded');
            div.appendTo($(evt.target));
        }
        else
        {
            app.resetPassword(data);
        }
    },

    resetPassword: function(data) {
        var jqxhr = $.ajax({
            url:'http://'+ app.back +'/reset-password', 
            method: 'POST', 
            dataType: 'json',
            data: {
                password: data['password'],
                passwordConfirm: data['passwordConfirm'],
                id: app.id,
                token: app.token
            } 
            });
            // Je déclare la méthode done, celle-ci sera executée si la réponse est satisfaisante
            jqxhr.done(function (response) {
            if (response.success)
            {
                var div = $('<div>').html('Votre mot de passe a bien été modifié, vous pouvez vous connecter').addClass('bg-success text-light text-center rounded p-2 mt-2 mb-2');
                div.appendTo($('.reset-password'));
            }
            else 
            {
                var div = $('<div>').addClass(' error bg-danger text-light text-center rounded p-2 mt-2 mb-2');
                if(response.msg.pass)
                {
                    div.html(response.msg.pass);
                }
                else{
                    div.html(response.msg);
                }
                div.appendTo($('.reset-password'));
            }
            });
            // Je déclare la méthode fail, celle-ci sera executée si la réponse est insatisfaisante
            jqxhr.fail(function () {
            alert('Requête échouée');
            });
    }
};
$(app.init);