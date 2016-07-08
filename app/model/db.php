<?php

    function getDB() {
        try {
            $db = new PDO('mysql:host=localhost;dbname=mentorski;charset=utf8', 'root', '');//;charset=utf8
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
        return $db;
    }


