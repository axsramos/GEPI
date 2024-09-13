<?php

namespace app\model;

use app\core\Database;
use app\shared\MessageDictionary;
use PDO;

class StockModel
{
    private $attStkCod;
    private $attStkDsc;
    private $attStkBlq;
    private $attStkObs;

    // -- database -- //
    private $cnx;
    private $tbl = 'Stock';

    private $csMessage;
    public $messages = array();
    public $data_row = array();

    public function __construct()
    {
        $this->cnx = new Database();
        $this->csMessage = new MessageDictionary;
    }

    // -- get -- //
    public function getStkCod()
    {
        return $this->attStkCod;
    }
    public function getStkDsc()
    {
        return $this->attStkDsc;
    }
    public function getStkBlq()
    {
        return $this->attStkBlq;
    }
    public function getStkObs()
    {
        return $this->attStkObs;
    }

    // -- set -- //
    public function setStkCod($inStkCod)
    {
        $this->attStkCod = $inStkCod;
    }
    public function setStkDsc($inStkDsc)
    {
        $this->attStkDsc = htmlspecialchars($inStkDsc);
    }
    public function setStkBlq($inStkBlq)
    {
        $this->attStkBlq = $inStkBlq;
    }
    public function setStkObs($inStkObs)
    {
        $this->attStkObs = htmlspecialchars($inStkObs);
    }

    // -- crud -- //
    public function readAllLines()
    {
        $qry = "
        SELECT
            StkCod,
            StkDsc,
            StkBlq,
            StkObs
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
            StkCod,
            StkDsc,
            StkBlq,
            StkObs
        FROM
        " . $this->tbl . "
        WHERE
            StkCod = :StkCod
        ";

        $parameters = array(
            ":StkCod" => $this->attStkCod
        );

        $stmt = $this->cnx->executeQuery($qry, $parameters);
        $rows = $stmt->rowCount();

        if ($rows) {
            $this->data_row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->attStkCod = $this->data_row['StkCod'];
            $this->attStkDsc = $this->data_row['StkDsc'];
            $this->attStkBlq = $this->data_row['StkBlq'];
            $this->attStkObs = $this->data_row['StkObs'];
        }

        return boolval($rows);
    }

    public function insertLine()
    {
        if (empty($this->attStkCod)) {
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
            StkCod,
            StkDsc,
            StkBlq,
            StkObs
        )
        VALUES
        (
            :StkCod,
            :StkDsc,
            :StkBlq,
            :StkObs
        )
        ";

        $parameters = array(
            ':StkCod' => $this->attStkCod,
            ':StkDsc' => $this->attStkDsc,
            ':StkBlq' => $this->attStkBlq,
            ':StkObs' => $this->attStkObs
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
            StkDsc = :StkDsc,
            StkBlq = :StkBlq,
            StkObs = :StkObs
        WHERE
            StkCod = :StkCod
        ";

        $parameters = array(
            ':StkCod' => $this->attStkCod,
            ':StkDsc' => $this->attStkDsc,
            ':StkBlq' => $this->attStkBlq,
            ':StkObs' => $this->attStkObs
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
            StkCod = :StkCod
        ";

        $parameters = array(
            ':StkCod' => $this->attStkCod
        );

        $stmt = $this->cnx->executeQuery($qry, $parameters);
        $rows = $stmt->rowCount();

        return boolval($rows);
    }

    // -- other -- //
    private function newid()
    {
        do {
            $this->attStkCod = uniqid();
        } while(!$this->check_duplicate_key());
    }

    private function check_duplicate_key()
    {
        $qry = "
        SELECT
            StkCod
        FROM
        " . $this->tbl . "
        WHERE
            StkCod = :StkCod
        ";

        $parameters = array(
            ":StkCod" => $this->attStkCod
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
        $qry = "
        DELETE FROM
            Stockflow
        WHERE
            StkCod = :StkCod
        ";

        $parameters = array(
            ':StkCod' => $this->attStkCod
        );
        
        $stmt = $this->cnx->executeQuery($qry, $parameters);
    }
}
