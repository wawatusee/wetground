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

    public function deleteImage($galleryName, $filename)
    {
        // 1. Sécurisation des noms pour éviter les injections de chemin
        $galleryName = basename($galleryName);
        $filename = basename($filename);

        // 2. Construction du chemin vers LA galerie spécifique
        // On part de baseDir (racine) + nom de la galerie
        $galleryPath = $this->baseDir . $galleryName . DIRECTORY_SEPARATOR;

        $original = $galleryPath . 'original' . DIRECTORY_SEPARATOR . $filename;
        $thumb = $galleryPath . 'thumbs' . DIRECTORY_SEPARATOR . $filename;

        // 3. Suppression physique
        if (file_exists($original))
            unlink($original);
        if (file_exists($thumb))
            unlink($thumb);

        // 4. Mise à jour de l'index
        return $this->refreshIndex();
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

    /* private function deleteDirectory($dir)
     {
         $files = array_diff(scandir($dir), array('.', '..'));
         foreach ($files as $file) {
             (is_dir("$dir/$file")) ? $this->deleteDirectory("$dir/$file") : unlink("$dir/$file");
         }
         return rmdir($dir);
     }*/
    public function deleteGallery($galleryName)
    {
        $galleryName = basename($galleryName);
        $galleryPath = $this->baseDir . $galleryName . DIRECTORY_SEPARATOR;

        if (!is_dir($galleryPath))
            return false;

        // 1. Liste des sous-dossiers à vider
        $subfolders = ['original', 'thumbs'];

        foreach ($subfolders as $sub) {
            $path = $galleryPath . $sub . DIRECTORY_SEPARATOR;
            if (is_dir($path)) {
                // On vide tous les fichiers du sous-dossier
                $files = glob($path . '*');
                foreach ($files as $file) {
                    if (is_file($file))
                        unlink($file);
                }
                // On supprime le sous-dossier maintenant vide
                rmdir($path);
            }
        }

        // 2. Supprimer les fichiers qui traîneraient à la racine de la galerie (ex: index.json local)
        $remainingFiles = glob($galleryPath . '*');
        foreach ($remainingFiles as $file) {
            if (is_file($file))
                unlink($file);
        }

        // 3. Enfin, on supprime le dossier de la galerie lui-même
        $success = rmdir($galleryPath);

        // 4. On met à jour l'index global pour faire disparaître la galerie de la liste
        if ($success) {
            $this->refreshIndex();
        }

        return $success;
    }
}