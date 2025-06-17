<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4"><?= esc($titlePage) ?>: <?= esc($user->first_name . ' ' . $user->last_name) ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="<?= url_to('dashboard') ?>">Visão Geral</a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?= url_to('admin_usuarios') ?>">Usuários</a>
        </li>
        <li class="breadcrumb-item active"><?= esc($titlePage) ?></li>
    </ol>

    <?php if (session()->has('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->has('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php $validation = session()->getFlashdata('validation'); ?>
    <?php
    /**
     * @var \CodeIgniter\Validation\Validation|null $validation
     */
    ?>
    <?php if ($validation) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5>Erros de Validação:</h5>
            <ul style="list-style: none; padding-left: 0; margin-bottom: 0;">
                <?= $validation->listErrors() ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="<?= url_to('admin_usuarios_update', $user->id) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <?= form_hidden('_method', 'PUT') ?>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="first_name" class="form-label">Nome *</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= old('first_name', $user->first_name) ?>" required>
            </div>
            <div class="col-md-4">
                <label for="last_name" class="form-label">Sobrenome *</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= old('last_name', $user->last_name) ?>" required>
            </div>
            <div class="col-md-4">
                <label for="username" class="form-label">Username *</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= old('username', $user->username) ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="email" class="form-label">E-mail *</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $user->email) ?>" required>
            </div>
            <div class="col-md-4">
                <label for="password" class="form-label">Nova Senha (deixe em branco para não alterar)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="col-md-4">
                <label for="password_confirm" class="form-label">Confirmar Nova Senha</label>
                <input type="password" class="form-control" id="password_confirm" name="password_confirm">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="role" class="form-label">Perfil *</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="user" <?= old('role', $user->group) == 'user' ? 'selected' : '' ?>>Usuário Comum</option>
                    <option value="admin" <?= old('role', $user->group) == 'admin' ? 'selected' : '' ?>>Administrador</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="gender" class="form-label">Gênero</label>
                <select class="form-select" id="gender" name="gender">
                    <option value="">Selecione</option>
                    <option value="male" <?= old('gender', $user->gender) == 'male' ? 'selected' : '' ?>>Masculino</option>
                    <option value="female" <?= old('gender', $user->gender) == 'female' ? 'selected' : '' ?>>Feminino</option>
                    <option value="other" <?= old('gender', $user->gender) == 'other' ? 'selected' : '' ?>>Outro</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="active" class="form-label">Status *</label>
                <select class="form-select" id="active" name="active" required>
                    <option value="1" <?= old('active', $user->active) == '1' ? 'selected' : '' ?>>Ativo</option>
                    <option value="0" <?= old('active', $user->active) == '0' ? 'selected' : '' ?>>Inativo</option>
                </select>
            </div>
        </div>

        <hr class="mb-3 mt-4">

        <div class="mb-3">
            <?php
            // Determina o caminho da imagem de perfil a ser exibida inicialmente
            $currentProfileImage = base_url($user->image && file_exists(FCPATH . $user->image) ? $user->image : 'images/defaults/avatar-default.png');
            if (empty($user->image) || !file_exists(FCPATH . $user->image)) {
                if ($user->gender === 'female') {
                    $currentProfileImage = base_url('images/defaults/avatar-female-default.png');
                } elseif ($user->gender === 'male') {
                    $currentProfileImage = base_url('images/defaults/avatar-male-default.png');
                }
            }
            // Se houver um valor "old" para a imagem (após uma falha de validação), use-o para o preview
            // Isso garante que se o usuário tentou enviar uma imagem e deu erro de validação, ela ainda aparece.
            if (old('image') && is_string(old('image')) && file_exists(FCPATH . old('image'))) {
                $currentProfileImage = base_url(old('image'));
            }
            ?>
            <img id="profileImagePreview" src="<?= $currentProfileImage ?>" alt="Avatar do Usuário" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ddd;">
            <label for="image" class="form-label">Imagem de Perfil</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png,image/gif,image/webp">
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="<?= url_to('admin_usuarios') ?>" class="btn btn-secondary">Cancelar</a>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const genderSelect = document.getElementById('gender');
            const profileImagePreview = document.getElementById('profileImagePreview');
            const fileInput = document.getElementById('image');

            const defaultMaleAvatar = '<?= base_url('images/defaults/avatar-male-default.png') ?>';
            const defaultFemaleAvatar = '<?= base_url('images/defaults/avatar-female-default.png') ?>';
            const defaultGenericAvatar = '<?= base_url('images/defaults/avatar-default.png') ?>';
            const initialImage = '<?= $currentProfileImage ?>'; // Guarda a imagem inicial

            function updateAvatarBasedOnGender() {
                const selectedGender = genderSelect.value;
                let newSrc = defaultGenericAvatar;

                if (selectedGender === 'male') {
                    newSrc = defaultMaleAvatar;
                } else if (selectedGender === 'female') {
                    newSrc = defaultFemaleAvatar;
                }

                // Só atualiza o preview se nenhuma imagem estiver sendo carregada
                if (!fileInput.files || fileInput.files.length === 0) {
                    // Verifica se a imagem atual é uma das padrões para permitir a mudança
                    // ou se não há imagem de usuário definida
                    const isDefaultImageCurrentlyShown = profileImagePreview.src.includes('defaults/');
                    if (isDefaultImageCurrentlyShown || !'<?= $user->image ?>') {
                        profileImagePreview.src = newSrc;
                    }
                }
            }

            function previewFile() {
                const file = fileInput.files[0];
                const reader = new FileReader();

                reader.onloadend = function() {
                    profileImagePreview.src = reader.result;
                }

                if (file) {
                    reader.readAsDataURL(file); // Lê o arquivo como URL de dados (Base64)
                } else {
                    // Se nenhum arquivo for selecionado, volta para a imagem inicial do usuário ou avatar de gênero
                    profileImagePreview.src = initialImage; // Volta para a imagem que veio do banco
                    updateAvatarBasedOnGender(); // Ajusta se a inicial for default
                }
            }

            // Adiciona listeners
            genderSelect.addEventListener('change', updateAvatarBasedOnGender);
            fileInput.addEventListener('change', previewFile);

            // Chamada inicial para garantir o avatar correto ao carregar a página
            // se não houver imagem de usuário e o gênero for um dos defaults
            if (!'<?= $user->image ?>' || !file_exists('<?= FCPATH . $user->image ?>')) {
                 updateAvatarBasedOnGender();
            }
        });
    </script>

    <?= $this->endSection() ?>