<?php

use app\core\Controller;
use app\shared\MessageDictionary;
use app\model\ReserveModel;
use app\model\StockFlowModel;

session_start();

class Reserve extends Controller
{
  private $csReserveModel;

  public function Index()
  {
    $message  = new MessageDictionary;
    $messages = array();

    $this->csReserveModel = new ReserveModel();
    $rows = $this->csReserveModel->readAllLines();

    $data_content = array("Messages" => $messages, "DataRows" => $rows);

    $this->view('ReserveListView', $data_content);
  }

  public function Show($id = null)
  {
    $message  = new MessageDictionary;
    $messages = array();
    $data_row = array();
    $data_equipments = array();

    if (isset($_POST['btnClose'])) {
      header("Location: /GEPI/Reserve");
    }

    $this->csReserveModel = new ReserveModel();
    $this->csReserveModel->setRsvCod($id);

    if (empty($id)) {
      $actionMode = 'modeInsert';

      if (isset($_POST['btnConfirm'])) {
        $this->csReserveModel = $this->SetValues();
        if ($this->csReserveModel->insertLine()) {
          header("Location: /GEPI/Reserve");
        }
      } else {
        $csStockFlowModel = new StockFlowModel();
        $data_equipments = $csStockFlowModel->EquipmentAvailable();
      }
    } else {
      $actionMode = 'modeDisplay';

      if (isset($_POST['btnDelete'])) {
        $actionMode = 'modeDelete';
        if ($this->csReserveModel->deleteLine()) {
          header("Location: /GEPI/Reserve");
        }
      }

      if (isset($_POST['btnConfirm'])) {
        $this->csReserveModel = $this->SetValues();
        if ($this->csReserveModel->updateLine()) {
          header("Location: /GEPI/Reserve");
        }
      }

      if (isset($_POST['btnUpdate'])) {
        $actionMode = 'modeUpdate';
      }

      if ($this->csReserveModel->readLine()) {
        $data_row = $this->csReserveModel->data_row;
      }
    }

    $data_content = array("Messages" => $messages, "ActionMode" => $actionMode, "DataRow" => $data_row, "DataEquipments" =>$data_equipments);

    $this->view('ReservePainelView', $data_content);
  }

  private function SetValues()
  {
    if (isset($_POST['RsvCod'])) {
      $this->csReserveModel->setRsvCod($_POST['RsvCod']);
    }
    $this->csReserveModel->setRsvDsc($_POST['RsvDsc']);
    $this->csReserveModel->setRsvBlq($_POST['RsvBlq']);
    $this->csReserveModel->setRsvObs($_POST['RsvObs']);
    
    return $this->csReserveModel;
  }
}
