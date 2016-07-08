<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of korisnici
 *
 * @author Tome
 */
class Korisnici implements \Iterator {

    public $korisnici;
    private $index = 0;
    private $db;

    function __construct($login = 0) {
        //if (login == 0) {
            $this->init();
        //}
    }

    function init() {
        if (isset($_GET['id'])) {//dovrsit
            $get = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if ($get == '-1') {
                $this->korisnici[0] = new Korisnik();
                return;
            }
            $qstr = 'SELECT * FROM korisnici WHERE id =' . $get;
        } else {
            $qstr = 'SELECT * FROM korisnici';
        }
        $this->db = getDB();
        $stm = $this->db->query($qstr);
        $this->korisnici = $stm->fetchAll(\PDO::FETCH_CLASS, "Korisnik", [$this->db]);
    }

    public function next() {
        $this->index++;
    }

    public function current() {
        return $this->korisnici[$this->index];
    }

    public function key() {
        return $this->index;
    }

    public function rewind() {
        $this->index = 0;
    }

    public function valid() {
        return 0 <= $this->index && $this->index < count($this->korisnici);
    }

}

class Korisnik {

    public $id;
    public $email;
    public $password;
    public $role;
    public $status;

    function __construct() {
        
    }

    function create($email, $pass, $role, $status) {
        $this->email = $email;
        $this->password = password_hash($pass, PASSWORD_DEFAULT);
        $this->role = $role;
        $this->status = $status;
        $db = getDB();
        //var_dump($this);
        $qstr = "INSERT INTO korisnici (email, password,role,status) VALUES (?, ?, ?, ?)";
        $stm = $db->prepare($qstr);
        $stm->execute([ $this->email, $this->password, $this->role, $this->status]);
        $this->id=$db->lastInsertId();
    }

    function delete() {
        $db = getDB();
        $qstr = "DELETE FROM korisnici WHERE id = :id";
        $stm = $db->prepare($qstr);
        return $stm->execute([ 'id' => $this->id]);
    }
    function byEmail($email){
        $this->db = getDB();
        $qstr = "SELECT * FROM korisnici WHERE email ='" . $email . "'";
        $stm = $this->db->query($qstr);
        $obj=$stm->fetchAll(\PDO::FETCH_CLASS, "Korisnik", [$this->db]);
        if(isset($obj[0])){
            return $obj[0];
        }
        return NULL;
    }
    
    function provjeriSifru($email, $sifra) {
        $obj =  $this->byEmail($email);
        // var_dump($obj);
        if (isset($obj) && password_verify($sifra, $obj->password)) {
            echo "tocno";
            return $obj;
        } else {
            echo "krivi unos | " . $email . " | ";
        }
    }

}
