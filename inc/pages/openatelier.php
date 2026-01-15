<?php
require_once '../src/utils/json_loader.php';
require_once '../src/model/article_model.php';
require_once '../src/view/article_view.php';
$lang = $_GET['lang'] ?? 'fr';
$articleModel = new ArticleModel(JSON . 'articles/stained-glass-hub.json');
//var_dump($articleModel);
//$article = new ArticleModel($path);

$view = new ArticleView(
    $articleModel->getData(),
    $lang
);
?>
<section class="core">

    <?php $view->render(); ?>

</section>