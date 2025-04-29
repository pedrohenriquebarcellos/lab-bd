<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include(__DIR__ . '/../config/connection.php');

$sales_name = $_POST['nome'];
$sales_cpf = $_POST['cpf'];
$sales_phone = $_POST['telefone'];


if (empty($sales_name) || empty($sales_cpf) || empty($sales_phone)) {
    $_SESSION['msg'] = '<span>Erro: Os campos devem ser preenchidos corretamente.</span>';
    header("Location: criar-cliente.php");
    exit();
}

$query = "INSERT INTO vendedores (nome, cpf, telefone) VALUES
    ('$sales_name', '$sales_cpf', '$sales_phone')";
$result = mysqli_query($con, $query);

if (!$result) {
    $_SESSION['msg'] = '<span>Erro: Não foi possível salvar o vendedor.</span>';
    header("Location: criar-vendedor.php");
    exit();
} else {
    $_SESSION['msg'] = '<span>Vendedor salvo com sucesso!</span>';
    header("Location: listar-vendedores.php");
    exit();
}

?>