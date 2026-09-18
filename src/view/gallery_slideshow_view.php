<?php

class GallerySlideshowView
{
    public static function display(string $folderName, int $interval = 3000): void
    {
        $physicalPath = ROOT . 'public/img/content/galleries/' . $folderName . '/original';

        if (!is_dir($physicalPath)) {
            echo "";
            return;
        }

        try {
            $model = new Model_gallery($physicalPath);
            $images = $model->getImages();

            if (empty($images)) {
                return;
            }

            echo '<div class="gallery-slideshow" data-interval="' . $interval . '">';

            foreach ($images as $index => $img) {
                $src = "img/content/galleries/{$folderName}/original/{$img['name']}";
                $active = ($index === 0) ? ' active' : '';

                echo "<img class='gallery-slideshow-image{$active}' 
                           src='{$src}' 
                           alt='{$img['name']}'>";
            }

            echo '</div>';

        } catch (Exception $e) {
            echo "";
        }
    }
}