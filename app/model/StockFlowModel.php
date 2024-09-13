<?php

namespace app\model;

use app\core\Database;
use app\shared\MessageDictionary;
use PDO;

class StockFlowModel
{
    private $attStkFlwCod;
    private $attStkFlwDca;
    private $attStkCod;
    private $attEqpCod;
    private $attStkFlwBlq;
    private $attStkFlwObs;
    private $attStkFlwAddClb;
    private $attStkFlwRmvClb;
    private $attStkFlwRsvCod;

    // -- database -- //
    private $cnx;
    private $tbl = 'StockFlow';

    private $csMessage;
    public $messages = array();
    public $data_row = array();

    public function __construct()
    {
        $this->cnx = new Database();
        $this->csMessage = new MessageDictionary;
    }

    // -- get -- //
    public function getStkFlwCod()
    {
        return $this->attStkFlwCod;
    }
    public function getStkFlwDca()
    {
        return $this->attStkFlwDca;
    }
    public function getStkCod()
    {
        return $this->attStkCod;
    }
    public function getEqpCod()
    {
        return $this->attEqpCod;
    }
    public function getStkFlwBlq()
    {
        return $this->attStkFlwBlq;
    }
    public function getStkFlwObs()
    {
        return $this->attStkFlwObs;
    }
    public function getStkFlwAddClb()
    {
        return $this->attStkFlwAddClb;
    }
    public function getStkFlwRmvClb()
    {
        return $this->attStkFlwRmvClb;
    }
    public function getStkFlwRsvCod()
    {
        return $this->attStkFlwRsvCod;
    }


    // -- set -- //
    public function setStkFlwCod($inStkFlwCod)
    {
        $this->attStkFlwCod = $inStkFlwCod;
    }
    public function setStkFlwDca($inStkFlwDca)
    {
        $this->attStkFlwDca = $inStkFlwDca;
    }
    public function setStkCod($inStkCod)
    {
        $this->attStkCod = $inStkCod;
    }
    public function setEqpCod($inEqpCod)
    {
        $this->attEqpCod = $inEqpCod;
    }
    public function setStkFlwBlq($inStkFlwBlq)
    {
        $this->attStkFlwBlq = $inStkFlwBlq;
    }
    public function setStkFlwObs($inStkFlwObs)
    {
        $this->attStkFlwObs = htmlspecialchars($inStkFlwObs);
    }
    public function setStkFlwAddClb($inStkFlwAddClb)
    {
        $this->attStkFlwAddClb = $inStkFlwAddClb;
    }
    public function setStkFlwRmvClb($inStkFlwRmvClb)
    {
        $this->attStkFlwRmvClb = $inStkFlwRmvClb;
    }
    public function setStkFlwRsvCod($inStkFlwRsvCod)
    {
        $this->attStkFlwRsvCod = $inStkFlwRsvCod;
    }

    // -- crud -- //
    public function readAllLines()
    {
        $qry = "
        SELECT
            StkFlwCod,
            StkFlwDca,
            StkCod,
            Equipment.EqpCod as EqpCod,
            Equipment.EqpDsc as EqpDsc,
            StkFlwBlq,
            StkFlwObs,
            StkFlwAddClb,
            StkFlwRmvClb,
            StkFlwRsvCod
        FROM
        " . $this->tbl . "
        INNER JOIN Equipment
        ON
            Equipment.EqpCod = StockFlow.EqpCod
        WHERE
            StkCod = :StkCod OR :StkCod = ''
        ";

        $parameters = array(
            ":StkCod" => $this->attStkCod
        );

        $stmt = $this->cnx->executeQuery($qry, $parameters);
        $rows = $stmt->rowCount();
        $allLines = false;

        if ($rows) {
            $allLines = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $allLines;
    }

    public function readLine()
    {
        if (empty($this->attStkFlwCod)) {
            $qry = "
            SELECT
                StkFlwCod,
                StkFlwDca,
                StkCod,
                EqpCod,
                StkFlwBlq,
                StkFlwObs,
                StkFlwAddClb,
                StkFlwRmvClb,
                StkFlwRsvCod
            FROM
            " . $this->tbl . "
            WHERE
                StkCod = :StkCod
            AND EqpCod = :EqpCod
            ";
        } else {
            $qry = "
            SELECT
                StkFlwCod,
                StkFlwDca,
                StkCod,
                EqpCod,
                StkFlwBlq,
                StkFlwObs,
                StkFlwAddClb,
                StkFlwRmvClb,
                StkFlwRsvCod
            FROM
            " . $this->tbl . "
            WHERE
                StkFlwCod = :StkFlwCod
            ";
        }


        $parameters = array(
            ":StkFlwCod" => $this->attStkFlwCod,
            ":StkCod" => $this->attStkCod,
            ":EqpCod" => $this->attEqpCod
        );

        $stmt = $this->cnx->executeQuery($qry, $parameters);
        $rows = $stmt->rowCount();

        if ($rows) {
            $this->data_row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->attStkFlwCod = $this->data_row['StkFlwCod'];
            $this->attStkFlwDca = $this->data_row['StkFlwDca'];
            $this->attStkCod = $this->data_row['StkCod'];
            $this->attEqpCod = $this->data_row['EqpCod'];
            $this->attStkFlwBlq = $this->data_row['StkFlwBlq'];
            $this->attStkFlwObs = $this->data_row['StkFlwObs'];
            $this->attStkFlwAddClb = $this->data_row['StkFlwAddClb'];
            $this->attStkFlwRmvClb = $this->data_row['StkFlwRmvClb'];
            $this->attStkFlwRsvCod = $this->data_row['StkFlwRsvCod'];
        }

        return boolval($rows);
    }

    public function insertLine()
    {
        if (empty($this->attStkFlwCod)) {
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
            StkFlwCod,
            StkFlwDca,
            StkCod,
            EqpCod,
            StkFlwBlq,
            StkFlwObs,
            StkFlwAddClb,
            StkFlwRmvClb,
            StkFlwRsvCod
        )
        VALUES
        (
            :StkFlwCod,
            :StkFlwDca,
            :StkCod,
            :EqpCod,
            :StkFlwBlq,
            :StkFlwObs,
            :StkFlwAddClb,
            :StkFlwRmvClb,
            :StkFlwRsvCod
        )
        ";

        $parameters = array(
            ':StkFlwCod' => $this->attStkFlwCod,
            ':StkFlwDca' => $this->attStkFlwDca,
            ':StkCod' => $this->attStkCod,
            ':EqpCod' => $this->attEqpCod,
            ':StkFlwBlq' => $this->attStkFlwBlq,
            ':StkFlwObs' => $this->attStkFlwObs,
            ':StkFlwAddClb' => $this->attStkFlwAddClb,
            ':StkFlwRmvClb' => $this->attStkFlwRmvClb,
            ':StkFlwRsvCod' => $this->attStkFlwRsvCod
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
            StkFlwDca = :StkFlwDca,
            StkCod = :StkCod,
            EqpCod = :EqpCod,
            StkFlwBlq = :StkFlwBlq,
            StkFlwObs = :StkFlwObs,
            StkFlwAddClb = :StkFlwAddClb,
            StkFlwRmvClb = :StkFlwRmvClb,
            StkFlwRsvCod = :StkFlwRsvCod
        WHERE
            StkFlwCod = :StkFlwCod
        ";

        $parameters = array(
            ':StkFlwCod' => $this->attStkFlwCod,
            ':StkFlwDca' => $this->attStkFlwDca,
            ':StkCod' => $this->attStkCod,
            ':EqpCod' => $this->attEqpCod,
            ':StkFlwBlq' => $this->attStkFlwBlq,
            ':StkFlwObs' => $this->attStkFlwObs,
            ':StkFlwAddClb' => $this->attStkFlwAddClb,
            ':StkFlwRmvClb' => $this->attStkFlwRmvClb,
            ':StkFlwRsvCod' => $this->attStkFlwRsvCod
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

        if (empty($this->attStkFlwCod)) {
            $qry = "
            DELETE FROM
            " . $this->tbl . "
            WHERE
                StkCod = :StkCod
            AND EqpCod = :EqpCod
            ";

            $parameters = array(
                ':StkCod' => $this->attStkCod,
                ':EqpCod' => $this->attEqpCod
            );
        } else {
            $qry = "
            DELETE FROM
            " . $this->tbl . "
            WHERE
                StkFlwCod = :StkFlwCod
            ";

            $parameters = array(
                ':StkFlwCod' => $this->attStkFlwCod
            );
        }

        $stmt = $this->cnx->executeQuery($qry, $parameters);
        $rows = $stmt->rowCount();

        return boolval($rows);
    }

    // -- other -- //
    private function newid()
    {
        do {
            $this->attStkFlwCod = uniqid();
        } while (!$this->check_duplicate_key());
    }

    private function check_duplicate_key()
    {
        $qry = "
        SELECT
            StkFlwCod
        FROM
        " . $this->tbl . "
        WHERE
            StkFlwCod = :StkFlwCod
        ";

        $parameters = array(
            ":StkFlwCod" => $this->attStkFlwCod
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
        // StkFlwItm
        // WHERE
        //     StkFlwCod = :StkFlwCod
        // ";

        // $parameters = array(
        //     ':StkFlwCod' => $this->attStkFlwCod
        // );

        // $stmt = $this->cnx->executeQuery($qry, $parameters);
    }

    public function EquipmentAvailable()
    {
        // hospedagem nao permitiu gerar view, utilizar query//
        // $qry = "
        // select 
        //     EqpCod,
        //     EqpDsc,
        //     EqpImgSrc
        // from
        //     ViewEquipmentAvailable
        // ";

        $qry = "
        select 
            Equipment.EqpCod as EqpCod,
            Equipment.EqpDsc as EqpDsc,
            (select concat(PicDir, PicSrc, '.', PicExt) from Picture where Picture.PicCod = Equipment.EqpPic) as EqpImgSrc
        from (
            select EqpCod from (
            (
                select EqpCod 
                from StockFlow 
                where StkFlwRsvCod = 0 
                and StkFlwBlq = 'S'
            ) union (
                select EqpCod 
                from Equipment 
                where EqpBlq = 'N'
            )
            ) as FilterEquipmentAvailable
            group by EqpCod
        ) as EquipmentAvailable
        inner join Equipment
        on Equipment.EqpCod = EquipmentAvailable.EqpCod
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
