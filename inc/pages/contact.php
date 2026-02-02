<h2 class="invisible-titre">Contact</h2>

<div class="contacts-container">
    <ul class="contacts">
        <li> <a class=" contacts-maillink" href="mailto:info@wetground.be">info[at]wetground.be</a>
        </li>

        <li> <a class="contacts-phonelink" href="tel:+32486100573">Tel : +32(0)486.10.05.73</a>
        </li>
        <li> <a class="contacts-whatsapplink" aria-label="Chat on WhatsApp"
                href="https://wa.me/+32486100573">Whatsapp</a>
        </li>
        <li> <a class="contacts-instagram"
                href="https://www.instagram.com/wetground_expo?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">Instagram</a>
        </li>
        <li>
            <a class="contacts-adress" href="https://www.openstreetmap.org/?mlat=50.8614745&mlon=4.3692008#map=17/50.8614745/4.3692008"
                target="_blank" rel="noopener">
                rue de la Constitution, 13<br>
                1030 Schaerbeek - Belgium
            </a>
        </li>

    </ul>
<?php 
//TEST contact

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