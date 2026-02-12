<?php
class GalleryViewForMixte {
    public static function display(string $folderName): void {
        $physicalPath = ROOT . 'public/img/content/galleries/' . $folderName . '/thumbs';
        
        // On gère l'erreur silencieusement ou avec un petit message discret
        if (!is_dir($physicalPath)) {
            echo "";
            return;
        }

        try {
            $model = new Model_gallery($physicalPath);
            $images = $model->getImages();

            echo '<div class="gallery-mixte-container">';
            foreach ($images as $img) {
                $src = "img/content/galleries/{$folderName}/thumbs/{$img['name']}";
                echo "<div class='gallery-mixte-item'>";
                echo "<img src='{$src}' alt='{$img['name']}'>";
                echo "</div>";
            }
            echo '</div>';
        } catch (Exception $e) {
            echo "";
        }
    }
}