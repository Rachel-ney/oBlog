var appSignIn = {
  uri: '',

  init: function() {
    appSignIn.uri =  $('.container').data('uri');
    $('.register').on('submit', appSignIn.handleCheckForm);
    $('.sign-in').on('submit', appSignIn.handleCheckForm)
  },

  handleCheckForm: function(evt) {
    // je détermine si c'est sign in ou register par la présence / absence de l'input name
    var register = $($(evt.target).find('.name')).val();
    if(typeof register !== 'undefined')
    {
      register = true;
    }
    else {
      register = false;
    }
    // je retire tout les messages d'erreur s'il y en as
    $('.error').remove();
    // dans tout les cas je récupère email et password
    var data = {
      'email': $.trim($($(evt.target).find('.email')).val()),
      'password': $.trim($($(evt.target).find('.password')).val())
    };

    // si c'est le formulaire d'inscription je récupère aussi le pseudo et la confirmation du mdp
    if(register) 
    {
      data['name'] = $.trim($($(evt.target).find('.name')).val());
      data['pass_confirm'] = $.trim($($(evt.target).find('.password-confirm')).val());
    }
  
    // par défaut je considère que des valeurs on été mis dans chaque input
    var notEmpty = true;
    // je vérifie qu'aucun input n'est vide
    // NB : les vérif sur l'intégrité seront faite coté back
    for ( var index in data) 
    {
      // si vide j'affiche un message d'erreur
      // et je dis que notEmpty = false;
      if(data[index] == '') 
      {
        var textError = 'Vous ne pouvez pas laisser de champ vide';
        // si formulaire d'inscription
        if(register) 
        {
          var error = $('<div>').addClass('mx-auto col-11 my-3 border text-light bg-danger rounded py-2 error').html(textError);
        }
        // sinon formulaire connexion
        else
        {
          var error = $('<div>').addClass('mx-auto my-2 border text-light bg-danger rounded p-2 error').html(textError);
        }
        // j'ajoute le message au formulaire
        error.appendTo(evt.target);
        notEmpty = false;
      }
    }

    if(register)
    {
      if(data['password'] !== data['pass_confirm'])
      {
        var textError = 'Vos mot de passe doivent êtres identiques';
        var error = $('<div>').addClass('mx-auto col-11 my-3 border text-light bg-danger rounded py-2 error').html(textError);
        error.appendTo(evt.target);
        notEmpty = false;
      }
    }

    // si notEmpty = true, alors aucun input n'était vide
    // et les deux mdp sont identiques
    if (notEmpty) 
    {
      // je lance la requête vers le back
      appSignIn.dataRequest(data, register);
    }
    else 
    {
      // je bloque l'envoi du formulaire
      evt.preventDefault();
    }
  },

  dataRequest: function(dataValue, register) {
    if(register)
    {
      var jqxhr = $.ajax({
        url: 'http://localhost/Projet_perso/oBlog/Backend/add-author', 
        method: 'POST',
        dataType: 'json',
        data: {
          name: dataValue['name'],
          password: dataValue['password'],
          pass_confirm: dataValue['pass_confirm'],
          email: dataValue['email']
        }
      });
    }
    else 
    {
      var jqxhr = $.ajax({
        url: 'http://localhost/Projet_perso/oBlog/Backend/connexion', 
        method: 'POST',
        dataType: 'json',
        data: {
          password: dataValue['password'],
          email: dataValue['email']
        }
      });
    }
    // Je déclare la méthode done, celle-ci sera executée si la réponse est satisfaisante
    jqxhr.done(function (response) {

    });
    // Je déclare la méthode fail, celle-ci sera executée si la réponse est insatisfaisante
    jqxhr.fail(function () {
      alert('Requête échouée');
    });
  },
};
$(appSignIn.init);