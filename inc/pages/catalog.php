<?php

/* Classes requises pour alimenter la page */
require_once ROOT . 'src/view/article_view.php';
require_once ROOT . 'src/model/gallery_model.php';
require_once ROOT . 'src/model/model_galleries_choices.php';
require_once ROOT . 'src/view/gallery_view.php';
require_once ROOT . 'src/view/gallery_view_for_mixte.php';

/* Article d'introduction */
(new ArticleView(
    ROOT . 'json/articles/Catalog_advise.json',
    $lang
))->render();


/*
 * Galerie sélectionnée
 */
$selectedGallery = isset($_GET['gallery'])
    ? htmlspecialchars($_GET['gallery'])
    : '';


/*
 * Récupération des galeries visibles
 */
$galleriesModel = new ModelGalleryChoices(
    'img/content/galleries/',
    ROOT . 'json/galleries_config.json'
);

$galleryChoices = $galleriesModel->getGalleryChoices($lang);


/*
 * Détermination de la galerie à afficher
 *
 * Si aucune galerie n'est sélectionnée dans l'URL,
 * on affiche automatiquement la première galerie visible.
 */
if (
    !empty($selectedGallery)
    && array_key_exists($selectedGallery, $galleryChoices)
) {
    $galleryName = $selectedGallery;
} else {
    $galleryName = array_key_first($galleryChoices);
}


/*
 * Menu des galeries
 */
echo '<ul class="responsiveMenu">';

foreach ($galleryChoices as $folder => $label) {

    $selected = ($galleryName === $folder)
        ? 'selected-item'
        : '';

    $href = '?page=catalog&gallery='
        . urlencode($folder)
        . '&lang='
        . urlencode($lang);

    echo "<li class='gallery-item $selected'>";
    echo '<a href="' . htmlspecialchars($href) . '">'
        . htmlspecialchars($label)
        . '</a>';
    echo '</li>';
}

echo '</ul>';


/*
 * Affichage de la galerie
 */
if ($galleryName !== null) {

    $cheminImages = $repImg
        . 'galleries/'
        . $galleryName
        . '/original';

    try {

        $gallery = new Model_gallery(
            $cheminImages,
            'image/jpeg'
        );

        $images = $gallery->getImages();

        $view = new View_gallery(
            $images,
            $galleryName
        );

        echo $view->render();

    } catch (Exception $e) {

        echo 'Erreur : '
            . htmlspecialchars($e->getMessage());
    }
}

?>
<!-- /container -->
<script src="js/imagesloaded.pkgd.min.js"></script>
<script src="js/masonry.pkgd.min.js"></script>
<script src="js/classie.js"></script>
<script src="js/main.js"></script>
<script>
    (function () {
        // create SVG circle overlay and append it to the preview element
        function createCircleOverlay(previewEl) {
            var dummy = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            dummy.setAttributeNS(null, 'version', '1.1');
            dummy.setAttributeNS(null, 'width', '100%');
            dummy.setAttributeNS(null, 'height', '100%');
            dummy.setAttributeNS(null, 'class', 'overlay');
            var g = document.createElementNS('http://www.w3.org/2000/svg', 'g');
            var circle = document.createElementNS("http://www.w3.org/2000/svg", "circle");
            circle.setAttributeNS(null, 'cx', 0);
            circle.setAttributeNS(null, 'cy', 0);
            circle.setAttributeNS(null, 'r', Math.sqrt(Math.pow(previewEl.offsetWidth, 2) + Math.pow(previewEl.offsetHeight, 2)));
            dummy.appendChild(g);
            g.appendChild(circle);
            previewEl.appendChild(dummy);
        }

        new GridFx(document.querySelector('.grid'), {
            onInit: function (instance) {
                createCircleOverlay(instance.previewEl);
            },
            onResize: function (instance) {
                instance.previewEl.querySelector('svg circle').setAttributeNS(null, 'r', Math.sqrt(Math.pow(instance.previewEl.offsetWidth, 2) + Math.pow(instance.previewEl.offsetHeight, 2)));
            },
            onOpenItem: function (instance, item) {
                // item's image
                var gridImg = item.querySelector('img'),
                    gridImgOffset = gridImg.getBoundingClientRect(),
                    win = {
                        width: document.documentElement.clientWidth,
                        height: window.innerHeight
                    },
                    SVGCircleGroupEl = instance.previewEl.querySelector('svg > g'),
                    SVGCircleEl = SVGCircleGroupEl.querySelector('circle');

                SVGCircleEl.setAttributeNS(null, 'r', Math.sqrt(Math.pow(instance.previewEl.offsetWidth, 2) + Math.pow(instance.previewEl.offsetHeight, 2)));
                // set the transform for the SVG g node. This will animate the circle overlay. The origin of the circle depends on the position of the clicked item.
                if (gridImgOffset.left + gridImg.offsetWidth / 2 < win.width / 2) {
                    SVGCircleGroupEl.setAttributeNS(null, 'transform', 'translate(' + win.width + ', ' + (gridImgOffset.top + gridImg.offsetHeight / 2 < win.height / 2 ? win.height : 0) + ')');
                } else {
                    SVGCircleGroupEl.setAttributeNS(null, 'transform', 'translate(0, ' + (gridImgOffset.top + gridImg.offsetHeight / 2 < win.height / 2 ? win.height : 0) + ')');
                }
            }
        });
    })();
</script>