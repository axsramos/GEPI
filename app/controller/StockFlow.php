<?php

use app\core\Controller;
use app\shared\MessageDictionary;
use app\model\StockModel;
use app\model\StockFlowModel;

session_start();

class StockFlow extends Controller
{
  private $csStockFlowModel;
  PRIVATE $csStockModel;

  public function Index($id = null)
  {
    if (empty($id)) {
      header("Location: /GEPI/Stock");
    } else {
      header("Location: /GEPI/StockFlow/Show/" . $id);
    }
  }

  public function Show($idStkCod = null, $idEqpCod = null)
  {
    $message  = new MessageDictionary;
    $messages = array();
    $header_data_row = array();
    $data_rows = array();
    $data_new_equipments = array();

    if (isset($_POST['btnClose'])) {
      header("Location: /GEPI/Stock");
    }

    $this->csStockModel = new StockModel();
    $this->csStockModel->setStkCod($idStkCod);

    $this->csStockFlowModel = new StockFlowModel();
    $this->csStockFlowModel->setStkCod($idStkCod);
    $this->csStockFlowModel->setEqpCod($idEqpCod);

    if (empty($idStkCod)) {
      header("Location: /GEPI/Stock");
    } else {
      $actionMode = 'modeDisplay';

      if (isset($_POST['btnDelete'])) {
        $actionMode = 'modeDelete';

        $this->csStockFlowModel->setStkFlwCod($_POST['btnDelete']);

        if ($this->csStockFlowModel->deleteLine()) {
          header("Location: /GEPI/StockFlow/Show/" . $idStkCod);
        }
      }
      
      if (isset($_POST['btnInsert'])) {
        $actionMode = 'modeInsert';

        $this->csStockFlowModel = $this->SetValues();

        if ($this->csStockFlowModel->insertLine()) {
          header("Location: /GEPI/StockFlow/Show/" . $idStkCod);
        }
      }

      if ($this->csStockModel->readLine()) {
        $header_data_row = $this->csStockModel->data_row;
      }
      if ($this->csStockFlowModel->readAllLines()) {
        $data_rows = $this->csStockFlowModel->readAllLines();
      }
      
    }

    $data_new_equipments = $this->ListEquipmentAvailable($idStkCod);

    $data_content = array("Messages" => $messages, "ActionMode" => $actionMode, "HeaderDataRow" => $header_data_row, "DataRows" => $data_rows, "NewEquipmentDataRows" => $data_new_equipments);

    $this->view('StockFlowListView', $data_content);
  }

  private function SetValues()
  {
    if (isset($_POST['StkCod'])) {
      $this->csStockFlowModel->setStkCod($_POST['StkCod']);
    }
    $this->csStockFlowModel->setStkFlwCod('');
    $this->csStockFlowModel->setStkFlwDca(date('Y-m-d'));
    $this->csStockFlowModel->setEqpCod($_POST['btnInsert']);
    $this->csStockFlowModel->setStkFlwBlq('N');
    $this->csStockFlowModel->setStkFlwObs('');
    $this->csStockFlowModel->setStkFlwAddClb($_SESSION['LOGIN_ID']);
    $this->csStockFlowModel->setStkFlwRmvClb(null);
    $this->csStockFlowModel->setStkFlwRsvCod(null);
    
    return $this->csStockFlowModel;
  }

  protected function ListEquipmentAvailable($inStkCod) {
    $data = array();

    $csStockFlowModel = new StockFlowModel();
    $csStockFlowModel->setStkCod($inStkCod);
    $equipments = $csStockFlowModel->EquipmentAvailable();

    $data = array();
    $rows = $csStockFlowModel->readAllLines();

    foreach ($equipments as $value) {
      $add = TRUE;
      foreach ($rows as $value_item) {
        if ($value['EqpCod'] == $value_item['EqpCod']) {
          $add = FALSE;
          break;
        }
      }
      if ($add) {
        array_push($data, $value);
      }
    }

    return $data;
  }
}
