<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include(__DIR__ . '/../config/connection.php');

$payment_method_description = $_POST['descricao'];


if (empty($payment_method_description)) {
    $_SESSION['msg'] = '<span>Erro: Os campos devem ser preenchidos corretamente.</span>';
    header("Location: criar-forma-pagamento.php");
    exit();
}

$query = "INSERT INTO forma_pagamento (descricao) VALUES
    ('$payment_method_description')";
$result = mysqli_query($con, $query);

if (!$result) {
    $_SESSION['msg'] = '<span>Erro: Não foi possível salvar a forma de pagamento.</span>';
    header("Location: criar-forma-pagamento.php");
    exit();
} else {
    $_SESSION['msg'] = '<span>Forma de pagamento salva com sucesso!</span>';
    header("Location: listar-formas-pagamento.php");
    exit();
}

?>