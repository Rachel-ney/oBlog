<?php

// Les différents articles sous forme d'objet
$articlesList = [
    new Article(
        'Ivre, il refait tous les challenges en un week-end sans dormir.',
        'Ou comment j\'ai appris plein de choses en faisant une nouvelle fois tous les challenges que j\'avais loupé.',
        'Alexandre',
        '2017-07-13',
        'Ma Vie De Dev'
    ),
    new Article(
        'POO or not POO, that is the question.',
        'La POO est-elle vraiment indispensable pour une architecture solide ? Etude de cas avec PHP.',
        'Julie',
        '2017-07-04',
        'TeamBack'
    ),
    new Article(
        'Git, pour les n00bs.',
        'Un p\'tit récap rapide pour tout ceux qui, comme moi, ont galéré sur ce magnifique outil de versionning.',
        'Lucie',
        '2017-06-19',
        'Collaboration'
    ),
    new Article(
        'Le syndrome de la page blanche',
        'Cette frustration quand le code ne vient pas, le temps passe, la deadline approche...',
        'Xavier',
        '2017-05-06',
        'Ma Vie De Dev'
    ),
];

// Les catégories
$categoriesList = [
    'TeamBack',
    'TeamFront',
    'Collaboration',
    'Ma Vie De Dev'
];

// Les auteurs
$authorsList = [
    'Maxime',
    'Anthony',
    'Alexandre',
    'Dario',
    'Julie',
    'Lucie',
    'Xavier'
];