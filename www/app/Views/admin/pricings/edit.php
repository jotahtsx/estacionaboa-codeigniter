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

    <form action="<?= base_url("admin/precificacoes/atualizar/{$pricing['id']}") ?>" method="post" class="admin-form">
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="pricing_category_id" class="form-label">Categoria</label>
                    <select name="pricing_category_id" id="pricing_category_id" class="form-select" required>
                        <option value="">Selecione uma categoria</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= esc($cat['id']) ?>"
                                <?= old('pricing_category_id', $pricing['pricing_category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                <?= esc($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="mb-3">
                    <label for="pricing_by_hour">Preço por hora (R$)</label>
                    <input type="number" step="0.01" name="pricing_by_hour" id="pricing_by_hour" class="form-control number" value="<?= old('pricing_by_hour', $pricing['pricing_by_hour'] ?? '') ?>" required>
                </div>
            </div>

            <div class="col-md-2">
                <div class="mb-3">
                    <label for="pricing_by_mensality">Preço mensal (R$)</label>
                    <input type="number" step="0.01" name="pricing_by_mensality" id="pricing_by_mensality" class="form-control number" value="<?= old('pricing_by_mensality', $pricing['pricing_by_mensality'] ?? '') ?>" required>
                </div>
            </div>

            <div class="col-md-2">
                <div class="mb-3">
                    <label for="capacity">Capacidade</label>
                    <input type="number" name="capacity" id="capacity" class="form-control number" value="<?= old('capacity', $pricing['capacity'] ?? '') ?>" required>
                </div>
            </div>

            <div class="col-md-2">
                <div class="mb-3">
                    <label for="active">Ativo?</label>
                    <select name="active" id="active" class="form-select">
                        <option value="1" <?= old('active', $pricing['active'] ?? '1') == '1' ? 'selected' : '' ?>>Sim</option>
                        <option value="0" <?= old('active', $pricing['active'] ?? '1') == '0' ? 'selected' : '' ?>>Não</option>
                    </select>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-submit">Atualizar</button>
        <a href="<?= base_url('admin/precificacoes') ?>" class="btn btn-secondary btn-cancel">Cancelar</a>
    </form>
</div>

<?= $this->endSection() ?>