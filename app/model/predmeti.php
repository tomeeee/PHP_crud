<?php

class Predmeti implements \Iterator {

    public $predmeti;
    private $index = 0;
    private $db;

    function __construct($lista = 0) {
        if ($lista == 0) {
            $this->init();
        } else {
            $this->initUpisniList($lista);
        }
    }

    function init() {

        if (isset($_GET['id'])) {
            $get = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT);
            if ($get == '-1') {
                $this->predmeti[0] = new Predmet();
                return;
            }
            $qstr = 'SELECT * FROM predmeti WHERE id =' . $get;
        } else {
            $qstr = 'SELECT * FROM predmeti';
        }
        $this->db = getDB();
        $stm = $this->db->query($qstr);
        $this->predmeti = $stm->fetchAll(\PDO::FETCH_CLASS, "Predmet", [$this->db]);
    }

    function initUpisniList($lista) {
        $qstr = "SELECT * FROM predmeti
               WHERE (NOT EXISTS(
               SELECT * FROM upisi WHERE upisi.predmet_id=predmeti.id AND upisi.student_id=" . $lista . "))";
        $this->db = getDB();
        $stm = $this->db->query($qstr);
        $this->predmeti = $stm->fetchAll(\PDO::FETCH_CLASS, "Predmet", [$this->db]);
    }

    public function next() {
        $this->index++;
    }

    public function current() {
        return $this->predmeti[$this->index];
    }

    public function key() {
        return $this->index;
    }

    public function rewind() {
        $this->index = 0;
    }

    public function valid() {
        return 0 <= $this->index && $this->index < count($this->predmeti);
    }

}

class Predmet {

    public $id;
    public $ime;
    public $kod;
    public $program;
    public $bodovi;
    public $sem_redovni;
    public $sem_izvanredni;
    public $izborni;

    function __construct() {
        
    }

    function create($ime, $kod, $program, $bodovi, $sem_red, $sem_izv, $izb) {
        $this->ime = $ime;
        $this->kod = $kod;
        $this->program = $program;
        $this->bodovi = $bodovi;
        $this->sem_redovni = $sem_red;
        $this->sem_izvanredni = $sem_izv;
        $this->izborni = $izb;
        $db = getDB();
        //var_dump($this);
        $qstr = "INSERT INTO predmeti (ime, kod, program, bodovi, sem_redovni, sem_izvanredni, izborni) VALUES (?, ?, ?, ?, ?, ? ,?)";
        $stm = $db->prepare($qstr);
        return $stm->execute([ $this->ime, $this->kod, $this->program, $this->bodovi, $this->sem_redovni, $this->sem_izvanredni, $this->izborni]);
    }

    function update($ime, $kod, $program, $bodovi, $sem_red, $sem_izv, $izb) {
        $this->ime = $ime;
        $this->kod = $kod;
        $this->program = $program;
        $this->bodovi = $bodovi;
        $this->sem_redovni = $sem_red;
        $this->sem_izvanredni = $sem_izv;
        $this->izborni = $izb;
        $db = getDB();
        $qstr = "UPDATE predmeti SET ime= :ime ,kod= :kod ,program= :prog ,bodovi= :bod , sem_redovni= :sr , sem_izvanredni= :si ,izborni= :izb WHERE id = :id";
        $stm = $db->prepare($qstr);
        return $stm->execute([ 'id' => $this->id, 'ime' => $this->ime, 'kod' => $this->kod,
                    'prog' => $this->program, 'bod' => $this->bodovi, 'sr' => $this->sem_redovni, 'si' => $this->sem_izvanredni, 'izb' => $this->izborni]);
    }

    function delete() {
        $db = getDB();
        $qstr = "DELETE FROM predmeti WHERE id = :id";
        $stm = $db->prepare($qstr);
        return $stm->execute([ 'id' => $this->id]);
    }

}
