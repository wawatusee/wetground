<?php
/**
 * La classe ViewMenu produit les éléments d'un menu au format HTML
 */
class ViewMenu
{
    private string $viewMenu = "";
    private string $lang;

    public function __construct(string $lang)
    {
        $this->lang = $lang;
    }

    /**
     * Génère un menu principal
     *
     * @param array $menuArray Tableau d'objets menu (propriétés : page, titre->{lang})
     * @param bool $singlePage True si navigation ancre (#), false si navigation classique (?page=)
     * @param string|null $currentPage La page actuellement active
     * @return string HTML du menu
     */
    public function getViewMainMenu(array $menuArray, bool $singlePage = true, ?string $currentPage = null): string
    {
        foreach ($menuArray as $item) {
            // Protection XSS
            $page = htmlspecialchars($item->page);
            $title = htmlspecialchars($item->titre->{$this->lang});

            // Vérifie si c'est la page active
            $isActive = ($currentPage === $item->page) ? " active" : "";

            // Génère le lien
            if ($singlePage) {
                $this->viewMenu .= "<a class='itemMenu{$isActive}' href='#{$page}'>{$title}</a>";
            } else {
                $this->viewMenu .= "<a class='itemMenu{$isActive}' href='?page={$page}'>{$title}</a>";
            }
        }

        return $this->viewMenu;
    }

    /**
     * Génère un menu utilisable depuis une page externe
     */
    public function getViewMainMenuFromExt(array $menuArray, bool $singlePage = true, ?string $currentPage = null): string
    {
        foreach ($menuArray as $item) {
            $page = htmlspecialchars($item->page);
            $title = htmlspecialchars($item->titre->{$this->lang});
            $isActive = ($currentPage === $item->page) ? " active" : "";

            $this->viewMenu .= "<a class='itemMenu{$isActive}' href='index.php?lang={$this->lang}#{$page}'>{$title}</a>";
        }

        return $this->viewMenu;
    }
}
