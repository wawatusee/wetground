<?php
class ModelGalleryChoices
{

    private string $directory;
    private string $configFile;

    public function __construct(string $directory, string $configFile = '')
    {
        $this->directory = rtrim($directory, '/') . '/';
        $this->configFile = $configFile;
    }

    public function getGalleryChoices(string $lang = 'en'): array
    {
        $allFolders = [];
        if (is_dir($this->directory)) {
            $allFolders = array_diff(scandir($this->directory), ['.', '..']);
        }

        // Si pas de config, on renvoie tout par défaut (ancien comportement)
        if (empty($this->configFile) || !file_exists($this->configFile)) {
            return array_filter($allFolders, fn($f) => is_dir($this->directory . $f));
        }

        $config = json_decode(file_get_contents($this->configFile), true);
        $finalChoices = [];

        foreach ($config as $folderName => $settings) {
            // On ne garde que si c'est visible ET que le dossier existe physiquement
            if (($settings['visible'] ?? false) && is_dir($this->directory . $folderName)) {
                $finalChoices[$folderName] = $settings["label_$lang"] ?? $folderName;
            }
        }

        return $finalChoices;
    }
}