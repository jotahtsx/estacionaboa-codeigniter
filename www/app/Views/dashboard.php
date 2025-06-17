<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Visão Geral</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">
                Visão geral em tempo real das vagas, entradas e saídas.
            </li>
        </ol>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 mb-4" style="background: linear-gradient(135deg, #0d6efd, #0b5ed7); color: white;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <p class="mb-1 fw-semibold text-uppercase text-white-50" style="font-size: 0.8rem;">Total de Vagas</p>
                                <h2 class="mb-0">120</h2>
                            </div>
                            <i class="fas fa-parking fa-2x opacity-50"></i>
                        </div>

                        <div class="row text-center mt-3">
                            <div class="col">
                                <p class="mb-1 small text-white-50">Livre</p>
                                <h5 class="mb-0">45</h5>
                            </div>
                            <div class="col border-start border-white">
                                <p class="mb-1 small text-white-50">Ocupadas</p>
                                <h5 class="mb-0">75</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 d-flex justify-content-between align-items-center">
                        <a class="small text-white text-decoration-underline" href="#">Estacionar agora</a>
                        <i class="fas fa-arrow-right text-white-50"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 mb-4" style="background: linear-gradient(135deg, #6f42c1, #5a32a3); color: white;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <p class="mb-1 fw-semibold text-uppercase text-white-50" style="font-size: 0.8rem;">Mensais</p>
                                <h2 class="mb-0">R$ 3.200,00</h2>
                            </div>
                            <i class="fas fa-calendar-check fa-2x opacity-50"></i>
                        </div>

                        <div class="row text-center mt-3">
                            <div class="col">
                                <p class="mb-1 small text-white-50">Pagas</p>
                                <h5 class="mb-0">25</h5>
                            </div>
                            <div class="col border-start border-white">
                                <p class="mb-1 small text-white-50">Abertas</p>
                                <h5 class="mb-0">10</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 d-flex justify-content-between align-items-center">
                        <a class="small text-white text-decoration-underline" href="#">Estacionar agora</a>
                        <i class="fas fa-arrow-right text-white-50"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 mb-4" style="background: linear-gradient(135deg, #dc3545, #c82333); color: white;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <p class="mb-1 fw-semibold text-uppercase text-white-50" style="font-size: 0.8rem;">Avulsos</p>
                                <h2 class="mb-0">R$ 1.480,00</h2>
                            </div>
                            <i class="fas fa-money-bill-wave fa-2x opacity-50"></i>
                        </div>

                        <div class="row text-center mt-3">
                            <div class="col">
                                <p class="mb-1 small text-white-50">Pagas</p>
                                <h5 class="mb-0">18</h5>
                            </div>
                            <div class="col border-start border-white">
                                <p class="mb-1 small text-white-50">Abertas</p>
                                <h5 class="mb-0">7</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 d-flex justify-content-between align-items-center">
                        <a class="small text-white text-decoration-underline" href="#">Estacionar agora</a>
                        <i class="fas fa-arrow-right text-white-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card shadow-sm border-0 mb-4" style="background: linear-gradient(135deg, #198754, #157347); color: white;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <p class="mb-1 fw-semibold text-uppercase text-white-50" style="font-size: 0.8rem;">Mensalistas</p>
                                <h2 class="mb-0">86</h2>
                            </div>
                            <i class="fas fa-users fa-2x opacity-50"></i>
                        </div>

                        <div class="row text-center mt-3">
                            <div class="col">
                                <p class="mb-1 small text-white-50">Ativos</p>
                                <h5 class="mb-0">75</h5>
                            </div>
                            <div class="col border-start border-white">
                                <p class="mb-1 small text-white-50">Inativos</p>
                                <h5 class="mb-0">11</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 d-flex justify-content-between align-items-center">
                        <a class="small text-white text-decoration-underline" href="#">Estacionar agora</a>
                        <i class="fas fa-arrow-right text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>