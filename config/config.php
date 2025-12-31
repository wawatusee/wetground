<?php 
//Racine du site
define('ROOT', '../');
define('PUBLIC_URL', '../public/');
//Répertoire global des images
define('IMG_URL',PUBLIC_URL.'img/');
$repMedias=IMG_URL;
$repDeco=IMG_URL.'deco/';
$repImg=IMG_URL.'content/';
define('JSON','../json/');
require_once '../src/model/config_model.php';
$config = new Config(JSON . 'config.json');
//Config du site, partie publique
//Comportement single ou multipage,
// chaque section intégrée sera soit absorbée par la simple page ou deviendra une page à part entière
$singlePage = $config->get('singlePage', 0);
//Fin de comportement single ou multipage,
/*****************************************/
$title = $config->get('titleWebSite', []);
//Gestion de langue
$langs = $config->get('langs', []);

if (isset($_GET['lang']) && array_key_exists($_GET['lang'], $langs)) {
    $lang = $_GET['lang'];
} else {
    $lang = 'fr';
}
define('APP_LANG', $lang);
//Fin de gestion de langue
/************************/
//Paramètres de base du site
/*******/
/************************/
//Titre du site
//Les éléments du titre sont décomposés dans un tableau pour permettre plus de mobilité dans la présentation de celui-ci. 
$titleWebSite=["wetground.be"];
/************************/
//Fin des paramètres de base du site
//Fin de config du site, partie publique