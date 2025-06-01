<?php
$host = "sql202.infinityfree.com";
$port = 3306;
$username = "if0_39135162";
$password = "XbbFBKQ8u1vIm";
$database = "rooms_reservations";

$db = new PDO("mysql:host=$host;port=$port",
               $username,
               $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec("use `$database`");
?>