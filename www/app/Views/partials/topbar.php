<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="<?= base_url() ?>">Estacionaboa</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <?php
    $user = auth()->user();
    if (! $user) {
        $imagePath = base_url('images/defaults/avatar-default.png');
        $altText = 'Convidado';
        $notificationsCount = 0;
    } else {
        $altText = $user->username ?? $user->name ?? 'Usuário';
        $avatarPath = null;
        if (!empty($user->image) && is_string($user->image) && file_exists(FCPATH . $user->image)) {
            $avatarPath = $user->image;
        }
        if ($avatarPath) {
            $avatarPath = ltrim($avatarPath, '/');
            $imagePath = base_url($avatarPath);
        } else {
            $defaultAvatar = 'images/defaults/avatar-default.png';
            if (isset($user->gender) && !empty($user->gender)) {
                if ($user->gender === 'female') {
                    $defaultAvatar = 'images/defaults/avatar-female-default.png';
                } elseif ($user->gender === 'male') {
                    $defaultAvatar = 'images/defaults/avatar-male-default.png';
                }
            }
            $imagePath = base_url($defaultAvatar);
        }
        $notificationsCount = 3;
    }
    ?>

    <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0 me-lg-4 align-items-center">

        <li class="nav-item dropdown me-3">
            <a class="nav-link d-flex align-items-center py-0" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="position-relative not-drop">
                    <i class="fas fa-bell text-white animate-fade not-icon"></i>
                    <?php if ($notificationsCount > 0): ?>
                        <span class="badge-notification position-absolute top-1 start-100 translate-middle rounded-circle bg-danger"><?= $notificationsCount ?></span>
                    <?php endif; ?>
                </div>
            </a>
            <ul class="dropdown-menu notifications-dropdown dropdown-menu-end p-0 m-0" aria-labelledby="notificationsDropdown">
                <li class="dropdown-header">Notificações</li>
                <li class="notification-item">
                    <div class="notification-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <div class="notification-title">Existem mensalidades vencidas</div>
                        <a href="#" class="notification-link">gerencie as mensalidades</a>
                    </div>
                </li>
                <li class="notification-item">
                    <div class="notification-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div>
                        <div class="notification-title">Existem formas de pagamento inativas</div>
                        <a href="#" class="notification-link">gerencie as formas de pagamento</a>
                    </div>
                </li>
                <button class="notification-button urgent-button">Não deixe de verificar!</button>
            </ul>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center py-0" id="userDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= $imagePath ?>" alt="<?= esc($user->username ?? $user->name ?? 'Usuário') ?>" title="<?= esc($user->username ?? $user->name ?? 'Usuário') ?>" class="rounded-circle user-drop">
            </a>
            <ul class="dropdown-menu dropdown-menu-end p-0 m-0" aria-labelledby="userDropdown">
                <li><a class="dropdown-item rounded-top py-3" href="#">Settings</a></li>
                <li>
                    <hr class="dropdown-divider my-0" />
                </li>
                <li><a class="dropdown-item py-3" href="#">Activity Log</a></li>
                <li>
                    <hr class="dropdown-divider my-0" />
                </li>
                <li><a class="dropdown-item rounded-bottom py-3" href="<?= url_to('logout') ?>">Sair</a></li>
            </ul>
        </li>
    </ul>
</nav>