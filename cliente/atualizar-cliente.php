<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include(__DIR__ . '/../config/connection.php');

$id = $_POST['id'];
$acao = $_POST['acao'];

if ($acao === 'atualizar') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $ativo = (bool)$_POST['ativo'] ? 1 : 0;

    $query = "UPDATE clientes SET nome = '$nome', email = '$email', telefone = '$telefone', ativo = $ativo, data_cadastro = NOW() WHERE id_clientes = $id";
    $result = mysqli_query($con, $query);
    
    if ($result) {
        $_SESSION['msg'] = "Cliente atualizado com sucesso.";
        header("Location: listar-clientes.php");
        exit();
    } else {
        $_SESSION['msg'] = "Erro ao atualizar cliente: " . mysqli_error($con);
        header("Location: editar-cliente.php?id=" . $id);
        exit();
    }
} else if ($acao === 'remover') {
    $query = "DELETE FROM clientes WHERE id_clientes = $id";
    $result = mysqli_query($con, $query);
    if ($result) {
        $_SESSION['msg'] = "Cliente removido com sucesso.";
        header("Location: listar-clientes.php");
        exit();
    } else {
        $_SESSION['msg'] = "Erro ao remover cliente: " . mysqli_error($con);
        header("Location: listar-clientes.php");
        exit();
    }
}

?>