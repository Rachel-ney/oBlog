var app = {
  back: '',
  sess: '',

  init: function() {
    app.back = $('.container-fluid').data('back');
    app.sess = $('.container-fluid').data('sess');
    app.recoverData();
  },

  recoverData: function() {
    var id = $('.datas').data('id');
    var token = $('.datas').data('token');

    if(id === '' || token === '')
    {
        $('p.msg').html('Une erreur est survenue').addClass('bg-warning');
    }
    else
    {
        app.sendValidation(id, token);
    }
  },

  sendValidation: function(idUser, tokenUser) {
    var jqxhr = $.ajax({
      url:  app.back +'/validate-account', 
      method: 'GET', 
      dataType: 'json',
      data: {
        sess  : app.sess,
        id    : idUser,
        token : tokenUser
      } 
    });
    // Je déclare la méthode done, celle-ci sera executée si la réponse est satisfaisante
    jqxhr.done(function (response) {
      if (response.success)
      {
        $('p.msg').html('Votre compte a été activé avec succes, vous pouvez vous connecter').addClass('bg-success text-light');
      }
      else 
      {
        $('p.msg').html(response.msg).addClass('bg-warning');
      }
    });
    // Je déclare la méthode fail, celle-ci sera executée si la réponse est insatisfaisante
    jqxhr.fail(function () {
      console.log('Requête échouée');
    });
  }
};
$(app.init);