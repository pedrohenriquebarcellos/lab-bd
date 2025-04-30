<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include(__DIR__ . '/../config/connection.php');
  session_start();

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pedido = isset($_POST['id_pedido']) ? intval($_POST['id_pedido']) : 0;
    $status = isset($_POST['status']) ? $_POST['status'] : '';
  
    if ($id_pedido > 0 && $status !== '') {
      $stmt = $con->prepare("UPDATE pedidos SET status_pedido = ? WHERE id_pedidos = ?");
      $stmt->bind_param("si", $status, $id_pedido);
  
      if ($stmt->execute()) {
        $_SESSION['msg'] = "Status do pedido atualizado com sucesso.";
      } else {
        $_SESSION['msg'] = "Erro ao atualizar o status do pedido.";
      }
  
      $stmt->close();
    } else {
      $_SESSION['msg'] = "Dados inválidos para atualizar o status.";
    }
  
    $con->close();
  
    header("Location: editar-pedido.php?id=$id_pedido");
    exit;
  }
}
?>