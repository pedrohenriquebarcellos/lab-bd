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
                <li><a href="../cliente/criar-cliente.php" class="active">Criar Cliente</a></li>
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
        <?php
        if (isset($_SESSION['msg'])) {
            echo "<div class='alert'>" . $_SESSION['msg'] . "</div>";
            unset($_SESSION['msg']);
        }
        ?>
        <h1>Criar Nova Forma de Pagamento</h1>

        <form action="salvar-forma-pagamento.php" method="POST" class="form-container">
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <input type="text" id="descricao" name="descricao" placeholder="Digite a forma de pagamento" required>
            </div>

            <button type="submit" class="btn">Salvar Forma de Pagamento</button>
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