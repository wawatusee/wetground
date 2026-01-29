<?php
class ArticleView
{
    private array $data;
    private string $lang;

    public function __construct(array $data, string $lang)
    {
        $this->data = $data;
        $this->lang = $lang;
    }

    /**
     * Gère la traduction avec fallback
     */
    private function translate($field): string|array
    {
        if (is_array($field) && isset($field[$this->lang])) {
            return $field[$this->lang];
        }
        // Si c'est un tableau de langues mais que la langue choisie n'existe pas
        if (is_array($field)) {
            return reset($field);
        }
        // Si ce n'est pas un tableau (ex: un niveau de titre), on rend tel quel
        return $field;
    }

    /**
     * Point d'entrée principal pour le rendu
     */
    public function render(): void
    {
        if (!isset($this->data['content']) || !is_array($this->data['content'])) {
            echo "<p>Aucun contenu disponible.</p>";
            return;
        }

        foreach ($this->data['content'] as $block) {
            $this->renderBlock($block);
        }
    }

    /**
     * Dispatcher de rendu selon le type de bloc
     */
    private function renderBlock(array $block): void
    {
        switch ($block['type']) {
            case 'title':
                $level = $block['level'] ?? 2;
                $text = $this->translate($block['text']);
                echo "<h{$level}>" . htmlspecialchars($text) . "</h{$level}>";
                break;

            case 'text':
                $content = $this->translate($block['content']);
                // nl2br permet de garder les retours à la ligne si l'admin en saisit
                echo "<p>" . nl2br(htmlspecialchars($content)) . "</p>";
                break;

            case 'list':
                $style = $block['style'] ?? 'ul';
                $items = $this->translate($block['items']); // Retourne le tableau de la langue
                echo "<{$style}>";
                foreach ($items as $item) {
                    echo "<li>" . htmlspecialchars($item) . "</li>";
                }
                echo "</{$style}>";
                break;

            case 'link':
                $label = $this->translate($block['label']);
                $url = $block['url'] ?? '#';
                echo "<a href='" . htmlspecialchars($url) . "' class='btn-article'>" . htmlspecialchars($label) . "</a>";
                break;

            default:
                echo "";
                break;
        }
    }
}