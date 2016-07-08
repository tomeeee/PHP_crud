<?php

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
class VUpisi {

    private $header, $footer;

    function __construct() {
        $this->header = 'templates/header.php';
        $this->footer = 'templates/footer.php';
    }

    function prikazi(\Upisi $model) {//upiši/ispiši/položeno
        include $this->header;
        //var_dump($model->korisnici);
        //echo "<div style='float:left;position:relative;left:50%;'>";
        // echo '<div style="height:600px;width:400px;overflow:auto;float:left;position:relative;left:-50%;">';
        echo '<div class="panel panel-group row" >';
        $this->prikaziPredmete($model);
        
        $semestar = array();
        $status = 'sem_' . $model->student->status;
        foreach ($model->upisi as $key) {
            $semestar[$key->predmet->$status] = 1;
        }
        ksort($semestar);
        
        $this->prikaziUpisano($model,$semestar,$status);
        echo "</div>";
        include $this->footer;
    }

    function prikaziPredmete(\Upisi $model) {
        echo 'Predmeti:<br/><div class="panel panel-group col-sm-6" style="max-height: 300px;overflow-y: scroll;">';
        echo "<form method='POST'>";
        foreach ($model->ostaliPredmeti->predmeti as $op) {
            echo '<button class="btn btn-xs btn-info" type="submit" name="upisi" value="' . $op->id . '">Upisi</button>' . $op->ime ." ($op->kod)". "<br/>";
        }
        echo "</form>";
        echo "</div>";
        //echo "<div    style='float:left;position:relative;left:-50%;'>";
    }

    function prikaziUpisano(\Upisi $model,$semestar,$status) {
        echo '<div class="panel panel-group col-sm-6" >Upis (' . $model->student->email . "):<br/>";
        echo "<form method='POST'>";
        foreach ($semestar as $key => $value) {
            echo "Semestar " . $key . " :<br/>";
            foreach ($model->upisi as $kljuc => $value) {
                if ($value->predmet->$status == $key) {
                    if ($value->status == 'passed') {
                        echo '<button class="btn btn-xs btn-info" type="submit" name="polozeno" value="' . $kljuc . '"> Polozeno </button> ';
                    } else {
                        echo '<button class="btn btn-xs btn-info" type="submit" name="nije_polozeno" value="' . $kljuc . '">Nije polozeno</button><button class="btn btn-xs btn-info" type="submit" name="ispisi" value="' . $kljuc . '">Ispisi</button> ';
                    }
                    echo $value->predmet->ime ." (".$value->predmet->kod.")". "<br/>";
                }
            }
            echo "<br/>";
        }
        echo "</form>";
        echo "</div>";
    }

}
