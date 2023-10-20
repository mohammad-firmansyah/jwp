<?php
/**
 * using mysqli_connect for database connection
 */
 
$databaseHost = '127.0.0.1';
$databaseName = 'jwd';
$databaseUsername = 'root';
$databasePassword = '';
 
$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 
 
?>