<?php
// 1. Dépendances
require_once '../src/utils/json_loader.php';
require_once '../src/model/article_model.php';
require_once '../src/view/article_view.php';

$lang = $_GET['lang'] ?? 'fr';

// 2. On charge le "PLAN DE MONTAGE" (le layout)
$layoutPath = '../json/pages/workshops.json';

try {
    $pageStructure = JsonLoader::load($layoutPath);
    $blocks = $pageStructure['layout'] ?? [];
} catch (Exception $e) {
    $blocks = [];
}
?>

<section class="core">
    <?php
    // 3. On boucle sur chaque bloc défini dans l'admin
    foreach ($blocks as $block):

        // SI c'est une référence à un article
        if ($block['type'] === 'article_ref'):
            $articleFile = '../json/articles/' . $block['filename'];

            try {
                if (file_exists($articleFile)) {
                    $data = JsonLoader::load($articleFile);
                    $model = new ArticleModel($data);
                    $view = new ArticleView($model->getData(), $lang);

                    // Rendu immédiat du bloc
                    $view->render();
                }
            } catch (Exception $e) {
                echo "";
            }
            // ... à l'intérieur de ta boucle de blocs ...
        elseif ($block['type'] === 'gallery_ref'):
            // 1. On vérifie le chemin
            $galleryName = $block['folder'];
            // On s'assure que le chemin remonte bien à la racine si nécessaire
            $cheminImages = '../public/img/content/galleries/' . $galleryName . '/original';

            if (!is_dir($cheminImages)) {
                echo "";
            }

            try {
                require_once('../src/model/gallery_model.php');
                require_once("../src/view/gallery_view.php");

                // On enlève le filtre strict 'image/jpeg' pour tester si c'est plus large
                $galleryModel = new Model_gallery($cheminImages);
                $images = $galleryModel->getImages();

                if (!empty($images)): ?>
                    <div class="gallery-simple-grid">
                        <?php foreach ($images as $img):
                            // 1. On construit le chemin vers l'image originale
                            // On utilise $cheminImages que tu as défini plus haut
                            $originalPath = $cheminImages . '/' . $img['name'];

                            // 2. On génère le chemin vers la miniature (thumb)
                            // On remplace le dossier /original/ par /thumbs/ dans la chaîne
                            $thumbPath = str_replace('/original/', '/thumbs/', $originalPath);
                            ?>
                            <a href="<?= $originalPath ?>" class="gallery-link" target="_blank">
                                <img src="<?= $thumbPath ?>" width="<?= $img['width'] ?>" height="<?= $img['height'] ?>"
                                    alt="<?= htmlspecialchars($img['name']) ?>" loading="lazy">
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif;

            } catch (Exception $e) {
                echo "Erreur Galerie : " . $e->getMessage();
            }


            // SI c'est un composant spécial (Hero, Formulaire, etc.)
        elseif ($block['type'] === 'ui_component'):
            // Ici, on pourra inclure des fichiers de vue spécifiques plus tard
            // include '../src/view/components/' . $block['name'] . '.php';
            echo "<div class='ui-comp'>Composant : " . $block['name'] . "</div>";
        endif;

    endforeach;

    // Message si la page est vide
    if (empty($blocks)): ?>
        <p>Cette page n'a pas encore de contenu.</p>
    <?php endif; ?>
</section>