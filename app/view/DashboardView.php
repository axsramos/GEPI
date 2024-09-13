<!DOCTYPE html>
<html lang="pt">

<head>

    <?php include_once('section/head_meta_link.php'); ?>

</head>

<body class="sb-nav-fixed">
    <?php include_once('section/body_topnav.php'); ?>

    <div id="layoutSidenav">

        <?php include_once('section/body_sidenav.php'); ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Colaboradores <p><h2><?=$data_content["DataCards"]['Collaborators'];?></h2></p></div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
                                    <!-- <div class="small text-white"><i class="fas fa-angle-right"></i></div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">Equipamentos <p><h2><?=$data_content["DataCards"]['Equipments'];?></h2></p></div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
                                    <!-- <div class="small text-white"><i class="fas fa-angle-right"></i></div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">Reservas Aprovadas <p><h2><?=$data_content["DataCards"]['ReserveApproved'];?></h2></p></div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
                                    <!-- <div class="small text-white"><i class="fas fa-angle-right"></i></div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">Reservas Finalizadas <p><h2><?=$data_content["DataCards"]['ReserveLocked'];?></h2></p></div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <!-- <a class="small text-white stretched-link" href="#">View Details</a> -->
                                    <!-- <div class="small text-white"><i class="fas fa-angle-right"></i></div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area mr-1"></i>
                                    Area Chart Example - fake
                                </div>
                                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar mr-1"></i>
                                    Bar Chart Example - fake
                                </div>
                                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Lista de Reservas Aprovadas
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th hidden>C&oacute;digo</th>
                                            <th>Agendado</th>
                                            <th>Supervisor</th>
                                            <th>Equipamentos</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Item</th>
                                            <th hidden>C&oacute;digo</th>
                                            <th>Agendado</th>
                                            <th>Supervisor</th>
                                            <th>Equipamentos</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        if ($data_content['DataRows']) {
                                            foreach ($data_content['DataRows'] as $data_item) {
                                                echo '<tr>';
                                                echo '<td><a type="button" class="btn btn-outline-primary" href="/GEPI/FinalizeReservation/Index/' . $data_item['RsvCod'] . '">Selecionar</a></td>';
                                                echo '<td hidden>' . $data_item['RsvCod'] . '</td>';
                                                echo '<td>' . $data_item['RsvDta'] . '</td>';
                                                echo '<td>' . $data_item['RsvClbNme'] . '</td>';
                                                echo '<td>' . $data_item['RsvEqpQtd'] . '</td>';
                                                echo '</tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <?php include_once('section/body_footer.php'); ?>

        </div>
    </div>

    <?php include_once('section/body_scripts_src.php'); ?>

</body>

</html>