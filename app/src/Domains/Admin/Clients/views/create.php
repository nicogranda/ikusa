<?php
// $errors y $options llegan desde ClientsController::create()
?>

<main class="client-form__wrapper">
    <h1 class="client-form__title">Nuevo cliente</h1>

    <?php if (!empty($errors)): ?>
        <div class="client-form__errors">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form class="client-form" method="POST" action="?page=clients&action=create">

        <div class="client-form__row">
            <label class="client-form__label" for="name">Nombre</label>
            <input class="client-form__input" type="text" id="name" name="name"
                   value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
        </div>

        <div class="client-form__row client-form__row--split">
            <div>
                <label class="client-form__label" for="language">Idioma</label>
                <select class="client-form__select" id="language" name="language" required>
                    <option value="">Selecciona...</option>
                    <?php foreach ($options['languages'] as $code => $label): ?>
                        <option value="<?= $code ?>" <?= (($_POST['language'] ?? '') === $code) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="client-form__label" for="currency">Divisa</label>
                <select class="client-form__select" id="currency" name="currency" required>
                    <option value="">Selecciona...</option>
                    <?php foreach ($options['currencies'] as $code => $label): ?>
                        <option value="<?= $code ?>" <?= (($_POST['currency'] ?? '') === $code) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="client-form__row client-form__row--split">
            <div>
                <label class="client-form__label" for="email">Email</label>
                <input class="client-form__input" type="email" id="email" name="email"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
            <div>
                <label class="client-form__label" for="phone">Teléfono</label>
                <input class="client-form__input" type="text" id="phone" name="phone"
                       value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" required>
            </div>
        </div>

        <div class="client-form__row">
            <label class="client-form__label" for="alias">Alias</label>
            <input class="client-form__input" type="text" id="alias" name="alias"
                   value="<?= htmlspecialchars($_POST['alias'] ?? '') ?>" required>
        </div>

        <div class="client-form__row">
            <label class="client-form__label" for="address">Dirección</label>
            <input class="client-form__input" type="text" id="address" name="address"
                   value="<?= htmlspecialchars($_POST['address'] ?? '') ?>" required>
        </div>

        <div class="client-form__row client-form__row--triple">
            <div>
                <label class="client-form__label" for="city">Ciudad</label>
                <input class="client-form__input" type="text" id="city" name="city"
                       value="<?= htmlspecialchars($_POST['city'] ?? '') ?>" required>
            </div>
            <div>
                <label class="client-form__label" for="state">Provincia/Estado</label>
                <input class="client-form__input" type="text" id="state" name="state"
                       value="<?= htmlspecialchars($_POST['state'] ?? '') ?>" required>
            </div>
            <div>
                <label class="client-form__label" for="zip_code">Código postal</label>
                <input class="client-form__input" type="text" id="zip_code" name="zip_code"
                       value="<?= htmlspecialchars($_POST['zip_code'] ?? '') ?>" required>
            </div>
        </div>

        <div class="client-form__row client-form__row--split">
            <div>
                <label class="client-form__label" for="country">País</label>
                <select class="client-form__select" id="country" name="country" required>
                    <option value="">Selecciona...</option>
                    <?php foreach ($options['countries'] as $value => $label): ?>
                        <option value="<?= htmlspecialchars($value) ?>" <?= (($_POST['country'] ?? '') === $value) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="client-form__label" for="tax_id">CIF / NIF</label>
                <input class="client-form__input" type="text" id="tax_id" name="tax_id"
                       value="<?= htmlspecialchars($_POST['tax_id'] ?? '') ?>" required>
            </div>
        </div>

        <div class="client-form__row">
            <label class="client-form__label" for="representative">Representante</label>
            <input class="client-form__input" type="text" id="representative" name="representative"
                   value="<?= htmlspecialchars($_POST['representative'] ?? '') ?>" required>
        </div>

        <div class="client-form__row">
            <label class="client-form__label" for="business_type">Tipo de negocio</label>
            <select class="client-form__select" id="business_type" name="business_type" required>
                <option value="">Selecciona...</option>
                <?php foreach ($options['business_types'] as $id => $label): ?>
                    <option value="<?= $id ?>" <?= ((string) ($_POST['business_type'] ?? '') === (string) $id) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($label) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="client-form__row">
            <label class="client-form__label" for="tax_note">Nota fiscal (opcional)</label>
            <textarea class="client-form__textarea" id="tax_note" name="tax_note" rows="3"><?= htmlspecialchars($_POST['tax_note'] ?? '') ?></textarea>
        </div>

        <button class="client-form__submit" type="submit">Guardar cliente</button>

    </form>
</main>
