<?php class ArticleModel
{
    private array $data;

    public function __construct(string $jsonPath)
    {
        $json = file_get_contents($jsonPath);
        $this->data = json_decode($json, true);
    }

    public function getData(): array
    {
        return $this->data;
    }
}
