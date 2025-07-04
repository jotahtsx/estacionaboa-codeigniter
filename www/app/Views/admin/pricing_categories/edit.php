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

    <form action="<?= base_url("admin/categorias/atualizar/{$category['id']}") ?>" method="post" class="admin-form mb-3">
        <?= csrf_field() ?>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="name">Nome da Categoria</label>
                <input type="text" name="name" id="name" class="form-control" required value="<?= esc(old('name', $category['name'])) ?>">
            </div>
            <div class="col-md-2 mb-3">
                <label for="active">Ativo?</label>
                <select name="active" id="active" class="form-select">
                    <option value="1" <?= old('active', $category['active'] ?? '1') == '1' ? 'selected' : '' ?>>Sim</option>
                    <option value="0" <?= old('active', $category['active'] ?? '1') == '0' ? 'selected' : '' ?>>Não</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>

<?= $this->endSection() ?>