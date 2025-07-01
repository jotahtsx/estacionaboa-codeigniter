<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4 title-page"><b><?= esc($titlePage) ?></b></h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success admin-msg"><?= esc(session('success')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('warning')): ?>
        <div class="alert alert-warning admin-msg"><?= esc(session('warning')) ?></div>
    <?php endif; ?>

    <div class="mb-3 mt-3 text-start">
        <button class="notification-button button-create" onclick="window.location.href='<?= url_to('admin_precificacoes_create') ?>'">
            Nova Precificação
        </button>
    </div>

    <?php if (!empty($pricings)): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Valor Hora</th>
                    <th>Mensal</th>
                    <th>Capacidade</th>
                    <th>Ativo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pricings as $pricing): ?>
                    <tr>
                        <td><?= esc($pricing['pricing_category']) ?></td>
                        <td>R$ <?= number_format($pricing['pricing_by_hour'], 2, ',', '.') ?></td>
                        <td>R$ <?= number_format($pricing['pricing_by_mensality'], 2, ',', '.') ?></td>
                        <td><?= esc($pricing['capacity']) ?></td>
                        <td><?= $pricing['active'] ? 'Sim' : 'Não' ?></td>
                        <td>
                            <a href="<?= base_url("admin/precificacoes/editar/{$pricing['id']}") ?>" class="btn btn-sm btn-warning">Editar</a>
                            <form action="<?= base_url("admin/precificacoes/deletar/{$pricing['id']}") ?>" method="post" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info admin-msg">Nenhuma precificação encontrada no momento.</div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
