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
class CUpisi {

    private $model;
    private $view;

    function __construct($model, $view) {
        $this->model = $model;
        $this->view = $view;
    }

    function view() { //upiši/ispiši/položeno
        if (!isset($this->model->student->email)) {
            echo "Nepostojeci Student";
        } else {
            if ($_SESSION['login'] == '1' || $_SESSION['student_id'] == $this->model->student_id) {
                $this->prikaziView();
            } elseif ($_SESSION['login'] == 2) {
                echo "nedozvoljen pristup <br/>";
                echo "<a href='./index.php?ctrl=upisi&action=view&student_id=" . $_SESSION['student_id'] . "'>svoj list</a>";
            } else {
                echo "nedozvoljen pristup <br/>";
                echo "<a href='./index.php?ctrl=korisnici&action=login' >Login</a>";
            }
        }
    }

    function prikaziView() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //print_r($_POST);
            $post = filter_input_array(INPUT_POST, ['polozeno' => FILTER_SANITIZE_STRING,
                'nije_polozeno' => FILTER_SANITIZE_STRING,
                'ispisi' => FILTER_SANITIZE_STRING,
                'upisi' => FILTER_SANITIZE_STRING]);
            if (isset($post['polozeno'])) {//promjeni u nepolozeno
                $this->model->upisi[$post['polozeno']]->promjeniStatus('enrolled');
            } elseif (isset($post['nije_polozeno'])) {//promjeni u polozeno
                $this->model->upisi[$post['nije_polozeno']]->promjeniStatus('passed');
            } elseif (isset($post['ispisi'])) {
                $this->model->upisi[$post['ispisi']]->ispisi();
                header('Location: ./index.php?ctrl=upisi&action=view&student_id=' . $this->model->student_id);
            } elseif (isset($post['upisi'])) {
                $noviupis = new Upis();
                $noviupis->upisi($this->model->student_id, $post['upisi']);
                header('Location: ./index.php?ctrl=upisi&action=view&student_id=' . $this->model->student_id);
            }
        }
        $this->view->prikazi($this->model);
    }

}
