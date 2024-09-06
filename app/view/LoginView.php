<!DOCTYPE html>
<html lang="pt">

<head>

    <?php include_once('section/head_meta_link.php'); ?>

</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <div class="card-body">
                                    <form action="/GEPI/Login/" method="post">
                                        <div class="form-group">
                                            <div class="d-flex justify-content-center">
                                                <i class="fas fa-fingerprint fa-4x"></i>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="attBiometrics">Chave de Autentica&ccedil;&atilde;o</label>
                                            <input class="form-control py-4" id="attBiometrics" name="attBiometrics" type="password" placeholder="Entre com sua biometria" autofocus="autofocus" required/>
                                        </div>
                                        <?php
                                        if ($data_content['Messages']) {
                                            foreach ($data_content['Messages'] as $message_item) {
                                                echo '<div class="' . $message_item['alert'] . '" role="alert">';
                                                echo $message_item['message'];
                                                echo '</div>';
                                            }
                                        }
                                        ?>

                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type="submit" name="btnEnter" class="btn btn-primary">Entrar</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    <div class="small"><a href="/GEPI/Register/">Precisa de uma conta? Cadastre-se!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">

            <?php include_once('section/body_footer.php'); ?>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>