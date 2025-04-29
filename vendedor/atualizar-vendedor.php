<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include(__DIR__ . '/../config/connection.php');

$id = $_POST['id'];
$acao = $_POST['acao'];

if ($acao === 'atualizar') {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];

    $query = "UPDATE vendedores SET nome = '$nome', cpf = '$cpf', telefone = '$telefone' WHERE id_vendedores = $id";
    $result = mysqli_query($con, $query);
    
    if ($result) {
        $_SESSION['msg'] = "Vendedor atualizado com sucesso.";
        header("Location: listar-vendedores.php");
        exit();
    } else {
        $_SESSION['msg'] = "Erro ao atualizar vendedor: " . mysqli_error($con);
        header("Location: editar-vendedor.php?id=" . $id);
        exit();
    }
} else if ($acao === 'remover') {
    $query = "DELETE FROM vendedores WHERE id_vendedores = $id";
    $result = mysqli_query($con, $query);
    if ($result) {
        $_SESSION['msg'] = "Vendedor removido com sucesso.";
        header("Location: listar-vendedores.php");
        exit();
    } else {
        $_SESSION['msg'] = "Erro ao remover vendedor: " . mysqli_error($con);
        header("Location: listar-vendedores.php");
        exit();
    }
}

?>