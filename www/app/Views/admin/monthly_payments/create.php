<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4 title-page"><b><?= esc($titlePage) ?></b></h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url_to('dashboard') ?>">Visão Geral</a></li>
        <li class="breadcrumb-item"><a href="">Mensalidades</a></li>
        <li class="breadcrumb-item active"><?= esc($titlePage) ?></li>
    </ol>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success admin-msg"><?= esc(session('success')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger admin-msg"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <?php if ($errors = session('errors')): ?>
        <div class="alert alert-danger admin-msg">
            <p>Por favor, corrija os seguintes erros:</p>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= route_to('admin_mensalidades_store') ?>" method="post" class="admin-form mb-3">
        <?= csrf_field() ?>

        <div class="row mb-3">
            <!-- Mensalista -->
            <div class="col-md-10 mb-3">
                <label for="monthly_payer_id" class="form-label">Mensalista *</label>
                <select class="form-select" id="monthly_payer_id" name="monthly_payer_id" required>
                    <option value="">Selecione o Mensalista</option>
                    <?php foreach ($monthlyPayers as $payer): ?>
                        <option 
                            value="<?= $payer['id'] ?>" 
                            data-due-day="<?= esc($payer['due_day']) ?>"
                            <?= old('monthly_payer_id') == $payer['id'] ? 'selected' : '' ?>>
                            <?= esc($payer['first_name'] . ' ' . $payer['last_name']) ?> | <?= esc($payer['cpf']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Melhor dia do vencimento -->
            <div class="col-md-2 mb-3">
                <label for="due_day" class="form-label">Dia do Vencimento *</label>
                <input type="number" class="form-control date" id="due_day" name="due_day" min="1" max="31" value="<?= old('due_day') ?>">
            </div>

            <!-- Categoria de Precificação -->
            <div class="col-md-3 mb-3">
                <label for="pricing_id" class="form-label">Categoria *</label>
                <select class="form-select" id="pricing_id" name="pricing_id" required>
                    <option value="">Selecione a categoria</option>
                    <?php foreach ($pricings as $pricing): ?>
                        <option 
                            value="<?= $pricing['id'] ?>" 
                            data-price="<?= $pricing['pricing_by_mensality'] ?>" 
                            <?= old('pricing_id') == $pricing['id'] ? 'selected' : '' ?>
                        >
                            <?= esc($pricing['category_name']) ?> - R$ <?= number_format($pricing['pricing_by_mensality'], 2, ',', '.') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Valor da Mensalidade -->
            <div class="col-md-2 mb-3">
                <label for="pricing_value" class="form-label">Mensalidade (R$) *</label>
                <input type="text" id="pricing_value" name="pricing_value" class="form-control money" value="<?= old('pricing_value') ?>" required>
            </div>

            <!-- Data de Vencimento -->
            <div class="col-md-2 mb-3">
                <label for="due_date" class="form-label">Data de Vencimento *</label>
                <input type="date" id="due_date" name="due_date" class="form-control date" value="<?= old('due_date') ?>" required>
            </div>

            <!-- Situação -->
            <div class="col-md-3 mb-3">
                <label for="status" class="form-label">Situação *</label>
                <select id="status" name="status" class="form-select" required>
                    <option value="pendente" <?= old('status') === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                    <option value="pago" <?= old('status') === 'pago' ? 'selected' : '' ?>>Pago</option>
                    <option value="atrasado" <?= old('status') === 'atrasado' ? 'selected' : '' ?>>Atrasado</option>
                </select>
            </div>

            <div class="col-md-2">
                <div class="mb-3">
                    <label for="active">Ativo?</label>
                    <select name="active" id="active" class="form-select">
                        <option value="1" <?= old('active', '1') == '1' ? 'selected' : '' ?>>Sim</option>
                        <option value="0" <?= old('active') == '0' ? 'selected' : '' ?>>Não</option>
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-submit">Salvar</button>
        <a href="" class="btn btn-secondary btn-cancel">Cancelar</a>
    </form>
</div>

<!-- Máscara para valor monetário -->
<script src="https://unpkg.com/imask"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const moneyInput = document.querySelector('.money');
    if(moneyInput) {
        IMask(moneyInput, {
            mask: Number,
            scale: 2,
            thousandsSeparator: '.',
            radix: ',',
            mapToRadix: ['.'],
            padFractionalZeros: true,
        });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const monthlyPayerSelect = document.getElementById('monthly_payer_id');
    const dueDayInput = document.getElementById('due_day');

    function updateDueDay() {
        const selectedOption = monthlyPayerSelect.options[monthlyPayerSelect.selectedIndex];
        const dueDay = selectedOption.getAttribute('data-due-day');
        if (dueDay) {
            dueDayInput.value = dueDay;
        } else {
            dueDayInput.value = '';
        }
    }

    monthlyPayerSelect.addEventListener('change', updateDueDay);

    // Se quiser já popular ao carregar a página, chama aqui:
    updateDueDay();
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const pricingSelect = document.getElementById('pricing_id');
    const pricingValueInput = document.getElementById('pricing_value');

    function updatePrice() {
        const selected = pricingSelect.options[pricingSelect.selectedIndex];
        const price = selected.getAttribute('data-price');

        if (price && pricingValueInput) {
            pricingValueInput.value = price;
            pricingValueInput.dispatchEvent(new Event('input')); // ativa mascara, se tiver
        }
    }

    pricingSelect.addEventListener('change', updatePrice);
    updatePrice(); // já preenche se tiver valor selecionado
});
</script>


<?= $this->endSection() ?>
