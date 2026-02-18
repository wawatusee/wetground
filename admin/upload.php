<?php
ob_start(); // Capture toute sortie accidentelle

require 'image_uploader.class.php';

header('Content-Type: application/json');

$response = array('success' => false, 'error' => '');

try {
    // Cas où post_max_size est dépassé
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST) && empty($_FILES)) {
        throw new Exception(
            'Le fichier dépasse la taille maximale autorisée (' . ini_get('post_max_size') . ').'
        );
    }

    $uploadDir = $_POST['uploadDir'] ?? null;
    $width = $_POST['width'] ?? null;
    $height = $_POST['height'] ?? null;
    $imageFormat = $_POST['imageFormat'] ?? null;

    if (!$uploadDir || !$width || !$height || !$imageFormat) {
        throw new Exception('Paramètres d’upload manquants.');
    }


    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
        $file = [
            'name' => $_FILES['images']['name'][$key],
            'type' => $_FILES['images']['type'][$key],
            'tmp_name' => $tmpName,
            'error' => $_FILES['images']['error'][$key],
            'size' => $_FILES['images']['size'][$key],
        ];

        $imageName = pathinfo($file['name'], PATHINFO_FILENAME);
        switch ($file['error']) {

            case UPLOAD_ERR_OK:
                break;

            case UPLOAD_ERR_INI_SIZE:
                throw new Exception(
                    'Le fichier "' . $file['name'] . '" dépasse la taille maximale autorisée ('
                    . ini_get('upload_max_filesize') . ').'
                );

            case UPLOAD_ERR_FORM_SIZE:
                throw new Exception(
                    'Le fichier "' . $file['name'] . '" dépasse la taille autorisée par le formulaire.'
                );

            case UPLOAD_ERR_PARTIAL:
                throw new Exception(
                    'Le fichier "' . $file['name'] . '" a été partiellement uploadé.'
                );

            case UPLOAD_ERR_NO_FILE:
                throw new Exception('Aucun fichier sélectionné.');

            default:
                throw new Exception(
                    'Erreur inconnue lors de l’upload du fichier "' . $file['name'] . '".'
                );
        }

        $uploader = new ImageUploader($uploadDir, $width, $height, $imageName, $imageFormat);
        $uploader->upload($file);
    }

    $response['success'] = true;
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

// Capture de sortie inattendue et JSON sans erreurs
ob_end_clean();
try {
    echo json_encode($response, JSON_THROW_ON_ERROR | JSON_PARTIAL_OUTPUT_ON_ERROR);
} catch (JsonException $jsonError) {
    echo json_encode(['success' => false, 'error' => 'JSON encoding error: ' . $jsonError->getMessage()]);
}
exit;