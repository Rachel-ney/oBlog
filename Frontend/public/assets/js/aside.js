var aside = {
  uri: '',
  init: function () {
    // je récupère la base uri : 
    aside.uri = $('main').data("uri");
    aside.recoverCategoryList();
    aside.recoverAuthorList();
  },

  recoverCategoryList: function () {
    var jqxhr = $.ajax({
      url: 'http://localhost/Projet_perso/oBlog/Backend/public/all-category', // URL sur laquelle faire l'appel Ajax
      method: 'GET', // La méthode HTTP souhaité pour l'appel Ajax (GET ou POST)
      dataType: 'json', // Le type de données attendu en réponse (text, html, xml, json)
    });
    // Je déclare la méthode done, celle-ci sera executée si la réponse est satisfaisante
    jqxhr.done(function (response) {
      // j'affiche la liste de mes catégorie
      aside.displayList(response.allCategory, 'category');
    });
    // Je déclare la méthode fail, celle-ci sera executée si la réponse est insatisfaisante
    jqxhr.fail(function () {
      alert('Requête échouée');
    });
  },

  recoverAuthorList: function () {
    var jqxhr = $.ajax({
      url: 'http://localhost/Projet_perso/oBlog/Backend/public/all-author', // URL sur laquelle faire l'appel Ajax
      method: 'GET', // La méthode HTTP souhaité pour l'appel Ajax (GET ou POST)
      dataType: 'json', // Le type de données attendu en réponse (text, html, xml, json)
    });
    // Je déclare la méthode done, celle-ci sera executée si la réponse est satisfaisante
    jqxhr.done(function (response) {
      // j'affiche la liste de mes auteurs
      aside.displayList(response.allAuthor, 'author');
    });
    // Je déclare la méthode fail, celle-ci sera executée si la réponse est insatisfaisante
    jqxhr.fail(function () {
      alert('Requête échouée');
    });
  },

  displayList: function (allList, listType) {
    // pour chaque catégorie que j'ai récupéré de ma bdd
    for (var currentIndex in allList) 
    {
      // je genere un nouveau li
      var $newList = aside.generateList(allList[currentIndex].name, allList[currentIndex].id, listType);
      // Celon son type
      if (listType === 'category') 
      {
        // je l'insère dans la liste catégorie
        $($newList).appendTo('.category-aside');
      } 
      else if (listType === 'author') 
      {
        // ou dans la liste auteur
        $($newList).appendTo('.author-aside');
      }
    }
  },

  generateList: function (name, id, listType) {
    if (listType === 'category') 
    {
      // je séléctionne le premier enfant de ma liste catégorie
      var list = $('.category-aside').children()[0];
    } 
    else if (listType === 'author') 
    {
      // je séléctionne le premier enfant de ma liste auteur
      var list = $('.author-aside').children()[0];
    }
    // je le clone
    var $newList = $(list).clone();
    // je lui retire le display none de bootstrap
    $newList.removeClass('d-none');
    // je rempli le lien qu'il contient avec le nom de la catégorie
    $newList.find('a').html(name);
    // je préformate l'url à attribuer à mon lien: 
    if (listType === 'category') 
    {
      var $url = 'http://localhost'+ aside.uri +'/categorie/' + id;
    } 
    else if (listType === 'author') 
    {
      var $url = 'http://localhost'+ aside.uri +'/auteur/' + id;
    }
    // je rempli le href du lien
    $newList.find('a').attr('href', $url);
    return $newList;
  }

};
$(aside.init);