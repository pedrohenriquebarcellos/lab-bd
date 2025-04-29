<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include(__DIR__ . '/../config/connection.php');
$customerId = $_POST['clientes'];
$paymentMethodId= $_POST['forma_pagamento'];
$sellerId = $_POST['vendedores'];

$products = $_POST['produto_id'];
$qtys = $_POST['quantidade'];

if (
    empty($customerId) | 
    empty($paymentMethodId) | 
    empty($sellerId)
    empty($products)
) {
    $_SESSION['msg'] = '<span>Erro: Os campos devem ser preenchidos corretamente.</span>';
    header("Location: criar-pedido.php");
    exit();
}

mysqli_begin_transaction($con);

$query = "INSERT INTO pedidos(id_cliente, id_forma_pagamento, id_vendedor, data_pedido) VALUES
    ('$customerId', '$paymentMethodId', '$sellerId', NOW())";

mysqli_query($query, $con);

if (!$result) {
    $_SESSION['msg'] = '<span>Erro: Não foi possível salvar a forma de pagamento.</span>';
    header("Location: criar-forma-pagamento.php");
    exit();
} else {
    $id_pedido = mysqli_insert_id($con);

    foreach($products as $product) {
        $query_product = "INSERT INTO pedidos";
    }
}
?>