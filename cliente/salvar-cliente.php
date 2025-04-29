<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include(__DIR__ . '/../config/connection.php');

$customer_name = $_POST['nome'];
$customer_email = $_POST['email'];
$customer_phone = $_POST['telefone'];


if (empty($customer_name) || empty($customer_email) || empty($customer_phone)) {
    $_SESSION['msg'] = '<span>Erro: O campo devem ser preenchidos corretamente.</span>';
    header("Location: criar-cliente.php");
    exit();
}

$query = "INSERT INTO clientes (nome, email, telefone, data_cadastro, ativo) VALUES
    ('$customer_name', '$customer_email', '$customer_phone', NOW(), 1)";
$result = mysqli_query($con, $query);

if (!$result) {
    $_SESSION['msg'] = '<span>Erro: Não foi possível salvar o cliente.</span>';
    header("Location: criar-cliente.php");
    exit();
} else {
    $_SESSION['msg'] = '<span>Cliente salvo com sucesso!</span>';
    header("Location: listar-clientes.php");
    exit();
}

?>