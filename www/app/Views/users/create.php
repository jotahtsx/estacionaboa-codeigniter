<?= $this->include('partials/head') ?>
<?= $this->include('partials/topbar') ?>
<?= $this->include('partials/sidebar') ?>

<div id="layoutSidenav_content">
    <main>

        <div class="container-fluid px-4">
            <h1 class="mt-4">Criar Novo Usuário</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">
                    Criar Novo Usuário
                </li>
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

                    <?php if (session('validation')): ?>
                        <div class="alert alert-danger">
                            <ul style="list-style: none; padding-left: 0; margin-bottom: 0;">
                                <?= session('validation')->listErrors() ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('usuarios/cadastrar') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="first_name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= old('first_name') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="last_name" class="form-label">Sobrenome</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= old('last_name') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= old('username') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Perfil</label>
                            <select name="role" class="form-select" required>
                                <option value="user" <?= old('role') === 'user' ? 'selected' : '' ?>>Usuário Comum</option>
                                <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Administrador</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="active" class="form-label">Ativo</label>
                            <select class="form-select" id="active" name="active" required>
                                <option value="1" <?= old('active') === '1' ? 'selected' : '' ?>>Sim</option>
                                <option value="0" <?= old('active') === '0' ? 'selected' : '' ?>>Não</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Confirmar Senha</label>
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                        </div>

                        <div class="mb-3">
                            <label for="gender">Gênero</label>
                            <select name="gender" id="gender" class="form-control">
                                <option value="" disabled hidden>Selecione</option>
                                <option value="male">Masculino</option>
                                <option value="female">Feminino</option>
                                <option value="other">Outro</option>
                            </select>
                        </div>

                        <div class="mb-3">

                            <?php
                            $initialImagePath = base_url('images/defaults/avatar-default.png');
                            if (old('gender')) {
                                if (old('gender') === 'female') {
                                    $initialImagePath = base_url('images/defaults/avatar-female-default.png');
                                } elseif (old('gender') === 'male') {
                                    $initialImagePath = base_url('images/defaults/avatar-male-default.png');
                                }
                            }
                            ?>

                            <img id="profileImagePreview" src="<?= $initialImagePath ?>" alt="Avatar do Usuário" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ddd;">

                            <label for="image" class="form-label">Imagem do Usuário</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">Criar Usuário</button>
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
                reader.readAsDataURL(file); // Lê o arquivo como URL de dados (Base64)
            } else {
                // Se nenhum arquivo for selecionado, volta para o avatar padrão de gênero
                updateAvatarBasedOnGender();
            }
        }

        // Adiciona listeners
        genderSelect.addEventListener('change', updateAvatarBasedOnGender);
        fileInput.addEventListener('change', previewFile);

        // Chama a função ao carregar a página para definir o avatar inicial se 'old' gender estiver presente
        updateAvatarBasedOnGender();
    });
</script>