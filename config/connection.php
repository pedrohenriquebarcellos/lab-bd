<?php
$server = 'localhost';
$user = 'user';
/* Conexão local com Docker*/
$password = 'root';
/* Conexão na faculdade com XAMP*/
//$password = '';
$db = 'lab-bd';

$con = mysqli_connect($server, $user, $password, $db);

if (!$con) {
    print("Could not connect to MySQL");
    print("Error: " . mysqli_connect_error());
    exit;
} else {
    echo "Connect successfully!";
}
?>