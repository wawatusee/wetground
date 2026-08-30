<?php
// Configuration des chemins
$galleriesDir = '../public/img/content/galleries/';
$jsonPath = '../json/galleries_config.json';

// 1. Chargement de la config existante
$config = file_exists($jsonPath) ? json_decode(file_get_contents($jsonPath), true) : [];

// 2. Traitement du formulaire (Sauvegarde)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_config'])) {
    $newConfig = [];
    if (isset($_POST['folders'])) {
        foreach ($_POST['folders'] as $folder => $data) {
            $newConfig[$folder] = [
                'visible' => isset($data['visible']),
                'label_fr' => htmlspecialchars($data['label_fr']),
                'label_en' => htmlspecialchars($data['label_en'])
            ];
        }
    }
    file_put_contents($jsonPath, json_encode($newConfig, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $config = $newConfig;
    echo "<p style='color:green;'>✅ Configuration mise à jour !</p>";
}

// 3. Scan des dossiers physiques pour trouver des nouveautés
$physicalFolders = array_diff(scandir($galleriesDir), ['.', '..']);
?>

<h1>Gestion du Catalogue</h1>
<form method="post">
    <table border="1" cellpadding="10" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr style="background: #eee;">
                <th>Dossier Physique</th>
                <th>Visible</th>
                <th>Label FR</th>
                <th>Label EN</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($physicalFolders as $folder): 
                if (!is_dir($galleriesDir . $folder)) continue;
                
                // On récupère les infos du JSON ou des valeurs par défaut
                $info = $config[$folder] ?? ['visible' => false, 'label_fr' => $folder, 'label_en' => $folder];
            ?>
            <tr>
                <td><strong><?= $folder ?></strong></td>
                <td align="center">
                    <input type="checkbox" name="folders[<?= $folder ?>][visible]" <?= $info['visible'] ? 'checked' : '' ?>>
                </td>
                <td>
                    <input type="text" name="folders[<?= $folder ?>][label_fr]" value="<?= htmlspecialchars($info['label_fr']) ?>">
                </td>
                <td>
                    <input type="text" name="folders[<?= $folder ?>][label_en]" value="<?= htmlspecialchars($info['label_en']) ?>">
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <button type="submit" name="save_config" style="padding: 10px 20px; cursor: pointer;">Enregistrer la configuration</button>
</form>