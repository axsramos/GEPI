<?php

$attStkCod = '';
$attStkDsc = '';
$attStkBlq = 'N';
$attStkObs = '';

if (isset($data_content['HeaderDataRow']['StkCod'])) {
    $attStkCod = $data_content['HeaderDataRow']['StkCod'];
    $attStkDsc = $data_content['HeaderDataRow']['StkDsc'];
    $attStkBlq = $data_content['HeaderDataRow']['StkBlq'];
    $attStkObs = $data_content['HeaderDataRow']['StkObs'];
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
                <form action="/GEPI/Stock/Show/<?= $attStkCod; ?>" method="post">
                    <div class="container-fluid">
                        <h1 class="mt-4">Estoque</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Itens do estoque selecionado</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-list mr-1"></i>
                                Detalhes do cadastro
                            </div>
                            <div class="card-body">
                                <div class="table">
                                    <div class="mb-3 row">
                                        <label for="attStkCod" class="col-sm-2 col-form-label">C&oacute;digo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="attStkCod" name="StkCod" value="<?= $attStkCod; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="attStkDsc" class="col-sm-2 col-form-label">Descri&ccedil;&atilde;o</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="attStkDsc" name="StkDsc" value="<?= $attStkDsc; ?>" <?= $isDisabled ?> required>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="attStkBlq" class="col-sm-2 col-form-label">Bloqueado</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="attStkBlq" name="StkBlq" <?= $isDisabled ?>>
                                                <option value="N" <?= ($attStkBlq == 'N' ? 'selected' : ''); ?>>N&atilde;o</option>
                                                <option value="S" <?= ($attStkBlq == 'S' ? 'selected' : ''); ?>>Sim</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="attStkObs" class="col-sm-2 col-form-label">Observa&ccedil;&atilde;o</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="attStkObs" name="StkObs" value="<?= $attStkObs; ?>" <?= $isDisabled; ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Lista
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th hidden>C&oacute;digo</th>
                                                <th>Descri&ccedil;&atilde;o</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Item</th>
                                                <th hidden>C&oacute;digo</th>
                                                <th>Descri&ccedil;&atilde;o</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            if ($data_content['DataRows']) {
                                                foreach ($data_content['DataRows'] as $data_item) {
                                                    echo '<tr>';
                                                    echo '<td><button class="btn btn-danger" type="button" data-toggle="modal" data-target="#msgModal">Excluir</button></td>';
                                                    echo '<td hidden>' . $data_item['EqpCod'] . '</td>';
                                                    echo '<td>' . $data_item['EqpDsc'] . '</td>';
                                                    echo '</tr>';
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-block">
                            <a class="btn btn-secondary" type="button" href="/GEPI/Stock">Fechar</a>
                            <button class="btn btn-primary" type="submit" name="btnUpdate" <?= ($data_content['ActionMode'] == 'modeDisplay' ? '' : 'hidden'); ?>>Adicionar Item</button>
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