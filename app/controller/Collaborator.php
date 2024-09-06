<?php

use app\core\Controller;
use app\shared\MessageDictionary;
use app\model\CollaboratorModel;

session_start();

class Collaborator extends Controller
{
  private $csCollaboratorModel;

  public function Index()
  {
    $message  = new MessageDictionary;
    $messages = array();

    $this->csCollaboratorModel = new CollaboratorModel();
    $rows = $this->csCollaboratorModel->readAllLines();

    $data_content = array("Messages" => $messages, "DataRows" => $rows);

    $this->view('CollaboratorListView', $data_content);
  }

  public function Show($id = null)
  {
    $message  = new MessageDictionary;
    $messages = array();
    $data_row = array();

    if (isset($_POST['btnClose'])) {
      header("Location: /GEPI/Collaborator");
    }

    $this->csCollaboratorModel = new CollaboratorModel();
    $this->csCollaboratorModel->setClbCod($id);

    if (empty($id)) {
      $actionMode = 'modeInsert';

      if (isset($_POST['btnConfirm'])) {
        $this->csCollaboratorModel = $this->SetValues();
        if ($this->csCollaboratorModel->insertLine()) {
          header("Location: /GEPI/Collaborator");
        }
      }
    } else {
      $actionMode = 'modeDisplay';

      if (isset($_POST['btnDelete'])) {
        $actionMode = 'modeDelete';
        if ($this->csCollaboratorModel->deleteLine()) {
          header("Location: /GEPI/Collaborator");
        }
      }

      if (isset($_POST['btnConfirm'])) {
        $this->csCollaboratorModel = $this->SetValues();
        if ($this->csCollaboratorModel->updateLine()) {
          header("Location: /GEPI/Collaborator");
        }
      }

      if (isset($_POST['btnUpdate'])) {
        $actionMode = 'modeUpdate';
      }

      if ($this->csCollaboratorModel->readLine()) {
        $data_row = $this->csCollaboratorModel->data_row;
      }
    }

    $data_content = array("Messages" => $messages, "ActionMode" => $actionMode, "DataRow" => $data_row);

    $this->view('CollaboratorFormView', $data_content);
  }

  private function SetValues()
  {
    if (isset($_POST['ClbCod'])) {
      $this->csCollaboratorModel->setClbCod($_POST['ClbCod']);
    }
    $this->csCollaboratorModel->setClbSup($_POST['ClbSup']);
    $this->csCollaboratorModel->setClbNme($_POST['ClbNme']);
    $this->csCollaboratorModel->setClbBlq($_POST['ClbBlq']);
    $this->csCollaboratorModel->setClbKey($_POST['ClbKey']);
    
    return $this->csCollaboratorModel;
  }
}
