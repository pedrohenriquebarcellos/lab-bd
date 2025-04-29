<!DOCTYPE html>
<html lang="pt-BR">

<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
include(__DIR__ . '/../config/connection.php');
?>

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
    <h1>Criar Pedido</h1>
    <div class="form-container">
      <form action="salvar-pedido.php" method="POST" class="form">
        <div class="form-group">
          <label for="clientes">Cliente</label>
          <?php
          $queryClients = "SELECT * FROM clientes";
          $resultClients = mysqli_query($con, $queryClients);

          if (!$resultClients) {
            die("Erro na consulta: " . mysqli_error($con));
          }

          if (mysqli_num_rows($resultClients) == 0) {
            echo "<p>Nenhum cliente encontrado.</p>";
          }

          echo '<select id="clientes" name="clientes" required>';
          while ($row = mysqli_fetch_assoc($resultClients)) {
            echo '<option value="' . $row['id_clientes'] . '">' . $row['nome'] . '</option>';
          }
          echo '</select>';
          ?>
        </div>
        <div class="form-group">
          <div id="produtos-container">
            <div class="produto-item">
              <button type="button" class="btn remove" onclick="removerProduto(this)">x</button>
              <label>Produto 1</label>
              <select name="produtos_id[0]" class="produto-select" required>
                <?php
                $queryProdutos = "SELECT * FROM produtos";
                $resultProdutos = mysqli_query($con, $queryProdutos);
                while ($row = mysqli_fetch_assoc($resultProdutos)) {
                  echo '<option value="' . $row['id_produtos'] . '">' . $row['nome'] . '</option>';
                }
                ?>
              </select>

              <label>Quantidade</label>
              <input type="number" name="quantidade[0]" class="quantidade" min="1" required>

              <label>Preço Unitário</label>
              <input type="number" class="preco-unit" readonly>

              <label>Total do Produto</label>
              <input type="number" class="valor-total" readonly>              
            </div>
          </div>

          <button type="button" class="btn add" onclick="adicionarProduto()">Adicionar + Produtos</button>
        </div>
        <div class="form-group">
          <label for="produto">Forma de Pagamento</label>
          <?php
          $queryPayment = "SELECT * FROM forma_pagamento";
          $resultPayment = mysqli_query($con, $queryPayment);

          if (!$resultPayment) {
            die("Erro na consulta: " . mysqli_error($con));
          }

          if (mysqli_num_rows($resultPayment) == 0) {
            echo "<p>Nenhuma forma de pagamento encontrada.</p>";
          }

          echo '<select id="forma_pagamento" name="forma_pagamento" required>';
          while ($row = mysqli_fetch_assoc($resultPayment)) {
            echo '<option value="' . $row['id_pagamentos'] . '">' . $row['descricao'] . '</option>';
          }
          echo '</select>';
          ?>
        </div>

        <div class="form-group">
          <label for="quantidade">Vendedor</label>
          <?php
          $querySellers = "SELECT * FROM vendedores";
          $resultSellers = mysqli_query($con, $querySellers);

          if (!$resultSellers) {
            die("Erro na consulta: " . mysqli_error($con));
          }

          if (mysqli_num_rows($resultSellers) == 0) {
            echo "<p>Nenhum vendedor encontrado.</p>";
          }

          echo '<select id="vendedores" name="vendedores" required>';
          while ($row = mysqli_fetch_assoc($resultSellers)) {
            echo '<option value="' . $row['id_vendedores'] . '">' . $row['nome'] . '</option>';
          }
          echo '</select>';
          ?>
        </div>

        <div class="form-group">
          <label for="preco">Valor Total</label>
          <input type="number" id="preco" name="preco_total" placeholder="Valor total" readonly required>
        </div>

        <button type="submit" class="btn">Salvar Pedido</button>
      </form>
    </div>
  </main>

  <script>
    let produtoIndex = 1;

    const precosProdutos = {
      <?php
      $queryProdutos = "SELECT * FROM produtos";
      $resultProdutos = mysqli_query($con, $queryProdutos);
      $precos = [];
      while ($produto = mysqli_fetch_assoc($resultProdutos)) {
        $precos[] = '"' . $produto['id_produtos'] . '": ' . $produto['preco_unit'];
      }
      echo implode(",\n", $precos);
      ?>
    };

    function atualizarCampos(item) {
      const select = item.querySelector('.produto-select');
      const quantidade = item.querySelector('.quantidade');
      const precoUnit = item.querySelector('.preco-unit');
      const total = item.querySelector('.valor-total');

      function calcular() {
        const produtoId = select.value;
        const preco = precosProdutos[produtoId] || 0;
        const qtd = parseFloat(quantidade.value) || 0;
        precoUnit.value = preco.toFixed(2);
        total.value = (preco * qtd).toFixed(2);
        atualizarValorTotalGeral();
      }

      select.addEventListener('change', calcular);
      quantidade.addEventListener('input', calcular);
      calcular();
    }

    function adicionarProduto() {
      const container = document.getElementById('produtos-container');
      const novoItem = container.querySelector('.produto-item').cloneNode(true);


      novoItem.querySelector('.quantidade').value = '';
      novoItem.querySelector('.preco-unit').value = '';
      novoItem.querySelector('.valor-total').value = '';

      novoItem.querySelector('.produto-select').setAttribute('name', `produto_id[${produtoIndex}]`);
      novoItem.querySelector('.quantidade').setAttribute('name', `quantidade[${produtoIndex}]`);

      const labels = novoItem.querySelectorAll('label');
      if (labels.length >= 1) labels[0].textContent = `Produto ${produtoIndex + 1}`;
      if (labels.length >= 2) labels[1].textContent = `Quantidade`;
      if (labels.length >= 3) labels[2].textContent = `Preço Unitário`;
      if (labels.length >= 4) labels[3].textContent = `Total`;

      container.appendChild(novoItem);
      atualizarCampos(novoItem);

      produtoIndex++;
    }

    function atualizarValorTotalGeral() {
      const totais = document.querySelectorAll('.valor-total');
      let soma = 0;

      totais.forEach(input => {
        const valor = parseFloat(input.value);
        if (!isNaN(valor)) {
          soma += valor;
        }
      });

      document.getElementById('preco').value = soma.toFixed(2);
    }

    function removerProduto(botao) {
      const item = botao.closest('.produto-item');
      const container = document.getElementById('produtos-container');

      if (container.children.length > 1) {
        item.remove();
        atualizarValorTotalGeral();
      } else {
        alert("É necessário ter pelo menos um produto no pedido.");
      }
    }

    document.querySelectorAll('.produto-item').forEach(atualizarCampos);
  </script>


  <script>
    const menuToggle = document.getElementById('menu-toggle');
    const nav = document.getElementById('nav');

    menuToggle.addEventListener('click', () => {
      nav.classList.toggle('active');
    });
  </script>

  <?php
  mysqli_close($con);
  ?>

</body>

</html>