<?php
/*Classes requises pour alimenter la page*/
require_once ROOT.'src/view/article_view.php';
require_once ROOT.'src/model/gallery_model.php';
require_once ROOT.'src/view/gallery_view_for_mixte.php';
/*Fin des classes requises pour alimenter la page*/
?>
<?php/*
$pathWorkshop = ROOT . 'json/articles/workshop.json'; // Vérifie bien ce chemin !
$articleWorkshop = new ArticleView($pathWorkshop, $lang);
$articleWorkshop->render();*/
?>
<?php (new ArticleView(ROOT.'json/articles/workshop.json', $lang))->render(); ?>
<?php GalleryViewForMixte::display('WORKSHOPS'); ?>
<?php/*
try {
    // 1. Le Modèle : On va chercher la donnée brute
    // On passe le chemin physique complet (ROOT)
    $folderName = 'WORKSHOPS';
    //$model = new Model_gallery(ROOT.'public/img/content/galleries/' . $folderName);
    $model = new Model_gallery(ROOT.'public/img/content/galleries/' . $folderName . '/original');
    $data = $model->getImages();
    // 2. La Vue : On lui confie la donnée pour le rendu
    // Elle n'a besoin que du tableau et du nom de dossier pour les URLs
    $view = new GalleryViewForMixte($data, $folderName);
    // 3. Affichage
    $view->render();

} catch (Exception $e) {
    echo "Erreur galerie : " . $e->getMessage();
}
*/?>
