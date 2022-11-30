<?php

    /* Credentials for MySQL database.*/ 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "jeopardydb";

    try{
    /*connect to MySQL database*/ 
    $jeopdb = new mysqli($servername, $username, $password, $dbname);
    } catch (PDOException $e) {
        $error=$e->getMessage();
        echo '<p> database error, unable to connect: ' .$error;
        exit();
    }

?>