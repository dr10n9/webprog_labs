<?php
$host = "127.0.0.1";
$port = 3306;
$username = "username";
$password = "password";
$database = "web_lab";

$db = new PDO("mysql:host=$host;port=$port",
               $username,
               $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec("use `$database`");
?>