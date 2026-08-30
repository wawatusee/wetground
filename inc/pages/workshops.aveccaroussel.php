<?php
/*Classes requises pour alimenter la page*/
require_once ROOT.'src/view/article_view.php';
require_once ROOT.'src/model/gallery_model.php';
require_once ROOT.'src/view/gallery_view_for_mixte.php';
/*Fin des classes requises pour alimenter la page*/
?>

<?php
//Bloc article 
// Affiche un article depuis /json/articles/ (dupliquer ce bloc avec un autre fichier json pour ajouter un article)
(new ArticleView(ROOT.'json/articles/workshop.json', $lang))->render();
//Fin Bloc article 
 ?>
<?php
//Bloc galerie
// Affiche une galerie (dupliquer ce bloc php avec un autre identifiant pour ajouter une galerie)
GalleryViewForMixte::display('WORKSHOPS');
//Fin Bloc galerie
?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const container = document.querySelector('.gallery-mixte-container');
    if (!container) return;

    // 1. On crée un wrapper autour de la galerie pour positionner les flèches
    const wrapper = document.createElement('div');
    wrapper.className = 'gallery-mixte-wrapper';
    container.parentNode.insertBefore(wrapper, container);
    wrapper.appendChild(container);

    // 2. Création des boutons
    const btnPrev = document.createElement('button');
    btnPrev.className = 'nav-btn btn-prev';
    btnPrev.innerHTML = '&#10094;';

    const btnNext = document.createElement('button');
    btnNext.className = 'nav-btn btn-next';
    btnNext.innerHTML = '&#10095;';

    wrapper.appendChild(btnPrev);
    wrapper.appendChild(btnNext);

    // 3. Logique de mouvement (80% de la largeur visible)
    btnNext.addEventListener('click', () => {
        const offset = container.offsetWidth * 0.8;
        container.scrollBy({ left: offset, behavior: 'smooth' });
    });

    btnPrev.addEventListener('click', () => {
        const offset = container.offsetWidth * 0.8;
        container.scrollBy({ left: -offset, behavior: 'smooth' });
    });
});
</script>
