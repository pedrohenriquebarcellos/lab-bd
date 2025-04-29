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
  <title>Criar Cliente</title>
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
        <li><a href="../produto/criar-produto.php" class="active">Criar Produto</a></li>
        <li><a href="../produto/listar-produtos.php">Listar Produtos</a></li>
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
    <h1>Criar Novo Produto</h1>

    <form action="salvar-produto.php" method="POST" class="form-container">
      <div class="form-group">
        <label for="product_name">Nome Produto:</label>
        <input type="text" id="product_name" name="product_name" required>
      </div>

      <div class="form-group">
        <label for="nome">Descrição Produto:</label>
        <input type="text" id="product_description" name="product_description" required>
      </div>

      <div class="form-group">
        <label for="nome">Preço Produto:</label>
        <input type="text" id="product_price" name="product_price" required>
      </div>

      <div class="form-group">
        <label for="product_stock">Estoque</label>
        <input type="text" id="product_stock" name="product_stock" required>
      </div>

      <button type="submit" class="btn">Salvar Produto</button>
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