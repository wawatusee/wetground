<?php
require_once '../src/model/contact_model.php';

$jsonPath = '../json/contacts/wetground.json';
$jsonRaw = file_get_contents($jsonPath);
$data = json_decode($jsonRaw, true);

$d = new ContactModel($data);
?>

<footer>
    <div class="footerNav">

        <!-- Coordonnées -->
        <nav class="navfooterbloc footer-contact">
            <address>
                <a class="situationlink"
                   href="<?= $d->get('map_url') ?>"
                   target="_blank"
                   rel="noopener">
                    <?= nl2br($d->get('address', $lang)) ?>
                </a>

                <a class="maillink"
                   href="mailto:<?= $d->get('email') ?>">
                    <?= str_replace('@', '[at]', $d->get('email')) ?>
                </a>

                <a class="phonelink"
                   href="tel:<?= $d->getCleanPhone() ?>">
                    <?= $d->get('phone') ?>
                </a>
            </address>
        </nav>

        <!-- Réseaux sociaux -->
        <nav class="navfooterbloc footer-socials">
            <?php foreach ($d->getSocials() as $social): ?>

                <?php
                $platform = $social['platform'];
                $value = $social['value'];

                switch ($platform) {
                    case 'whatsapp':
                        $url = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $value);
                        break;

                    case 'instagram':
                        $url = 'https://instagram.com/' . ltrim($value, '@');
                        break;

                    case 'facebook':
                        $url = strpos($value, 'http') === 0
                            ? $value
                            : 'https://facebook.com/' . ltrim($value, '/');
                        break;

                    default:
                        $url = $value;
                }
                ?>

                <a class="footer-sociallink footer-<?= htmlspecialchars($platform) ?>"
                   href="<?= htmlspecialchars($url) ?>"
                   target="_blank"
                   rel="noopener">
                    <?= ucfirst(htmlspecialchars($platform)) ?>
                </a>

            <?php endforeach; ?>
        </nav>

    </div>
</footer>