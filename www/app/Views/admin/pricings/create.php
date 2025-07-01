<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4 title-page"><b><?= esc($titlePage) ?></b></h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="<?= url_to('dashboard') ?>">Visão Geral</a>
        </li>
        <li class="breadcrumb-item active"><?= esc($titlePage) ?></li>
    </ol>

    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger admin-msg">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= url_to('admin_precificacoes_store') ?>" method="post" class="admin-form">
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-md-4">
                <label for="category_id">Categoria</label>
                <select name="category_id" id="category_id" class="form-select" required>
                    <option value="" disabled selected>Selecione uma categoria</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= old('category_id') == $cat['id'] ? 'selected' : '' ?>>
                            <?= esc($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>


            <div class="col-md-2">
                <label for="pricing_by_hour">Preço por hora (R$)</label>
                <input type="number" step="0.01" name="pricing_by_hour" class="form-control number" value="<?= old('pricing_by_hour') ?>" required>
            </div>

            <div class="col-md-2">
                <label for="pricing_by_mensality">Preço mensal (R$)</label>
                <input type="number" step="0.01" name="pricing_by_mensality" class="form-control number" value="<?= old('pricing_by_mensality') ?>" required>
            </div>

            <div class="col-md-2">
                <label for="capacity">Capacidade</label>
                <input type="number" name="capacity" class="form-control number" value="<?= old('capacity') ?>" required>
            </div>

            <div class="col-md-2">
                <label for="active">Ativo?</label>
                <select name="active" class="form-select">
                    <option value="1" <?= old('active') == '1' ? 'selected' : '' ?>>Sim</option>
                    <option value="0" <?= old('active') == '0' ? 'selected' : '' ?>>Não</option>
                </select>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary btn-submit">Salvar</button>
            <a href="<?= base_url('admin/precificacoes') ?>" class="btn btn-secondary btn-cancel">Cancelar</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>