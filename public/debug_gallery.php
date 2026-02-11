<?php
// debug_gallery.php
define('ROOT', './');
include 'inc/pages/catalog.php'; // On charge tes réglages

echo "<body style='background:#1a1a1a; color:#eee; font-family:sans-serif; padding:20px;'>";
echo "<h1>☀️ Diagnostic Sérénité</h1>";

$checkPath = 'img/content/galleries/galleries_index.json';

if (!file_exists($checkPath)) {
    echo "<p style='color:#ff5555;'>❌ L'index JSON est absent. On le recréera ensemble.</p>";
} else {
    $data = json_decode(file_get_contents($checkPath), true);
    echo "<p style='color:#55ff55;'>✅ Index JSON trouvé ! (" . count($data) . " galeries détectées)</p>";
    
    echo "<table border='1' style='border-collapse:collapse; width:100%;'>";
    echo "<tr style='background:#333;'><th>Galerie</th><th>Images</th><th>État Thumbs</th><th>État Originaux</th></tr>";
    
    foreach ($data as $g) {
        $id = $g['id'];
        $count = count($g['images']);
        $thumbOk = is_dir("img/content/galleries/$id/thumbs") ? "✅" : "❌";
        $origOk = is_dir("img/content/galleries/$id/original") ? "✅" : "❌";
        
        echo "<tr>";
        echo "<td><strong>$id</strong></td>";
        echo "<td align='center'>$count</td>";
        echo "<td align='center'>$thumbOk</td>";
        echo "<td align='center'>$origOk</td>";
        echo "</tr>";
    }
    echo "</table>";
}

echo "<p style='margin-top:20px;'>👉 <strong>Si tout est au vert :</strong> Ton erreur 500 n'était qu'un mauvais rêve de mémoire vive.<br>";
echo "👉 <strong>Si Brave rame encore :</strong> On réduira la qualité de compression de 90 à 70 en 2 secondes.</p>";
echo "</body>";