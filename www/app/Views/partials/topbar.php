<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="<?= base_url() ?>">Estacionaboa</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>
    <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0 me-lg-4">
        <?php
        $user = auth()->user();
        $altText = $user->username ?? $user->name ?? 'Usuário';
        $imagePath = base_url('uploads/avatar-header.jpg');
        ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= $imagePath ?>" alt="<?= esc($altText) ?>" title="<?= esc($altText) ?>" class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover; border: 2px solid #fff; transition: transform 0.3s ease;">
            </a>
            <ul class="dropdown-menu dropdown-menu-end p-0 m-0" aria-labelledby="navbarDropdown">
                <li>
                    <a class="dropdown-item rounded-top py-3" href="#">Settings</a>
                </li>
                <li>
                    <hr class="dropdown-divider my-0" />
                </li>
                <li>
                    <a class="dropdown-item py-3" href="#">Activity Log</a>
                </li>
                <li>
                    <hr class="dropdown-divider my-0" />
                </li>
                <li>
                    <a class="dropdown-item rounded-bottom py-3" href="<?= url_to('logout') ?>">Sair</a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
