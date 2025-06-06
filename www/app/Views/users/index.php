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

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif ?>

            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">
                    Listagem e gerenciamento dos usuários do sistema.
                </li>
            </ol>

            <div class="mb-4">
                <button class="notification-button button-create" onclick="window.location.href='<?= site_url('usuarios/cadastrar') ?>'">
                    Cadastrar Usuário
                </button>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <table class="datatable">
                        <thead>
                            <tr>
                                <th>Imagem</th>
                                <th>Nome</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Perfil</th>
                                <th>Ativo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($users)) : ?>
                                <?php foreach ($users as $user) : ?>
                                    <?php
                                    $userImagePath = null;
                                    if (!empty($user['image']) && is_string($user['image']) && file_exists(FCPATH . $user['image'])) {
                                        $userImagePath = $user['image'];
                                    }
                                    if ($userImagePath) {
                                        $userImagePath = ltrim($userImagePath, '/');
                                        $finalImagePath = base_url($userImagePath);
                                    } else {
                                        $defaultAvatar = 'images/defaults/avatar-default.png';
                                        if (isset($user['gender']) && !empty($user['gender'])) {
                                            if ($user['gender'] === 'female') {
                                                $defaultAvatar = 'images/defaults/avatar-female-default.png';
                                            } elseif ($user['gender'] === 'male') {
                                                $defaultAvatar = 'images/defaults/avatar-male-default.png';
                                            }
                                        }
                                        $finalImagePath = base_url($defaultAvatar);
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo base_url('usuarios/editar/' . $user['id']) ?>">
                                                <img src="<?= $finalImagePath ?>" alt="<?= esc($user['username'] ?? $user['first_name'] ?? 'Usuário') ?>" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                            </a>
                                        </td>
                                        <td valingn="middle"><?= esc($user['first_name']) ?> <?= esc($user['last_name']) ?></td>
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
                                            <button class="icon-button" title="Visualizar" onclick="window.location.href='<?= base_url('usuarios/show/' . $user['id']) ?>'">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <a href="<?php echo base_url('usuarios/editar/' . $user['id']) ?>" class="icon-button" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?= base_url('usuarios/delete/' . $user['id']) ?>" method="post" style="display:inline;">
                                                <button type="submit" class="icon-button" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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