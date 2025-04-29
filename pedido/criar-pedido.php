<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Criar Pedido - Sistema CRUD</title>
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
        <li><a href="../pedido/criar-pedido.php" class="active">Criar Pedido</a></li>
        <li><a href="../pedido/listar-pedidos.php">Listar Pedidos</a></li>
        <li><a href="../produto/criar-produto.php">Criar Produto</a></li>
        <li><a href="../produto/listar-produto.php">Listar Produto</a></li>
      </ul>
    </nav>
    <div class="menu-toggle" id="menu-toggle">
      <i class="fas fa-bars"></i>
    </div>
  </header>

  <main class="main">
    <h1>Criar Pedido</h1>
    <div class="form-container">
      <form action="processar-venda.php" method="POST" class="form">
        <div class="form-group">
          <label for="produto">Produto</label>
          <input type="text" id="produto" name="produto" placeholder="Digite o nome do produto" required>
        </div>

        <div class="form-group">
          <label for="quantidade">Quantidade</label>
          <input type="number" id="quantidade" name="quantidade" placeholder="Digite a quantidade" required>
        </div>

        <div class="form-group">
          <label for="preco">Preço</label>
          <input type="number" id="preco" name="preco" step="0.01" placeholder="Digite o preço do produto" required>
        </div>

        <button type="submit" class="btn-submit">Salvar Venda</button>
      </form>
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