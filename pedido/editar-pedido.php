<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

include(__DIR__ . '/../config/connection.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Venda</title>
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
        <li><a href="../produto/listar-produtos.php">Listar Produtos</a></li>
      </ul>
    </nav>
    <div class="menu-toggle" id="menu-toggle">
      <i class="fas fa-bars"></i>
    </div>
  </header>

  <main class="main">
    <a href="./listar-pedidos.php" class="go-back">
      <i class="fa-solid fa-arrow-left"></i>
      <h3>Voltar</h3>
    </a>
    <?php
    if (isset($_SESSION['msg'])) {
      echo "<div class='alert'>" . $_SESSION['msg'] . "</div>";
      unset($_SESSION['msg']);
    }
    ?>
    <h1>Detalhes do Pedido</h1>

    <table class="responsive-table">
      <thead>
        <tr>
          <th>Produto</th>
          <th>Quantidade</th>
          <th>Valor Unitário</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $id_pedido = isset($_GET['id']) ? intval($_GET['id']) : 0;

        $query = "
          SELECT 
            ip.id AS id_item,
            p.nome AS nome_produto,
            ip.quantidade,
            ip.preco_unit,
            (ip.quantidade * ip.preco_unit) AS total_item,
            ped.status_pedido AS status
          FROM itens_pedido ip
          JOIN produtos p ON ip.id_produto = p.id_produtos
          JOIN pedidos ped ON ip.id_pedido = ped.id_pedidos
          WHERE ip.id_pedido = $id_pedido
        ";

        $result = mysqli_query($con, $query);

        $queryStatus = "SELECT status_pedido FROM pedidos WHERE id_pedidos = $id_pedido";
        $subtotal = "SELECT valor_total FROM pedidos WHERE id_pedidos = $id_pedido";
        $resultStatus = mysqli_query($con, $queryStatus);

        if ($resultStatus && $row = mysqli_fetch_assoc($resultStatus)) {
          $statusAtual = (int) $row['status_pedido'];
        }

        if (!$result || mysqli_num_rows($result) === 0) {
          echo "<tr><td colspan='5'>Nenhum item encontrado para este pedido.</td></tr>";
        } else {
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['nome_produto']}</td>";
            echo "<td>{$row['quantidade']}</td>";
            echo "<td>R$ " . number_format($row['preco_unit'], 2, ',', '.') . "</td>";
            echo "<td>R$ " . number_format($row['total_item'], 2, ',', '.') . "</td></tr>";
          }

          $subtotalResult = mysqli_query($con, $subtotal);
          if ($subtotalResult && $subtotalRow = mysqli_fetch_assoc($subtotalResult)) {
            echo
            "<tr><td colspan='4' style='text-align: center; padding-right: 2rem;'>" .
              "<strong>Total: R$</strong>" . number_format($subtotalRow['valor_total'], 2, ',', '.') .
              "</td></tr>";
          }
        }

        $enumQuery = "SHOW COLUMNS FROM pedidos LIKE 'status_pedido'";
        $enumResult = mysqli_query($con, $enumQuery);
        $enumValues = [];
        if ($enumResult && $row = mysqli_fetch_assoc($enumResult)) {
          preg_match_all("/'([^']+)'/", $row['Type'], $matches);
          $enumValues = $matches[1];
        }
        mysqli_close($con);

        ?>
      </tbody>
    </table>

    <h2 class="title">Atualizar Status do Pedido</h2>
    <form action="atualizar-status.php" method="POST" class="form-status">
      <input type="hidden" name="id_pedido" value="<?php echo $id_pedido; ?>">
      <div class="form-group">
        <label for="status">Status do Pedido</label>
        <select name="status" id="status">
          <?php
          foreach ($enumValues as $value) {
            echo "<option value='$value' " . ($statusAtual == $value ? 'selected' : '') . ">$value</option>";
          }
          ?>
        </select>
      </div>

      <button type="submit" class="btn">Salvar Status</button>
    </form>
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