<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4 title-page"><b><?= esc($titlePage) ?></b></h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success admin-msg"><?= esc(session('success')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger admin-msg"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url_to('dashboard') ?>">Visão Geral</a></li>
        <li class="breadcrumb-item active"><?= esc($titlePage) ?></li>
    </ol>

    <div class="mb-4">
        <button class="notification-button button-create" onclick="window.location.href='<?= url_to('admin_formas_pagamento_create') ?>'">
            Nova Forma de Pagamento
        </button>
    </div>

    <?php if (!empty($paymentMethods)): ?>
        <table class="table datatable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Forma de pagamento</th>
                    <th>Ativo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paymentMethods as $method): ?>
                    <tr>
                        <td><?= esc($method['id']) ?></td>
                        <td><?= esc($method['name']) ?></td>
                        <td>
                            <?php if ($method['active'] == 1) : ?>
                                <span class="badge bg-success">Sim</span>
                            <?php else : ?>
                                <span class="badge bg-danger">Não</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= url_to('admin_formas_pagamento_edit', $method['id']) ?>" class="icon-button" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?= url_to('admin_formas_pagamento_delete', $method['id']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Confirmar exclusão?');">
                                <?= csrf_field() ?>
                                <button type="submit" class="icon-button" title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info admin-msg">Nenhuma forma de pagamento encontrada no momento.</div>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>