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
class CKorisnici {

    private $model;
    private $view;

    function __construct($model, $view) {
        $this->model = $model;
        $this->view = $view;
    }

    function viewAll() {
        $this->view->prikaziSve($this->model);
    }

    function vecUlogiran() {
        if (isset($_SESSION['login']) && $_SESSION['login'] == '1') {//vec ulogiran
            header('Location: ./index.php?ctrl=predmeti&action=viewAll');
        } elseif (isset($_SESSION['student_id']) && $_SESSION['student_id'] != '-1') {
            header('Location: ./index.php?ctrl=upisi&action=view&student_id=' . $_SESSION['student_id']);
        }
    }

    function login() {//http://localhost/Projekt_Tome/index.php?ctrl=korisnici&action=login
        $this->vecUlogiran();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //print_r($_POST);
            if (isset($_POST['login'])) {
                $post = filter_input_array(INPUT_POST, ['email' => FILTER_SANITIZE_EMAIL, 'sifra' => FILTER_SANITIZE_STRING]);
                $user = (new Korisnik())->provjeriSifru($post['email'], $post['sifra']);
                if ($user != null) {
                    //var_dump($user);
                    if ($user->role == 'mentor') {
                        $_SESSION['login'] = 1;
                        header('Location: ./index.php?ctrl=predmeti&action=viewAll');
                    } else {
                        $_SESSION['login'] = 2;
                        $_SESSION['student_id'] = $user->id;
                        header('Location: ./index.php?ctrl=upisi&action=view&student_id=' . $user->id);
                    }
                }
            }
            // header('Location: ./index.php?ctrl=predmeti&action=viewAll');
            $this->regPOST();
        }
        $this->view->login();
    }

    function logout() {
        $_SESSION['login'] = 0;
        if (isset($_SESSION['student_id'])) {
            $_SESSION['student_id'] = -1;
        }
        header('Location: ./index.php?ctrl=korisnici&action=login');
    }

    function regPOST() {
        if (!empty($_POST['email']) && !empty($_POST['sifra1']) && isset($_POST['reg'])) {
            if ($_POST['sifra1'] == $_POST['sifra2']) {
                $post = filter_input_array(INPUT_POST, ['email' => FILTER_SANITIZE_EMAIL, 'sifra1' => FILTER_SANITIZE_STRING, 'status' => FILTER_SANITIZE_STRING]);
                $user = (new Korisnik())->byEmail($post['email']);
                if ($user != NULL) {
                    echo "email vec postoji";
                } else {
                    $user = new Korisnik();
                    $user->create($post['email'], $post['sifra1'], 'student', $post['status']); //$email, $pass, $role, $status
                    echo "registriran";
                    $_SESSION['login'] = 2;
                    $_SESSION['student_id'] = $user->id;
                    //print_r($_SESSION);
                    header('Location: ./index.php?ctrl=upisi&action=view&student_id=' . $_SESSION['student_id']);
                }
            } else
                echo "sifre nisu iste";
        }
    }

}
