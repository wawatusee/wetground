<?php
class GalleryViewForMixte {
    private array $images;
    private string $publicDir;

    public function __construct(array $images, string $publicDir) {
        $this->images = $images;
        $this->publicDir = $publicDir; // Ici on recevra 'WORKSHOPS/thumbs' par exemple
    }

    public function render(): void {
        if (empty($this->images)) {
            echo "";
            return;
        }

        echo '<div class="gallery-mixte-container">';
        foreach ($this->images as $img) {
            // ON CORRIGE ICI : On utilise ton architecture 'public/img/content/galleries/'
            // Note : Si ton serveur pointe déjà dans 'public' comme racine, 
            // le chemin doit commencer par /img/...
            $src = "img/content/galleries/{$this->publicDir}/thumbs/{$img['name']}";
            
            echo <<<HTML
<div class="gallery-mixte-item" >
    <img src="{$src}" 
         width="{$img['width']}" 
         height="{$img['height']}" 
         alt="{$img['name']}" 
         style="max-width:200px; height:auto;">
</div>
HTML;
        }
        echo '</div>';
    }
}