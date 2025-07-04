<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4 title-page"><b><?= esc($titlePage) ?></b></h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/categorias/store') ?>" method="post" class="admin-form">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="name">Nome da Categoria</label>
                <input type="text" name="name" id="name" class="form-control" required value="<?= esc(old('name')) ?>">
            </div>
            <div class="col-md-2 mb-3">
                <label for="active" class="form-label">Ativo?</label>
                <select class="form-select" id="active" name="active" required>
                    <option value="1" <?= old('active', isset($category['active']) ? $category['active'] : '') == 1 ? 'selected' : '' ?>>Ativo</option>
                    <option value="0" <?= old('active', isset($category['active']) ? $category['active'] : '') == 0 ? 'selected' : '' ?>>Inativo</option>
                </select>
                <?php if (session('errors.active')) : ?>
                    <div class="text-danger mt-2"><?= session('errors.active') ?></div>
                <?php endif; ?>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-submit">Cadastrar</button>
        <a href="<?= url_to('admin_precificacoes_categorias') ?>" class="btn btn-secondary btn-cancel">Cancelar</a>
    </form>
</div>

<?= $this->endSection() ?>