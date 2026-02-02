<?php
class ContactModel
{
    private $data;

    public function __construct($jsonData)
    {
        $this->data = $jsonData;
    }

    /**
     * Récupère une valeur. 
     * Si c'est un tableau (langues), retourne la bonne langue.
     */
    public function get($field, $lang = 'fr')
    {
        if (!isset($this->data[$field]))
            return '';

        $value = $this->data[$field];

        if (is_array($value)) {
            // C'est un champ traduit (ex: address ou role)
            return $value[$lang] ?? $value['fr'] ?? '';
        }

        // C'est un champ simple (ex: name, phone, email)
        return $value;
    }

    public function getCleanPhone()
    {
        return preg_replace('/[^0-9+]/', '', $this->get('phone'));
    }

    public function getSocials()
    {
        return $this->data['socials'] ?? [];
    }
}