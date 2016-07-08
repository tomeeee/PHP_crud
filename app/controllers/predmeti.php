<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Predmeti
 *
 * @author Tome
 */
class CPredmeti {

    private $model;
    private $view;

    function __construct($model, $view) {
        $this->model = $model;
        $this->view = $view;
    }

    function viewAll() {
        $this->view->prikaziSve($this->model);
    }

    function detalji() {
        $this->view->detalji($this->model->predmeti[0]);
    }

    function edit() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //print_r($_POST);
            if (isset($_POST['spremi'])) {
                $post = filter_var_array($_POST, FILTER_SANITIZE_STRING);
                $this->model->predmeti[0]->update($post['ime'], $post['kod'], $post['program'], $post['bodovi'], $post['sem_red'], $post['sem_izv'], $post['izborni']);
            } elseif (isset($_POST['brisi'])) {
                $this->model->predmeti[0]->delete();
                header('Location: ./index.php?ctrl=predmeti&action=viewAll');
            }
        }
        $this->view->edit($this->model->predmeti[0]);
    }

    function novi() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //print_r($_POST);
            if (isset($_POST['spremi'])) {
                $post = filter_var_array($_POST, FILTER_SANITIZE_STRING);
                $this->model->predmeti[0]->create($post['ime'], $post['kod'], $post['program'], $post['bodovi'], $post['sem_red'], $post['sem_izv'], $post['izborni']);
            } elseif (isset($_POST['brisi'])) {
                header('Location: ./index.php?ctrl=predmeti&action=viewAll');
            }
        }
        $this->view->edit($this->model->predmeti[0]);
    }

}
