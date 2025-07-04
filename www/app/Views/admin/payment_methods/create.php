<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4 title-page"><b><?= esc($titlePage) ?></b></h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url_to('dashboard') ?>">Visão Geral</a></li>
        <li class="breadcrumb-item"><a href="<?= url_to('admin_formas_pagamento') ?>">Formas de pagamento</a></li>
        <li class="breadcrumb-item active"><?= esc($titlePage) ?></li>
    </ol>

    <form action="<?= url_to('admin_formas_pagamento_store') ?>" method="post" class="admin-form">
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="name" class="form-label">Forma de Pagamento</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= old('name') ?>" required>
                    <?php if (session('errors.name')) : ?>
                        <div class="text-danger mt-2"><?= session('errors.name') ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-2">
                <div class="mb-3">
                    <label for="active" class="form-label">Status</label>
                    <select class="form-select" id="active" name="active" required>
                        <option value="1" <?= old('active', '1') == '1' ? 'selected' : '' ?>>Ativo</option>
                        <option value="0" <?= old('active', '1') == '0' ? 'selected' : '' ?>>Inativo</option>
                    </select>
                    <?php if (session('errors.active')) : ?>
                        <div class="text-danger mt-2"><?= session('errors.active') ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-submit">Salvar</button>
        <a href="<?= url_to('admin_formas_pagamento') ?>" class="btn btn-secondary btn-cancel">Cancelar</a>
    </form>
</div>

<?= $this->endSection() ?>