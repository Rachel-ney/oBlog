var aside = {
    init: function() {
        console.log('aside -> init');
        aside.addCategoryList();
    },
    addCategoryList: function() {
        console.log('aside->addCategoryList');
        var jqxhr = $.ajax(
            {
              url: 'http://api.okanban.local/lists', // URL sur laquelle faire l'appel Ajax
              method: 'GET', // La méthode HTTP souhaité pour l'appel Ajax (GET ou POST)
              dataType: 'json', // Le type de données attendu en réponse (text, html, xml, json)
            }
          );
            // Je déclare la méthode done, celle-ci sera executée si la réponse est satisfaisante
          jqxhr.done(function(response) 
          {
            console.log(response);
          });
          // Je déclare la méthode fail, celle-ci sera executée si la réponse est insatisfaisante
          jqxhr.fail(function() {
            alert('Requête échouée');
          });
    }

};
$(aside.init);