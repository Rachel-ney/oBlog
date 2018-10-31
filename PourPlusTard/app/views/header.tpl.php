<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Sonic</title>
</head>
<body>
<nav>
    <ul>
        <li><a class="button" href="<?= $this->router->generate('home') ?>">Acceuil</a></li>
        <li><a class="button" href="<?= $this->router->generate('creator') ?>">Page des créateurs</a></li>
    </ul>
</nav>
    <div class="container">
