<?php

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

if (isset($data_content['DataRow']['RsvCod'])) {
    $attRsvCod = $data_content['DataRow']['RsvCod'];
    $attRsvDta = $data_content['DataRow']['RsvDta'];
    $attRsvClb = $data_content['DataRow']['RsvClb'];
    $attRsvClbNme = $data_content['DataRow']['RsvClbNme'];
    $attRsvBlq = $data_content['DataRow']['RsvBlq'];
    $attRsvApv = $data_content['DataRow']['RsvApv'];
    $attRsvLck = $data_content['DataRow']['RsvLck'];
    $attRsvClbLck = $data_content['DataRow']['RsvClbLck'];
    $attRsvClbLckNme = $data_content['DataRow']['RsvClbLckNme'];
    $attRsvLckDta = $data_content['DataRow']['RsvLckDta'];
}

$isDisabled = ($data_content['ActionMode'] == 'modeDisplay' ? 'disabled' : '');

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
                <form action="/GEPI/Reserve/Show/<?= $attRsvCod; ?>" method="post">
                    <div class="container-fluid">
                        <h1 class="mt-4">Reserva</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Cadastro de reserva</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-list mr-1"></i>
                                Detalhes do cadastro
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
                                            <input type="date" class="form-control" id="attRsvDta" name="RsvDta" value="<?= substr($attRsvDta,0,10); ?>" <?= $isDisabled ?> required>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="attRsvClbNme" class="col-sm-2 col-form-label">Colaborador Supervisor</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="attRsvClb" name="RsvClb" value="<?= $attRsvClb; ?>" <?= $isDisabled ?> hidden>
                                            <input type="text" class="form-control" id="attRsvClbNme" name="RsvClbNme" value="<?= $attRsvClbNme; ?>" <?= $isDisabled ?> disabled>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="attRsvBlq" class="col-sm-2 col-form-label">Bloqueado</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="attRsvBlq" name="RsvBlq" <?= $isDisabled ?>>
                                                <option value="N" <?= ($attRsvBlq == 'N' ? 'selected' : ''); ?>>N&atilde;o</option>
                                                <option value="S" <?= ($attRsvBlq == 'S' ? 'selected' : ''); ?>>Sim</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="attRsvApv" class="col-sm-2 col-form-label">Aprovado</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="attRsvApv" name="RsvApv" <?= $isDisabled ?>>
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
                                            <input type="text" class="form-control" id="attRsvClbLck" name="RsvClbLck" value="<?= $attRsvClbLck; ?>" <?= $isDisabled; ?> hidden>
                                            <input type="text" class="form-control" id="attRsvClbLckNme" name="RsvClbLckNme" value="<?= $attRsvClbLckNme; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="attRsvLckDta" class="col-sm-2 col-form-label">Data da Retirada</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" id="attRsvLckDta" name="RsvLckDta" value="<?= substr($attRsvLckDta,0,10); ?>" <?= $isDisabled ?> disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-block">
                            <a class="btn btn-secondary" type="button" href="/GEPI/Reserve">Fechar</a>
                            <button class="btn btn-success" type="submit" name="btnConfirm" <?= ($data_content['ActionMode'] == 'modeDisplay' ? 'hidden' : ''); ?>>Confirmar</button>
                            <button class="btn btn-primary" type="submit" name="btnUpdate" <?= ($data_content['ActionMode'] == 'modeDisplay' ? '' : 'hidden'); ?>>Editar</button>
                            <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#msgModal" <?= ($data_content['ActionMode'] == 'modeDisplay' ? '' : 'hidden'); ?>>Excluir</button>
                            <a class="btn btn-info" type="button" href="/GEPI/Reserve/Panel/<?= $attRsvCod; ?>" <?= ($data_content['ActionMode'] == 'modeDisplay' ? '' : 'hidden'); ?>>Equipamentos</a>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div id="msgModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Conteúdo do modal-->
                            <div class="modal-content">

                                <!-- Cabeçalho do modal -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Confirma a opera&ccedil;&atilde;o?</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Corpo do modal -->
                                <div class="modal-body">
                                    <p>Voc&ecirc; tem certeza que deseja realizar esta a&ccedil;&atilde;o?&nbsp; </p>
                                    <p>Confirmar a exclus&atilde;o.</p>
                                </div>

                                <!-- Rodapé do modal-->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger" name="btnDelete">Excluir</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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