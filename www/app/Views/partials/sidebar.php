<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link <?php echo ($active_page == 'home') ? 'active' : ''; ?>" href="<?php echo base_url(); ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Visão Geral
                </a>
                <a class="nav-link" href="charts.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-parking"></i></div>
                    Estacionar
                </a>
                <a class="nav-link" href="charts.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Mensalistas
                </a>
                <a class="nav-link" href="tables.html">
                    <div class="sb-nav-link-icon"><i class="fas fas fa-hand-holding-usd"></i></div>
                    Mensalidades
                </a>
                <div class="sb-sidenav-menu-heading">Administração</div>

                <a class="nav-link <?php echo ($active_page == 'usuarios') ? 'active' : ''; ?>" href="<?= url_to('admin_usuarios') ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-users-cog"></i></div>Usuários
                </a>

                <a class="nav-link <?php echo ($active_page == 'configuracoes') ? 'active' : ''; ?>" href="<?php echo base_url('admin/configuracoes'); ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                    Configurações
                </a>
                <a class="nav-link <?php echo (strpos(current_url(), 'admin/precificacoes') !== false || strpos(current_url(), 'admin/categorias') !== false) ? 'active' : ''; ?>" href="<?php echo base_url('admin/precificacoes'); ?>">
                    <div class="sb-nav-link-icon"><i class="fas fas fa-tag"></i></div>
                    Precificações
                </a>
                <a class="nav-link <?php echo ($active_page == 'pagamentos') ? 'active' : ''; ?>" href="<?= url_to('admin_formas_pagamento') ?>">
                    <div class="sb-nav-link-icon"><i class="fas fas fa-credit-card"></i></div>
                    Pagamentos
                </a>
            </div>
        </div>

        <div class="sb-sidenav-footer border-top pt-2">
            <div class="small">Logado como:</div>
            <?php
            $loggedInUser = auth()->user();
            echo (!empty($loggedInUser->first_name)) ? esc($loggedInUser->first_name) : 'Usuário';
            ?>
            <div class="mt-2 text-muted small text-center" style="font-size: 11px; opacity: 0.75;">
                <?= esc(get_settings()['trade_name'] ?? 'Nome da Empresa') ?>
            </div>
        </div>
    </nav>
</div>