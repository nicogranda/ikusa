<?php

$buttonClass = 'btn';

if ($button['style'] === 'primary') {
    $buttonClass .= ' btn--primary';
}

if ($button['style'] === 'outline') {
    $buttonClass .= ' btn--outline';
}
?>

<a
    href="<?= $button['url']; ?>"
    class="<?= $buttonClass; ?>">

    <?= $button['label']; ?>

    <?php if ($button['icon']) : ?>

        <span class="btn__icon">

            <?php
            switch ($button['icon']) {

                case 'arrow':
                    echo '→';
                    break;

                case 'chat':
                    echo '◌';
                    break;
            }
            ?>

        </span>

    <?php endif; ?>

</a>