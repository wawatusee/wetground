<?php
$menuMain_model = $menus->getMenu("Main_menu");
require_once("../src/view/view_menus.php");
$menusView = new ViewMenu($lang);
// Détection de la page active
$currentPage = $_GET['page'] ?? null;
//Le deuxième paramètre determine le comportement du site en singlepage ou pas
$menuMain_view = $menusView->getViewMainMenu(
    $menuMain_model,
    $singlePage,
    $currentPage
);
?>
<nav class="responsiveMenu" id="responsiveMenu">
  <button class="icon" id="menuToggle" aria-label="Ouvrir ou fermer le menu" aria-expanded="false">
    <span id="menuIcon">☰</span>
  </button>
<?php echo $menuMain_view; ?>
</nav>