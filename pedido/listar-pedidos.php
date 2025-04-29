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
        <li><a href="../listar-produto.php">Listar Produto</a></li>
      </ul>
    </nav>
    <div class="menu-toggle" id="menu-toggle">
      <i class="fas fa-bars"></i>
    </div>
  </header>

  <main class="main">
    <h1>Vendas Realizadas</h1>

    <div class="table-container">
      <table class="responsive-table">
        <thead>
          <tr>
            <th data-label="ID">ID</th>
            <th data-label="Nome">Cliente</th>
            <th>Data</th>
            <th>Valor</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <!-- Exemplo de venda -->
          <tr>
            <td>1</td>
            <td>João Silva</td>
            <td>28/04/2025</td>
            <td>R$ 250,00</td>
            <td>
              <a href="editar-pedido.php?id=1" class="btn-edit">
                <i class="fas fa-edit"></i> Editar
              </a>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>Maria Oliveira</td>
            <td>27/04/2025</td>
            <td>R$ 120,00</td>
            <td>
              <a href="editar-pedido.php?id=2" class="btn-edit">
                <i class="fas fa-edit"></i> Editar
              </a>
            </td>
          </tr>
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