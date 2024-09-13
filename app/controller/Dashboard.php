<?php

use app\core\Controller;
use app\shared\MessageDictionary;
use app\model\ReserveModel;
use app\model\CollaboratorModel;
use app\model\EquipmentModel;

session_start();

class Dashboard extends Controller
{
  private $csReserveModel;
  private $csCollaboratorModel;
  private $csEquipmentModel;

  public function index()
  {
    $message  = new MessageDictionary;
    $messages = array();
    // array_push($messages, $message->getDictionaryError(3, "Messages", "You are on the home page."));

    $data_card = $this->dataCards();

    $this->csReserveModel = new ReserveModel();
    $rows = $this->csReserveModel->readAllLinesApproved();
    
    $data_content = array("Messages" => $messages, "DataRows" => $rows, "DataCards" => $data_card);

    $this->view('DashboardView', $data_content);
  }

  private function dataCards()
  {
    $this->csCollaboratorModel = new CollaboratorModel();
    $quantityCollaborator = $this->csCollaboratorModel->Quantity();

    $this->csEquipmentModel = new EquipmentModel();
    $quantityEquipment = $this->csEquipmentModel->Quantity();

    $this->csReserveModel = new ReserveModel();
    $quantityReserveApproved = $this->csReserveModel->QuantityApproved();
    $quantityReserveLocked = $this->csReserveModel->QuantityLocked();

    $data = array("Collaborators" => $quantityCollaborator[0]['ClbQtd'], "Equipments" => $quantityEquipment[0]['EqpQtd'], "ReserveApproved" => $quantityReserveApproved[0]['RsvQtdApv'], "ReserveLocked" => $quantityReserveLocked[0]['RsvQtdLck']);

    return $data;
  }
}
