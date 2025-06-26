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
        <div class="alert alert-success admin-msg"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <form class="admin-form mb-3" action="<?= base_url('admin/configuracoes') ?>" method="post">
        <input type="hidden" name="id" value="<?= esc($config['id']) ?>">

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="trade_name">Razão Social</label>
                <input type="text" name="legal_name" id="legal_name" class="form-control" value="<?= esc($config['legal_name']) ?>">
            </div>
            <div class="col-md-6">
                <label for="trade_name">Nome Fantasia</label>
                <input type="text" name="trade_name" id="trade_name" class="form-control" value="<?= esc($config['trade_name']) ?>">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="cnpj">CNPJ</label>
                <input type="text" name="cnpj" id="cnpj" class="form-control" value="<?= esc($config['cnpj']) ?>" required>
            </div>
            <div class="col-md-6">
                <label for="state_registration">Inscrição Estadual</label>
                <input type="text" name="state_registration" id="state_registration" class="form-control" value="<?= esc($config['state_registration']) ?>" required>
            </div>
        </div>

        <div class="section-separator"></div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="zip_code">CEP</label>
                <input type="text" name="zip_code" id="zip_code" class="form-control" value="<?= esc($config['zip_code']) ?>">
            </div>
            <div class="col-md-5">
                <label for="address">Endereço</label>
                <input type="text" name="address" id="addressInput" class="form-control" value="<?= esc($config['address']) ?>" required>
            </div>
            <div class="col-md-1">
                <label for="number">Número</label>
                <input type="text" name="number" id="number" class="form-control" value="<?= esc($config['number']) ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="neighborhood">Bairro</label>
                <input type="text" name="neighborhood" id="neighborhood" class="form-control" value="<?= esc($config['neighborhood']) ?>" required>
            </div>
            <div class="col-md-5">
                <label for="city">Cidade</label>
                <input type="text" name="city" id="city" class="form-control" value="<?= esc($config['city']) ?>" required>
            </div>
            <div class="col-md-1">
                <label for="state">Estado</label>
                <input type="text" name="state" id="state" class="form-control" value="<?= esc($config['state']) ?>" required maxlength="2">
            </div>
        </div>

        <div class="section-separator"></div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="site_url">Website</label>
                <input type="text" name="site_url" id="site_url" class="form-control" value="<?= esc($config['site_url']) ?>">
            </div>
            <div class="col-md-2">
                <label for="instagram">Instagram</label>
                <input type="text" name="instagram" id="instagram" class="form-control" value="<?= esc($config['instagram']) ?>">
            </div>
            <div class="col-md-2">
                <label for="phone_number">Telefone</label>
                <input type="text" name="phone_number" id="phone_number" class="form-control" value="<?= esc($config['phone_number']) ?>" required>
            </div>

            <div class="col-md-4">
                <label for="email">E-mail de contato</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= esc($config['email']) ?>" required>
            </div>

        </div>

        <div class="mb-4">
            <label for="ticket_footer_text">Texto no rodapé do ticket</label>
            <textarea name="ticket_footer_text" id="ticket_footer_text" class="form-control" rows="3" required><?= esc($config['ticket_footer_text']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-save">Salvar Configurações</button>
    </form>
</div>

<?= $this->endSection() ?>