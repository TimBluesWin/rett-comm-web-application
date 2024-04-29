<?php
    $databaseHost = 'localhost';
    $databaseName = 'rett-comm';
    $databaseUsername = 'root';
    $databasePassword = '';

    $con = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

    if (!$con)
    {
        die("Connection error: " . mysqli_connect_error());
    }