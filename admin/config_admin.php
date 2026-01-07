<?php
$lapin='carottes';
// Pages accessibles dans l’admin
define('ADMIN_PAGES', [
    'dashboard',
    'pages',
    'articles',
    'galleries'
]);

// Dossier JSON des contenus
define('JSON_PAGES_DIR', realpath(__DIR__ . '/../json/pages/'));
