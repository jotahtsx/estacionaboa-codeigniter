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
                            <div class="datatable-dropdown">{select}</div> <!-- Seletor de quantidade -->
                            <div class="datatable-info">{info}</div> <!-- Info de quantos registros -->
                            <div class="datatable-pagination">{pager}</div> <!-- Controles de página -->
                        </div>
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
  const idleLimit = 60; // Limite de inatividade em segundos (30 segundos aqui)

  // Incrementa o tempo de inatividade a cada segundo
  setInterval(function() {
    idleTime++;
    if (idleTime >= idleLimit) {
      window.location.href = '/logout';  // Redireciona para o logout após 30 segundos
    }
  }, 1000); // Checa a cada 1 segundo

  // Reseta o contador sempre que há interação do usuário
  window.onload = resetTimer;
  document.onmousemove = resetTimer;
  document.onkeypress = resetTimer;

  function resetTimer() {
    idleTime = 0;
  }

  
</script>


</body>

</html>