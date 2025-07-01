<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4 title-page"><b><?= esc($titlePage) ?></b></h1>

    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger admin-msg">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/precificacoes') ?>" method="post" class="admin-form">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="pricing_category">Categoria</label>
            <input type="text" name="pricing_category" class="form-control" value="<?= old('pricing_category') ?>" required>
        </div>

        <div class="mb-3">
            <label for="pricing_by_hour">Preço por hora (R$)</label>
            <input type="number" step="0.01" name="pricing_by_hour" class="form-control" value="<?= old('pricing_by_hour') ?>" required>
        </div>

        <div class="mb-3">
            <label for="pricing_by_mensality">Preço mensal (R$)</label>
            <input type="number" step="0.01" name="pricing_by_mensality" class="form-control" value="<?= old('pricing_by_mensality') ?>" required>
        </div>

        <div class="mb-3">
            <label for="capacity">Capacidade</label>
            <input type="number" name="capacity" class="form-control" value="<?= old('capacity') ?>" required>
        </div>

        <div class="mb-3">
            <label for="active">Ativo?</label>
            <select name="active" class="form-control">
                <option value="1" <?= old('active') == '1' ? 'selected' : '' ?>>Sim</option>
                <option value="0" <?= old('active') == '0' ? 'selected' : '' ?>>Não</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary btn-submit">Salvar</button>
        <a href="<?= base_url('admin/precificacoes') ?>" class="btn btn-secondary btn-cancel">Cancelar</a>
    </form>
</div>

<?= $this->endSection() ?>
