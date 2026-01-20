<?php
// admin/src/model/article_model.php

class ArticleModel
{
    private array $data;

    /**
     * Le constructeur reçoit maintenant directement le tableau de données
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }
}