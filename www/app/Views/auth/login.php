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

        <?php if (session()->has('errors')): ?>
            <div class="alert alert-danger" role="alert">
                <ul>
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger" role="alert">
                <?= esc(session('error')) ?>
            </div>
        <?php endif ?>

        <?php if (session()->has('success')): ?>
            <div class="alert alert-success" role="alert">
                <?= esc(session('success')) ?>
            </div>
        <?php endif ?>

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