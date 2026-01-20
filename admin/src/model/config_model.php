<?php
// admin/src/model/config_model.php

// On utilise la constante définie dans config_admin.php
require_once JSON_LOADER;

class ConfigModel {
    public static function getLangs(): array {
        // Chemin propre vers le fichier de config global
        $configPath = ROOT_PATH . 'json/config.json';
        
        try {
            $config = JsonLoader::load($configPath);
            return $config['config']['langs'] ?? ['fr' => 'Français'];
        } catch (Exception $e) {
            return ['fr' => 'Français'];
        }
    }
}