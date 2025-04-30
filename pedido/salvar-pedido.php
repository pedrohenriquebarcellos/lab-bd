<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include(__DIR__ . '/../config/connection.php');

$customerId = $_POST['clientes'];
$paymentMethodId = $_POST['forma_pagamento'];
$sellerId = $_POST['vendedores'];

$products = $_POST['produto_id'];
$qtys = $_POST['quantidade'];

if (
    empty($customerId) ||
    empty($paymentMethodId) ||
    empty($sellerId) ||
    empty($products)
) {
    $_SESSION['msg'] = '<span>Erro: Os campos devem ser preenchidos corretamente.</span>';
    header("Location: criar-pedido.php");
    exit();
}

mysqli_begin_transaction($con);

$totalPedido = 0.0;

foreach ($products as $index => $productId) {
    $quantity = isset($qtys[$index]) ? (int)$qtys[$index] : 1;

    $stmt_estoque = mysqli_prepare($con, "SELECT quantidade_estoque FROM produtos WHERE id_produtos = ?");
    mysqli_stmt_bind_param($stmt_estoque, 'i', $productId);
    mysqli_stmt_execute($stmt_estoque);
    mysqli_stmt_bind_result($stmt_estoque, $quantidadeEstoque);
    mysqli_stmt_fetch($stmt_estoque);
    mysqli_stmt_close($stmt_estoque);
    
    if ($quantidadeEstoque < $quantity) {
        $stmt_nome_produto = mysqli_prepare($con, "SELECT nome FROM produtos WHERE id_produtos = ?");
        mysqli_stmt_bind_param($stmt_nome_produto, 'i', $productId);
        mysqli_stmt_execute($stmt_nome_produto);
        mysqli_stmt_bind_result($stmt_nome_produto, $nomeProduto);
        mysqli_stmt_fetch($stmt_nome_produto);
        mysqli_stmt_close($stmt_nome_produto);

        $_SESSION['msg'] = '<span>Erro: Estoque insuficiente para o produto ' . $nomeProduto . '.</span>';
        header("Location: criar-pedido.php");
        exit();
    }
    
    $stmt_preco = mysqli_prepare($con, "SELECT preco_unit FROM produtos WHERE id_produtos = ?");
    mysqli_stmt_bind_param($stmt_preco, 'i', $productId);
    mysqli_stmt_execute($stmt_preco);
    mysqli_stmt_bind_result($stmt_preco, $precoUnit);
    mysqli_stmt_fetch($stmt_preco);
    mysqli_stmt_close($stmt_preco);

    $totalPedido += $precoUnit * $quantity;
}


$query = "INSERT INTO pedidos(id_cliente, id_forma_pagamento, id_vendedor, data_pedido, valor_total)
    VALUES (?, ?, ?, NOW(), ?)";

$stmt_pedido = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt_pedido, 'iiid', $customerId, $paymentMethodId, $sellerId, $totalPedido);
mysqli_stmt_execute($stmt_pedido);

if (mysqli_stmt_affected_rows($stmt_pedido) <= 0) {
    mysqli_rollback($con);
    $_SESSION['msg'] = '<span>Erro: Não foi possível salvar o pedido.</span>';
    header("Location: criar-pedido.php");
    exit();
}

$id_pedido = mysqli_insert_id($con);
mysqli_stmt_close($stmt_pedido);

foreach ($products as $index => $productId) {
    $quantity = isset($qtys[$index]) ? (int)$qtys[$index] : 1;

    $query_item = "CALL sp_inserir_item_pedido(?, ?, ?)";
    $stmt_item = mysqli_prepare($con, $query_item);
    mysqli_stmt_bind_param($stmt_item, 'iii', $id_pedido, $productId, $quantity);
    mysqli_stmt_execute($stmt_item);

    if (mysqli_stmt_affected_rows($stmt_item) <= 0) {
        mysqli_rollback($con);
        $_SESSION['msg'] = '<span>Erro: Falha ao adicionar item ao pedido.</span>';
        header("Location: criar-pedido.php");
        exit();
    }

    mysqli_stmt_close($stmt_item);
}

mysqli_commit($con);
$_SESSION['msg'] = '<span>Pedido criado com sucesso!</span>';
header("Location: listar-pedidos.php");
exit();
