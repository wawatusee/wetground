<?php
class ContactView
{
    private $model;
    private $lang;

    public function __construct(ContactModel $model, $lang = 'fr')
    {
        $this->model = $model;
        $this->lang = $lang;
    }

    public function render()
    {
        $d = $this->model;
        ob_start(); ?>
        <ul class="contacts">
            <li>
                <a class="contacts-maillink" href="mailto:<?= $d->get('email') ?>">
                    <?= str_replace('@', '[at]', $d->get('email')) ?>
                </a>
            </li>

            <li>
                <a class="contacts-phonelink" href="tel:<?= $d->getCleanPhone() ?>">
                    Tel : <?= $d->get('phone') ?>
                </a>
            </li>

            <?php foreach ($d->getSocials() as $social):
                $platform = $social['platform'];
                $class = ($platform === 'instagram') ? "contacts-instagram" : "contacts-{$platform}link";
                $url = $this->formatUrl($platform, $social['value']);
                ?>
                <li>
                    <a class="<?= $class ?>" href="<?= $url ?>">
                        <?= ucfirst($platform) ?>
                    </a>
                </li>
            <?php endforeach; ?>

            <?php if ($d->get('map_url')): ?>
                <li>
                    <a class="contacts-address" href="<?= $d->get('map_url') ?>" target="_blank" rel="noopener">
                        <?= nl2br($d->get('address', $this->lang)) ?>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
        <?php
        return ob_get_clean();
    }

    private function formatUrl($platform, $value)
    {
        if (strpos($value, 'http') === 0)
            return $value;
        switch ($platform) {
            case 'whatsapp':
                return "https://wa.me/" . preg_replace('/[^0-9]/', '', $value);
            case 'instagram':
                return "https://instagram.com/" . ltrim($value, '@');
            default:
                return $value;
        }
    }
}