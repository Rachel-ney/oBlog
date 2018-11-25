var app = {
  uri: '',

  init: function () {
    // je récupère la base uri : 
    app.uri = $('.container').data('uri');
    // j'ajoute mes events
    $('.form-modal').on('submit', app.handleConfirmModal);
    $('.form-password').on('submit', app.handleCheckPasswordChange);
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

  handleCheckPasswordChange: function(evt) {
    //evt.preventDefault();
    console.log('change pass');
    // je supprime les erreurs qui été déjà la pour ne pas les accumuler et pour supprimer celle qui on pu être résolu par l'user
    $('.error').remove();

    var data = {
      'oldPass' : $.trim($('.password').val()),
      'newPass' : $.trim($('.newPassword').val()),
      'newPassConfirm' : $.trim($('.newPasswordConfirm').val())
    };
    // je considère par défaut qu'il n'y a pas d'erreur
    var notError = true;
    var errorMsg = [];

    for ( var index in data)
    {
      // si un input est vide
      if(data[index] === '')
      {
        // je déclare une erreur
        notError = false;
        errorMsg[0] = 'Vous ne pouvez pas laisser de champs vide';
      }
    }
    // si les champs nouveau mot de passe et confirmation sont différents
    if (data['newPass'] !== data['newPassConfirm'])
    {
      // je déclare une erreur
      notError = false;
      errorMsg[1] = 'Le nouveau mot de passe et sa confirmation doivent êtres identiques';
    }
    // s'il y a eu une erreur
    if (!notError) 
    {
      // je stoppe le formulaire
      evt.preventDefault();
      // j'affiche un message en fonction de l'erreur
      for (var index in errorMsg)
      {
          var div = $('<div>').addClass('error bg-warning p-2 mt-2 rounded text-center').html(errorMsg[index]);
          div.appendTo('.form-password');
      }
    }
    else 
    {
      app.changePassword(data);
    }
  },

  unsubscribeUser: function(passwordEntry) {
    var jqxhr = $.ajax({
      url: 'http://localhost/Projet_perso/oBlog/Backend/desactivate', 
      method: 'POST', 
      dataType: 'json',
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
  },

  changePassword: function(arrayData) {
    var jqxhr = $.ajax({
      url: 'http://localhost/Projet_perso/oBlog/Backend/change-pass', 
      method: 'POST', 
      dataType: 'json', 
      data: {
        oldPass : arrayData['oldPass'],
        newPass: arrayData['newPass'],
        newPassConfirm: arrayData['newPassConfirm']
      } 
    });
    // Je déclare la méthode done, celle-ci sera executée si la réponse est satisfaisante
    jqxhr.done(function (response) {

    });
    // Je déclare la méthode fail, celle-ci sera executée si la réponse est insatisfaisante
    jqxhr.fail(function () {
      alert('Requête échouée');
    });
  },
};
$(app.init)