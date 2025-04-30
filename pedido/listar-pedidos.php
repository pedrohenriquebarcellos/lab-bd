<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Listar Pedidos</title>
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
        <li><a href="../pedido/criar-pedido.php">Criar Pedido</a></li>
        <li><a href="../cliente/listar-clientes.php">Listar Clientes</a></li>
        <li><a href="../pedido/listar-pedidos.php">Listar Pedidos</a></li>
        <li><a href="../produto/criar-produto.php">Criar Produto</a></li>
        <li><a href="../produto/listar-produtos.php">Listar Produtos</a></li>
      </ul>
    </nav>
    <div class="menu-toggle" id="menu-toggle">
      <i class="fas fa-bars"></i>
    </div>
  </header>

  <main class="main">
    <a href="../index.html" class="go-back">
      <i class="fa-solid fa-arrow-left"></i>
      <h3>Voltar</h3>
    </a>
    <?php
    if (isset($_SESSION['msg'])) {
      echo "<div class='alert'>" . $_SESSION['msg'] . "</div>";
      unset($_SESSION['msg']);
    }
    ?>
    <h1>Pedidos Realizados</h1>

    <div class="table-container">
      <table class="responsive-table">
        <thead>
          <tr>
            <th data-label="ID">ID</th>
            <th data-label="Nome">Cliente</th>
            <th>Vendedor</th>
            <th>Total</th>
            <th>Forma de Pagamento</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include(__DIR__ . '/../config/connection.php');

          $query = "
            SELECT ped.id_pedidos, cli.nome AS nome_cliente, ven.nome AS nome_vendedor, 
            fp.descricao AS forma_pagamento, ped.valor_total, ped.status_pedido
            FROM pedidos ped
            JOIN clientes cli ON ped.id_cliente = cli.id_clientes
            JOIN vendedores ven ON ped.id_vendedor = ven.id_vendedores
            JOIN forma_pagamento fp ON ped.id_forma_pagamento = fp.id_pagamentos
            ORDER BY ped.id_pedidos DESC;
          ";

          $result = mysqli_query($con, $query);

          if (!$result) {
            echo "<p>Erro ao consultar os pedidos: " . mysqli_error($con) . "</p>";
          } elseif (mysqli_num_rows($result) == 0) {
            echo "<p>Nenhum pedido encontrado.</p>";
          } else {
            while ($reg = mysqli_fetch_array($result)) {
              echo "<tr><td>" . $reg['id_pedidos'] . "</td>";
              echo "<td>" . $reg['nome_cliente'] . "</td>";
              echo "<td>" . $reg['nome_vendedor'] . "</td>";
              echo "<td>R$" . number_format($reg['valor_total'], 2, ',', '.') . "</td>";
              echo "<td>" . $reg['forma_pagamento'] . "</td>";
              echo "<td>" . $reg['status_pedido'] . "</td>";
              echo "<td><a href='editar-pedido.php?id=" . $reg['id_pedidos'] . "' class='btn-edit'><i class='fas fa-edit'></i> Editar</a></td></tr>";
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