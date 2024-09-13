<?php

namespace app\model;

use app\core\Database;
use app\shared\MessageDictionary;
use PDO;

class EquipmentModel
{
    private $attEqpCod;
    private $attEqpDsc;
    private $attEqpBlq;
    private $attEqpPic;
    private $attEqpObs;
    private $attEqpPicSrc;

    // -- database -- //
    private $cnx;
    private $tbl = 'Equipment';

    private $csMessage;
    public $messages = array();
    public $data_row = array();

    public function __construct()
    {
        $this->cnx = new Database();
        $this->csMessage = new MessageDictionary;
    }

    // -- get -- //
    public function getEqpCod()
    {
        return $this->attEqpCod;
    }
    public function getEqpDsc()
    {
        return $this->attEqpDsc;
    }
    public function getEqpBlq()
    {
        return $this->attEqpBlq;
    }
    public function getEqpPic()
    {
        return $this->attEqpPic;
    }
    public function getEqpObs()
    {
        return $this->attEqpObs;
    }
    public function getEqpPicSrc()
    {
        return $this->attEqpPicSrc;
    }

    // -- set -- //
    public function setEqpCod($inEqpCod)
    {
        $this->attEqpCod = $inEqpCod;
    }
    public function setEqpDsc($inEqpDsc)
    {
        $this->attEqpDsc = htmlspecialchars($inEqpDsc);
    }
    public function setEqpBlq($inEqpBlq)
    {
        $this->attEqpBlq = $inEqpBlq;
    }
    public function setEqpPic($inEqpPic)
    {
        $this->attEqpPic = $inEqpPic;
    }
    public function setEqpObs($inEqpObs)
    {
        $this->attEqpObs = htmlspecialchars($inEqpObs);
    }

    // -- crud -- //
    public function readAllLines()
    {
        $qry = "
        SELECT
            EqpCod,
            EqpDsc,
            EqpPic,
            EqpBlq,
            EqpObs
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
            EqpCod,
            EqpDsc,
            EqpPic,
            EqpBlq,
            EqpObs
        FROM
        " . $this->tbl . "
        WHERE
            EqpCod = :EqpCod
        ";

        $parameters = array(
            ":EqpCod" => $this->attEqpCod
        );

        $stmt = $this->cnx->executeQuery($qry, $parameters);
        $rows = $stmt->rowCount();

        if ($rows) {
            $this->data_row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->attEqpCod = $this->data_row['EqpCod'];
            $this->attEqpDsc = $this->data_row['EqpDsc'];
            $this->attEqpPic = $this->data_row['EqpPic'];
            $this->attEqpBlq = $this->data_row['EqpBlq'];
            $this->attEqpObs = $this->data_row['EqpObs'];
        }

        return boolval($rows);
    }

    public function insertLine()
    {
        if (empty($this->attEqpCod)) {
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
            EqpCod,
            EqpDsc,
            EqpPic,
            EqpBlq,
            EqpObs
        )
        VALUES
        (
            :EqpCod,
            :EqpDsc,
            :EqpPic,
            :EqpBlq,
            :EqpObs
        )
        ";

        $parameters = array(
            ':EqpCod' => $this->attEqpCod,
            ':EqpDsc' => $this->attEqpDsc,
            ':EqpPic' => $this->attEqpPic,
            ':EqpBlq' => $this->attEqpBlq,
            ':EqpObs' => $this->attEqpObs
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
            EqpDsc = :EqpDsc,
            EqpPic = :EqpPic,
            EqpBlq = :EqpBlq,
            EqpObs = :EqpObs
        WHERE
            EqpCod = :EqpCod
        ";

        $parameters = array(
            ':EqpCod' => $this->attEqpCod,
            ':EqpDsc' => $this->attEqpDsc,
            ':EqpPic' => $this->attEqpPic,
            ':EqpBlq' => $this->attEqpBlq,
            ':EqpObs' => $this->attEqpObs
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
            EqpCod = :EqpCod
        ";

        $parameters = array(
            ':EqpCod' => $this->attEqpCod
        );

        $stmt = $this->cnx->executeQuery($qry, $parameters);
        $rows = $stmt->rowCount();

        return boolval($rows);
    }

    // -- other -- //
    private function newid()
    {
        do {
            $this->attEqpCod = uniqid();
        } while(!$this->check_duplicate_key());
    }

    private function check_duplicate_key()
    {
        $qry = "
        SELECT
            EqpCod
        FROM
        " . $this->tbl . "
        WHERE
            EqpCod = :EqpCod
        ";

        $parameters = array(
            ":EqpCod" => $this->attEqpCod
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
        // EqpItm
        // WHERE
        //     EqpCod = :EqpCod
        // ";

        // $parameters = array(
        //     ':EqpCod' => $this->attEqpCod
        // );

        // $stmt = $this->cnx->executeQuery($qry, $parameters);
    }

    public function readLineWhithPicture()
    {
        $qry = "
        SELECT
            EqpCod,
            EqpDsc,
            EqpPic,
            EqpBlq,
            EqpObs,
            (select concat('/GEPI/', PicDir, PicSrc, '.', PicExt) from picture where PicCod = Equipment.EqpPic) as EqpPicSrc
        FROM
        " . $this->tbl . "
        WHERE
            EqpCod = :EqpCod
        ";

        $parameters = array(
            ":EqpCod" => $this->attEqpCod
        );

        $stmt = $this->cnx->executeQuery($qry, $parameters);
        $rows = $stmt->rowCount();

        if ($rows) {
            $this->data_row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->attEqpCod = $this->data_row['EqpCod'];
            $this->attEqpDsc = $this->data_row['EqpDsc'];
            $this->attEqpPic = $this->data_row['EqpPic'];
            $this->attEqpBlq = $this->data_row['EqpBlq'];
            $this->attEqpObs = $this->data_row['EqpObs'];
            $this->attEqpPicSrc = $this->data_row['EqpPicSrc'];
        }

        return boolval($rows);
    }

    public function Quantity()
    {
        $qry = "
        SELECT
            Count(EqpCod) as EqpQtd
        FROM
        " . $this->tbl . "
        WHERE
            EqpBlq = 'N'
        ";

        $stmt = $this->cnx->executeQuery($qry);
        $rows = $stmt->rowCount();
        $allLines = false;

        if ($rows) {
            $allLines = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $allLines;
    }
    
}
