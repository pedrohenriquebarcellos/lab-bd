<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include(__DIR__ . '/../config/connection.php');

$id = $_POST['id'];
$acao = $_POST['acao'];

if ($acao === 'atualizar') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco_unit = $_POST['preco'];
    $estoque = $_POST['quantidade_estoque'];

    $query = "UPDATE produtos SET nome = '$nome', descricao = '$descricao', preco_unit = '$preco_unit', quantidade_estoque = $estoque WHERE id_produtos = $id";
    $result = mysqli_query($con, $query);
    
    if ($result) {
        $_SESSION['msg'] = "Produto atualizado com sucesso.";
        header("Location: listar-produtos.php");
        exit();
    } else {
        $_SESSION['msg'] = "Erro ao atualizar produto: " . mysqli_error($con);
        header("Location: editar-produto.php?id=" . $id);
        exit();
    }
} else if ($acao === 'remover') {
    $query = "DELETE FROM produtos WHERE id_produtos = $id";
    $result = mysqli_query($con, $query);
    if ($result) {
        $_SESSION['msg'] = "Produto removido com sucesso.";
        header("Location: listar-produtos.php");
        exit();
    } else {
        $_SESSION['msg'] = "Erro ao remover produto: " . mysqli_error($con);
        header("Location: listar-produtos.php");
        exit();
    }
}

?>