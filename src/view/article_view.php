<?php
class ArticleView {
    private $data;
    private $lang;

    public function __construct(string $fullPath, string $lang = 'fr') {
        $this->lang = $lang;

        if (file_exists($fullPath)) {
            $raw = file_get_contents($fullPath);
            $this->data = json_decode($raw, true);
        }
    }

    public function render(): void {
        // Si les données ne sont pas là, on sort silencieusement
        if (!$this->data || !isset($this->data['content'])) {
            echo "";
            return;
        }

        echo '<article class="nucleus-article">';
        
        foreach ($this->data['content'] as $block) {
            // On utilise exactement la logique de ton script 'openatelier'
            if ($block['type'] === 'title') {
                $level = $block['level'] ?? 2;
                $text = $block['text'][$this->lang] ?? $block['text']['fr'];
                echo "<h{$level}>" . htmlspecialchars($text) . "</h{$level}>";
            } 
            elseif ($block['type'] === 'text') {
                $content = $block['content'][$this->lang] ?? $block['content']['fr'];
                echo "<p>" . nl2br(htmlspecialchars($content)) . "</p>";
            }
        }

        echo '</article>';
    }
}