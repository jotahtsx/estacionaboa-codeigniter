<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4 title-page"><b><?= esc($titlePage) ?></b></h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url_to('dashboard') ?>">Visão Geral</a></li>
        <li class="breadcrumb-item"><a href="<?= url_to('admin_formas_pagamento') ?>">Formas de pagamento</a></li>
        <li class="breadcrumb-item active"><?= esc($titlePage) ?></li>
    </ol>

    <?php if (session()->getFlashdata('warning')): ?>
        <div class="alert alert-warning admin-msg"><?= esc(session('warning')) ?></div>
    <?php endif; ?>

    <form action="<?= url_to('admin_formas_pagamento_update', $paymentMethod['id']) ?>" method="post" class="admin-form">
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="name" class="form-label">Nome da Forma de Pagamento</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= old('name', $paymentMethod['name']) ?>" required>
                    <?php if (session('errors.name')) : ?>
                        <div class="text-danger mt-2"><?= session('errors.name') ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group mb-3">
                    <label for="active">Ativo?</label>
                    <select name="active" id="active" class="form-select">
                        <option value="1" <?= old('active', $paymentMethod['active'] ?? '1') == '1' ? 'selected' : '' ?>>Sim</option>
                        <option value="0" <?= old('active', $paymentMethod['active'] ?? '1') == '0' ? 'selected' : '' ?>>Não</option>
                    </select>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-submit">Salvar</button>
        <a href="<?= url_to('admin_formas_pagamento') ?>" class="btn btn-secondary btn-cancel">Cancelar</a>
    </form>
</div>

<?= $this->endSection() ?>