var app = {
  uri: '',
  back: '',
  target: '',
  postTarget: '',

  init: function () {
    // je récupère la base uri : 
    app.uri = $('.container').data('uri');
    app.back = $('.container').data("back");
    // j'ajoute mes events
    $('.form-modal-desactivate').on('submit', app.handleConfirmModalDesactivate);
    $('.form-password').on('submit', app.handleCheckPasswordChange);
    $('.form-new-post').on('submit', app.handleCheckNewPost);
    $('.modify-post').on('click', app.handleDisplayFormModifyPost);
    $('.cancel-modify').on('click', app.handleCancelModidfyPost);
    $('.form-delete-post').on('submit', app.handleCheckDeletePost);
  },

  handleConfirmModalDesactivate: function(evt) {
    evt.preventDefault();
    console.log('desactivate');
    var password = $.trim($('input#pass-desactivate').val());
    if(password !== '')
    {
      app.unsubscribeUser(password);
    }
    else
    {
      $('.error').remove();
      var span = $('<span>').html('Veuillez entrer votre mot de passe pour confirmer').addClass('error');
      span.prependTo($('.form-modal'));
    }
  },

  handleCheckPasswordChange: function(evt) {
    evt.preventDefault();

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
      $('.password').val('');
      $('.newPassword').val('');
      $('.newPasswordConfirm').val('');
    }
    // s'il y a eu une erreur
    if (!notError) 
    {
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

  handleCheckNewPost: function(evt) {
    evt.preventDefault();

    var data = {
      title    : $.trim($('input#title').val()),
      resume   : $.trim($('textarea#resume').val()),
      content  : $.trim($('textarea#content').val()),
      category : $('select#category').val()
    };

    var notEmpty = true;
    var categoryChoose = true;
    for ( var index in data)
    {
      if (data[index] === '')
      {
        notEmpty = false;
      }
      if(data['category'] === null)
      {
        categoryChoose = false;
      }
    }

    $('.error').remove();
    var div = $('<div>').addClass('error bg-warning p-2 mt-2 text-center rounded');
    if(!notEmpty)
    {
      div.html('Vous ne pouvez pas laisser de champ vide');
      div.appendTo($('.form-new-post'));
    }
    else if(!categoryChoose)
    {
      div.html('Vous devez choisir une catégorie');
      div.appendTo($('.form-new-post'));
    }
    else{
      app.sendNewPost(data);
    }
  },

  handleDisplayFormModifyPost: function(evt) {
    // je cible la div contenant l'article et le cache
    var divPost = $(evt.target).parent();
    divPost.addClass('d-none'); 
    // je cible la balise article parente
    var article = $(divPost).parent();
    // pour cibler le formulaire et l'afficher
    var form = $(article).find('form');
    form.removeClass('d-none');

    form.on('submit', app.handleCheckModifyPost);
  },

  handleCancelModidfyPost: function(evt) {
    var divForm = $(evt.target).parent();
    divForm.addClass('d-none'); 
    // je cible la balise article parente
    var article = $(divForm).parent();
    // pour cibler le formulaire et l'afficher
    var post = $(article).find('div:first-child');
    post.removeClass('d-none');
  },

  handleCheckModifyPost: function(evt) { 
    evt.preventDefault();

    var form = $(evt.target);
    
    var data = {
      'id'          : form.data('postid'),
      'title'       : $.trim($(form.find('.modify-title')).val()),
      'resume'      : $.trim($(form.find('.modify-resume')).val()),
      'content'     : $.trim($(form.find('.modify-content')).val()),
      'category' : $(form.find('select.modify-category')).val(),
    };

    var notEmpty = true;
    for ( var index in data)
    {
      if (data[index] === '')
      {
        notEmpty = false;
      }
    }

    $('.error').remove();
    var div = $('<div>').addClass('error bg-warning p-2 mt-2 text-center rounded');
    if(!notEmpty)
    {
      div.html('Vous ne pouvez pas laisser de champ vide');
      div.appendTo($(evt.target));
    }
    else{
      app.postTarget = evt.target;
      app.sendPostModification(data);
    }
  },

  handleCheckDeletePost: function(evt) {
    evt.preventDefault();

    var id = $($(evt.target).find('select.to-delete')).val();
    var password = $.trim($($(evt.target).find('.confirm-delete-post')).val());

    $('.error').remove();
    var errorMsg = [];
    var notEmpty = true;

    if (id === null )
    {
      errorMsg[0] = 'Vous devez choisir un article pour le supprimer';
      notEmpty = false;
    }
    else if (password === '')
    {
      errorMsg[1] = 'Vous devez entrer votre mot de passe pour confirmer';
      notEmpty = false;
    }

    if (!notEmpty)
    {
      for (var index in errorMsg)
      {
        var div = $('<div>').html(errorMsg[index]).addClass('error bg-warning p-2 mt-2 text-center rounded');
        div.appendTo($(evt.target));
      }
    }
    else
    {
      app.removePost(id, password);
    }
  },

  unsubscribeUser: function(passwordEntry) {
    var jqxhr = $.ajax({
      url:'http://'+ app.back +'/desactivate', 
      method: 'POST', 
      dataType: 'json',
      data: {
        password: passwordEntry,
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
          app.target = 'desactivate';
          app.displayError('other',response.msg);
      }
    });
    // Je déclare la méthode fail, celle-ci sera executée si la réponse est insatisfaisante
    jqxhr.fail(function () {
      alert('Requête échouée');
    });
  },

  changePassword: function(arrayData) {
    var jqxhr = $.ajax({
      url:'http://'+ app.back +'/change-pass', 
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
      if (response.success)
      {
        location.reload(true);
      }
      else 
      {
        app.target = 'changePass';
        if(response.msg.pass)
        {
          app.displayError('pass',response.msg);
        }
        else
        {
          app.displayError('other',response.msg);
        }
      }
    });
    // Je déclare la méthode fail, celle-ci sera executée si la réponse est insatisfaisante
    jqxhr.fail(function () {
      alert('Requête échouée');
    });
  },

  sendNewPost: function(arrayData) {
    var jqxhr = $.ajax({
      url:'http://'+ app.back +'/add-update-post', 
      method: 'POST', 
      dataType: 'json', 
      data: {
        action   : 'insert',
        title    : arrayData['title'],
        resume   : arrayData['resume'],
        content  : arrayData['content'],
        category_id : arrayData['category']
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
          app.target = 'newPost';
          app.displayError('other',response.msg);
      }
    });
    // Je déclare la méthode fail, celle-ci sera executée si la réponse est insatisfaisante
    jqxhr.fail(function () {
      alert('Requête échouée');
    });
  },

  sendPostModification: function(arrayData) {
    var jqxhr = $.ajax({
      url:'http://'+ app.back +'/add-update-post', 
      method: 'POST', 
      dataType: 'json', 
      data: {
        action   : 'update',
        post_id  : arrayData['id'],
        title    : arrayData['title'],
        resume   : arrayData['resume'],
        content  : arrayData['content'],
        category_id : arrayData['category']
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
          app.target = 'modifyPost';
          app.displayError('other',response.msg);
      }
    });
    // Je déclare la méthode fail, celle-ci sera executée si la réponse est insatisfaisante
    jqxhr.fail(function () {
      alert('Requête échouée');
    });
  },

  removePost: function(id, passwordUser) {
    var jqxhr = $.ajax({
      url:'http://'+ app.back +'/delete-post', 
      method: 'POST', 
      dataType: 'json', 
      data: {
        post_id   : id,
        password  : passwordUser,
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
        app.target = 'deletePost';
        if(response.msg.pass)
        {
          app.displayError('pass',response.msg);
        }
        else
        {
          app.displayError('other',response.msg);
        }
      }
    });
    // Je déclare la méthode fail, celle-ci sera executée si la réponse est insatisfaisante
    jqxhr.fail(function () {
      alert('Requête échouée');
    });
  },

  displayError: function(type, msg) {
    $('.error').remove();

    var div = $('<div>').addClass('error bg-warning text-center rounded p-2 mt-2 mb-2');

    if(type === 'pass')
    {
      div.html(msg['pass']);
      $('.password').val('');
      $('.newPassword').val('');
      $('.newPasswordConfirm').val('');
      $('.confirm-delete-post').val('');
      
    }
    else
    {
      div.html(msg);
    }
    
    if(app.target === 'desactivate')
    {
      div.appendTo($('.form-modal'));
    }
    else if (app.target === 'changePass')
    {
      div.appendTo($('.form-password'));
    }
    else if (app.target === 'newPost')
    {
      div.appendTo($('.form-new-post'));
    }
    else if (app.target === 'modifyPost')
    {
      div.appendTo($(app.postTarget));
    }
    else if (app.target === 'deletePost')
    {
      div.appendTo($('.form-delete-post'));
    }
    else 
    {
      console.log('Nani ?!')
    }
  }
};
$(app.init)