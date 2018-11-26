<div class="row  justify-content-center data">
    <main class="col-lg-10">
    <?php if (isset($_SESSION['error']['addPostFail'])) : ?>
    <p class="col-lg-12 bg-warning rounded p-2 text-center ">
        <?=$_SESSION['error']['addPostFail'];?>
    </p>
    <?php endif; ?>
    <?php if (isset($_SESSION['success']['addPost'])) : ?>
    <p class="col-lg-12 bg-success rounded p-2 text-center text-light ">
        <?=$_SESSION['success']['addPost'];?>
    </p>
    <?php endif; ?>
        <div class="accordion" id="accordionExample">

            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-light col-12" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Mes informations
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        <div class=" d-md-flex justify-content-around my-infos">
                            <ul class="list-group list-group-flush col-md-4 col-12 mb-3">
                                <li class="list-group-item text-center"><?=$_SESSION['user']['name'];?></li>
                                <li class="list-group-item text-center"><?=$_SESSION['user']['email'];?></li>
                                <button type="button" class="btn btn-danger mt-3 unsubscribe" data-toggle="modal" data-target="#confirm-modal" data-whatever="@getbootstrap">Désactiver mon compte</button>
                                <?php if (isset($_SESSION['error']['desactivateFail'])) : ?>
                                    <span class="text-center bg-warning rounded p-2 mt-2"><?=$_SESSION['error']['desactivateFail']; ?></span>
                                <?php endif; ?>
                            </ul>
                            <form class="col-md-5 col-12 form-password">
                                <div class="form-group mb-1">
                                    <p>Changer de mot de passe</p>
                                    <input type="password" class="form-control password" placeholder="Mot de passe actuel">
                                </div>
                                <div class="form-group mb-1">
                                    <input type="password" class="form-control newPassword" placeholder="Nouveau mot de passe">
                                </div>
                                <div class="form-group mb-1">
                                    <input type="password" class="form-control newPasswordConfirm" placeholder="Confirmer le nouveau mot de passe">
                                </div>
                                <button type="submit" class="btn btn-light">Valider</button>
                                <?php if (isset($_SESSION['error']['changePassFail'])) : ?>
                                    <div class="text-center bg-warning rounded p-2 mt-2"><?=$_SESSION['error']['changePassFail']; ?></div>
                                <?php endif ?>
                                <?php if (isset($_SESSION['error']['passwordFail'])) : ?>
                                        <div class="text-center bg-warning rounded p-2 mt-2"><?=$_SESSION['error']['passwordFail']; ?></div>
                                <?php endif ?>
                                <?php if (isset($_SESSION['success']['changePass'])) : ?>
                                        <div class="text-center bg-success rounded p-2 mt-2 text-light"><?=$_SESSION['success']['changePass']; ?></div>
                                <?php endif ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-light collapsed col-12" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Publier un article
                        </button>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body d-md-flex justify-content-center">
                        <form class="col-md-9 col-12 form-new-post">
                            <div class="form-group">
                                <p>Titre de l'article</p>
                                <input type="text" class="form-control" id="title" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <p>Sous titre / Phrase de présentation</p>
                                <textarea class="form-control" id="resume" rows="2"></textarea>
                            </div>
                            <div class="form-group">
                                <p>Contenu</p>
                                <textarea class="form-control" id="content" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="category">
                                <option selected disabled>Catégorie</option>
                                <?php foreach ($_SESSION['category'] as $id => $name) : ?>
                                <option value="<?=$id?>"><?=$name?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-light">Valider</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-light collapsed col-12" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Mes articles
                        </button>
                    </h5>
                </div>
                
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body">
                        <?php if(isset($_SESSION['user']['posts'])) : 
                              foreach ($_SESSION['user']['posts'] as $post) :?>
                        
                                <article class="card" data-postid="<?=$post['id'];?>">
                                    <div class="card-body">
                                        <h2 class="card-title"><?=$post['title'];?></h2>
                                        <p class="card-text"><?=$post['resume'];?></p>
                                        <p class="card-text"><?=$post['content'];?></p>
                                        <p class="infos">
                                            Posté le <time><?=$post['created_at'];?></time> 
                                            <?php if(!is_null($post['updated_at'])): ?>
                                                modifié le <time><?=$post['updated_at'];?></time>
                                            <?php endif; ?>
                                            dans <span><?=$post['category'];?></span>
                                        </p>
                                        <button type="button" class="btn btn-danger">Supprimer</button>
                                        <button type="button" class="btn btn-warning">Modifier</button>
                                    </div>
                                </article>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <p>Vous n'avez pas encore écris d'article</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>


<div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="confirm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title">Entrez votre mot de passe pour confirmer </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-modal">
          <div class="form-group">
            <input type="password" class="form-control" id="pass-confirm">
          </div>
        <div class="modal-footer border-0">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger confirm-button">Confirmer</button>
        </div>
        </form>
      </div>

    </div>
  </div>
</div>

<?php
// j'attend la fin du chargement de la page pour remettre à 0 mes messages d'erreur / succes stocké en session

unset($_SESSION['error']);
unset($_SESSION['success']);

?>