<?php

namespace app\model;

use app\core\Database;
use app\shared\MessageDictionary;
use PDO;

class CollaboratorModel
{
    private $attClbCod;
    private $attClbNme;
    private $attClbBlq;
    private $attClbSup;
    private $attClbKey;

    // -- database -- //
    private $cnx;
    private $tbl = 'collaborator';

    private $csMessage;
    public $messages = array();
    public $data_row = array();

    public function __construct()
    {
        $this->cnx = new Database();
        $this->csMessage = new MessageDictionary;
    }

    // -- get -- //
    public function getClbCod()
    {
        return $this->attClbCod;
    }
    public function getClbNme()
    {
        return $this->attClbNme;
    }
    public function getClbBlq()
    {
        return $this->attClbBlq;
    }
    public function getClbSup()
    {
        return $this->attClbSup;
    }
    public function getClbKey()
    {
        return $this->attClbKey;
    }

    // -- set -- //
    public function setClbCod($inClbCod)
    {
        $this->attClbCod = $inClbCod;
    }
    public function setClbNme($inClbNme)
    {
        $this->attClbNme = htmlspecialchars($inClbNme);
    }
    public function setClbBlq($inClbBlq)
    {
        $this->attClbBlq = $inClbBlq;
    }
    public function setClbSup($inClbSup)
    {
        $this->attClbSup = $inClbSup;
    }
    public function setClbKey($inClbKey)
    {
        $this->attClbKey = htmlspecialchars($inClbKey);
    }

    // -- crud -- //
    public function readAllLines()
    {
        $qry = "
        SELECT
            ClbCod,
            ClbNme,
            ClbSup,
            ClbBlq,
            ClbKey
        FROM
        " . $this->tbl . "
        ";

        $stmt = $this->cnx->executeQuery($qry);
        $rows = $stmt->rowCount();
        $allLines = false;

        if ($rows) {
            $allLines = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $allLines;
    }

    public function readLine()
    {
        $qry = "
        SELECT
            ClbCod,
            ClbNme,
            ClbSup,
            ClbBlq,
            ClbKey
        FROM
        " . $this->tbl . "
        WHERE
            ClbCod = :ClbCod
        ";

        $parameters = array(
            ":ClbCod" => $this->attClbCod
        );

        $stmt = $this->cnx->executeQuery($qry, $parameters);
        $rows = $stmt->rowCount();

        if ($rows) {
            $this->data_row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->attClbCod = $this->data_row['ClbCod'];
            $this->attClbNme = $this->data_row['ClbNme'];
            $this->attClbSup = $this->data_row['ClbSup'];
            $this->attClbBlq = $this->data_row['ClbBlq'];
            $this->attClbKey = $this->data_row['ClbKey'];
        }

        return boolval($rows);
    }

    public function insertLine()
    {
        if (empty($this->attClbCod)) {
            $this->newid();
        } else {
            if (!$this->check_duplicate_key()) {
                return FALSE;
            }
        }

        $this->newid();

        $qry = "
        INSERT INTO
        " . $this->tbl . "
        (
            ClbCod,
            ClbNme,
            ClbSup,
            ClbBlq,
            ClbKey
        )
        VALUES
        (
            :ClbCod,
            :ClbNme,
            :ClbSup,
            :ClbBlq,
            :ClbKey
        )
        ";

        $parameters = array(
            ':ClbCod' => $this->attClbCod,
            ':ClbNme' => $this->attClbNme,
            ':ClbSup' => $this->attClbSup,
            ':ClbBlq' => $this->attClbBlq,
            ':ClbKey' => $this->attClbKey
        );

        $stmt = $this->cnx->executeQuery($qry, $parameters);
        $rows = $stmt->rowCount();

        return boolval($rows);
    }

    public function updateLine()
    {
        $qry = "
        UPDATE 
        " . $this->tbl . "
        SET
            ClbNme = :ClbNme,
            ClbSup = :ClbSup,
            ClbBlq = :ClbBlq,
            ClbKey = :ClbKey
        WHERE
            ClbCod = :ClbCod
        ";

        $parameters = array(
            ':ClbCod' => $this->attClbCod,
            ':ClbNme' => $this->attClbNme,
            ':ClbSup' => $this->attClbSup,
            ':ClbBlq' => $this->attClbBlq,
            ':ClbKey' => $this->attClbKey
        );

        $stmt = $this->cnx->executeQuery($qry, $parameters);
        $rows = $stmt->rowCount();

        return boolval($rows);
    }

    public function deleteLine()
    {
        if ($this->check_referencial_key()) {
            $this->delete_referencial();
        }

        $qry = "
        DELETE FROM
        " . $this->tbl . "
        WHERE
            ClbCod = :ClbCod
        ";

        $parameters = array(
            ':ClbCod' => $this->attClbCod
        );

        $stmt = $this->cnx->executeQuery($qry, $parameters);
        $rows = $stmt->rowCount();

        return boolval($rows);
    }

    // -- other -- //
    private function newid()
    {
        do {
            $this->attClbCod = uniqid();
        } while(!$this->check_duplicate_key());
    }

    private function check_duplicate_key()
    {
        $qry = "
        SELECT
            ClbCod
        FROM
        " . $this->tbl . "
        WHERE
            ClbCod = :ClbCod
        ";

        $parameters = array(
            ":ClbCod" => $this->attClbCod
        );

        $stmt = $this->cnx->executeQuery($qry, $parameters);
        $rows = $stmt->rowCount();

        if ($rows) {
            array_push($this->messages, $this->csMessage->getDictionaryError(1, "Messages", "Ocorreu um erro. Validação em dado duplicado. Registro já existe."));
        }

        return !boolval($rows);
    }

    private function check_referencial_key()
    {
        return true;
    }
    private function delete_referencial()
    {
        // $qry = "
        // DELETE FROM
        // ClbItm
        // WHERE
        //     ClbCod = :ClbCod
        // ";

        // $parameters = array(
        //     ':ClbCod' => $this->attClbCod
        // );

        // $stmt = $this->cnx->executeQuery($qry, $parameters);
    }

    public function checklogin()
    {
        $qry = "
        SELECT
            ClbCod,
            ClbNme,
            ClbSup,
            ClbBlq,
            ClbKey
        FROM
        " . $this->tbl . "
        WHERE
            ClbKey = :ClbKey
        ";

        $parameters = array(
            ":ClbKey" => $this->attClbKey
        );

        $stmt = $this->cnx->executeQuery($qry, $parameters);
        $rows = $stmt->rowCount();

        if ($rows) {
            $this->data_row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->attClbCod = $this->data_row['ClbCod'];
            $this->attClbNme = $this->data_row['ClbNme'];
            $this->attClbSup = $this->data_row['ClbSup'];
            $this->attClbBlq = $this->data_row['ClbBlq'];
            $this->attClbKey = $this->data_row['ClbKey'];
        }

        return boolval($rows);
    }
}
