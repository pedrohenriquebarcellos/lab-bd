<?php
include('config/connection.php');
$product_name = $_POST['product_name'];
$product_description = $_POST['product_description'];
$product_price = floatval($_POST['product_price']);
$product_stock = $_POST['product_stock'];

$query = "INSERT INTO produtos (nome, descricao, preco_unit, quantidade_estoque) VALUES
    ('$product_name', '$product_description', '$product_price' ,'$product_stock')";
$result = mysqli_query($con, $query);

if (mysqli_insert_id($con)) {
    header("Location: listar-produto.php");
} else {
    echo "<br><font color=blue> Could not add! </font>";
}
?>