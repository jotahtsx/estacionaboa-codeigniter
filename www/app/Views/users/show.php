<?= $this->include('partials/head') ?>
<?= $this->include('partials/topbar') ?>
<?= $this->include('partials/sidebar') ?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Usuário: <b><?= esc($user->first_name) ?>  <?= esc($user->last_name) ?></b></h1> 
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= base_url('usuarios') ?>">Usuários</a></li>
                <li class="breadcrumb-item active"><?= esc($user->first_name) ?>  <?= esc($user->last_name) ?></li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">
                    <p><strong>ID:</strong> <?= esc($user->id) ?></p>
                    <p><strong>Nome:</strong> <?= esc($user->first_name) ?></p>
                    <p><strong>Sobrenome:</strong> <?= esc($user->last_name) ?></p>
                    <p><strong>Username:</strong> <?= esc($user->username) ?></p>
                    <p><strong>Email:</strong> <?= esc($user->email) ?></p>

                    <p><strong>Ativo:</strong> <?= $user->active ? 'Sim' : 'Não' ?></p>

                    <p>
                        <strong>Perfil:</strong>
                        <?= esc($user->group) == 'admin' ? 'Administrador' : 'Usuário Comum' ?>
                    </p>

                    <a href="<?= base_url('usuarios') ?>" class="btn btn-secondary mt-3">Voltar</a>
                </div>
            </div>
        </div>
    </main>
</div>

<?= $this->include('partials/scripts') ?>