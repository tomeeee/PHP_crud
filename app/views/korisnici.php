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
class VKorisnici {

    private $header, $footer;

    function __construct() {
        $this->header = 'templates/header.php';
        $this->footer = 'templates/footer.php';
    }

    function prikaziSve(\Korisnici $model) {
        include $this->header;
        //var_dump($model->korisnici);
        echo "Lista studenata:<br/>";
        echo '<div class="panel panel-default"><table class="table table-striped">';
        foreach ($model->korisnici as $key) {
            if ($key->role == 'student') {
                echo "<tr><td><a href='./index.php?ctrl=upisi&action=view&student_id=" . $key->id . "'>" . $key->email . "</a></td></tr>";
            }
        }
        echo "</table></div>";
        include $this->footer;
    }

    function login() {
        include $this->header;
        ?>
        <div class="panel panel-default" style="max-width: 300px;">   
            <form method="POST">
                <table class="table">
                    <tr><td> E-mail:</td><td> <input class="form-control" type="email" name="email" value="" required/></td></tr>
                    <tr><td>Sifra:</td><td> <input class="form-control" type="password" name="sifra" value="" required/></td></tr>
                    <tr><td colspan="2"><input class="btn btn-success" type="submit" name="login" value="Login" /></td></tr>
                </table> 
            </form>
        </div>
        <div class="panel panel-group" style="max-width: 300px;"> <button class="btn btn-success" onclick="prikazi();">Registracija</button>

            <?php
            $this->registracija();
            include $this->footer;
        }

        function registracija() {
            ?>
            <div id="reg" style="display:none">
                <form method="POST">
                    E-mail:<input class="form-control" type="email" name="email" value="" required/><br>
                    Sifra: <input class="form-control" type="password" name="sifra1" value="" required/><br>
                    Sifra: <input class="form-control" type="password" name="sifra2" value="" required/><br>
                    Status:<select class="form-control" name="status">
                        <option value="redovni">Redovni</option>
                        <option value="izvanredni">Izvanredni</option>
                    </select>
                    <input class="btn btn-success" type="submit" name="reg" value="Registriraj" /><br>
                </form>
            </div>  </div> 
            <script>
                function prikazi() {
                    document.getElementById("reg").style.display = "initial";
                }
            </script>
            <?php
        }

    }
    