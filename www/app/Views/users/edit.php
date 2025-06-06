<?= $this->include('partials/head') ?>
<?= $this->include('partials/topbar') ?>
<?= $this->include('partials/sidebar') ?>

<div id="layoutSidenav_content">
    <main>

        <?php if (session('validation')): ?>
            <div class="alert alert-danger">
                <ul style="list-style: none; padding-left: 0; margin-bottom: 0;">
                    <?= session('validation')->listErrors() ?>
                </ul>
            </div>
        <?php endif; ?>


        <div class="container-fluid px-4">
            <h1 class="mt-4">Editar: <b><?= esc($user->first_name) ?> <?= esc($user->last_name) ?></b></h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">
                    Usuário: <b><?= esc($user->username) ?></b>
                </li>
            </ol>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= base_url('usuarios') ?>">Usuários</a></li>
                <li class="breadcrumb-item">Editar</li>
                <li class="breadcrumb-item active"><?= esc($user->first_name) ?> <?= esc($user->last_name) ?></li>
            </ol>
            <div class="card mb-4">

                <div class="card-body">

                    <?php if (session('validation')): ?>
                        <div class="alert alert-danger">
                            <ul style="list-style: none; padding-left: 0; margin-bottom: 0;">
                                <?= session('validation')->listErrors() ?>
                            </ul>
                        </div>
                    <?php endif; ?>


                    <form action="<?= base_url('usuarios/atualizar/' . $user->id) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= esc($user->id) ?>">

                        <div class="mb-3">
                            <label for="first_name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= esc($user->first_name) ?>">
                        </div>

                        <div class="mb-3">
                            <label for="last_name" class="form-label">Sobrenome</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= esc($user->last_name) ?>">
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= esc($user->username) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= esc($user->email) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="active" class="form-label">Perfil</label>
                            <select name="role" class="form-select">
                                <option value="user" <?= old('role', $user->group ?? '') === 'user' ? 'selected' : '' ?>>Usuário Comum</option>
                                <option value="admin" <?= old('role', $user->group ?? '') === 'admin' ? 'selected' : '' ?>>Administrador</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="active" class="form-label">Ativo</label>
                            <select class="form-select" id="active" name="active">
                                <option value="1" <?= ($user->active == 1) ? 'selected' : '' ?>>Sim</option>
                                <option value="0" <?= ($user->active == 0) ? 'selected' : '' ?>>Não</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha (opcional)</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Deixe em branco para não alterar">
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Gênero</label>
                            <select name="gender" class="form-select" id="gender">
                                <option value="male" <?= old('gender', $user->gender ?? '') === 'male' ? 'selected' : '' ?>>Masculino</option>
                                <option value="female" <?= old('gender', $user->gender ?? '') === 'female' ? 'selected' : '' ?>>Feminino</option>
                                <option value="other" <?= old('gender', $user->gender ?? '') === 'other' ? 'selected' : '' ?>>Outro</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Imagem de Perfil</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png,image/gif,image/webp">
                            <small class="form-text text-muted">Formatos permitidos: JPG, PNG, GIF, WEBP. Tamanho máximo: 2MB.</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        <a href="<?= base_url('usuarios') ?>" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<?= $this->include('partials/scripts') ?>