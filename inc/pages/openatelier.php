<?php
// 1. Charger le Layout de la page
$layoutRaw = file_get_contents('../json/pages/openatelier.json');
$layoutData = json_decode($layoutRaw, true);

foreach ($layoutData['layout'] as $component) {
    if ($component['type'] === 'article_ref') {
        
        // 2. Aller chercher l'article pointé
        $articlePath = '../json/articles/' . $component['filename'];
        
        if (file_exists($articlePath)) {
            $articleData = json_decode(file_get_contents($articlePath), true);
            
            // 3. Utiliser un Renderer ou inclure une vue pour l'article
            renderArticle($articleData, $lang);
        }
    }
}

// Fonction d'exemple pour le rendu d'un article
function renderArticle($data, $lang) {
    foreach ($data['content'] as $block) {
        if ($block['type'] === 'title') {
            echo "<h{$block['level']}>" . $block['text'][$lang] . "</h{$block['level']}>";
        } 
        elseif ($block['type'] === 'text') {
            echo "<p>" . nl2br($block['content'][$lang]) . "</p>";
        }
    }
}
?>