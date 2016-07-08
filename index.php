<?php

session_start();
$ctrl = array('korisnici', 'predmeti', 'upisi');
$action = array('login', 'logout', 'viewAll', 'detalji', 'edit', 'novi', 'view');
$studentCtrl = array('upisi', 'korisnici');
$studentAction = array('view', 'login', 'logout',);
if (isset($_GET['ctrl']) && isset($_GET['action']) && in_array($_GET['ctrl'], $ctrl) && in_array($_GET['action'], $action)) {
    $ctrl_name = $_GET['ctrl'];
    $action_name = $_GET['action'];
    require_once("app/model/db.php");
    require_once 'app/model/' . $ctrl_name . '.php';
    require_once 'app/views/' . $ctrl_name . '.php';
    require_once 'app/controllers/' . $ctrl_name . '.php';

    if (in_array($ctrl_name, $studentCtrl) && in_array($action_name, $studentAction) && isset($_SESSION['login']) && $_SESSION['login'] == 2 || isset($_SESSION['login']) && $_SESSION['login'] == 1 || $action_name == 'login') {
        $model_class = ucfirst($ctrl_name);
        $view_class = 'V' . ucfirst($ctrl_name);
        $ctrl_class = 'C' . ucfirst($ctrl_name);

        $model = new $model_class();
        $view = new $view_class();
        $ctrl = new $ctrl_class($model, $view);
        $ctrl->$action_name();
    } elseif ($_SESSION['login'] == 2) {
        echo "nedozvoljen pristup <br/>";
        echo "<a href='./index.php?ctrl=upisi&action=view&student_id=" . $_SESSION['student_id'] . "'>svoj list</a>";
    } else {
        echo "nedozvoljen pristup <br/>";
        echo "<a href='./index.php?ctrl=korisnici&action=login' >Login</a>";
    }
} else {
    header('Location: ./index.php?ctrl=korisnici&action=login');
}
/* 
http://localhost/Projekt_Tome/index.php?ctrl=predmeti&action=detalji&id=1
http://localhost/Projekt_Tome/index.php?ctrl=predmeti&action=edit&id=3
http://localhost/Projekt_Tome/index.php?ctrl=upisi&action=view&student_id=2
http://localhost/Projekt_Tome/index.php?ctrl=korisnici&action=viewAll
 
*/