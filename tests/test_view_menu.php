<?php
require_once '../src/view/view_menus.php'; // Chemin vers votre classe

// --- UTILITAIRE DE TEST SIMPLE ---
function assertContains(string $needle, string $haystack, string $message) {
    if (strpos($haystack, $needle) !== false) {
        echo "✅ SUCCESS : $message\n";
    } else {
        echo "❌ FAILED : $message\n";
        echo "   Attendu : $needle\n";
        echo "   Reçu : " . htmlspecialchars($haystack) . "\n";
    }
}

// --- PRÉPARATION DES DONNÉES ---
$item = new stdClass();
$item->page = "catalog";
$item->titre = new stdClass();
$item->titre->fr = "Catalogue";
$item->titre->en = "Catalog";
$menuArray = [$item];

echo "--- Démarrage des tests du menu ---\n\n";

// --- TEST 1 : Vérification du format d'URL (Anglais) ---
$viewEn = new ViewMenu('en');
$htmlEn = $viewEn->getViewMainMenu($menuArray, false);

// Correction : On cherche la présence de la query string sans se soucier des guillemets
assertContains(
    'page=catalog&amp;lang=en', 
    $htmlEn, 
    "L'URL doit contenir les paramètres page et lang avec l'encodage HTML"
);

// --- TEST 2 : Vérification de la traduction (Français) ---
$viewFr = new ViewMenu('fr');
$htmlFr = $viewFr->getViewMainMenu($menuArray, false);
assertContains(
    '>Catalogue</a>', 
    $htmlFr, 
    "Le libellé doit être traduit en Français"
);

// --- TEST 3 : Vérification de la classe Active ---
// Ici aussi, on va être plus souple sur les guillemets
$htmlActive = $viewFr->getViewMainMenu($menuArray, false, 'catalog');
assertContains(
    "itemMenu active", 
    $htmlActive, 
    "La classe 'active' doit être présente"
);


