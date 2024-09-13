<?php

use app\core\Controller;
use app\shared\MessageDictionary;
use app\model\ReserveModel;
use app\model\CollaboratorModel;

session_start();

class FinalizeReservation extends Controller
{
  private $csReserveModel;
  private $csCollaboratorModel;

  public function Index($id = null)
  {
    $message  = new MessageDictionary;
    $messages = array();

    if (isset($_POST['btnClose'])) {
      header("Location: /GEPI/Dashboard");
    }

    if (empty($id)) {
      header("Location: /GEPI/Dashboard");
    } else {
      $actionMode = 'modeDisplay';

      $this->csReserveModel = new ReserveModel();
      $this->csReserveModel->setRsvCod($id);

      $result = $this->csReserveModel->readLine();
      $data_row = $this->csReserveModel->data_row;

      if (isset($_POST['btnFinalizar'])) {
        $attBiometrics = $_POST['attBiometrics'];

        $this->csCollaboratorModel = new CollaboratorModel();
        $this->csCollaboratorModel->setClbKey($attBiometrics);

        if ($this->csCollaboratorModel->checklogin()) {
          $this->csReserveModel->setRsvLck('S');
          $this->csReserveModel->setRsvClbLck($this->csCollaboratorModel->getClbCod());
          $this->csReserveModel->setRsvLckDta(date('Y-m-d H-i-s'));

          if ($this->csReserveModel->updateLine()) {
            header("Location: /GEPI/Dashboard");
          }
        } else {
          array_push($messages, $message->getDictionaryError(1, "Messages", "Autenticação falhou. Tente novamente."));
        }
      }
    }

    $data_rows = $this->csReserveModel->readAllLinesEquipments();
    $data_equipments = array();

    $data_content = array("Messages" => $messages, "ActionMode" => $actionMode, "DataRowHeader" => $data_row, "DataRows" => $data_rows, "DataEquipments" => $data_equipments);

    $this->view('FinalizeReservationView', $data_content);
  }
}
