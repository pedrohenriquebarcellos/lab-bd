<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include(__DIR__ . '/../config/connection.php');

$id = $_POST['id'];
$acao = $_POST['acao'];

if ($acao === 'atualizar') {
    $paymentDescription = $_POST['descricao'];

    $query = "UPDATE forma_pagamento SET nome = '$paymentDescription' WHERE id_pagamentos = $id";
    $result = mysqli_query($con, $query);

    if ($result) {
        $_SESSION['msg'] = "Forma de pagamento atualizada com sucesso.";
        header("Location: listar-formas-pagamento.php");
        exit();
    } else {
        $_SESSION['msg'] = "Erro ao atualizar forma de pagamento: " . mysqli_error($con);
        header("Location: editar-forma-pagamento.php?id=" . $id);
        exit();
    }
} else if ($acao === 'remover') {
    $query = "DELETE FROM forma_pagamento WHERE id_pagamentos = $id";
    $result = mysqli_query($con, $query);
    if ($result) {
        $_SESSION['msg'] = "Forma de pagamento removida com sucesso.";
        header("Location: listar-formas-pagamento.php");
        exit();
    } else {
        $_SESSION['msg'] = "Erro ao remover forma de pagamento: " . mysqli_error($con);
        header("Location: listar-formas-pagamento.php");
        exit();
    }
}
