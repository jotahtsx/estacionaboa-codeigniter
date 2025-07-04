<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>


<div class="container-fluid px-4">
    <h1 class="mt-4 title-page"><b><?= esc($titlePage) ?></b></h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url_to('dashboard') ?>">Visão Geral</a></li>
        <li class="breadcrumb-item"><a href="<?= url_to('admin_precificacoes') ?>">Precificações</a></li>
        <li class="breadcrumb-item active"><?= esc($titlePage) ?></li>
    </ol>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success admin-msg"><?= esc(session('success')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger admin-msg"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <div class="mb-4">
        <button class="notification-button button-create" onclick="window.location.href='<?= base_url('admin/categorias/cadastrar') ?>'">
            Nova Categoria
        </button>
    </div>

    <?php if (empty($categories)) : ?>
        <div class="alert alert-warning">Nenhuma categoria cadastrada ainda.</div>
    <?php else: ?>
        <div class="card mb-4">
            <div class="card-body">
                <table class="datatable">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Ativo</th>
                            <th class="actions-column">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?= esc($category['name']) ?></td>
                                <td>
                                    <?php if ($category['active'] == 1) : ?>
                                        <span class="badge bg-success">Sim</span>
                                    <?php else : ?>
                                        <span class="badge bg-danger">Não</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url("admin/categorias/editar/{$category['id']}") ?>" class="icon-button" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?= url_to('admin_categorias_delete', $category['id']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Confirmar exclusão?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="icon-button" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>