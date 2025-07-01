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

    <form action="<?= base_url('admin/categorias/store') ?>" method="post" class="admin-form mb-3">
        <div class="mb-3">
            <label for="name">Nome da Categoria</label>
            <input type="text" name="name" id="name" class="form-control" required value="<?= esc(old('name')) ?>">
        </div>
        <button type="submit" class="notification-button button-create">Cadastrar</button>
        <a href="<?= url_to('admin_precificacoes_categorias') ?>" class="btn btn-secondary btn-cancel">Cancelar</a>
    </form>
</div>

<?= $this->endSection() ?>