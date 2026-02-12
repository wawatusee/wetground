<?php
class ArticleView {
    private $data = null;
    private $lang;

    public function __construct($fullPath, $lang = 'fr') {
        $this->lang = $lang;
        if (file_exists($fullPath)) {
            $raw = file_get_contents($fullPath);
            $this->data = json_decode($raw, true);
        }
    }

    public function render() {
        if (!$this->data) {
            echo "";
            return;
        }

        echo '<div class="nucleus-article">';
        foreach ($this->data['content'] as $block) {
            if ($block['type'] === 'title') {
                $t = $block['text'][$this->lang] ?? $block['text']['fr'];
                echo "<h2>" . htmlspecialchars($t) . "</h2>";
            } 
            elseif ($block['type'] === 'text') {
                $c = $block['content'][$this->lang] ?? $block['content']['fr'];
                echo "<p>" . nl2br(htmlspecialchars($c)) . "</p>";
            }
        }
        echo '</div>';
    }
}