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
    <title>Editar Vendedor</title>
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
        <a href="./listar-formas-pagamento.php" class="go-back">
            <i class="fa-solid fa-arrow-left"></i>
            <h3>Voltar</h3>
        </a>
        <?php
        if (isset($_SESSION['msg'])) {
            echo "<div class='alert'>" . $_SESSION['msg'] . "</div>";
            unset($_SESSION['msg']);
        }
        ?>
        <h1>Editar Formas de Pagamento</h1>

        <div class="form-container">
            <?php
            include(__DIR__ . '/../config/connection.php');

            $query = "SELECT * FROM forma_pagamento WHERE id_pagamentos = " . $_GET['id'];
            $result = mysqli_query($con, $query);

            if (!$result) {
                echo "<p>Erro ao consultar a forma de pagamento: " . mysqli_error($con) . "</p>";
            } elseif (mysqli_num_rows($result) == 0) {
                echo "<p>Nenhuma forma de pagamento encontrada.</p>";
            } else {
                $reg = mysqli_fetch_array($result);

                if ($reg['id_pagamentos'] != $_GET['id']) {
                    echo "<p>Forma de pagamento não encontrada.</p>";
                    exit();
                }

                $currentId = $reg['id_pagamentos'];
                $currentPaymentDescription = $reg['descricao'];
            }

            mysqli_close($con);
            ?>
            <form action="atualizar-forma-pagamento.php" method="POST" class="form">
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">

                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <input type="text" id="descricao" name="descricao" placeholder="Descrição da Forma de Pagamento" value="<?= $currentPaymentDescription ?? "" ?>" required>
                </div>

                <button type="submit" class="btn" name="acao" value="atualizar">Salvar Alterações</button>
                <button type="submit" class="btn delete" name="acao" value="remover" onclick="return confirm('Tem certeza que deseja remover esta forma de pagamento?');">Remover Forma de Pgto</button>
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