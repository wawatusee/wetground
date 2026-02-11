<?php
require_once '../src/view/article_view.php';

// Le développeur voit exactement le chemin utilisé
$path = __DIR__ . '/json/workshop.json'; 
$lang = 'fr';

$article = new ArticleView($path, $lang);
?>

<div class="container">
    <?php $article->render(); ?>
</div>