<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pesquisar Pedidos</title>
  <link rel="stylesheet" href="../assets/styles.css">
  <script src="https://kit.fontawesome.com/552acac2d8.js" crossorigin="anonymous"></script>
</head>

<body>

  <header class="header">
    <div class="logo">Projeto LAB-BD</div>
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
    <h1>Pesquisar Pedidos</h1>

    <form action="filtrar-pesquisa.php" method="POST" class="form-status">
        <div class="form-group">
            <label for="vendedor">Opções de Pesquisa</label>
            <select id="pesquisa-pedido" name="pesquisa-pedido">
                <option value="id">ID</option>
                <option value="cliente">Cliente</option>
                <option value="vendedor">Vendedor</option>
                <option value="status">Status</option>
            </select>            
        </div>
        <div class="form-group">
            <label for="search-attribute">Dado para pesquisa:</label>
            <input minlength="1" maxlength="15" type="text" name="search-attribute" placeholder="Digite o valor para pesquisa" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn">Pesquisar</button>
        </div>
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