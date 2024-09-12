<?php

$column_print = 0;

?>

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
                    <h1 class="mt-4">Reserva</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Reserva de Equipamentos</li>
                    </ol>


                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            DataTable Example
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        if ($data_content['DataEquipments']) {
                                            foreach ($data_content['DataEquipments'] as $data_item) {
                                                if ($column_print == 0) {
                                                    echo '<tr>';
                                                }
                                                // columns //
                                                if ($column_print == 4) {
                                                    $column_print = 1;
                                                    echo '</tr>';
                                                } else {
                                                    $column_print = $column_print + 1;
                                                }
                                                echo '<td>';
                                                echo '<div class="card bg-info text-white mb-4">';
                                                echo '    <div class="card-body">'. $data_item['EqpDsc'] .'</div>';
                                                echo '    <img src="/GEPI'. $data_item['EqpImgSrc'] .'" class="img-fluid img-thumbnail" alt="...">';
                                                echo '    <div class="card-footer d-flex align-items-center justify-content-between">';
                                                echo '        <a class="small text-white stretched-link" href="#">View Details</a>';
                                                echo '        <div class="small text-white"><i class="fas fa-angle-right"></i></div>';
                                                echo '    </div>';
                                                echo '</div>';
                                                echo '</td>';
                                            }
                                            while($column_print < 4) {
                                                echo '<td>';
                                                echo '<div class="card bg-secondary text-white mb-4">';
                                                echo '    <div class="card-body">&nbsp;</div>';
                                                echo '    <img src="/GEPI/images/none.png" class="img-fluid img-thumbnail" alt="...">';
                                                echo '    <div class="card-footer d-flex align-items-center justify-content-between">';
                                                echo '        <a class="small text-white stretched-link" href="#">View Details</a>';
                                                echo '        <div class="small text-white"><i class="fas fa-angle-right"></i></div>';
                                                echo '    </div>';
                                                echo '</div>';
                                                echo '</td>';
                                                $column_print = $column_print + 1;
                                            }
                                            echo '</tr>';
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