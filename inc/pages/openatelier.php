<?php
// 1. Chargement des outils et dépendances
require_once '../src/utils/json_loader.php';
require_once '../src/model/article_model.php';
require_once '../src/view/article_view.php';

// Configuration globale pour la page
$lang = $_GET['lang'] ?? 'fr';

// --- Bloc : Hub (Atelier partagé) ---
$hubPath = '../json/articles/stained-glass-hub.json';

try {
    // On extrait, on modélise et on prépare la vue avec le préfixe 'hub'
    $hubData  = JsonLoader::load($hubPath);
    $hubModel = new ArticleModel($hubData);
    $hubView  = new ArticleView($hubModel->getData(), $lang);
} catch (Exception $e) {
    // On peut logger l'erreur et décider de ne pas afficher ce bloc précis
    $hubView = null; 
}
?>

<section class="core">

    <?php if ($hubView): ?>
        <?php $hubView->render(); ?>
    <?php else: ?>
        <p>Contenu temporairement indisponible.</p>
    <?php endif; ?>

</section>