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
class VPredmeti {

    private $header, $footer;

    function __construct() {
        $this->header = 'templates/header.php';
        $this->footer = 'templates/footer.php';
    }

    function prikaziSve(\Predmeti $model) {
        include $this->header;
        // include 'templates/list.php';
        //var_dump($model->predmeti);
        echo '<div class="panel panel-default">';
        echo '<table class="table table-striped">';
        echo "<tr><td><a class='btn btn-info' href='./index.php?ctrl=predmeti&action=novi&id=-1'>Novi</a><br/></td></tr>";
        foreach ($model->predmeti as $key) {
            echo '<tr><td>';
            echo $key->ime . " (" . $key->kod . ") <a href='./index.php?ctrl=predmeti&action=detalji&id=" . $key->id . "'>Detalji</a>" . " | " . "<a href='./index.php?ctrl=predmeti&action=edit&id=" . $key->id . "'>Edit</a><br/>";
            echo '</td></tr>';
        }
        echo '</table>';
        echo "</div>";
        include $this->footer;
    }

    function detalji(\Predmet $predmet) {
        //var_dump($predmet);
        include $this->header;
        echo '<div class="panel panel-default" style="max-width: 400px;">';
        echo '<table class="table table-striped">';
        echo "<tr><td colspan='2'><a class='btn btn-info' href='./index.php?ctrl=predmeti&action=viewAll'>Natrag</a><br/></td></tr>";
        echo "<td>Ime:</td><td>" . $predmet->ime
        . "</td></tr><tr><td>Kod:</td><td>" . $predmet->kod
        . "</td></tr><tr><td>Program:</td><td>" . $predmet->program
        . "</td></tr><tr><td>Bodovi:</td><td>" . $predmet->bodovi
        . "</td></tr><tr><td>Semestar red:</td><td>" . $predmet->sem_redovni
        . "</td></tr><tr><td>Semestar izv:</td><td>" . $predmet->sem_izvanredni
        . "</td></tr><tr><td>Izborni:</td><td>" . $predmet->izborni;
        echo "</td></tr></table>";
        echo "<div>";
        include $this->footer;
    }

    function edit(\Predmet $predmet) {
        include $this->header;
        ?>
        <div class="panel panel-default" style="max-width: 400px;">   
            <form method="POST">
                <table class="table table-striped">
                    <tr><td colspan="2"><a class='btn btn-info' href='./index.php?ctrl=predmeti&action=viewAll'>Natrag</a><br/></td></tr>
                    <tr> <td>Ime:</td><td><input class="form-control" type="text" name="ime" value="<?= $predmet->ime ?>"/>
                        </td></tr><tr><td>Kod:</td><td><input class="form-control" type="text" name="kod" value="<?= $predmet->kod ?>"/>
                        </td></tr><tr><td>Program:</td><td><input class="form-control" type="text" name="program" value="<?= $predmet->program ?>"/>
                        </td></tr><tr><td>Bodovi:</td><td><input class="form-control" type="number" name="bodovi" value="<?= $predmet->bodovi ?>"/>
                        </td></tr><tr><td>Semestar red:</td><td><input class="form-control" type="number" name="sem_red" value="<?= $predmet->sem_redovni ?>"/>
                        </td></tr><tr><td>Semestar izv:</td><td><input class="form-control" type="number" name="sem_izv" value="<?= $predmet->sem_izvanredni ?>"/>
                     </td></tr><tr><td>Izborni:</td><td><!--  <input class="form-control" style="width: 50px;" type="text"  value="<?= $predmet->izborni ?>" disabled = "disabled"/>-->
                            <select name="izborni" class="form-control"> 
                                <option value="<?= $predmet->izborni ?>"><?= $predmet->izborni ?></option>
                                <option value="da">Da</option>
                                <option value="ne">Ne</option>
                            </select>
                        </td></tr>
                    <tr><td><input class="btn btn-primary" type="submit" name="spremi" value="spremi" /></td><td><input class="btn btn-danger" type="submit" name="brisi" value="brisi" /></td></tr>
                </table>
            </form>
        </div>
        <?php
        include $this->footer;
    }

}
