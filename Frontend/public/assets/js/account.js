var app = {
  uri: '',

  init: function () {
    // je récupère la base uri : 
    app.uri = $('.container').data('uri');
    // j'ajoute mes events
    $('.form-modal').on('submit', app.handleConfirmModal);
    //$('.form-password').on('submit', app.handleCheckForm);
  },

  handleConfirmModal: function(evt) {
    var password = $.trim($('input#pass-confirm').val());

    if(password !== '')
    {
      app.unsubscribeUser(password);
      console.log('passé');
    }
    else
    {
      evt.preventDefault();
      $('.error').remove();
      var span = $('<span>').html('Veuillez entrer votre mot de passe pour confirmer').addClass('error');
      span.prependTo($('.form-modal'));
    }
  },

  unsubscribeUser: function(passwordEntry) {
    var jqxhr = $.ajax({
      //url hebergeur : 
      // url: 'https://neyress.yo.fr/oblog-Api/Backend/all-category', 
      url: 'http://localhost/Projet_perso/oBlog/Backend/desactivate-author', 
      method: 'GET', // La méthode HTTP souhaité pour l'appel Ajax (GET ou POST)
      dataType: 'json', // Le type de données attendu en réponse (text, html, xml, json)
      data: {
        password: passwordEntry,
      } 
    });
    // Je déclare la méthode done, celle-ci sera executée si la réponse est satisfaisante
    jqxhr.done(function (response) {

    });
    // Je déclare la méthode fail, celle-ci sera executée si la réponse est insatisfaisante
    jqxhr.fail(function () {
      alert('Requête échouée');
    });
  }

};
$(app.init)