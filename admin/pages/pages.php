<?php
// Chargement du menu
$menuFile = __DIR__ . '/../../json/menus.json';
$pagesDir = JSON_PAGES_DIR;

// sécurité dossiers
if (!is_dir($pagesDir)) {
    mkdir($pagesDir, 0777, true);
}

// lire menu json
$menu = file_exists($menuFile) ? json_decode(file_get_contents($menuFile), true) : [];

$menuPages = [];

// récupérer les pages du Main_menu
if (!empty($menu['Main_menu'])) {
    foreach ($menu['Main_menu'] as $item) {
        if (!empty($item['page'])) {
            $menuPages[] = $item['page'] . '.json';
        }
    }
}

// fallback si menu vide
if (empty($menuPages)) {
    $menuPages[] = 'dashboard.json';
}

// création automatique fichiers manquants
foreach ($menuPages as $file) {
    $path = $pagesDir . '/' . $file;

    if (!file_exists($path)) {
        file_put_contents($path, json_encode([
            "title" => ["fr" => $file, "en" => $file],
            "blocks" => [
                [
                    "type" => "text",
                    "content" => [
                        "fr" => "",
                        "en" => ""
                    ]
                ]
            ]
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

// bouton nouvelle page
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_page'])) {

    $newSlug = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['new_slug'] ?? '');
    if ($newSlug !== '') {

        $newFile = $pagesDir . '/' . $newSlug . '.json';

        if (!file_exists($newFile)) {
            file_put_contents($newFile, json_encode([
                "title" => ["fr" => $newSlug, "en" => $newSlug],
                "blocks" => [
                    [
                        "type" => "text",
                        "content" => ["fr" => "", "en" => ""]
                    ]
                ]
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        // on redirige dessus
        header("Location: ?edit=" . urlencode($newSlug . '.json'));
        exit;
    }
}

// sauvegarde d'une page
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_page'])) {

    $pageFile = basename($_POST['page_file']);
    $jsonPath = $pagesDir . '/' . $pageFile;

    $data = [
        "title" => [
            "fr" => $_POST['title_fr'] ?? '',
            "en" => $_POST['title_en'] ?? ''
        ],
        "blocks" => [
            [
                "type" => "text",
                "content" => [
                    "fr" => $_POST['text_fr'] ?? '',
                    "en" => $_POST['text_en'] ?? ''
                ]
            ]
        ]
    ];

    file_put_contents($jsonPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    $msg = "Page sauvegardée ✔️";
}

// page sélectionnée
$selectedPage = $_GET['edit'] ?? ($menuPages[0] ?? null);

$selectedPath = $selectedPage ? $pagesDir . '/' . $selectedPage : null;

$pageData = ($selectedPath && file_exists($selectedPath))
    ? json_decode(file_get_contents($selectedPath), true)
    : null;

?>
<section class="form-contener">

    <h2>Gestion des pages</h2>

    <?php if (!empty($msg)): ?>
        <p style="color: green;"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <h3>Créer une nouvelle page</h3>

    <form method="post">
        <input type="text" name="new_slug" placeholder="slug_exemple">
        <button type="submit" name="new_page">➕ Nouvelle page</button>
    </form>

    <hr>

    <h3>Éditer une page</h3>

    <form method="get">
        <select name="edit" onchange="this.form.submit()">
            <?php foreach ($menuPages as $file): ?>
                <option value="<?= htmlspecialchars($file) ?>"
                    <?= ($file === $selectedPage ? 'selected' : '') ?>>
                    <?= htmlspecialchars($file) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if ($pageData): ?>

        <form method="post">

            <input type="hidden" name="page_file" value="<?= htmlspecialchars($selectedPage) ?>">

            <label>Titre FR</label>
            <input type="text" name="title_fr"
                   value="<?= htmlspecialchars($pageData['title']['fr'] ?? '') ?>">

            <label>Titre EN</label>
            <input type="text" name="title_en"
                   value="<?= htmlspecialchars($pageData['title']['en'] ?? '') ?>">

            <?php
            $block = $pageData['blocks'][0] ?? ['content' => ['fr'=>'','en'=>'']];
            ?>

            <label>Texte FR</label>
            <textarea name="text_fr"><?= htmlspecialchars($block['content']['fr'] ?? '') ?></textarea>

            <label>Texte EN</label>
            <textarea name="text_en"><?= htmlspecialchars($block['content']['en'] ?? '') ?></textarea>

            <button type="submit" name="save_page">💾 Sauvegarder</button>

        </form>

    <?php endif; ?>

</section>
