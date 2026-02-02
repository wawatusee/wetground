<h2 class="invisible-titre">Contact</h2>

<div class="contacts-container">

    <?php
    require_once '../src/model/contact_model.php';
    require_once '../src/view/contact_view.php';

    // 1. On charge le fichier JSON que tu viens de créer via l'admin
    $jsonPath = '../json/contacts/wetground.json';
    $jsonRaw = file_get_contents($jsonPath);
    $data = json_decode($jsonRaw, true);

    // 2. Initialisation du Model et de la View
    $contactModel = new ContactModel($data);
    $contactView = new ContactView($contactModel, $lang);

    // 3. Affichage
    echo $contactView->render();

    ?>

    <div class="map-wrapper">
        <iframe
            src="https://www.openstreetmap.org/export/embed.html?bbox=4.3652%2C50.8594%2C4.3732%2C50.8634&layer=mapnik&marker=50.86147450297319%2C4.3692008228386445"
            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>