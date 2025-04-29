<?php
/* Conexão na faculdade com XAMP */
//$server = 'localhost';
/* Conexão local com Docker */
$server = '127.0.0.1';    
$user = 'user';
/* Conexão local com Docker*/
$password = 'password123';
/* Conexão na faculdade com XAMP*/
//$password = '';
$db = 'lab-bd';

$con = mysqli_connect($server, $user, $password, $db);

if (!$con) {
    print("Could not connect to MySQL");
    print("Error: " . mysqli_connect_error());
    exit;
} else {}
?>