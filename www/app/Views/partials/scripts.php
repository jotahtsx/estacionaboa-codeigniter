<script src="<?= base_url('libs/bootstrap@5.2.3/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('js/app.js') ?>"></script>
<script src="<?= base_url('libs/simple-datatables@7.1.2/simple-datatables.min.js') ?>"></script>

<script>
    window.addEventListener('DOMContentLoaded', event => {
        document.querySelectorAll('.datatable').forEach(table => {
            new simpleDatatables.DataTable(table, {
                labels: {
                    placeholder: "Buscar...",
                    perPage: "Registros por página",
                    noRows: "Nenhum registro disponível",
                    noResults: "Nenhum resultado corresponde à sua busca",
                    info: "Mostrando de {start} a {end} de {rows} registros",
                    loading: "Carregando...",
                    infoFiltered: " – filtrado de {rows} registros no total"
                },
                layout: {
                    top: "{search}",
                    bottom: `
                        <div class="datatable-bottom">
                            <div class="datatable-dropdown">{select}</div> <div class="datatable-info">{info}</div> <div class="datatable-pagination">{pager}</div> </div>
                    `
                },
                pagination: {
                    previous: "Anterior",
                    next: "Próximo",
                    navigate: "Ir para a página",
                    page: "Página {page}",
                    showing: "Mostrando página {page} de {pages}",
                    of: "de"
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        let idleTime = 0;
        const idleLimit = 570;
        const warningTime = 30;
        let idleInterval;
        let warningTimeout;

        function startIdleTimer() {
            idleTime = 0;
            if (idleInterval) {
                clearInterval(idleInterval);
            }
            if (warningTimeout) {
                clearTimeout(warningTimeout);
            }

            idleInterval = setInterval(function() {
                idleTime++;
                if (idleTime === (idleLimit - warningTime)) {
                    showLogoutWarning();
                }

                
                if (idleTime >= idleLimit) {
                    logoutViaPost();
                    clearInterval(idleInterval);
                    if (warningTimeout) {
                        clearTimeout(warningTimeout);
                    }
                    hideLogoutWarning();
                }
            }, 1000);
        }

        function resetTimer() {
            startIdleTimer();
            hideLogoutWarning(); 
        }

        function logoutViaPost() {
            fetch('/logout', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                },
                credentials: 'same-origin'
            }).then(() => {
                window.location.href = '/login';
            }).catch(error => {
                console.error('Erro ao tentar logout:', error);
                window.location.href = '/login';
            });
        }

        // --- Funções para o aviso de logout --- //
        function showLogoutWarning() {
            const warningDiv = document.getElementById('logoutWarning'); // ID da div do aviso
            if (warningDiv) {
                warningDiv.style.display = 'block'; // Mostra a div
                let countdown = warningTime;
                const countdownSpan = warningDiv.querySelector('.countdown');

                if (countdownSpan) {
                    countdownSpan.textContent = countdown; // Exibe o tempo inicial
                }

                // Inicia a contagem regressiva no aviso
                warningTimeout = setInterval(() => {
                    countdown--;
                    if (countdownSpan) {
                        countdownSpan.textContent = countdown;
                    }
                    if (countdown <= 0) {
                        clearInterval(warningTimeout); // Para a contagem regressiva
                    }
                }, 1000);
            }
        }

        function hideLogoutWarning() {
            const warningDiv = document.getElementById('logoutWarning');
            if (warningDiv) {
                warningDiv.style.display = 'none'; // Esconde a div
                if (warningTimeout) {
                    clearInterval(warningTimeout); // Para o timer do aviso se estiver rodando
                    warningTimeout = null;
                }
            }
        }

        // Inicia o timer quando o DOM estiver completamente carregado
        startIdleTimer();

        // Adiciona listeners para eventos de interação do usuário
        document.addEventListener('mousemove', resetTimer);
        document.addEventListener('keypress', resetTimer);
        document.addEventListener('mousedown', resetTimer);
        document.addEventListener('touchstart', resetTimer); // Para dispositivos de toque
        document.addEventListener('scroll', resetTimer);
        document.addEventListener('click', resetTimer);

        const continueSessionBtn = document.getElementById('continueSessionBtn');
        if (continueSessionBtn) {
            continueSessionBtn.addEventListener('click', resetTimer);
        }
    });
</script>

</body>

</html>