<?php

use app\core\Controller;
use app\shared\MessageDictionary;
use app\model\CollaboratorModel;

session_start();

class Register extends Controller
{
  public function index()
  {
    $message  = new MessageDictionary;
    $messages = array();

    // array_push($messages, $message->getDictionaryError(3, "Messages", "You are on the home page."));

    $data_content = array("Messages" => $messages);

    $dataBiometrics = '';
    $dataname = '';
    $hasError = FALSE;

    $this->Logout(false);

    if (isset($_POST['btnEnter'])) {

      $dataBiometrics = $_POST['attBiometrics'];
      $dataname = trim($_POST['attName']);

      if (empty($dataname)) {
        array_push($messages, $message->getDictionaryError(2, "Messages", "Entre com seu nome."));
        $hasError = TRUE;
      }
      if (empty($dataBiometrics)) {
        array_push($messages, $message->getDictionaryError(2, "Messages", "Entre com sua biometria / senha de acesso."));
        $hasError = TRUE;
      }
      if (!$hasError) {
        $csCollaboratorModel = new CollaboratorModel();
        $csCollaboratorModel->setClbKey($dataBiometrics);
        $csCollaboratorModel->setClbNme($dataname);
        $csCollaboratorModel->setClbBlq('N');
        $csCollaboratorModel->setClbSup('S'); // demo //
        if ($csCollaboratorModel->insertLine()) {
          if ($csCollaboratorModel->checklogin()) {
            $_SESSION['LOGIN_ID'] = $csCollaboratorModel->getClbCod();
            $_SESSION['LOGIN_NAME'] = trim(substr($csCollaboratorModel->getClbNme(), 0, 25));
            $_SESSION['LOGIN_SUPER'] = $csCollaboratorModel->getClbSup();
            header("Location: /GEPI/Dashboard/");
          } else {
            array_push($messages, $message->getDictionaryError(1, "Messages", "Identifica&ccedil;&atilde;o inv&aacute;lida!"));
          }
        }
      }
    }

    $data_content = array("Messages" => $messages);

    $this->view('RegisterView', $data_content);
  }

  public function Logout($redirect = True)
  {
    $_SESSION['LOGIN_ID'] = '';
    $_SESSION['LOGIN_NAME'] = 'An&ocirc;nimo';
    $_SESSION['LOGIN_SUPER'] = 'N';

    if ($redirect) {
      header("Location: /GEPI/Login/");
    }
  }
}
