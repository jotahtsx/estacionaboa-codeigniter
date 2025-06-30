<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4 title-page"><b>Configurações</b></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="<?= url_to('dashboard') ?>">Visão Geral</a>
        </li>
        <li class="breadcrumb-item active">Configurações</li>
    </ol>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success admin-msg">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger admin-msg">
            <ul class="mb-0">
                <?php foreach ($errors as $field => $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <form class="admin-form mb-3" action="<?= base_url('admin/configuracoes') ?>" method="post">
        <input type="hidden" name="id" value="<?= esc(old('id', $config['id'] ?? '')) ?>">

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="legal_name">Razão Social</label>
                <input type="text" name="legal_name" id="legal_name" class="form-control" value="<?= esc(old('legal_name', $config['legal_name'] ?? '')) ?>">
            </div>
            <div class="col-md-6">
                <label for="trade_name">Nome Fantasia</label>
                <input type="text" name="trade_name" id="trade_name" class="form-control" value="<?= esc(old('trade_name', $config['trade_name'] ?? '')) ?>">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="cnpjInput">CNPJ</label>
                <input type="text" name="cnpj" id="cnpjInput" class="form-control" value="<?= esc(old('cnpj', $config['cnpj'] ?? '')) ?>">
            </div>
            <div class="col-md-6">
                <label for="state_registration">Inscrição Estadual</label>
                <input type="text" name="state_registration" id="state_registration" class="form-control" value="<?= esc(old('state_registration', $config['state_registration'] ?? '')) ?>" required>
            </div>
        </div>

        <div class="section-separator"></div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="zipCodeInput">CEP</label>
                <input type="text" name="zip_code" id="zipCodeInput" class="form-control" value="<?= esc(old('zip_code', $config['zip_code'] ?? '')) ?>">
            </div>
            <div class="col-md-5">
                <label for="addressInput">Endereço</label>
                <input type="text" name="address" id="addressInput" class="form-control" value="<?= esc(old('address', $config['address'] ?? '')) ?>" required>
            </div>
            <div class="col-md-1">
                <label for="number">Número</label>
                <input type="text" name="number" id="number" class="form-control" value="<?= esc(old('number', $config['number'] ?? '')) ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="neighborhood">Bairro</label>
                <input type="text" name="neighborhood" id="neighborhood" class="form-control" value="<?= esc(old('neighborhood', $config['neighborhood'] ?? '')) ?>" required>
            </div>
            <div class="col-md-5">
                <label for="city">Cidade</label>
                <input type="text" name="city" id="city" class="form-control" value="<?= esc(old('city', $config['city'] ?? '')) ?>" required>
            </div>
            <div class="col-md-1">
                <label for="state">Estado</label>
                <input type="text" name="state" id="state" class="form-control" value="<?= esc(old('state', $config['state'] ?? '')) ?>" required maxlength="2">
            </div>
        </div>

        <div class="section-separator"></div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="site_url">Website</label>
                <input type="text" name="site_url" id="site_url" class="form-control" value="<?= esc(old('site_url', $config['site_url'] ?? '')) ?>">
            </div>
            <div class="col-md-2">
                <label for="instagram">Instagram</label>
                <input type="text" name="instagram" id="instagram" class="form-control" value="<?= esc(old('instagram', $config['instagram'] ?? '')) ?>">
            </div>
            <div class="col-md-2">
                <label for="phoneInput">Telefone</label>
                <input type="text" name="phone_number" id="phoneInput" class="form-control" value="<?= esc(old('phone_number', $config['phone_number'] ?? '')) ?>" required>
            </div>
            <div class="col-md-4">
                <label for="email">E-mail de contato</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= esc(old('email', $config['email'] ?? '')) ?>" required>
            </div>
        </div>

        <div class="mb-4">
            <label for="ticket_footer_text">Texto no rodapé do ticket</label>
            <textarea name="ticket_footer_text" id="ticket_footer_text" class="form-control" rows="3" required><?= esc(old('ticket_footer_text', $config['ticket_footer_text'] ?? '')) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-save">Salvar Configurações</button>
    </form>
</div>

<script src="https://unpkg.com/imask"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cnpjInput = document.getElementById('cnpjInput');
        const zipInput = document.getElementById('zipCodeInput');
        const phoneInput = document.getElementById('phoneInput');

        if (cnpjInput) {
            IMask(cnpjInput, {
                mask: '00.000.000/0000-00'
            });
        }

        if (zipInput) {
            IMask(zipInput, {
                mask: '00000-000'
            });
        }

        if (phoneInput) {
            IMask(phoneInput, {
                mask: '(00) 00000-0000'
            });
        }
    });
</script>

<?= $this->endSection() ?>