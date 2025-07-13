<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4 title-page"><b><?= esc($titlePage) ?></b></h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= url_to('dashboard') ?>">Visão Geral</a></li>
        <li class="breadcrumb-item active"><?= esc($titlePage) ?></li>
    </ol>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success admin-msg"><?= esc(session('success')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger admin-msg"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <div class="mb-4">
        <button class="notification-button button-create" onclick="window.location.href='<?= url_to('admin_mensalidades_create') ?>'">
            <i class="fas fa-plus me-1"></i> Nova Mensalidade
        </button>
    </div>

    <?php if (!empty($monthlyPayments) && is_array($monthlyPayments)): ?>
        <table class="table datatable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mensalista</th>
                    <th>CPF</th>
                    <th>Categoria</th>
                    <th>Valor Mensalidade</th>
                    <th>Vencimento</th>
                    <th>Pagamento</th>
                    <th>Ativo</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>

                <?php
                    function formatCPF($cpf) {
                        return preg_replace("/^(\d{3})(\d{3})(\d{3})(\d{2})$/", "$1.$2.$3-$4", preg_replace('/\D/', '', $cpf));
                    }
                ?>

                <?php foreach ($monthlyPayments as $payment): ?>
                    <tr>
                        <td><?= esc($payment['id']) ?></td>
                        <td><?= esc($payment['first_name'] . ' ' . $payment['last_name']) ?></td>
                        <td><?= esc(formatCPF($payment['cpf'])) ?></td>
                        <td><?= esc($payment['category_name']) ?></td>
                        <td>R$ <?= number_format($payment['pricing_value'] ?? $payment['pricing_by_mensality'], 2, ',', '.') ?></td>
                        <td><?= esc(date('d/m/Y', strtotime($payment['due_date']))) ?></td>
                        <td>
                            <?= !empty($payment['payment_date']) ? esc(date('d/m/Y', strtotime($payment['payment_date']))) : '<span class="text-muted">---</span>' ?>
                        </td>
                        <td>
                            <?php if ((int) $payment['active'] === 1): ?>
                                <span class="badge bg-success">Sim</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Não</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                                $statusClasses = [
                                    'pago'     => 'success',
                                    'pendente' => 'warning',
                                    'atrasado' => 'danger',
                                ];
                                $status = $payment['status'];
                            ?>
                            <span class="badge bg-<?= $statusClasses[$status] ?? 'secondary' ?>">
                                <?= ucfirst($status) ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= url_to('admin_mensalidades_edit', $payment['id']) ?>" class="icon-button" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?= url_to('admin_mensalidades_delete', $payment['id']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Deseja realmente excluir esta mensalidade?');">
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
        <div class="alert alert-info admin-msg">Nenhuma mensalidade cadastrada no momento.</div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
