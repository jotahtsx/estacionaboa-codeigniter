<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4 title-page"><b><?= esc($titlePage) ?></b></h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url_to('dashboard') ?>">Visão Geral</a></li>
        <li class="breadcrumb-item"><a href="<?= url_to('admin_mensalistas') ?>">Mensalistas</a></li>
        <li class="breadcrumb-item active"><?= esc($titlePage) ?></li>
    </ol>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success admin-msg"><?= esc(session('success')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger admin-msg"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <?php
    $errors = session('errors');
    if ($errors) : ?>
        <div class="alert alert-danger admin-msg">
            <p>Por favor, corrija os seguintes erros:</p>
            <ul>
                <?php foreach ($errors as $field => $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= url_to('admin_mensalistas_store') ?>" method="post" class="admin-form mb-3">
        <?= csrf_field() ?>

        <div class="row mb-3">
            <div class="col-md-3 mb-3">
                <label for="first_name" class="form-label">Nome *</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= old('first_name') ?>">
            </div>
            <div class="col-md-3 mb-3">
                <label for="last_name" class="form-label">Sobrenome *</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= old('last_name') ?>">
            </div>
            <div class="col-md-2 mb-3">
                <label for="birth_date" class="form-label">Data de Nascimento *</label>
                <input type="date" class="form-control date" id="birth_date" name="birth_date" value="<?= old('birth_date') ?>">
            </div>
            <div class="col-md-2 mb-3">
                <label for="cpf" class="form-label">CPF *</label>
                <input type="text" class="form-control" id="cpf" name="cpf" value="<?= old('cpf') ?>" placeholder="000.000.000-00">
            </div>
            <div class="col-md-2">
                <label for="rg" class="form-label">RG *</label>
                <input type="text" class="form-control" id="rg" name="rg" value="<?= old('rg') ?>">
            </div>
            <div class="col-md-3">
                <label for="zipCodeInput" class="form-label">CEP *</label>
                <input type="text" class="form-control" id="zipCodeInput" name="zip_code" value="<?= old('zip_code') ?>">
            </div>
            <div class="col-md-3">
                <label for="addressInput" class="form-label">Endereço (Rua/Avenida) *</label>
                <input type="text" class="form-control" id="addressInput" name="street" value="<?= old('street') ?>">
            </div>
            <div class="col-md-2">
                <label for="number" class="form-label">Número *</label>
                <input type="text" class="form-control" id="number" name="number" value="<?= old('number') ?>">
            </div>
            <div class="col-md-4 mb-3">
                <label for="neighborhood" class="form-label">Bairro *</label>
                <input type="text" class="form-control" id="neighborhood" name="neighborhood" value="<?= old('neighborhood') ?>">
            </div>
            <div class="col-md-6">
                <label for="city" class="form-label">Cidade *</label>
                <input type="text" class="form-control" id="city" name="city" value="<?= old('city') ?>">
            </div>
            <div class="col-md-2">
                <label for="state" class="form-label">Estado (UF) *</label>
                <input type="text" class="form-control" id="state" name="state" value="<?= old('state') ?>" maxlength="2">
            </div>
            <div class="col-md-4 mb-3">
                <label for="complement" class="form-label">Complemento</label>
                <input type="text" class="form-control" id="complement" name="complement" value="<?= old('complement') ?>">
            </div>
            <div class="col-md-3">
                <label for="phoneInput" class="form-label">Telefone *</label>
                <input type="text" name="phone" id="phoneInput" class="form-control" value="<?= old('phone') ?>">
            </div>
            <div class="col-md-3">
                <label for="email" class="form-label">Email *</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>">
            </div>
            <div class="col-md-2">
                <label for="due_day" class="form-label">Vencimento *</label>
                <input type="number" class="form-control date" id="due_day" name="due_day" value="<?= old('due_day') ?>" min="1" max="31">
            </div>
            <div class="col-md-3 mb-3">
                <label for="vehicle_plate" class="form-label">Placa do Veículo *</label>
                <input type="text" class="form-control" id="vehicle_plate" name="vehicle_plate" value="<?= old('vehicle_plate') ?>" placeholder="AAA0A00 ou ABC-1234">
            </div>
            <div class="col-md-3 mb-3">
                <label for="vehicle_type" class="form-label">Tipo de Veículo *</label>
                <select class="form-select" id="vehicle_type" name="vehicle_type" required>
                    <option value="carro" <?= old('vehicle_type') === 'carro' ? 'selected' : '' ?>>Carro</option>
                    <option value="moto" <?= old('vehicle_type') === 'moto' ? 'selected' : '' ?>>Moto</option>
                    <option value="outro" <?= old('vehicle_type') === 'outro' ? 'selected' : '' ?>>Outro</option>
                </select>
            </div>
            <div class="col-md-2 mb-3">
                <label for="active" class="form-label">Ativo *</label>
                <select class="form-select" id="active" name="active" required>
                    <option value="1" <?= old('active') === '1' ? 'selected' : '' ?>>Sim</option>
                    <option value="0" <?= old('active') === '0' ? 'selected' : '' ?>>Não</option>
                </select>
            </div>
            <div class="col-12 mb-3">
                <label for="notes" class="form-label">Observações</label>
                <textarea class="form-control" id="notes" name="notes" rows="3"><?= old('notes') ?></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-submit">Salvar</button>
        <a href="<?= url_to('admin_mensalistas') ?>" class="btn btn-secondary btn-cancel">Cancelar</a>
    </form>
</div>

<script src="https://unpkg.com/imask"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cpfInput = document.getElementById('cpf');
        const zipInput = document.getElementById('zipCodeInput');
        const phoneInput = document.getElementById('phoneInput');
        const stateInput = document.getElementById('state');
        const addressInput = document.getElementById('addressInput');
        const neighborhoodInput = document.getElementById('neighborhood');
        const cityInput = document.getElementById('city');
        const plateInput = document.getElementById('vehicle_plate');

        if (cpfInput) {
            IMask(cpfInput, { mask: '000.000.000-00' });
        }

        if (phoneInput) {
            IMask(phoneInput, { mask: '(00) 00000-0000' });
        }

        if (zipInput) {
            IMask(zipInput, { mask: '00000-000' });

            zipInput.addEventListener('blur', () => {
                const cep = zipInput.value.replace(/\D/g, '');
                if (cep.length !== 8) return alert('CEP inválido.');
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.erro) return alert('CEP não encontrado.');
                        if (addressInput) addressInput.value = data.logradouro || '';
                        if (neighborhoodInput) neighborhoodInput.value = data.bairro || '';
                        if (cityInput) cityInput.value = data.localidade || '';
                        if (stateInput) stateInput.value = data.uf || '';
                    })
                    .catch(() => alert('Erro ao buscar CEP.'));
            });
        }

        IMask(plateInput, {
        mask: [
            {
            mask: 'AAA-0000',
            definitions: {
                'A': /[A-Za-z]/,
                '0': /[0-9]/
            }
            },
            {
            mask: 'AAA0A00',
            definitions: {
                'A': /[A-Za-z]/,
                '0': /[0-9]/
            }
            }
        ],
        prepare: function(str) {
            return str.toUpperCase();
        }
        });


        if (stateInput) {
            stateInput.addEventListener('input', (e) => {
                e.target.value = e.target.value.toUpperCase();
            });
        }
    });
</script>

<?= $this->endSection() ?>
