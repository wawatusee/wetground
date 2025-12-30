<?php
require_once '../src/utils/json_loader.php';
require_once '../src/model/article_model.php';
require_once '../src/view/article_view.php';
$lang = $_GET['lang'] ?? 'fr';
$articleModel  = new ArticleModel('../json/articles/stained-glass-hub.json');
var_dump($articleModel);
//$article = new ArticleModel($path);

$view = new ArticleView(
    $articleModel->getData(),
    $lang
);

$view->render();

?>

<section class="core">
    
    <h2>Open atelier</h2>
    <!--<img class="illu-studio" src="<?=$repImg?>studio/studio-reduit-animated.gif" alt="">-->
    <article class="simple-article">
        <?= $studioPricingContentML[$lang] ?>
    </article>

</section>