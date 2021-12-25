<?php
    $host = "localhost";
    $username = "root";
    $password = "toor";
    $db_name = "petcarebusiness";

    $connect = mysqli_connect($host, $username, $password, $db_name);

    if(!$connect) {
        die("Cannot connect to database");
    }
?>