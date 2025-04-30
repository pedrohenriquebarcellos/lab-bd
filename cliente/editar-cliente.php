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
  <title>Editar Cliente</title>
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
    <a href="./criar-cliente.php" class="go-back">
      <i class="fa-solid fa-arrow-left"></i>
      <h3>Voltar</h3>
    </a>
    <?php
    if (isset($_SESSION['msg'])) {
      echo "<div class='alert'>" . $_SESSION['msg'] . "</div>";
      unset($_SESSION['msg']);
    }
    ?>
    <h1>Editar Cliente</h1>

    <div class="form-container">
      <?php
      include(__DIR__ . '/../config/connection.php');

      $query = "SELECT * FROM clientes WHERE id_clientes = " . $_GET['id'];
      $result = mysqli_query($con, $query);

      if (!$result) {
        echo "<p>Erro ao consultar o cliente: " . mysqli_error($con) . "</p>";
      } elseif (mysqli_num_rows($result) == 0) {
        echo "<p>Nenhum cliente encontrado.</p>";
      } else {
        $reg = mysqli_fetch_array($result);

        if ($reg['id_clientes'] != $_GET['id']) {
          echo "<p>Cliente não encontrado.</p>";
          exit();
        }

        $currentId = $reg['id_clientes'];
        $currentName = $reg['nome'];
        $currentEmail = $reg['email'];
        $currentPhone = $reg['telefone'];
        $currentActive = $reg['ativo'];
      }

      mysqli_close($con);
      ?>
      <form action="atualizar-cliente.php" method="POST" class="form">
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">

        <div class="form-group">
          <label for="nome">Nome:</label>
          <input type="text" id="nome" name="nome" placeholder="Nome do Cliente" value="<?= $currentName ?? "" ?>" required>
        </div>

        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" placeholder="Email do Cliente" value="<?= $currentEmail ?? "" ?>" required>
        </div>

        <div class="form-group">
          <label for="telefone">Telefone:</label>
          <input
            onkeyup="handlePhone(event)"
            type="text"
            id="telefone"
            name="telefone"
            placeholder="Telefone do Cliente"
            value="<?= $currentPhone ?? "" ?>"
            required
            maxlength="15">
        </div>

        <div class="form-group">
          <label for="ativo">Ativo:</label>
          <select id="ativo" name="ativo" required>
            <option value="1" <?= $currentActive ? 'selected' : '' ?>>Sim</option>
            <option value="0" <?= !$currentActive ? 'selected' : '' ?>>Não</option>
          </select>
        </div>

        <button type="submit" class="btn" name="acao" value="atualizar">Salvar Alterações</button>
        <button type="submit" class="btn delete" name="acao" value="remover" onclick="return confirm('Tem certeza que deseja remover este cliente?');">Remover Cliente</button>
      </form>
    </div>
  </main>

  <script>
    const handlePhone = (event) => {
      let input = event.target
      input.value = phoneMask(input.value)
    }

    const phoneMask = (value) => {
      if (!value) return ""
      value = value.replace(/\D/g, '')
      value = value.replace(/(\d{2})(\d)/, "($1) $2")
      value = value.replace(/(\d)(\d{4})$/, "$1-$2")
      return value
    }
  </script>

  <script>
    const menuToggle = document.getElementById('menu-toggle');
    const nav = document.getElementById('nav');

    menuToggle.addEventListener('click', () => {
      nav.classList.toggle('active');
    });
  </script>

</body>

</html>