<?php

namespace app\model;

use app\core\Database;
use app\shared\MessageDictionary;
use PDO;

class PictureModel
{
    private $attPicCod;
    private $attPicNme;
    private $attPicSrc;
    private $attPicDir;
    private $attPicExt;
    private $attPicSze;

    // -- database -- //
    private $cnx;
    private $tbl = 'Picture';

    private $csMessage;
    public $messages = array();
    public $data_row = array();

    public function __construct()
    {
        $this->cnx = new Database();
        $this->csMessage = new MessageDictionary;
    }

    // -- get -- //
    public function getPicCod()
    {
        return $this->attPicCod;
    }
    public function getPicNme()
    {
        return $this->attPicNme;
    }
    public function getPicSrc()
    {
        return $this->attPicSrc;
    }
    public function getPicDir()
    {
        return $this->attPicDir;
    }
    public function getPicExt()
    {
        return $this->attPicExt;
    }
    public function getPicSze()
    {
        return $this->attPicSze;
    }

    // -- set -- //
    public function setPicCod($inPicCod)
    {
        $this->attPicCod = $inPicCod;
    }
    public function setPicNme($inPicNme)
    {
        $this->attPicNme = htmlspecialchars($inPicNme);
    }
    public function setPicSrc($inPicSrc)
    {
        $this->attPicSrc = htmlspecialchars($inPicSrc);
    }
    public function setPicDir($inPicDir)
    {
        $this->attPicDir = htmlspecialchars($inPicDir);
    }
    public function setPicExt($inPicExt)
    {
        $this->attPicExt = htmlspecialchars($inPicExt);
    }
    public function setPicSze($inPicSze)
    {
        $this->attPicSze = $inPicSze;
    }

    // -- crud -- //
    public function readAllLines()
    {
        $qry = "
        SELECT
            PicCod,
            PicNme,
            PicSrc,
            PicDir,
            PicExt,
            PicSze
        FROM
        " . $this->tbl . "
        WHERE
            PicCod = :PicCod
        ";

        $parameters = array(
            ":PicCod" => $this->attPicCod
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
        $qry = "
        SELECT
            PicCod,
            PicNme,
            PicSrc,
            PicDir,
            PicExt,
            PicSze
        FROM
        " . $this->tbl . "
        WHERE
            PicCod = :PicCod
        ";

        $parameters = array(
            ":PicCod" => $this->attPicCod
        );

        $stmt = $this->cnx->executeQuery($qry, $parameters);
        $rows = $stmt->rowCount();

        if ($rows) {
            $this->data_row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->attPicCod = $this->data_row['PicCod'];
            $this->attPicNme = $this->data_row['PicNme'];
            $this->attPicSrc = $this->data_row['PicSrc'];
            $this->attPicDir = $this->data_row['PicDir'];
            $this->attPicExt = $this->data_row['PicExt'];
            $this->attPicSze = $this->data_row['PicSze'];
        }

        return boolval($rows);
    }

    public function insertLine()
    {
        if (empty($this->attPicCod)) {
            $this->newid();
        } else {
            if (!$this->check_duplicate_key()) {
                return FALSE;
            }
        }

        $qry = "
        INSERT INTO
        " . $this->tbl . "
        (
            PicCod,
            PicNme,
            PicSrc,
            PicDir,
            PicExt,
            PicSze
        )
        VALUES
        (
            :PicCod,
            :PicNme,
            :PicSrc,
            :PicDir,
            :PicExt,
            :PicSze
        )
        ";

        $parameters = array(
            ':PicCod' => $this->attPicCod,
            ':PicNme' => $this->attPicNme,
            ':PicSrc' => $this->attPicSrc,
            ':PicDir' => $this->attPicDir,
            ':PicExt' => $this->attPicExt,
            ':PicSze' => $this->attPicSze
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
            PicNme = :PicNme,
            PicSrc = :PicSrc,
            PicDir = :PicDir,
            PicExt = :PicExt,
            PicSze = :PicSze
        WHERE
            PicCod = :PicCod
        ";

        $parameters = array(
            ':PicCod' => $this->attPicCod,
            ':PicNme' => $this->attPicNme,
            ':PicSrc' => $this->attPicSrc,
            ':PicDir' => $this->attPicDir,
            ':PicExt' => $this->attPicExt,
            ':PicSze' => $this->attPicSze
        );

        $stmt = $this->cnx->executeQuery($qry, $parameters);
        $rows = $stmt->rowCount();

        return boolval($rows);
    }

    public function deleteLine()
    {
        if (!$this->check_referencial_key()) {
            return FALSE;
        }

        $qry = "
        DELETE FROM
        " . $this->tbl . "
        WHERE
            PicCod = :PicCod
        ";

        $parameters = array(
            ':PicCod' => $this->attPicCod
        );

        $stmt = $this->cnx->executeQuery($qry, $parameters);
        $rows = $stmt->rowCount();

        return boolval($rows);
    }

    // -- other -- //
    private function newid()
    {
        do {
            $this->attPicCod = uniqid();
        } while(!$this->check_duplicate_key());
    }

    private function check_duplicate_key()
    {
        $qry = "
        SELECT
            PicNme
        FROM
        " . $this->tbl . "
        WHERE
            PicCod = :PicCod
        ";

        $parameters = array(
            ":PicCod" => $this->attPicCod
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
}
