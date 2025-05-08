<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="<?= base_url('css/app.css') ?>" rel="stylesheet" />
    <style>
        .auth {
            background: #8E2DE2;
            background: -webkit-linear-gradient(to top, #4A00E0, #8E2DE2);
            background: linear-gradient(to top, #4A00E0, #8E2DE2);
            flex-direction: column;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .auth-logo {
            width: 200px;
            margin-bottom: 20px;
        }

        .login-box {
            background: #fff;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 6px;
            width: 375px;
        }

        .login-box h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .login-box .error-box ul {
            margin-bottom: 0;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            text-transform: uppercase;
            font-size: 12px;
        }

        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            box-shadow: none;
        }

        .error-box {
            background: #ffe0e0;
            color: #900;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        button {
            display: block;
            width: 100%;
            padding: 15px 20px;
            border: none;
            background: #555;
            color: #fff ! Important;
            text-decoration: none ! Important;
            text-shadow: 1px 1px rgba(0, 0, 0, 0.5);
            font-size: 1.2em;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            transition-duration: 0.3s;
            -webkit-transition-duration: 0.3s;
            border-radius: 4px;
            -moz-border-radius: 4px;
            -webkit-border-radius: 4px;
            background-color: #3AADD9;
            text-transform: uppercase;

        }

        button:hover {
            background: #005fa3;
        }
    </style>
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