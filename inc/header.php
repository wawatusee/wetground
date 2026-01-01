<header>
   <div class="mainTitleBlock">
      <h1 class="mainsubtitle">
         <span class="title-elmt">wet ground glass works</span>
      </h1>
      <h2>a place to make, learn, share</h2>
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