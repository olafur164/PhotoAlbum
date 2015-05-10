<?php
include_once 'config.php';
$connection = new PDO("mysql:host=$server;dbname=$database", $user, $password);
?>