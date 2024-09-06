<?php

use app\core\Controller;
use app\shared\MessageDictionary;

session_start();

class Dashboard extends Controller
{
  public function index()
  {
    $message  = new MessageDictionary;
    $messages = array();

    http_response_code(200);
    array_push($messages, $message->getDictionaryError(3, "Messages", "You are on the home page."));

    $data_content = array("Messages" => $messages);

    $this->view('DashboardView', $data_content);
  }
}
