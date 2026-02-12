<?php
/*Classes requises pour alimenter la page*/
require_once ROOT.'src/view/article_view.php';
require_once ROOT.'src/model/gallery_model.php';
require_once ROOT.'src/view/gallery_view_for_mixte.php';
/*Fin des classes requises pour alimenter la page*/
?>

<?php (new ArticleView(ROOT.'json/articles/workshop.json', $lang))->render(); ?>
<?php GalleryViewForMixte::display('WORKSHOPS'); ?>

