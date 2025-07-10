<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4 title-page"><b><?= esc($titlePage) ?></b></h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success admin-msg"><?= esc(session('success')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger admin-msg"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url_to('dashboard') ?>">Visão Geral</a></li> <li class="breadcrumb-item active"><?= esc($titlePage) ?></li>
    </ol>

    <div class="mb-4">
        <button class="notification-button button-create" onclick="window.location.href='<?= url_to('admin_mensalistas_create') ?>'">
            <i class="fas fa-plus me-1"></i> Novo Mensalista
        </button>
    </div>

    <?php if (!empty($monthlyPayers) && is_array($monthlyPayers)): ?>
        <table class="table datatable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome Completo</th>
                    <th>CPF</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Dia Venc.</th>
                    <th>Ativo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($monthlyPayers as $payer): ?>
                    <tr>
                        <td><?= esc($payer['id']) ?></td>
                        <td><?= esc($payer['first_name'] . ' ' . $payer['last_name']) ?></td>
                        <td><?= esc(substr($payer['cpf'], 0, 3) . '.' . substr($payer['cpf'], 3, 3) . '.' . substr($payer['cpf'], 6, 3) . '-' . substr($payer['cpf'], 9, 2)) ?></td>
                        <td><?= esc($payer['email']) ?></td>
                        <td><?= esc($payer['phone']) ?></td>
                        <td><?= esc($payer['due_day']) ?></td>
                        <td>
                            <?php if ($payer['active'] == 1) : ?>
                                <span class="badge bg-success">Sim</span>
                            <?php else : ?>
                                <span class="badge bg-danger">Não</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= url_to('admin_mensalistas_edit', $payer['id']) ?>" class="icon-button" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?= url_to('admin_mensalistas_delete', $payer['id']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir este mensalista?');">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="icon-button" title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info admin-msg">Nenhum mensalista encontrado no momento.</div>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>