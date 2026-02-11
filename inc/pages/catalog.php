<?php
/**
 * CATALOG.PHP - Version Stabilisée
 */

// 1. Chemins et Constantes (On utilise tes constantes si définies, sinon fallback)
$basePath = defined('IMG_URL') ? IMG_URL : '../public/img/';
$indexPath = '../img/content/galleries/galleries_index.json';

// 2. Récupération des données
$galleriesData = [];
if (file_exists($indexPath)) {
    $json = file_get_contents($indexPath);
    $galleriesData = json_decode($json, true) ?: [];
}

// 3. Galerie sélectionnée
$selectedGallery = isset($_GET['gallery']) ? htmlspecialchars($_GET['gallery']) : 'LEAD+TIFFANY';
$currentGalleryImages = [];

foreach ($galleriesData as $g) {
    if (isset($g['id']) && strtoupper($g['id']) === strtoupper($selectedGallery)) {
        $currentGalleryImages = $g['images'] ?? [];
        break;
    }
}
?>

<p class="catalog-intro">
    The pieces displayed on this page are not for sale. If you're interested in a picture on glass, don't hesitate to
    contact me. You can choose colour and size!
</p>

<ul class="gallery-menu" id="galleryMenu">
    <li class="gallery-item <?= ($selectedGallery === 'LEAD+TIFFANY') ? 'selected-item' : '' ?>">
        <a href="?page=catalog&gallery=LEAD+TIFFANY">LEAD+TIFFANY</a>
    </li>
    <li class="gallery-item <?= ($selectedGallery === 'PICTURE-ON-GLASS') ? 'selected-item' : '' ?>">
        <a href="?page=catalog&gallery=PICTURE-ON-GLASS">PICTURE-ON-GLASS</a>
    </li>
</ul>

<div class="grid">
    <?php if (!empty($currentGalleryImages)): ?>
        <?php foreach ($currentGalleryImages as $image): ?>
            <div class="grid__item" data-size="1280x1280">
                <a href="img/content/galleries/<?= $selectedGallery ?>/original/<?= $image['name'] ?>" class="img-wrap">
                    <img src="img/content/galleries/<?= $selectedGallery ?>/thumbs/<?= $image['name'] ?>"
                        alt="<?= htmlspecialchars($image['name']) ?>" loading="lazy" />
                </a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="padding: 20px; text-align: center;">No images found in this gallery.</p>
    <?php endif; ?>
</div>

<div class="preview">
    <button class="action action--close">
        <i class="fa fa-times"></i><span class="text-hidden">Close</span>
    </button>
    <div class="description-preview"></div>
</div>

<script src="js/imagesloaded.pkgd.min.js"></script>
<script src="js/masonry.pkgd.min.js"></script>
<script src="js/classie.js"></script>
<script src="js/main.js"></script>

<script>
    (function () {
        // 1. On nettoie tout avant de commencer
        const gridEl = document.querySelector('.grid');
        if (!gridEl) return;

        // 2. On attend le chargement des images
        // Note : Assure-toi que js/imagesloaded.pkgd.min.js est bien présent sur ton serveur
        imagesLoaded(gridEl, { background: true }, function () {
            console.log('Images chargées, initialisation de GridFx...');

            try {
                new GridFx(gridEl, {
                    onInit: function (instance) {
                        // Fonction simple pour l'overlay sans fioritures
                        const preview = instance.previewEl;
                        if (!preview.querySelector('.overlay')) {
                            const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                            svg.setAttribute('class', 'overlay');
                            svg.innerHTML = '<g><circle cx="0" cy="0" r="0"></circle></g>';
                            preview.appendChild(svg);
                        }
                    }
                });
            } catch (e) {
                console.error("Erreur GridFx : ", e);
            }
        });
    })();
</script>

<style>
    /* Un petit correctif pour voir le bouton close même sans FontAwesome */
    .action--close {
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        font-size: 20px;
        line-height: 40px;
    }

    .action--close:after {
        content: '✕';
    }

    /* X de secours si FontAwesome est bloqué */
</style>