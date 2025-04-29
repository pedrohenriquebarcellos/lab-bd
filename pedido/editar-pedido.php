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
    <a href="javascript:history.back()" class="go-back">
      <i class="fa-solid fa-arrow-left"></i>
      <h3>Voltar</h3>
    </a>
    <h1>Editar Venda</h1>

    <div class="form-container">
      <form action="atualizar-venda.php" method="POST" class="form">
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">

        <div class="form-group">
          <label for="cliente">Cliente:</label>
          <input type="text" id="cliente" name="cliente" placeholder="Nome do Cliente" required>
        </div>

        <div class="form-group">
          <label for="data">Data:</label>
          <input type="date" id="data" name="data" required>
        </div>

        <div class="form-group">
          <label for="valor">Valor:</label>
          <input type="text" id="valor" name="valor" placeholder="Valor da Venda" required>
        </div>

        <div class="button-group">
          <button type="submit" class="btn-primary">
            <i class="fas fa-save"></i> Salvar Alterações
          </button>

          <a href="remover-venda.php?id=<?php echo $_GET['id']; ?>" class="btn-danger" onclick="return confirm('Tem certeza que deseja remover esta venda?');">
            <i class="fas fa-trash"></i> Remover Venda
          </a>
        </div>
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