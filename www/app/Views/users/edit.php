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
                </div>
            </div>
        </div>
    </main>
</div>

<?= $this->include('partials/scripts') ?>