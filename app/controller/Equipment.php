<?php

use app\core\Controller;
use app\shared\MessageDictionary;
use app\model\EquipmentModel;
use app\model\PictureModel;

session_start();

class Equipment extends Controller
{
  private $csEquipmentModel;

  public function Index()
  {
    $message  = new MessageDictionary;
    $messages = array();

    $this->csEquipmentModel = new EquipmentModel();
    $rows = $this->csEquipmentModel->readAllLines();

    $data_content = array("Messages" => $messages, "DataRows" => $rows);

    $this->view('EquipmentListView', $data_content);
  }

  public function Show($id = null)
  {
    $message  = new MessageDictionary;
    $messages = array();
    $data_row = array();

    if (isset($_POST['btnClose'])) {
      header("Location: /GEPI/Equipment");
    }

    $this->csEquipmentModel = new EquipmentModel();
    $this->csEquipmentModel->setEqpCod($id);

    if (empty($id)) {
      $actionMode = 'modeInsert';

      if (isset($_POST['btnConfirm'])) {
        $this->csEquipmentModel = $this->SetValues();
        $this->csEquipmentModel->setEqpPic($_SESSION['ID_FILE_UPLOAD']);
        if ($this->csEquipmentModel->insertLine()) {
          $_SESSION['ID_FILE_UPLOAD'] = '';
          header("Location: /GEPI/Equipment");
        }
      }
    } else {
      $actionMode = 'modeDisplay';

      if (isset($_POST['btnDelete'])) {
        $actionMode = 'modeDelete';
        if ($this->csEquipmentModel->deleteLine()) {
          header("Location: /GEPI/Equipment");
        }
      }

      if (isset($_POST['btnConfirm'])) {
        $this->csEquipmentModel = $this->SetValues();
        if ($this->csEquipmentModel->updateLine()) {
          header("Location: /GEPI/Equipment");
        }
      }

      if (isset($_POST['btnUpdate'])) {
        $actionMode = 'modeUpdate';
      }

      if ($this->csEquipmentModel->readLineWhithPicture()) {
        $data_row = $this->csEquipmentModel->data_row;
      }
    }

    $data_content = array("Messages" => $messages, "ActionMode" => $actionMode, "DataRow" => $data_row);

    $this->view('EquipmentFormView', $data_content);
  }

  private function SetValues()
  {
    if (isset($_POST['EqpCod'])) {
      $this->csEquipmentModel->setEqpCod($_POST['EqpCod']);
    }
    $this->csEquipmentModel->setEqpDsc($_POST['EqpDsc']);
    $this->csEquipmentModel->setEqpBlq($_POST['EqpBlq']);
    $this->csEquipmentModel->setEqpPic($_POST['EqpPic']);
    $this->csEquipmentModel->setEqpObs($_POST['EqpObs']);

    return $this->csEquipmentModel;
  }

  public function getPictureSource($inPicCod)
  {
    $source_picture = $inPicCod;

    $csPictureModel = new PictureModel();
    $csPictureModel->setPicCod($inPicCod);
    if ($csPictureModel->readLine()) {
      $source_picture = '/GEPI/';
      $source_picture .= $csPictureModel->getPicDir();
      $source_picture .= $csPictureModel->getPicSrc();
      $source_picture .= '.';
      $source_picture .= $csPictureModel->getPicExt();
    }

    return $source_picture;
  }
}
