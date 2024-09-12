<!DOCTYPE html>
<html lang="pt">

<head>

    <?php include_once('section/head_meta_link.php'); ?>

</head>

<body>
    <?php
    if (!empty($_SESSION['ID_FILE_UPLOAD'])) {
        echo '<script>window.self.close();</script>';
    }
    ?>
    <div class="container-fluid">
        <h1 class="mt-4">Anexar Foto</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Anexar foto para o equipamento</li>
        </ol>
        <?php
        if ($data_content['Messages']) {
            echo '<div class="ml-1 row">';
            foreach ($data_content['Messages'] as $message_item) {
                echo '<div class="' . $message_item['alert'] . '" role="alert">';
                echo $message_item['message'];
                echo '</div>';
            }
            echo '</div>';
        }
        ?>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-list mr-1"></i>
                Detalhes do cadastro
            </div>
            <form action="/GEPI/UploadFile" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="table">
                        <div class="mb-3 row">
                            <label for="attUploadFile" class="col-sm-2 col-form-label">Anexo da foto</label>
                            <div class="col-sm-10">
                                <input type="file" name="fileToUpload" id="fileToUpload">
                                <input type="submit" value="Enviar" name="submit">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include_once('section/body_scripts_src.php'); ?>

</body>

</html>