<?php

use app\core\Controller;
use app\shared\MessageDictionary;
use app\model\StockModel;

session_start();

class Stock extends Controller
{
  private $csStockModel;

  public function Index()
  {
    $message  = new MessageDictionary;
    $messages = array();

    $this->csStockModel = new StockModel();
    $rows = $this->csStockModel->readAllLines();

    $data_content = array("Messages" => $messages, "DataRows" => $rows);

    $this->view('StockListView', $data_content);
  }

  public function Show($id = null)
  {
    $message  = new MessageDictionary;
    $messages = array();
    $data_row = array();

    if (isset($_POST['btnClose'])) {
      header("Location: /GEPI/Stock");
    }

    $this->csStockModel = new StockModel();
    $this->csStockModel->setStkCod($id);

    if (empty($id)) {
      $actionMode = 'modeInsert';

      if (isset($_POST['btnConfirm'])) {
        $this->csStockModel = $this->SetValues();
        if ($this->csStockModel->insertLine()) {
          header("Location: /GEPI/Stock");
        }
      }
    } else {
      $actionMode = 'modeDisplay';

      if (isset($_POST['btnDelete'])) {
        $actionMode = 'modeDelete';
        if ($this->csStockModel->deleteLine()) {
          header("Location: /GEPI/Stock");
        }
      }

      if (isset($_POST['btnConfirm'])) {
        $this->csStockModel = $this->SetValues();
        if ($this->csStockModel->updateLine()) {
          header("Location: /GEPI/Stock");
        }
      }

      if (isset($_POST['btnUpdate'])) {
        $actionMode = 'modeUpdate';
      }

      if ($this->csStockModel->readLine()) {
        $data_row = $this->csStockModel->data_row;
      }
    }

    $data_content = array("Messages" => $messages, "ActionMode" => $actionMode, "DataRow" => $data_row);

    $this->view('StockFormView', $data_content);
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
