<?= $this->include('partials/head') ?>
<?= $this->include('partials/topbar') ?>
<?= $this->include('partials/sidebar') ?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Usuários</h1>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif ?>

            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">
                    Listagem e gerenciamento dos usuários do sistema.
                </li>
            </ol>

            <div class="mb-4">
                <button class="notification-button button-create">
                    Cadastrar Usuário
                </button>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <table class="datatable">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Perfil</th>
                                <th>Ativo</th>
                                <th>Criado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($users)) : ?>
                                <?php foreach ($users as $user) : ?>
                                    <tr>
                                        <td><?= esc($user['username']) ?></td>
                                        <td><?= esc($user['email']) ?></td>
                                        <td><?= esc($user['role']) ?></td>
                                        <td>
                                            <?php if ($user['active'] == 1) : ?>
                                                <span class="badge bg-success">Sim</span>
                                            <?php else : ?>
                                                <span class="badge bg-danger">Não</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $user['created_at'])->format('d/m/Y \à\s H:i:s') ?>
                                        </td>
                                        <td>
                                            <button class="icon-button" title="Visualizar">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <a href="<?php echo base_url('usuarios/editar/' . $user['id']) ?>" class="icon-button" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="icon-button" title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<?= $this->include('partials/scripts') ?>