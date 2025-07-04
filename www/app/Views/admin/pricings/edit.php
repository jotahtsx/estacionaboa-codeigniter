<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4 title-page"><b><?= esc($titlePage) ?></b></h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url_to('dashboard') ?>">Visão Geral</a></li>
        <li class="breadcrumb-item"><a href="<?= url_to('admin_precificacoes') ?>">Precificações</a></li>
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
                    <input
                        type="text"
                        name="pricing_by_hour"
                        id="pricing_by_hour"
                        class="form-control money-mask"
                        value="<?= old('pricing_by_hour', $pricing['pricing_by_hour'] !== null ? str_replace('.', ',', $pricing['pricing_by_hour']) : '0,00') ?>"
                        required>
                </div>
            </div>

            <div class="col-md-2">
                <div class="mb-3">
                    <label for="pricing_by_mensality">Preço mensal (R$)</label>
                    <input
                        type="text"
                        name="pricing_by_mensality"
                        id="pricing_by_mensality"
                        class="form-control money-mask"
                        value="<?= old('pricing_by_mensality', $pricing['pricing_by_mensality'] !== null ? str_replace('.', ',', $pricing['pricing_by_mensality']) : '0,00') ?>"
                        required>
                </div>
            </div>

            <div class="col-md-2">
                <div class="mb-3">
                    <label for="capacity">Capacidade</label>
                    <input
                        type="number"
                        name="capacity"
                        id="capacity"
                        class="form-control number"
                        value="<?= old('capacity', $pricing['capacity'] ?? '') ?>"
                        required>
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

        <div class="mt-3">
            <button type="submit" class="btn btn-primary btn-submit">Salvar</button>
            <a href="<?= base_url('admin/precificacoes') ?>" class="btn btn-secondary btn-cancel">Cancelar</a>
        </div>
    </form>
</div>

<script src="https://unpkg.com/imask"></script>
<script>
    const moneyMaskOptions = {
        mask: Number,
        scale: 2,
        signed: false,
        thousandsSeparator: '.',
        padFractionalZeros: true,
        normalizeZeros: true,
        radix: ',',
        mapToRadix: ['.']
    };

    IMask(document.getElementById('pricing_by_hour'), moneyMaskOptions);
    IMask(document.getElementById('pricing_by_mensality'), moneyMaskOptions);
</script>

<?= $this->endSection() ?>