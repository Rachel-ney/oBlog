<div class="row  justify-content-center">
    <main class="col-lg-10">
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
                        <div class=" d-md-flex justify-content-around">
                            <ul class="list-group list-group-flush col-md-4 col-12 mb-3">
                                <li class="list-group-item text-center">Pseudo</li>
                                <li class="list-group-item text-center">email</li>
                            </ul>
                            <form class="col-md-5 col-12">
                                <div class="form-group mb-1">
                                    <p>Changer de mot de passe</p>
                                    <input type="password" class="form-control" id="password" aria-describedby="emailHelp" placeholder="Mot de passe actuel">
                                </div>
                                <div class="form-group mb-1">
                                    <input type="password" class="form-control" id="newPassword" placeholder="Nouveau mot de passe">
                                </div>
                                <div class="form-group mb-1">
                                    <input type="password" class="form-control" id="newPasswordConfirm" placeholder="Confirmer le nouveau mot de passe">
                                </div>
                                <button type="submit" class="btn btn-light">Valider</button>
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
                        <form class="col-md-9 col-12">
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
                                <option>Catégorie</option>
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
                        <article class="card">
                            <div class="card-body">
                                <h2 class="card-title">Title</h2>
                                <p class="card-subtitle">Resume</p>
                                <p class="card-text">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deserunt, porro. Nihil, adipisci vel minima temporibus eos iste, tempora perferendis eius inventore odio optio nobis aperiam sed laboriosam quia deserunt voluptates cumque architecto suscipit! Ab aut rerum dolorum error, illo quaerat. Possimus assumenda aperiam numquam consequatur voluptatum facere illum deserunt amet!</p>
                                <p class="infos">
                                    Posté le <time>date</time> 
                                    dans <span>#Category</span>
                                </p>
                                <button type="button" class="btn btn-danger">Supprimer</button>
                                <button type="button" class="btn btn-warning">Modifier</button>
                            </div>
                        </article>
                        <article class="card">
                            <div class="card-body">
                                <h2 class="card-title">Title</h2>
                                <p class="card-subtitle">Resume</p>
                                <p class="card-text">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Optio ducimus et deserunt iure quia voluptates placeat, eligendi nesciunt iusto corrupti expedita sed tenetur laborum quasi cum quidem corporis labore fuga temporibus dolorem illo voluptatum alias rem! Ipsum est mollitia assumenda vel aspernatur eum accusantium temporibus explicabo repudiandae aliquid ratione corporis cupiditate labore delectus, quas id ex error alias non, eligendi quae! Ducimus totam praesentium expedita iste molestiae, ratione eaque aperiam magnam quod officia obcaecati consectetur ipsa accusamus, esse fugit odit sapiente. Doloribus eligendi beatae aut amet ea inventore itaque numquam consectetur nesciunt ad nostrum, voluptatum reprehenderit consequuntur modi asperiores culpa.</p>
                                <p class="infos">
                                    Posté le <time>date</time> 
                                    dans <span>#Category</span>
                                </p>
                                <button type="button" class="btn btn-danger">Supprimer</button>
                                <button type="button" class="btn btn-warning">Modifier</button>
                            </div>
                        </article>
                        
                    </div>
                </div>

            </div>
        </div>
    </main>
</div>
