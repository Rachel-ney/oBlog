        <footer>
            <!-- Je crée une nouvelle ligne dans ma grille virtuelle: https://getbootstrap.com/docs/4.1/layout/grid/
                Je déclare également que ces elements doivent être centré (flex): https://getbootstrap.com/docs/4.1/utilities/flex/#justify-content
                ainsi que leur textes: https://getbootstrap.com/docs/4.1/utilities/text/#text-alignment -->
            <div class="row justify-content-center text-center">
                <div class="col-9 links">
                    <!-- Je créé une liste: https://getbootstrap.com/docs/4.1/components/list-group/ -->
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="<?= $this->router->generate('contact');?>">Me contacter</a></li>
                        <li class="list-inline-item"><a href="<?= $this->router->generate('aboutUs');?>">A propos </a></li>
                        <li class="list-inline-item"><a href="<?= $this->router->generate('legalMention');?>">Mentions légales</a></li>
                    </ul>
                </div>
            </div>

        </footer>

    </div> <!-- /.container -->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
        crossorigin="anonymous"></script>
    <?php if(isset($this->var['js'])) : ?>
        <?php foreach ($this->var['js'] as $js) : ?>
            <script src="<?=$_SERVER['BASE_URI']?>/assets/js/<?=$js;?>.js"></script>
        <?php endforeach ?>
    <?php endif; ?>
</body>
</html>