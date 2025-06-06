<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Entrar</title>
    <link href="<?= base_url('css/app.css') ?>" rel="stylesheet" />
</head>

<body class="auth">

    <img class="auth-logo" src="<?= base_url('images/estacionaboa.svg') ?>" alt="Logo">


    <div class="login-box">

        <?php if (session('error')): ?>
            <div class="error-box"><?= session('error') ?></div>
        <?php endif; ?>

        <?php if (session('errors')): ?>
            <div class="error-box">
                <ul>
                    <?php foreach (session('errors') as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= site_url('/login') ?>">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" value="<?= old('email') ?>">
            </div>

            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" name="password" id="password">
            </div>

            <button type="submit">fazer login</button>
        </form>
    </div>

</body>

</html>