<?php
class ViewGalleryMenu {
    private $galleryChoices;
    private $page;
    private $selectedGallery;

    public function __construct(array $galleryChoices, string $page, string $selectedGallery = '') {
        $this->galleryChoices = $galleryChoices;
        $this->page = $page;
        $this->selectedGallery = $selectedGallery;
    }

    public function render() {
        if (empty($this->galleryChoices)) {
            echo '<p>Aucune galerie disponible.</p>';
            return;
        }

        // Début du menu (liste non ordonnée)
        echo '<ul class="gallery-menu" id="galleryMenu">';

        foreach ($this->galleryChoices as $choice) {
            // 1. Déterminer l'URL : ?page=galeries&gallery=NOM_GALERIE
            // L'URL actuelle est présumée, on ne modifie que les paramètres
            $href = '?' . http_build_query([
                'page'    => $this->page,
                'gallery' => $choice
            ]);

            // 2. Marquer l'élément sélectionné pour le style
            $cssClass = $choice === $this->selectedGallery ? ' selected-item' : '';

            // 3. Afficher l'élément de menu (li) et le lien (a)
            echo '<li class="gallery-item' . $cssClass . '">';
            echo '<a href="' . htmlspecialchars($href) . '">';
            echo htmlspecialchars($choice);
            echo '</a>';
            echo '</li>';
        }

        echo '</ul>';
    }
}
?>