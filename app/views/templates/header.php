<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./bs/css/bootstrap.min.css" rel="stylesheet">
        <link href="./bs/css/jumbotron.css" rel="stylesheet">
        <title></title>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div >
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <div class="navbar-form navbar-left">
                        <?php if (isset($_SESSION['login']) && $_SESSION['login'] != 0) { ?>
                            <div class="form-group"><a  class="btn btn-success btn-md btn-block" href="./index.php?ctrl=korisnici&action=logout" >logout</a> </div>
                            <?php if ($_SESSION['login'] == 1) { ?>
                                <div class="form-group"> <a class="btn btn-success btn-md btn-block" href='./index.php?ctrl=predmeti&action=viewAll' >predmeti</a> </div>
                                <div class="form-group"> <a class="btn btn-success btn-md btn-block" href="./index.php?ctrl=korisnici&action=viewAll" >studenti</a> </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </nav>
        <div class="container">