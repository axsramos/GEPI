<?php

use app\core\Controller;
use app\shared\MessageDictionary;
use app\model\PictureModel;

session_start();

class UploadFile extends Controller
{
  public function index()
  {
    $message  = new MessageDictionary;
    $messages = array();

    http_response_code(200);
    // array_push($messages, $message->getDictionaryError(3, "Messages", "You are on the home page."));

    $_SESSION['ID_FILE_UPLOAD'] = '';

    if (isset($_POST['submit']) and ($_FILES['fileToUpload']['error'] == 0)) {
      $target_dir = '/GEPI/uploads/';
      $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if ($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        // echo "File is not an image.";
        array_push($messages, $message->getDictionaryError(2, "Messages", "O arquivo n&atilde;o &eacute; uma imagem"));
        $uploadOk = 0;
      }
      
      // Check if file already exists
      if (file_exists($target_file)) {
        // echo "Sorry, file already exists.";
        array_push($messages, $message->getDictionaryError(2, "Messages", "Desculpe. O arquivo n&atilde;o existe."));
        $uploadOk = 0;
      }

      // Check file size
      if ($_FILES["fileToUpload"]["size"] > 500000) {
        // echo "Sorry, your file is too large.";\
        array_push($messages, $message->getDictionaryError(2, "Messages", "Desculpe. O arquivo &eacute; muito grande."));
        $uploadOk = 0;
      }

      // Allow certain file formats
      if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
      ) {
        // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        array_push($messages, $message->getDictionaryError(2, "Messages", "Desculpe. Somente arquivos JPG, JPEG, PNG e GIF s&atilde;o permitidos."));
        $uploadOk = 0;
      }

      if (boolval($uploadOk)) {
        $id_file = uniqid();
        $path_parts = pathinfo(dirname(__FILE__));
        $new_file = $path_parts['dirname'];
        $new_file = $new_file . "\\uploads\\" . $id_file . '.' . $imageFileType;
        $hasCopy = copy($_FILES["fileToUpload"]["tmp_name"], $new_file);

        if ($hasCopy) {
          $csPictureModel = new PictureModel();

          $csPictureModel->setPicCod($id_file);
          $csPictureModel->setPicNme($_FILES["fileToUpload"]["name"]);
          $csPictureModel->setPicSrc($id_file);
          $csPictureModel->setPicDir('/app/uploads/');
          $csPictureModel->setPicExt($imageFileType);
          $csPictureModel->setPicSze(1);
          
          if ($csPictureModel->insertLine()) {
            $_SESSION['ID_FILE_UPLOAD'] = $id_file;
          }
        }
      }
    }

    $data_content = array("Messages" => $messages);

    $this->view('UploadFileView', $data_content);
  }
}
