<?= $this->include('partials/head') ?>
<?= $this->include('partials/topbar') ?>
<?= $this->include('partials/sidebar') ?>

<div id="layoutSidenav_content">
    <main>


        <div class="container-fluid px-4">
            <h1 class="mt-4">Editar: <b><?= esc($user->username) ?></b></h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">
                    Editar: <b><?= esc($user->username) ?></b>
                </li>
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


                    <form action="<?= base_url('usuarios/atualizar/' . $user->id) ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= esc($user->id) ?>">

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

                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        <a href="<?= base_url('usuarios') ?>" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<?= $this->include('partials/scripts') ?>