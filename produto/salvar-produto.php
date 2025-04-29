<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include(__DIR__ . '/../config/connection.php');

$product_name = $_POST['product_name'];
$product_description = $_POST['product_description'];
$product_price = floatval($_POST['product_price']);
$product_stock = $_POST['product_stock'];

if (!is_numeric($product_stock)) {
    $_SESSION['msg'] = '<span>Erro: O campo estoque deve ser um número válido.</span>';
    header("Location: criar-produto.php");
    exit();
}

$query = "INSERT INTO produtos (nome, descricao, preco_unit, quantidade_estoque) VALUES
    ('$product_name', '$product_description', '$product_price' ,'$product_stock')";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Erro ao executar a query: " . mysqli_error($con));
}

if (mysqli_insert_id($con)) {
    $_SESSION['msg'] = '<span>Produto cadastrado com sucesso</span>';
    header("Location: listar-produtos.php");
    exit();
} else {
    $_SESSION['msg'] = '<span>Não foi possível cadastrar o produto</span>';
    header("Location: criar-produto.php");
    exit();
}
?>