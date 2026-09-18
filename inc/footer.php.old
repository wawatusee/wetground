<?php
require_once '../src/model/contact_model.php';
require_once '../src/view/contact_view.php';
// 1. On charge le fichier JSON
$jsonPath = '../json/contacts/wetground.json';
$jsonRaw = file_get_contents($jsonPath);
$data = json_decode($jsonRaw, true);

// 2. Initialisation du Model et de la View
$contactModel = new ContactModel($data);
$d = $contactModel;
?>
<footer>
    <div class="footerNav">
        <nav class="navfooterbloc">
            <address>
                <a class="situationlink" href="<?= $d->get('map_url') ?>" target="_blank" rel="noopener">
                    <?= nl2br($d->get('address', $lang)) ?>
                </a>
                <a class="maillink" href=<?= $d->get('email') ?> target="_blank"><?= str_replace('@', '[at]', $d->get('email')) ?></a>
                <a class="phonelink" href="tel:+32488191471">+32(0)488/19.14.71</a>

            </address>

        </nav>
        <nav class="navfooterbloc">
            <address>

                <?php var_dump($d->getSocials());
$contactView = new ContactView($d, $lang);
echo $contactView->render();
                    ?>


            </address>

        </nav>
    </div>
</footer>