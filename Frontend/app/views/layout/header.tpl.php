<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Déclaration de notre font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,800" rel="stylesheet">

    <!-- Font awesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
        crossorigin="anonymous">
    <!-- Ma feuille de style pour mon blog -->
    <link rel="stylesheet" href="<?=$_SERVER['BASE_URI']?>/assets/css/blog.css">
    <?php if ($this->var['js'][0] === 'memory') : ?>
    <link rel="stylesheet" href="<?=$_SERVER['BASE_URI'];?>/assets/css/memory.css">
    <link href="https://fonts.googleapis.com/css?family=Neucha" rel="stylesheet">
    <?php endif; ?>
    <title>oBlog</title>
</head>
<body>

    <!-- HEADER -->
    <header class="col-12 px-0">
        <?php $this->includeOne('/layout/nav') ?>
        <section class="text-center">
            <h1>A la dérive</h1>
            <hr />
            <p>
                Un blog collaboratif de développeurs web dérivant délibérément au milieu de l'espace
            </p>
        </section>
    </header>

    <!-- Serveur : data-back="https://api.rachel-michel.fr" -->
    <!-- Local : data-back="http://localhost/Projet_perso/oBlog/Backend" -->

    <div class="container-fluid" data-uri="<?=$_SERVER['BASE_URI'];?>" data-back="http://localhost/Projet_perso/oBlog/Backend" data-sess="<?= session_id();?>">