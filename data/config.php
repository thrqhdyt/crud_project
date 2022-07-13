<?php

/*** gunakan mysqli_connect untuk membuat koneksi ke database*/
$databaseHost = 'localhost';
$databaseName = 'db_bus';
$databaseUsername = 'root';
$databasePassword = '';

$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);