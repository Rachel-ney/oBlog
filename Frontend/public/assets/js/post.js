var appPost = {
    url: '',
    uri: '',

    init: function() {
      // je récupère la base uri : 
      appPost.uri = $('main').data("uri");
      // je determine quels articles je vais devoir récupérer en fonction du nom du data
      if (typeof $('main').data("category") !== 'undefined') {
          appPost.constructUrl('category');
      }
      else if (typeof $('main').data("author") !== 'undefined')
      {
        appPost.constructUrl('author');
      }
      else if (typeof $('main').data("all") !== 'undefined')
      {
        appPost.constructUrl('all');
      }
      else if (typeof $('main').data("one") !== 'undefined')
      {
        appPost.constructUrl('one');
      }
      else 
      {
          console.log('pas de data à analyser');
      }

      // je récupère les données en passant par mon api
      appPost.recoverPost();
    },
  
    constructUrl: function(type) {
        // je construit mon url vers mon api en fonction du type d'article voulu
        if (type === 'category' || type === 'author') 
        {
            var id = $('main').data(type);
            appPost.url = 'http://localhost/Projet_perso/oBlog/Backend/public/all-post-by/'+ type +'/'+ id ;
        }
        else if(type === 'all') 
        {
            appPost.url = 'http://localhost/Projet_perso/oBlog/Backend/public/all-post';
        }
        else if (type === 'one')
        {
            var id = $('main').data(type);
            appPost.url = 'http://localhost/Projet_perso/oBlog/Backend/public/one-post/'+ id;
        }
    },

    recoverPost: function() {
      var jqxhr = $.ajax({
        url: appPost.url, // URL sur laquelle faire l'appel Ajax
        method: 'GET', // La méthode HTTP souhaité pour l'appel Ajax (GET ou POST)
        dataType: 'json', // Le type de données attendu en réponse (text, html, xml, json)
      });
      // Je déclare la méthode done, celle-ci sera executée si la réponse est satisfaisante
      jqxhr.done(function (response) {
        // j'affiche la liste de mes auteurs
        appPost.displayPost(response.post);
        if (typeof response.msg !== 'undefined') 
        {
            $error = $('<div>').html('Oups on dirais bien qu\'il n\'y a pas encore d\'article ici');
            $($error).prependTo('main');
        }
      });
      // Je déclare la méthode fail, celle-ci sera executée si la réponse est insatisfaisante
      jqxhr.fail(function () {
        alert('Requête échouée');
      });
    },

    displayPost: function(postList) {
        // si la page concerne le détail d'un article
        if (typeof $('main').data("one") !== 'undefined')
        {
            var $newPost = appPost.generatePost(postList);
            // je l'ajoute à ma page
            $($newPost).prependTo('main');
        }
        // sinon la page doit afficher plusieurs articles 
        else 
        {
            for (var currentIndex in postList) 
            {
                // je genere un nouvel article
                var $newPost = appPost.generatePost(postList[currentIndex]);
                // je l'ajoute à ma page
                $($newPost).prependTo('main');
            }
        }

    },

    generatePost: function(post) {
        // je préformate les url de mes liens
        var urlPost =     'http://localhost'+ appPost.uri +'/article/' + post['id'];
        var urlAuthor =   'http://localhost'+ appPost.uri +'/auteur/' + post['authorId'];
        var urlCategory = 'http://localhost'+ appPost.uri +'/categorie/' + post['categoryId'];

        // je récupère le premier article
        var firstPost = $('main').children()[0];
        // je le clone
        var $newPost = $(firstPost).clone();
        // je retire la classe display none de bootstrap
        $newPost.removeClass('d-none');
        // je change le contenu du titre et le href de son lien
        $newPost.find('h2 a').html(post['title']).attr('href', urlPost);

        // si on dois afficher le détail d'un article
        if(typeof $('main').data("one") !== 'undefined')
        {
            // j'ajoute le résumé + le contenu
            var content = post['resume'] + '<br/><br/>' + post['content'];
            $newPost.find('p.card-text').html(content);
        }
        // sinon on affiche seulement le résumé
        else 
        {
            $newPost.find('p.card-text').html(post['resume']);
        }
        // je change le contenu + href du lien de l'auteur
        $($newPost.find('p.infos a')[0]).html(post['authorName']).attr('href', urlAuthor);
        // et le contenu + href du lien categorie
        $($newPost.find('p.infos a')[1]).html(post['categoryName']).attr('href', urlCategory);
        $newPost.find('p.infos time').html(post['created_at']);
        
        return $newPost;
    }
  };
  
  $(appPost.init);