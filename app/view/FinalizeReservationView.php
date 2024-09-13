<?php

$column_print = 0;
$equipment_included = FALSE;
$attRsvCod = '';
$attRsvDta = date('Y-m-d H:i:s');
$attRsvClb = $_SESSION['LOGIN_ID'];
$attRsvClbNme = $_SESSION['LOGIN_NAME'];
$attRsvBlq = 'N';
$attRsvApv = 'N';
$attRsvLck = 'N';
$attRsvClbLck = '';
$attRsvClbLckNme = '';
$attRsvLckDta = '';

if (isset($data_content['DataRowHeader']['RsvCod'])) {
    $attRsvCod = $data_content['DataRowHeader']['RsvCod'];
    $attRsvDta = $data_content['DataRowHeader']['RsvDta'];
    $attRsvClb = $data_content['DataRowHeader']['RsvClb'];
    $attRsvClbNme = $data_content['DataRowHeader']['RsvClbNme'];
    $attRsvBlq = $data_content['DataRowHeader']['RsvBlq'];
    $attRsvApv = $data_content['DataRowHeader']['RsvApv'];
    $attRsvLck = $data_content['DataRowHeader']['RsvLck'];
    $attRsvClbLck = $data_content['DataRowHeader']['RsvClbLck'];
    $attRsvClbLckNme = $data_content['DataRowHeader']['RsvClbLckNme'];
    $attRsvLckDta = $data_content['DataRowHeader']['RsvLckDta'];
}

$isDisabled = ($data_content['ActionMode'] == 'modeDisplay' ? 'disabled' : '');
$isVisibleFinalizar = 'hidden';

if ($attRsvLck == 'N') {
    $isVisibleFinalizar = '';
}

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
                <form action="/GEPI/FinalizeReservation/Index/<?= $attRsvCod; ?>" method="post">
                    <div class="container-fluid">
                        <h1 class="mt-4">Finalizar Reserva</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Cadastro de reserva</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-list mr-1"></i>
                                Detalhes da reserva
                            </div>
                            <div class="card-body">
                                <div class="table">
                                    <div class="mb-3 row">
                                        <label for="attRsvCod" class="col-sm-2 col-form-label">C&oacute;digo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="attRsvCod" name="RsvCod" value="<?= $attRsvCod; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="attRsvDta" class="col-sm-2 col-form-label">Data da Reserva</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" id="attRsvDta" name="RsvDta" value="<?= substr($attRsvDta, 0, 10); ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="attRsvClbNme" class="col-sm-2 col-form-label">Colaborador Supervisor</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="attRsvClb" name="RsvClb" value="<?= $attRsvClb; ?>" hidden>
                                            <input type="text" class="form-control" id="attRsvClbNme" name="RsvClbNme" value="<?= $attRsvClbNme; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="attRsvBlq" class="col-sm-2 col-form-label">Bloqueado</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="attRsvBlq" name="RsvBlq" disabled>
                                                <option value="N" <?= ($attRsvBlq == 'N' ? 'selected' : ''); ?>>N&atilde;o</option>
                                                <option value="S" <?= ($attRsvBlq == 'S' ? 'selected' : ''); ?>>Sim</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="attRsvApv" class="col-sm-2 col-form-label">Aprovado</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="attRsvApv" name="RsvApv" disabled>
                                                <option value="N" <?= ($attRsvApv == 'N' ? 'selected' : ''); ?>>N&atilde;o</option>
                                                <option value="S" <?= ($attRsvApv == 'S' ? 'selected' : ''); ?>>Sim</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="attRsvLck" class="col-sm-2 col-form-label">Retirado</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="attRsvLck" name="RsvLck" disabled>
                                                <option value="N" <?= ($attRsvLck == 'N' ? 'selected' : ''); ?>>N&atilde;o</option>
                                                <option value="S" <?= ($attRsvLck == 'S' ? 'selected' : ''); ?>>Sim</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="attRsvClbLckNme" class="col-sm-2 col-form-label">Colaborador</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="attRsvClbLck" name="RsvClbLck" value="<?= $attRsvClbLck; ?>" hidden>
                                            <input type="text" class="form-control" id="attRsvClbLckNme" name="RsvClbLckNme" value="<?= $attRsvClbLckNme; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="attRsvLckDta" class="col-sm-2 col-form-label">Data da Retirada</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" id="attRsvLckDta" name="RsvLckDta" value="<?= substr($attRsvLckDta, 0, 10); ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Lista de equipamentos
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
                                                foreach ($data_content['DataRows'] as $data_item) {
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
                                                    echo '<div class="card bg-success text-white mb-4">';
                                                    echo '    <div class="card-body">' . $data_item['EqpDsc'] . '</div>';
                                                    echo '    <img src="/GEPI' . $data_item['EqpImgSrc'] . '" class="img-fluid img-thumbnail" alt="...">';
                                                    echo '    <div class="card-footer d-flex align-items-center justify-content-between">';
                                                    echo '        <a class="small text-white stretched-link" href="#">Produto para retirar</a>';
                                                    echo '        <div class="small text-white"><i class="fas fa-angle-right"></i></div>';
                                                    echo '    </div>';
                                                    echo '</div>';
                                                    echo '</td>';
                                                }
                                                while ($column_print < 4) {
                                                    echo '<td>';
                                                    echo '<div class="card bg-secondary text-white mb-4">';
                                                    echo '    <div class="card-body">&nbsp;</div>';
                                                    echo '    <img src="/GEPI/images/none.png" class="img-fluid img-thumbnail" alt="...">';
                                                    echo '    <div class="card-footer d-flex align-items-center justify-content-between">';
                                                    echo '        <a class="small text-white stretched-link" href="#">Nenhum Produto</a>';
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

                        <!-- add button here -->
                        <div class="d-grid gap-2 d-md-block">
                            <a class="btn btn-secondary" type="button" href="/GEPI/Dashboard">Fechar</a>
                            <button class="btn btn-warning" type="button" name="btnFinalizarPopup" data-toggle="modal" data-target="#msgEquipment" <?= $isVisibleFinalizar; ?>>Retirar Equipamentos</button>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div id="msgEquipment" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Conteúdo do modal-->
                            <div class="modal-content">

                                <!-- Cabeçalho do modal -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Equipamento Selecionado</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Corpo do modal -->
                                <div class="modal-body">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-table mr-1"></i>
                                            Lista
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="attBiometrics">Chave de Autentica&ccedil;&atilde;o</label>
                                            <input class="form-control py-4" id="attBiometrics" name="attBiometrics" type="password" placeholder="Entre com sua biometria" autofocus="autofocus" required/>
                                        </div>
                                    </div>
                                </div>

                                <!-- Rodapé do modal-->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                    <button class="btn btn-success" type="submit" name="btnFinalizar">Finalizar</button>
                                </div>

                            </div>
                        </div>
                    </div>

                </form>
            </main>

            <?php include_once('section/body_footer.php'); ?>

        </div>
    </div>

    <?php include_once('section/body_scripts_src.php'); ?>

</body>

</html>