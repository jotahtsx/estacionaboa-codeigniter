<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?= $titlePage ?? 'Título da página' ?></title>

    <link href="<?= base_url('libs/simple-datatables@7.1.2/style.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('css/app.css') ?>" rel="stylesheet" />
    <script src="<?= base_url('libs/font-awesome/all.js') ?>"></script>
</head>

<body class="sb-nav-fixed">
    <div id="logoutWarning" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #ffc107; padding: 20px; border-radius: 5px; z-index: 1000; text-align: center; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
        <p>Sua sessão irá expirar em <span class="countdown" style="font-weight: bold;"></span> segundos devido à inatividade.</p>
        <button id="continueSessionBtn" class="btn btn-warning">Continuar sessão</button>
    </div>