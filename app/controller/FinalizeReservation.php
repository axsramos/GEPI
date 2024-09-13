<?php

use app\core\Controller;
use app\shared\MessageDictionary;
use app\model\ReserveModel;

session_start();

class FinalizeReservation extends Controller
{
  private $csReserveModel;

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
        $this->csReserveModel->setRsvLck('S');
        $this->csReserveModel->setRsvClbLck($_POST['attBiometrics']);
        $this->csReserveModel->setRsvLckDta(date('Y-m-d H-i-s'));

        if ($this->csReserveModel->updateLine()) {
          header("Location: /GEPI/Dashboard");
        }
      }
    }

    $data_rows = $this->csReserveModel->readAllLinesEquipments();
    $data_equipments = array();

    $data_content = array("Messages" => $messages, "ActionMode" => $actionMode, "DataRowHeader" => $data_row, "DataRows" => $data_rows, "DataEquipments" => $data_equipments);

    $this->view('FinalizeReservationView', $data_content);
  }
}
