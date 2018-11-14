var appSignIn = {
  uri: '',

  init: function() {
    appSignIn.uri =  $('.container').data("uri");
    $('.register').on('submit', appSignIn.handleCheckForm);
  },
  handleCheckForm: function(evt) {
    // je bloque l'envoi du formulaire
    evt.preventDefault();
    // je retire tout les messages d'erreur s'il y en as
    appSignIn.clearError();
    // j'enregistre mes inputs en enlevant les espaces 
    var data = {
      'name' : $.trim($($(evt.target).find('.name')).val()),
      'email': $.trim($($(evt.target).find('.email')).val()),
      'password': $.trim($($(evt.target).find('.password')).val())
    };
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
        var button = $('.register');
        var textError = 'Vous ne pouvez pas laisser le champ '+ index +' vide.';
        var error = $('<div>').addClass('mx-auto col-11 my-3 border text-light bg-danger rounded py-2 error').html(textError);
        error.appendTo(button);
        notEmpty = false;
      }
    }

    // si notEmpty = true, alors aucun input n'était vide
    if (notEmpty) 
    {
      // je lance la requête vers le back
      appSignIn.registerUser(data);
    }
  },

  clearError: function() {
    // s'il y a bien des messages d'erreur
    if(typeof $('.error') !== 'undefined')
    {
      $('.error').remove();
    }
  },

  registerUser: function(dataValue) {
    var jqxhr = $.ajax({
      //url hebergeur à créer: 
      // url: 'https://neyress.yo.fr/oblog-Api/Backend/all-category', 
      url: 'http://localhost/Projet_perso/oBlog/Backend/add-author', 
      method: 'POST', // La méthode HTTP souhaité pour l'appel Ajax (GET ou POST)
      dataType: 'json', // Le type de données attendu en réponse (text, html, xml, json)
      data: {
        name: dataValue['name'],
        password: dataValue['password'],
        email: dataValue['email']
      }
    });
    // Je déclare la méthode done, celle-ci sera executée si la réponse est satisfaisante
    jqxhr.done(function (response) {
      // j'affiche la liste de mes catégorie
      if (response.success) 
      {
        // je cache les formulaires
        $('.all-form').addClass('d-none');
        // j'ajoute un message de redirection vers la page mon compte au dessus des formulaires
        var container = $('.container');
        var div = $('<div>').addClass('row mx-auto col-11 my-3 border bg-light rounded py-2');
        var url = 'http://localhost'+ appSignIn.uri +'/mon-compte';
        var a = $('<a>').html('Mon compte.').attr('href', url).addClass('alert-link');
        var text = 'Vous avez été correctement enregistré. <br/> Merci de vous être inscrit ! Vous pouvez désormais publier et consulter vos propres articles, ainsi que modifier vos informations personnelles depuis votre page : ';
        var p = $('<p>').html(text);
        a.appendTo(p);
        p.appendTo(div);
        div.prependTo(container);
      }
      else 
      {
        var button = $('.register');
        var error = $('<div>').addClass('mx-auto col-11 my-3 border text-light bg-danger rounded py-2 error').html(response.msg);
        error.appendTo(button);
      }
    });
    // Je déclare la méthode fail, celle-ci sera executée si la réponse est insatisfaisante
    jqxhr.fail(function () {
      alert('Requête échouée');
    });
  },
};
$(appSignIn.init);