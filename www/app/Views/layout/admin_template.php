<?php
// Define variáveis padrão caso não venham do controlador
$active_page = $active_page ?? 'dashboard';
$titlePage   = $titlePage ?? 'Painel de Controle';

// Prepara os dados que serão passados para as partials
$viewDataForPartials = [
    'active_page' => $active_page,
    'titlePage'   => $titlePage,
    'user'        => auth()->user(),
];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?= esc($titlePage) ?></title>

    <?= $this->include('partials/head', $viewDataForPartials) ?>

</head>

<body class="sb-nav-fixed">

    <div id="logoutWarning" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #ffc107; padding: 20px; border-radius: 5px; z-index: 1000; text-align: center; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
        <p>Sua sessão irá expirar em <span class="countdown" style="font-weight: bold;"></span> segundos devido à inatividade.</p>
        <button id="continueSessionBtn" class="btn btn-warning">Continuar sessão</button>
    </div>

    <?= $this->include('partials/topbar', $viewDataForPartials) ?>

    <div id="layoutSidenav">
        <?= $this->include('partials/sidebar', $viewDataForPartials) ?>

        <div id="layoutSidenav_content">
            <main>
                <?= $this->renderSection('content') ?>
            </main>

            <?= $this->include('partials/footer', $viewDataForPartials) ?>
        </div>
    </div>

    <?= $this->include('partials/scripts', $viewDataForPartials) ?>

</body>

</html>