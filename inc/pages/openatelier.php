<?php
/*Classes requises pour alimenter la page*/
require_once ROOT.'src/view/article_view.php';
require_once ROOT.'src/model/gallery_model.php';
require_once ROOT.'src/view/gallery_view_for_mixte.php';
require_once ROOT.'src/view/gallery_slideshow_view.php';
/*Fin des classes requises pour alimenter la page*/
?>
<?php //Bloc article 
// Affiche un article depuis /json/articles/ (dupliquer ce bloc avec un autre fichier json pour ajouter un article)
(new ArticleView(ROOT.'json/articles/stained-glass-hub.json', $lang))->render();
//Fin bloc article ?>
<?php
//Bloc galerie
// Affiche une galerie (dupliquer ce bloc php avec un autre identifiant pour ajouter une galerie)
 //GalleryViewForMixte::display('WORKSTATIONS'); 
GallerySlideshowView::display('WORKSTATIONS', 3000);
 //Fin bloc galerie?>
<?php //Bloc article 
// Affiche un article depuis /json/articles/ (dupliquer ce bloc avec un autre fichier json pour ajouter un article)
(new ArticleView(ROOT.'json/articles/Workstation booking.json', $lang))->render();
 //Fin bloc article ?>
<?php
//Bloc galerie
// Affiche une galerie (dupliquer ce bloc php avec un autre identifiant pour ajouter une galerie)
GalleryViewForMixte::display('MOSAIC-WORKSHOP-SCHEDULE');
//Fin bloc galerie?>
 <script src="js/gallery_slideshow.js"></script>
