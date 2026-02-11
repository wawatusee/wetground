<?php
require_once ROOT.'src/view/article_view.php';
echo "<h2>lapin 1 (Inclusion OK)</h2>";

$path = ROOT . 'json/articles/workshop.json'; // Vérifie bien ce chemin !
$article = new ArticleView($path, 'fr');
echo "<h2>lapin 2 (Instanciation OK)</h2>";

$article->render();
echo "<h2>lapin 3 (Rendu terminé)</h2>";
?>