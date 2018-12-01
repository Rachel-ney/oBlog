var app = {
    back: '',
  
    init: function() {
      app.back = $('.container').data("back");
      app.recoverData();
    },

    recoverData: function() {
        var id = $('.datas').data('id');
        var token = $('.datas').data('token');

        if(id === '' || token === '')
        {
            $('p.msg').html('Une erreur est survenue').addClass('bg-warning');
        }
        else{
            app.sendValidation(id, token);
        }
    },

    sendValidation: function(idUser, tokenUser) {
        var jqxhr = $.ajax({
            url:'http://'+ app.back +'/validate-account', 
            method: 'GET', 
            dataType: 'json',
            data: {
              id: idUser,
              token: tokenUser
            } 
          });
          // Je déclare la méthode done, celle-ci sera executée si la réponse est satisfaisante
          jqxhr.done(function (response) {
            if (response.success)
            {
              location.reload(true);
            }
            else 
            {
                $('p.msg').html(response.msg).addClass('bg-warning');
            }
          });
          // Je déclare la méthode fail, celle-ci sera executée si la réponse est insatisfaisante
          jqxhr.fail(function () {
            alert('Requête échouée');
          });
    }
};
$(app.init);