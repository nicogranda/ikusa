<?php
// $client, $errors y $options llegan desde ClientsController::edit()/update()
?>

    <h1 class="contact-form__title">Client</h1>

    <?php if (!empty($errors)): ?>
        <div class="contact-form__errors">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
<main class="container">


    <form class="contact-form" method="POST" action="?page=clients&action=update">

        <input type="hidden" name="id" value="<?= (int) $client['id'] ?>">

        <div class="contact-form__row">
            <label class="contact-form__label contact-form__label--required" for="name">Nombre</label>
            <input class="contact-form__input" type="text" id="name" name="name"
                   value="<?= htmlspecialchars($client['name'] ?? '') ?>" required>
        </div>

        <div class="contact-form__row contact-form__row--split">
            <div>
                <label class="contact-form__label contact-form__label--required" for="language">Idioma</label>
                <select class="contact-form__select" id="language" name="language" required>
                    <option value="">Selecciona...</option>
                    <?php foreach ($options['languages'] as $code => $label): ?>
                        <option value="<?= $code ?>" <?= (($client['language'] ?? '') === $code) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="contact-form__label contact-form__label--required" for="currency">Divisa</label>
                <select class="contact-form__select" id="currency" name="currency" required>
                    <option value="">Selecciona...</option>
                    <?php foreach ($options['currencies'] as $code => $label): ?>
                        <option value="<?= $code ?>" <?= (($client['currency'] ?? '') === $code) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="contact-form__row contact-form__row--split">
            <div>
                <label class="contact-form__label contact-form__label--required" for="email">Email</label>
                <input class="contact-form__input" type="email" id="email" name="email"
                       value="<?= htmlspecialchars($client['email'] ?? '') ?>" required>
            </div>
            <div>
                <label class="contact-form__label contact-form__label--required" for="phone">Teléfono</label>
                <input class="contact-form__input" type="text" id="phone" name="phone"
                       value="<?= htmlspecialchars($client['phone'] ?? '') ?>" required>
            </div>
        </div>

        <div class="contact-form__row">
            <label class="contact-form__label contact-form__label--required" for="alias">Alias</label>
            <input class="contact-form__input" type="text" id="alias" name="alias"
                   value="<?= htmlspecialchars($client['alias'] ?? '') ?>" required>
        </div>

        <div class="contact-form__row">
            <label class="contact-form__label contact-form__label--required" for="address">Dirección</label>
            <input class="contact-form__input" type="text" id="address" name="address"
                   value="<?= htmlspecialchars($client['address'] ?? '') ?>" required>
        </div>

        <div class="contact-form__row contact-form__row--triple">
            <div>
                <label class="contact-form__label contact-form__label--required" for="city">Ciudad</label>
                <input class="contact-form__input" type="text" id="city" name="city"
                       value="<?= htmlspecialchars($client['city'] ?? '') ?>" required>
            </div>
            <div>
                <label class="contact-form__label contact-form__label--required" for="state">Provincia/Estado</label>
                <input class="contact-form__input" type="text" id="state" name="state"
                       value="<?= htmlspecialchars($client['state'] ?? '') ?>" required>
            </div>
            <div>
                <label class="contact-form__label contact-form__label--required" for="zip_code">Código postal</label>
                <input class="contact-form__input" type="text" id="zip_code" name="zip_code"
                       value="<?= htmlspecialchars($client['zip_code'] ?? '') ?>" required>
            </div>
        </div>

        <div class="contact-form__row contact-form__row--split">
            <div>
                <label class="contact-form__label contact-form__label--required" for="country">País</label>
                <select class="contact-form__select" id="country" name="country" required>
                    <option value="">Selecciona...</option>
                    <?php foreach ($options['countries'] as $value => $label): ?>
                        <option value="<?= htmlspecialchars($value) ?>" <?= (($client['country'] ?? '') === $value) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="contact-form__label contact-form__label--required" for="tax_id">CIF / NIF</label>
                <input class="contact-form__input" type="text" id="tax_id" name="tax_id"
                       value="<?= htmlspecialchars($client['tax_id'] ?? '') ?>" required>
            </div>
        </div>

        <div class="contact-form__row">
            <label class="contact-form__label contact-form__label--required" for="representative">Representante</label>
            <input class="contact-form__input" type="text" id="representative" name="representative"
                   value="<?= htmlspecialchars($client['representative'] ?? '') ?>" required>
        </div>

        <div class="contact-form__row">
            <label class="contact-form__label contact-form__label--required" for="business_type">Tipo de negocio</label>
            <select class="contact-form__select" id="business_type" name="business_type" required>
                <option value="">Selecciona...</option>
                <?php foreach ($options['business_types'] as $id => $label): ?>
                    <option value="<?= $id ?>" <?= ((string) ($client['business_type'] ?? '') === (string) $id) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($label) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="contact-form__row">
            <label class="contact-form__label" for="tax_note">Nota fiscal (opcional)</label>
            <textarea class="contact-form__textarea" id="tax_note" name="tax_note" rows="3"><?= htmlspecialchars($client['tax_note'] ?? '') ?></textarea>
        </div>

        <button class="contact-form__submit" type="submit">Guardar cambios</button>

    </form>
</main>