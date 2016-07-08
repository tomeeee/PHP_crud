<?php

require_once 'predmeti.php';
require_once 'korisnici.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of upisi
 *
 * @author Tome
 */
class Upisi {

    public $upisi;
    public $student_id;
    public $student;
    private $index = 0;
    private $db;
    public $ostaliPredmeti;

    function __construct() {
        $this->init();
        $this->ostaliPredmeti = new Predmeti($this->student_id);
    }

    function init() {
        if (isset($_GET['student_id'])) {
            $get = filter_input(INPUT_GET, 'student_id', FILTER_VALIDATE_INT);
            $this->student_id = $get;
            $this->initStudent();
            if ($get == '-1') {
                $this->upisi[0] = new Upis();
                return;
            }
            $qstr = 'SELECT * FROM upisi WHERE student_id =' . $this->student_id;
        } else {
            $qstr = 'SELECT * FROM upisi'; //ne treba
        }
        $this->db = getDB();
        $stm = $this->db->query($qstr);
        $this->upisi = $stm->fetchAll(\PDO::FETCH_CLASS, "Upis", [$this->db]);
    }

    function initStudent() {
        $this->db = getDB();
        $qstr = 'SELECT * FROM korisnici WHERE role = "student" AND id =' . $this->student_id;
        $stm = $this->db->query($qstr);
        $obj = $stm->fetchAll(\PDO::FETCH_CLASS, "korisnik", [$this->db]);
        if (isset($obj[0])) {
            $this->student = $obj[0];
        }
    }

    public function next() {
        $this->index++;
    }

    public function current() {
        return $this->upisi[$this->index];
    }

    public function key() {
        return $this->index;
    }

    public function rewind() {
        $this->index = 0;
    }

    public function valid() {
        return 0 <= $this->index && $this->index < count($this->upisi);
    }

}

class Upis {

    public $student_id;
    public $predmet_id;
    public $status;
    public $predmet;

    function __construct() {
        if ($this->predmet_id != NULL) {
            $this->db = getDB();
            $qstr = 'SELECT * FROM predmeti WHERE id =' . $this->predmet_id;
            $stm = $this->db->query($qstr);
            // $stm->setFetchMode(PDO::FETCH_CLASS, 'Predmet'); 
            //$this->predmet = $stm->fetch();
            $this->predmet = $stm->fetchAll(\PDO::FETCH_CLASS, 'Predmet', [$this->db])[0];
        }
    }

    function promjeniStatus($status) {
        $this->status = $status;
        $db = getDB();
        // echo $status;
        $qstr = "UPDATE upisi SET status= :status WHERE student_id = :sid AND predmet_id = :pid";
        $stm = $db->prepare($qstr);
        return $stm->execute([ 'status' => $this->status, 'sid' => $this->student_id, 'pid' => $this->predmet_id]);
    }

    function upisi($student_id, $predmet_id) {
        $this->student_id = $student_id;
        $this->predmet_id = $predmet_id;
        $this->status = 'enrolled';
        $db = getDB();
        //var_dump($this);
        $qstr = "INSERT INTO upisi (student_id, predmet_id, status) VALUES (?, ?, ?)";
        $stm = $db->prepare($qstr);
        return $stm->execute([ $this->student_id, $this->predmet_id, $this->status]);
    }

    function ispisi() {//sredit
        $db = getDB();
        $qstr = "DELETE FROM upisi WHERE predmet_id = :pid AND student_id= :sid";
        $stm = $db->prepare($qstr);
        return $stm->execute([ 'pid' => $this->predmet_id, 'sid' => $this->student_id]);
    }

}
