<?= $this->include('partials/head') ?>
<?= $this->include('partials/topbar') ?>
<?= $this->include('partials/sidebar') ?>

<div id="layoutSidenav_content">
    <main>
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

            <div class="card mb-4">
                <div class="card-body">
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
                            <?php
                            $userImageExists = false;
                            $finalImagePath = base_url('images/defaults/avatar-default.png');
                            if (!empty($user->image) && is_string($user->image)) {
                                $fullPathOnDisk = FCPATH . $user->image;
                                if (file_exists($fullPathOnDisk)) {
                                    $finalImagePath = base_url($user->image);
                                    $userImageExists = true;
                                } else {
                                    log_message('warning', 'Imagem do usuário ' . $user->id . ' no DB mas não encontrada no disco: ' . $fullPathOnDisk);
                                }
                            }
                            if (!$userImageExists) {
                                $genderForAvatar = old('gender', $user->gender);
                                if ($genderForAvatar === 'female') {
                                    $finalImagePath = base_url('images/defaults/avatar-female-default.png');
                                } elseif ($genderForAvatar === 'male') {
                                    $finalImagePath = base_url('images/defaults/avatar-male-default.png');
                                }
                            }
                            ?>
                            <img id="profileImagePreview" src="<?= $finalImagePath ?>?v=<?= time() ?>" alt="Avatar do Usuário" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ddd;">
                            <br>
                            <label for="image" class="form-label">Imagem de Perfil</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png,image/gif,image/webp">
                            <small class="form-text text-muted">Formatos permitidos: JPG, PNG, GIF, WEBP. Tamanho máximo: 2MB. Deixe em branco para manter a imagem atual.</small>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const genderSelect = document.getElementById('gender');
        const profileImagePreview = document.getElementById('profileImagePreview');
        const fileInput = document.getElementById('image');
        const defaultMaleAvatar = '<?= base_url('images/defaults/avatar-male-default.png') ?>';
        const defaultFemaleAvatar = '<?= base_url('images/defaults/avatar-female-default.png') ?>';
        const defaultGenericAvatar = '<?= base_url('images/defaults/avatar-default.png') ?>';
        const initialImageSrc = profileImagePreview.src.split('?')[0];
        const hasCustomImageInitially = <?= $userImageExists ? 'true' : 'false' ?>;
        function updateAvatarBasedOnGender() {
            const selectedGender = genderSelect.value;
            let newSrc = defaultGenericAvatar;

            if (selectedGender === 'male') {
                newSrc = defaultMaleAvatar;
            } else if (selectedGender === 'female') {
                newSrc = defaultFemaleAvatar;
            }
            if (!fileInput.files || fileInput.files.length === 0) {
                profileImagePreview.src = newSrc;
            }
        }
        function previewFile() {
            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onloadend = function() {
                profileImagePreview.src = reader.result;
            }
            if (file) {
                reader.readAsDataURL(file);
            } else {
                if (hasCustomImageInitially) {
                    profileImagePreview.src = initialImageSrc + '?v=' + new Date().getTime();
                } else {
                    updateAvatarBasedOnGender();
                }
            }
        }
        if (!hasCustomImageInitially) {
            updateAvatarBasedOnGender();
        }
        genderSelect.addEventListener('change', function() {
            if (!hasCustomImageInitially || !fileInput.files || fileInput.files.length === 0) {
                 updateAvatarBasedOnGender();
            }
        });

        fileInput.addEventListener('change', previewFile);
    });
</script>