<?php

namespace app\model;

use app\core\Database;
use app\shared\MessageDictionary;
use PDO;

class ReserveModel
{
    private $attRsvCod;
    private $attRsvDta;
    private $attRsvClb;
    private $attRsvBlq;
    private $attRsvApv;
    private $attRsvLck;
    private $attRsvClbLck;
    private $attRsvLckDta;

    // -- database -- //
    private $cnx;
    private $tbl = 'Reserve';

    private $csMessage;
    public $messages = array();
    public $data_row = array();

    public function __construct()
    {
        $this->cnx = new Database();
        $this->csMessage = new MessageDictionary;
    }

    // -- get -- //
    public function getRsvCod()
    {
        return $this->attRsvCod;
    }
    public function getRsvDta()
    {
        return $this->attRsvDta;
    }
    public function getRsvClb()
    {
        return $this->attRsvClb;
    }
    public function getRsvBlq()
    {
        return $this->attRsvBlq;
    }
    public function getRsvApv()
    {
        return $this->attRsvApv;
    }
    public function getRsvLck()
    {
        return $this->attRsvLck;
    }
    public function getRsvClbLck()
    {
        return $this->attRsvClbLck;
    }
    public function getRsvLckDta()
    {
        return $this->attRsvLckDta;
    }

    // -- set -- //
    public function setRsvCod($inRsvCod)
    {
        $this->attRsvCod = $inRsvCod;
    }
    public function setRsvDta($inRsvDta)
    {
        $this->attRsvDta = $inRsvDta;
    }
    public function setRsvClb($inRsvClb)
    {
        $this->attRsvClb = $inRsvClb;
    }
    public function setRsvBlq($inRsvBlq)
    {
        $this->attRsvBlq = $inRsvBlq;
    }
    public function setRsvApv($inRsvApv)
    {
        $this->attRsvApv = $inRsvApv;
    }
    public function setRsvLck($inRsvLck)
    {
        $this->attRsvLck = $inRsvLck;
    }
    public function setRsvClbLck($inRsvClbLck)
    {
        $this->attRsvClbLck = htmlspecialchars($inRsvClbLck);
    }
    public function setRsvLckDta($inRsvLckDta)
    {
        $this->attRsvLckDta = $inRsvLckDta;
    }

    // -- crud -- //
    public function readAllLines()
    {
        $qry = "
        SELECT
            RsvCod,
            RsvDta,
            RsvClb,
            RsvBlq,
            RsvApv,
            RsvLck,
            RsvClbLck,
            RsvLckDta 
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
            RsvCod,
            RsvDta,
            RsvClb,
            RsvBlq,
            RsvApv,
            RsvLck,
            RsvClbLck,
            RsvLckDta 
        FROM
        " . $this->tbl . "
        WHERE
            RsvCod = :RsvCod
        ";

        $parameters = array(
            ":RsvCod" => $this->attRsvCod
        );

        $stmt = $this->cnx->executeQuery($qry, $parameters);
        $rows = $stmt->rowCount();

        if ($rows) {
            $this->data_row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->attRsvDta = $this->data_row['attRsvDta'];
            $this->attRsvClb = $this->data_row['attRsvClb'];
            $this->attRsvBlq = $this->data_row['attRsvBlq'];
            $this->attRsvApv = $this->data_row['attRsvApv'];
            $this->attRsvLck = $this->data_row['attRsvLck'];
            $this->attRsvClbLck = $this->data_row['attRsvClbLck'];
            $this->attRsvLckDta = $this->data_row['attRsvLckDta'];
        }

        return boolval($rows);
    }

    public function insertLine()
    {
        if (empty($this->attRsvCod)) {
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
            RsvCod,
            RsvDta,
            RsvClb,
            RsvBlq,
            RsvApv,
            RsvLck,
            RsvClbLck,
            RsvLckDta 
        )
        VALUES
        (
            :RsvCod,
            :RsvDta,
            :RsvClb,
            :RsvBlq,
            :RsvApv,
            :RsvLck,
            :RsvClbLck,
            :RsvLckDta 
        )
        ";

        $parameters = array(
            ':RsvCod' => $this->attRsvCod,
            ':RsvDta' => $this->attRsvDta,
            ':RsvClb' => $this->attRsvClb,
            ':RsvBlq' => $this->attRsvBlq,
            ':RsvApv' => $this->attRsvApv,
            ':RsvLck' => $this->attRsvLck,
            ':RsvClbLck' => $this->attRsvClbLck,
            ':RsvLckDta' => $this->attRsvLckDta 
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
            RsvDta = :RsvDta,
            RsvClb = :RsvClb,
            RsvBlq = :RsvBlq,
            RsvApv = :RsvApv,
            RsvLck = :RsvLck,
            RsvClbLck = :RsvClbLck,
            RsvLckDta = :RsvLckDta 
        WHERE
            RsvCod = :RsvCod
        ";

        $parameters = array(
            ':RsvCod' => $this->attRsvCod,
            ':RsvDta' => $this->attRsvDta,
            ':RsvClb' => $this->attRsvClb,
            ':RsvBlq' => $this->attRsvBlq,
            ':RsvApv' => $this->attRsvApv,
            ':RsvLck' => $this->attRsvLck,
            ':RsvClbLck' => $this->attRsvClbLck,
            ':RsvLckDta' => $this->attRsvLckDta 
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
            RsvCod = :RsvCod
        ";

        $parameters = array(
            ':RsvCod' => $this->attRsvCod
        );

        $stmt = $this->cnx->executeQuery($qry, $parameters);
        $rows = $stmt->rowCount();

        return boolval($rows);
    }

    // -- other -- //
    private function newid()
    {
        do {
            $this->attRsvCod = uniqid();
        } while(!$this->check_duplicate_key());
    }

    private function check_duplicate_key()
    {
        $qry = "
        SELECT
            RsvCod
        FROM
        " . $this->tbl . "
        WHERE
            RsvCod = :RsvCod
        ";

        $parameters = array(
            ":RsvCod" => $this->attRsvCod
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
        // RsvItm
        // WHERE
        //     RsvCod = :RsvCod
        // ";

        // $parameters = array(
        //     ':RsvCod' => $this->attRsvCod
        // );

        // $stmt = $this->cnx->executeQuery($qry, $parameters);
    }
    
}
