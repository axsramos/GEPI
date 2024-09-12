<?php

$attClbCod = '';
$attClbNme = '';
$attClbBlq = 'N';
$attClbSup = 'N';
$attClbKey = '';

if (isset($data_content['DataRow']['ClbCod'])) {
    $attClbCod = $data_content['DataRow']['ClbCod'];
    $attClbNme = $data_content['DataRow']['ClbNme'];
    $attClbBlq = $data_content['DataRow']['ClbBlq'];
    $attClbSup = $data_content['DataRow']['ClbSup'];
    $attClbKey = $data_content['DataRow']['ClbKey'];
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
                <form action="/GEPI/Collaborator/Show/<?= $attClbCod; ?>" method="post">
                    <div class="container-fluid">
                        <h1 class="mt-4">Colaborador</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Cadastro de colaborador</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-list mr-1"></i>
                                Detalhes do cadastro
                            </div>
                            <div class="card-body">
                                <div class="table">
                                    <div class="mb-3 row">
                                        <label for="attClbCod" class="col-sm-2 col-form-label">C&oacute;digo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="attClbCod" name="ClbCod" value="<?= $attClbCod; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="attClbNme" class="col-sm-2 col-form-label">Nome</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="attClbNme" name="ClbNme" value="<?= $attClbNme; ?>" <?= $isDisabled ?> required>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="attClbBlq" class="col-sm-2 col-form-label">Bloqueado</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="attClbBlq" name="ClbBlq" <?= $isDisabled ?>>
                                                <option value="N" <?= ($attClbBlq == 'N' ? 'selected' : ''); ?>>N&atilde;o</option>
                                                <option value="S" <?= ($attClbBlq == 'S' ? 'selected' : ''); ?>>Sim</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="attClbSup" class="col-sm-2 col-form-label">Supervisor</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="attClbSup" name="ClbSup" <?= $isDisabled ?>>
                                                <option value="N" <?= ($attClbSup == 'N' ? 'selected' : ''); ?>>N&atilde;o</option>
                                                <option value="S" <?= ($attClbSup == 'S' ? 'selected' : ''); ?>>Sim</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="attClbKey" class="col-sm-2 col-form-label">Assinatura</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="attClbKey" name="ClbKey" value="<?= $attClbKey; ?>" <?= $isDisabled; ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-block">
                            <a class="btn btn-secondary" type="button" href="/GEPI/Collaborator">Fechar</a>
                            <button class="btn btn-success" type="submit" name="btnConfirm" <?= ($data_content['ActionMode'] == 'modeDisplay' ? 'hidden' : ''); ?>>Confirmar</button>
                            <button class="btn btn-primary" type="submit" name="btnUpdate" <?= ($data_content['ActionMode'] == 'modeDisplay' ? '' : 'hidden'); ?>>Editar</button>
                            <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#msgModal" <?= ($data_content['ActionMode'] == 'modeDisplay' ? '' : 'hidden'); ?>>Excluir</button>
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