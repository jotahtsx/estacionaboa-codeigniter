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
        <button class="notification-button button-create" style="background-color: #3498db;" onclick="window.location.href='<?= url_to('admin_precificacoes_categorias') ?>'">
            Categorias
        </button>
    </div>

    <?php if (!empty($pricings)): ?>
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Preço por Hora</th>
                    <th>Preço por Mensalidade</th>
                    <th>Capacidade</th>
                    <th>Ativo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pricings as $pricing): ?>
                    <tr>
                        <td><?= esc($pricing['category_name']) ?></td>
                        <td>R$ <?= number_format($pricing['pricing_by_hour'], 2, ',', '.') ?></td>
                        <td>R$ <?= number_format($pricing['pricing_by_mensality'], 2, ',', '.') ?></td>
                        <td><?= esc($pricing['capacity']) ?></td>
                        <td>
                            <?php if ($pricing['active'] == 1) : ?>
                                <span class="badge bg-success">Sim</span>
                            <?php else : ?>
                                <span class="badge bg-danger">Não</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= url_to('admin_precificacoes_edit', $pricing['id']) ?>" class="icon-button" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?= url_to('admin_precificacoes_delete', $pricing['id']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Confirmar exclusão?');">
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
    <?php else: ?>
        <div class="alert alert-info admin-msg">Nenhuma precificação encontrada no momento.</div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>