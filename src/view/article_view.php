<?php
class ArticleView {
    private $data;
    private $lang;

    /**
     * @param string $fullPath Chemin complet vers le fichier JSON
     * @param string $lang Langue à afficher ('fr', 'en', etc.)
     */
    public function __construct(string $fullPath, string $lang = 'fr') {
        $this->lang = $lang;

        if (file_exists($fullPath)) {
            $jsonContent = file_get_contents($fullPath);
            $this->data = json_decode($jsonContent, true);
        } else {
            $this->data = null;
        }
    }

    public function render(): void {
        if (!$this->data || !isset($this->data['content'])) {
            echo "";
            return;
        }

        echo '<article class="nucleus-article">';
        foreach ($this->data['content'] as $block) {
            echo $this->renderBlock($block);
        }
        echo '</article>';
    }

    private function renderBlock(array $block): string {
        switch ($block['type']) {
            case 'title':
                $level = $block['level'] ?? 2;
                $text  = $block['text'][$this->lang] ?? ($block['text']['fr'] ?? '');
                return <<<HTML
<h{$level} class="nucleus-title">{$text}</h{$level}>

HTML;

            case 'text':
                $content = $block['content'][$this->lang] ?? ($block['content']['fr'] ?? '');
                $formattedContent = nl2br(htmlspecialchars($content));
                return <<<HTML
<div class="nucleus-text-block">
    <p>{$formattedContent}</p>
</div>

HTML;

            default:
                return "";
        }
    }
}