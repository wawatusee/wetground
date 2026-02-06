<?php

class GalleryManager
{
    private $baseDir;
    private $indexPath;

    public function __construct($baseDir)
    {
        $this->baseDir = rtrim($baseDir, '/\\') . DIRECTORY_SEPARATOR;
        $this->indexPath = $this->baseDir . 'galleries_index.json';
    }

    // --- MÉTHODES ORIGINALES (AMÉLIORÉES) ---

    public function createGallery($name)
    {
        $folderName = $this->formatGalleryName($name);
        $galleryDir = $this->baseDir . $folderName;

        if (!is_dir($galleryDir)) {
            mkdir($galleryDir . '/original', 0777, true);
            mkdir($galleryDir . '/thumbs', 0777, true);
            $this->refreshIndex(); // Mise à jour auto après création
        } else {
            throw new Exception("La galerie existe déjà.");
        }
    }

    public function renameGallery($oldName, $newName)
    {
        $oldDir = $this->baseDir . $this->formatGalleryName($oldName);
        $newDir = $this->baseDir . $this->formatGalleryName($newName);

        if (is_dir($oldDir) && !is_dir($newDir)) {
            rename($oldDir, $newDir);
            $this->refreshIndex(); // Mise à jour auto après renommage
        } else {
            throw new Exception("Impossible de renommer la galerie.");
        }
    }

    public function deleteGallery($name)
    {
        $galleryDir = $this->baseDir . $this->formatGalleryName($name);

        if (is_dir($galleryDir)) {
            $this->deleteDirectory($galleryDir);
            $this->refreshIndex(); // Mise à jour auto après suppression
        } else {
            throw new Exception("Galerie introuvable.");
        }
    }

    // --- NOUVELLE MÉTHODE : LE PONT VERS LE BUILDER ---

    public function refreshIndex()
    {
        $galleries = [];
        // On récupère les dossiers en excluant les fichiers
        $folders = array_filter(glob($this->baseDir . '*'), 'is_dir');

        foreach ($folders as $folderPath) {
            $folderName = basename($folderPath);

            // On cherche les images dans le dossier thumbs
            $thumbPath = $folderPath . DIRECTORY_SEPARATOR . 'thumbs' . DIRECTORY_SEPARATOR;

            // glob avec BRACE pour gérer plusieurs extensions et insensibilité à la casse
            $images = glob($thumbPath . "*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}", GLOB_BRACE);

            $count = count($images);

            $galleries[] = [
                'id' => $folderName,
                'name' => str_replace('-', ' ', $folderName),
                'cover' => ($count > 0) ? basename($images[0]) : null,
                'count' => $count
            ];
        }

        return file_put_contents($this->indexPath, json_encode($galleries, JSON_PRETTY_PRINT), LOCK_EX);
    }

    // --- UTILITAIRES ---

    private function formatGalleryName($name)
    {
        // On garde ta logique strtoupper en ajoutant une sécurité sur les espaces 
        return strtoupper(str_replace(' ', '-', trim($name)));
    }

    private function deleteDirectory($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->deleteDirectory("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }
}