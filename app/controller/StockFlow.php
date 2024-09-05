<?php

use app\core\Controller;
use app\shared\MessageDictionary;
use app\model\StockModel;

class StockFlow extends Controller
{
  private $csStockModel;

  public function Index($id = null)
  {
    if (empty($id)) {
      header("Location: /GEPI/Stock");
    } else {
      header("Location: /GEPI/StockFlow/Show/" . $id);
    }
  }

  public function Show($id = null)
  {
    $message  = new MessageDictionary;
    $messages = array();
    $data_row = array();
    $data_equipments = array();

    if (isset($_POST['btnClose'])) {
      header("Location: /GEPI/Stock");
    }

    $this->csStockModel = new StockModel();
    $this->csStockModel->setStkCod($id);

    if (empty($id)) {
      die();
      // $actionMode = 'modeInsert';

      // if (isset($_POST['btnConfirm'])) {
      //   $this->csStockModel = $this->SetValues();
      //   if ($this->csStockModel->insertLine()) {
      //     header("Location: /GEPI/StockFlow");
      //   }
      // }
    } else {
      $actionMode = 'modeDisplay';

      if (isset($_POST['btnDelete'])) {
        $actionMode = 'modeDelete';
        if ($this->csStockModel->deleteLine()) {
          header("Location: /GEPI/Stock");
        }
      }

      // if (isset($_POST['btnConfirm'])) {
      //   $this->csStockModel = $this->SetValues();
      //   if ($this->csStockModel->updateLine()) {
      //     header("Location: /GEPI/Stock");
      //   }
      // }

      // if (isset($_POST['btnUpdate'])) {
      //   $actionMode = 'modeUpdate';
      // }

      if ($this->csStockModel->readLine()) {
        $data_row = $this->csStockModel->data_row;
      }
    }

    $data_content = array("Messages" => $messages, "ActionMode" => $actionMode, "HeaderDataRow" => $data_row, "DataRows" => $data_equipments);

    $this->view('StockFlowListView', $data_content);
  }

  private function SetValues()
  {
    if (isset($_POST['StkCod'])) {
      $this->csStockModel->setStkCod($_POST['StkCod']);
    }
    $this->csStockModel->setStkDsc($_POST['StkDsc']);
    $this->csStockModel->setStkBlq($_POST['StkBlq']);
    $this->csStockModel->setStkObs($_POST['StkObs']);
    
    return $this->csStockModel;
  }
}
