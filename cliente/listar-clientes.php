<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Listar Clientes</title>
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
        <li><a href="../cliente/criar-pedido.php">Criar Pedido</a></li>
        <li><a href="../listar-clientes.php">Listar Clientes</a></li>
        <li><a href="../listar-pedidos.php">Listar Pedidos</a></li>
        <li><a href="../produto/criar-produto.php">Criar Produto</a></li>
        <li><a href="../listar-produto.php">Listar Produto</a></li>
      </ul>
    </nav>
    <div class="menu-toggle" id="menu-toggle">
      <i class="fas fa-bars"></i>
    </div>
  </header>

  <main class="main">
    <h1>Clientes Cadastrados</h1>

    <div class="table-container">
      <table class="responsive-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <!-- Exemplo de cliente -->
          <tr>
            <td>1</td>
            <td>João Silva</td>
            <td>joao@email.com</td>
            <td>
              <a href="editar-cliente.php?id=1" class="btn-edit">
                <i class="fas fa-edit"></i> Editar
              </a>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>Maria Oliveira</td>
            <td>maria@email.com</td>
            <td>
              <a href="editar-cliente.php?id=2" class="btn-edit">
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