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

    let idleTime = 0;
    const idleLimit = 60;  // Definido para 10 segundos para testar

    setInterval(function() {
        idleTime++;
        if (idleTime >= idleLimit) {
            logoutViaPost();  // Chama a função de logout
        }
    }, 1000);

    function resetTimer() {
        idleTime = 0;
    }

    window.addEventListener('load', resetTimer);
    document.addEventListener('mousemove', resetTimer);
    document.addEventListener('keypress', resetTimer);
    document.addEventListener('mousedown', resetTimer);
    document.addEventListener('touchstart', resetTimer);
    document.addEventListener('scroll', resetTimer);

    // Função para realizar o logout via POST
    function logoutViaPost() {
        fetch('/logout', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>'  // Apenas se o CSRF estiver habilitado
            },
            credentials: 'same-origin'
        }).then(() => {
            window.location.href = '/login';  // Ou a página desejada após logout
        });
    }
</script>

</body>
</html>
