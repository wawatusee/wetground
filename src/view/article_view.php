<?php class ArticleView
{
    private array $data;
    private string $lang;

    public function __construct(array $data, string $lang)
    {
        $this->data = $data;
        $this->lang = $lang;
    }

    private function translate(array $field): string
    {
        // si la langue existe
        if (isset($field[$this->lang])) {
            return $field[$this->lang];
        }

        // fallback
        return reset($field);
    }

    public function render(): void
    {
        echo '<h1>' . htmlspecialchars(
            $this->translate($this->data['title'])
        ) . '</h1>';

        foreach ($this->data['article'] as $block) {
            echo '<h2>' . htmlspecialchars($block['name']) . '</h2>';
            echo '<p>' . $this->translate($block['description']) . '</p>';
        }
    }
}
