<?php $lexique_header_devise = [
    "fr" => "Une place pour faire, apprendre, partager",
    "en" => "A place to make, learn, share",
    "nl" => "Een plek om te maken, te leren en te delen"
];

$lexique_header_sstre = [
    "fr" => "Vitraux",
    "en" => "Glass works",
    "nl" => "Glas-in-lood",
];
?>



<header>
   <div class="mainTitleBlock">
      <h1 class="mainsubtitle">
         <span class="title-elmt">wet ground</span>
         <span class="title-elmt"> <?= $lexique_header_sstre[$lang] ?? $lexique_header_sstre['fr']; ?></span>
      </h1>
      <h2><?= $lexique_header_devise[$lang] ?? $lexique_header_devise['fr']; ?></h2>
   </div>
   <div class="menulangues">
      <?php foreach ($langs as $code_langue => $nom_langue): ?>
         <a href="?<?= http_build_query(array_merge($_GET, ['lang' => $code_langue])) ?>"
            class="<?= ($lang === $code_langue) ? 'active-lang' : '' ?>">
            <?= strtoupper($code_langue) ?>
         </a>
      <?php endforeach; ?>
   </div>

   <div class="menu">
      <?php require_once "../inc/nav.php" ?>
   </div>
</header>