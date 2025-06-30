<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">&copy; <?= date('Y') ?> <?= esc(get_settings()['trade_name'] ?? 'Nome da Empresa') ?></div>
            <div>
                <a href="#">Política de Privacidade</a>
                &middot;
                <a href="#">Termos &amp; Condições</a>
            </div>
        </div>
    </div>
</footer>