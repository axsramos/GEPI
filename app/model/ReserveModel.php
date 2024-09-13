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
    private $attRsvEqpCod;
    private $attEqpCod;
    private $attEqpDsc;

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
    public function getRsvEqpCod()
    {
        return $this->attRsvEqpCod;
    }
    public function getEqpCod()
    {
        return $this->attEqpCod;
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
        $this->attRsvClbLck = $inRsvClbLck;
    }
    public function setRsvLckDta($inRsvLckDta)
    {
        $this->attRsvLckDta = $inRsvLckDta;
    }
    public function setRsvEqpCod($inRsvEqpCod)
    {
        $this->attRsvEqpCod = $inRsvEqpCod;
    }
    public function setEqpCod($inEqpCod)
    {
        $this->attEqpCod = $inEqpCod;
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
            (select Collaborator.ClbNme from Collaborator where Collaborator.ClbCod = Reserve.RsvClb) as RsvClbNme,
            RsvBlq,
            RsvApv,
            RsvLck,
            RsvClbLck,
            (select Collaborator.ClbNme from Collaborator where Collaborator.ClbCod = Reserve.RsvClbLck) as RsvClbLckNme,
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

            $this->attRsvDta = $this->data_row['RsvDta'];
            $this->attRsvClb = $this->data_row['RsvClb'];
            $this->attRsvBlq = $this->data_row['RsvBlq'];
            $this->attRsvApv = $this->data_row['RsvApv'];
            $this->attRsvLck = $this->data_row['RsvLck'];
            $this->attRsvClbLck = $this->data_row['RsvClbLck'];
            $this->attRsvLckDta = $this->data_row['RsvLckDta'];
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
        } while (!$this->check_duplicate_key());
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

    public function readAllLinesEquipments()
    {
        $qry = "
        SELECT
            RsvEqpCod,
            RsvCod,
            EqpCod,
            (select Equipment.EqpDsc from Equipment where Equipment.EqpCod = ReserveEquipment.EqpCod) as EqpDsc
        FROM
            ReserveEquipment
        WHERE
            RsvCod = :RsvCod
        ";

        $parameters = array(
            ":RsvCod" => $this->attRsvCod
        );

        $stmt = $this->cnx->executeQuery($qry, $parameters);
        $rows = $stmt->rowCount();
        $allLines = false;

        if ($rows) {
            $allLines = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $allLines;
    }

    public function addOrRemoveEquipment()
    {
        $qry = "
        SELECT
            RsvEqpCod,
            RsvCod,
            EqpCod
        FROM
            ReserveEquipment
        WHERE
            RsvCod = :RsvCod
        AND EqpCod = :EqpCod
        ";

        $parameters = array(
            ":RsvCod" => $this->attRsvCod,
            ":EqpCod" => $this->attEqpCod
        );

        $stmt = $this->cnx->executeQuery($qry, $parameters);
        $rows = $stmt->rowCount();

        if ($rows) {
            $this->data_row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->attRsvEqpCod = $this->data_row['RsvEqpCod'];
            $this->attRsvCod = $this->data_row['RsvCod'];
            $this->attEqpCod = $this->data_row['EqpCod'];
        }

        if ($rows) {
            
            $qry = "
            DELETE FROM
                ReservEequipment
            WHERE
                RsvEqpCod = :RsvEqpCod
            ";

            $parameters = array(
                ":RsvEqpCod" => $this->attRsvEqpCod
            );

            $stmt = $this->cnx->executeQuery($qry, $parameters);
            $rows = $stmt->rowCount();
        } else {
            $qry = "
            INSERT INTO
                ReservEequipment
            (
                RsvEqpCod,
                RsvCod,
                EqpCod
            )
            VALUES
            (
                :RsvEqpCod,
                :RsvCod,
                :EqpCod
            )
            ";

            $this->setRsvEqpCod(uniqid());

            $parameters = array(
                ':RsvEqpCod' => $this->attRsvEqpCod,
                ':RsvCod' => $this->attRsvCod,
                ':EqpCod' => $this->attEqpCod
            );
            
            $stmt = $this->cnx->executeQuery($qry, $parameters);
            $rows = $stmt->rowCount();
        }

        return boolval($rows);
    }

    public function readAllLinesApproved() 
    {
        $qry = "
        SELECT
            RsvCod,
            RsvDta,
            RsvClb,
            (select Collaborator.ClbNme from Collaborator where Collaborator.ClbCod = Reserve.RsvClb) as RsvClbNme,
            RsvBlq,
            RsvApv,
            RsvLck,
            RsvClbLck,
            RsvLckDta,
            (select count(ReserveEquipment.EqpCod) from ReserveEquipment where ReserveEquipment.RsvCod = Reserve.RsvCod) as RsvEqpQtd 
        FROM
        " . $this->tbl . "
        WHERE
            RsvBlq = 'N'
        AND RsvLck = 'N'
        AND RsvDta >= now()
        AND RsvApv = 'S'
        ";
        
        $stmt = $this->cnx->executeQuery($qry);
        $rows = $stmt->rowCount();
        $allLines = false;

        if ($rows) {
            $allLines = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $allLines;
    }

    public function QuantityApproved()
    {
        $qry = "
        SELECT
            Count(RsvCod) as RsvQtdApv
        FROM
        " . $this->tbl . "
        WHERE
            RsvBlq = 'N'
        AND RsvLck = 'N'
        AND RsvApv = 'S'
        ";

        $stmt = $this->cnx->executeQuery($qry);
        $rows = $stmt->rowCount();
        $allLines = false;

        if ($rows) {
            $allLines = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $allLines;
    }

    public function QuantityLocked()
    {
        $qry = "
        SELECT
            Count(RsvCod) as RsvQtdLck
        FROM
        " . $this->tbl . "
        WHERE
            RsvBlq = 'N'
        AND RsvLck = 'S'
        AND RsvApv = 'S'
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
