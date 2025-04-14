<?= $this->include('partials/head') ?>
<?= $this->include('partials/topbar') ?>
<?= $this->include('partials/sidebar') ?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Usuários</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">
                    Listagem e gerenciamento dos usuários do sistema.
                </li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">
                    <table class="datatable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Criado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($users)) : ?>
                                <?php foreach ($users as $user) : ?>
                                    <tr>
                                        <td><?= $user['id'] ?></td>
                                        <td><?= $user['username'] ?></td>
                                        <td><?= $user['email'] ?></td>
                                        <td>
                                            <?php
                                            $createdAt = \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $user['created_at']);
                                            echo $createdAt->format('d/m/Y à\s H:i:s');
                                            ?>
                                        </td>
                                        <td>
                                            <button class="icon-button" title="Visualizar">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="icon-button" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="icon-button" title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Criado em</th>
                                <th>Ações</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>
<?= $this->include('partials/scripts') ?>