<?php 
require_once '../src/model/contact_model.php';


// 1. On charge le fichier JSON que tu viens de créer via l'admin
$jsonPath = '../json/contacts/wetground.json'; 
$jsonRaw = file_get_contents($jsonPath);
$data = json_decode($jsonRaw, true);

// 2. Initialisation du Model et de la View
$contactModel = new ContactModel($data);
$d=$contactModel;
?>
<footer>

    <div class="footerNav">

        <nav class="navfooterbloc">
            <h2>Contacts</h2>

                        <address>
                <a class="maillink" href=<?= $d->get('email') ?> target="_blank"><?= str_replace('@', '[at]', $d->get('email')) ?></a>
                <a class="phonelink" href="tel:+32488191471">+32(0)488/19.14.71</a>
                <a class="situationlink"
                    href="<?= $d->get('map_url') ?>"
                    target="_blank" rel="noopener">
                   <?= nl2br($d->get('address', $lang)) ?>
                </a>
            </address>
        </nav>
        <nav class="navfooterbloc">
            <h2>Menu</h2>
            <?php echo $menuMain_view ?>
        </nav>
    </div>

    <img class="footer-logo" src="<?= $repImgDeco ?>logo.svg" alt="">

</footer>