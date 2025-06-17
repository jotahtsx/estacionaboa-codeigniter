<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Detalhes do Usuário: <?= esc($user['username']) ?></h1>

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
        <li class="breadcrumb-item active">Informações detalhadas sobre o usuário.</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user me-1"></i>
            Informações do Perfil
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-center">
                    <?php
                    $userImagePath = null;
                    if (!empty($user['image']) && file_exists(FCPATH . $user['image'])) {
                        $userImagePath = $user['image'];
                    }

                    if ($userImagePath) {
                        $finalImagePath = base_url(ltrim($userImagePath, '/'));
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
                    <img src="<?= $finalImagePath ?>" alt="<?= esc($user['username'] ?? $user['first_name'] ?? 'Usuário') ?>" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                </div>
                <div class="col-md-9">
                    <p><strong>ID:</strong> <?= esc($user['id']) ?></p>
                    <p><strong>Nome Completo:</strong> <?= esc($user['first_name']) ?> <?= esc($user['last_name']) ?></p>
                    <p><strong>Username:</strong> <?= esc($user['username']) ?></p>
                    <p><strong>Email:</strong> <?= esc($user['email']) ?></p>
                    <p><strong>Gênero:</strong> <?= esc(ucfirst($user['gender'] ?? 'Não Informado')) ?></p>
                    <p><strong>Perfil:</strong> <?= esc($user['role']) ?></p>
                    <p><strong>Status:</strong>
                        <?php if ($user['active'] == 1) : ?>
                            <span class="badge bg-success">Ativo</span>
                        <?php else : ?>
                            <span class="badge bg-danger">Inativo</span>
                        <?php endif; ?>
                    </p>
                    <p><strong>Criado em:</strong> <?= esc($user['created_at']) ?></p>
                    <p><strong>Última Atualização:</strong> <?= esc($user['updated_at']) ?></p> 
                </div>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <a href="<?= url_to('admin_usuarios_edit', $user['id']) ?>" class="btn btn-primary me-2">
            <i class="fas fa-edit me-1"></i> Editar Usuário
        </a>
        <a href="<?= url_to('admin_usuarios') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Voltar à Lista
        </a>
    </div>

</div>
<?= $this->endSection() ?>