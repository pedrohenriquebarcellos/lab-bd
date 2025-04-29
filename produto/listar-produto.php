<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Listar Produtos</title>
  <link rel="stylesheet" href="../assets/styles.css">
  <script src="https://kit.fontawesome.com/552acac2d8.js" crossorigin="anonymous"></script>
</head>

<body>
  <header class="header">
    <div class="logo">Meu CRUD</div>
    <nav class="nav" id="nav">
      <ul>
        <li><a href="../index.html">Dashboard</a></li>
        <li><a href="../cliente/criar-cliente.php">Criar Cliente</a></li>
        <li><a href="../cliente/listar-clientes.php">Listar Clientes</a></li>
        <li><a href="../pedido/criar-pedido.php">Criar Pedido</a></li>
        <li><a href="../pedido/listar-pedidos.php">Listar Pedidos</a></li>
        <li><a href="../produto/criar-produto.php">Criar Produto</a></li>
        <li><a href="../produto/listar-produto.php" class="active">Listar Produto</a></li>
      </ul>
    </nav>
    <div class="menu-toggle" id="menu-toggle">
      <i class="fas fa-bars"></i>
    </div>
  </header>

  <main class="main">
    <?php
    if (isset($_SESSION['msg'])) {
      echo "<div class='alert'>" . $_SESSION['msg'] . "</div>";
      unset($_SESSION['msg']);
    }
    ?>
    <h1>Produtos Cadastrados</h1>

    <div class="table-container">
      <table class="responsive-table">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Estoque</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include(__DIR__ . '/../config/connection.php');

          $query = "SELECT * FROM produtos ORDER BY nome";
          $result = mysqli_query($con, $query);

          if (!$result) {
            echo "<p>Erro ao consultar os produtos: " . mysqli_error($con) . "</p>";
          } elseif (mysqli_num_rows($result) == 0) {
            echo "<p>Nenhum produto encontrado.</p>";
          } else {
            while ($reg = mysqli_fetch_array($result)) {
              echo "<tr><td>" . $reg['nome'] . "</td>";
              echo "<td>" . $reg['descricao'] . "</td>";
              echo "<td>" . $reg['preco_unit'] . "</td>";
              echo "<td>" . $reg['quantidade_estoque'] . "</td>";
              echo "<td><a href='editar-produto.php?id=" . $reg['id_produtos'] . "' class='btn-edit'><i class='fas fa-edit'></i> Editar</a></td></tr>";
            }
          }

          mysqli_close($con);
          ?>
        </tbody>
      </table>
    </div>
  </main>

  <script>
    const menuToggle = document.getElementById('menu-toggle');
    const nav = document.getElementById('nav');

    menuToggle.addEventListener('click', () => {
      nav.classList.toggle('active');
    });
  </script>

</body>

</html>