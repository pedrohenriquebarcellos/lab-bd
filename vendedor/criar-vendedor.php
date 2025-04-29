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
        <?php
        if (isset($_SESSION['msg'])) {
            echo "<div class='alert'>" . $_SESSION['msg'] . "</div>";
            unset($_SESSION['msg']);
        }
        ?>
        <h1>Criar Novo Vendedor</h1>

        <form action="salvar-vendedor.php" method="POST" class="form-container">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" placeholder="Digite o nome do vendedor" required>
            </div>

            <div class="form-group">
                <label for="cpf">CPF</label>
                <input
                    type="text"
                    id="cpf"
                    name="cpf"
                    placeholder="Digite o CPF do vendedor"
                    required
                    onkeyup="handleCPF(event)"
                    maxlength="14">
            </div>

            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input
                    onkeyup="handlePhone(event)"
                    type="text"
                    id="telefone"
                    name="telefone"
                    placeholder="Digite o telefone do vendedor"
                    required
                    maxlength="15">
            </div>

            <button type="submit" class="btn">Salvar Vendedor</button>
        </form>
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

        const handleCPF = (event) => {
            let input = event.target;
            input.value = cpfMask(input.value);
        };

        const cpfMask = (value) => {
            if (!value) return "";
            value = value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, "$1.$2");
            value = value.replace(/(\d{3})(\d)/, "$1.$2");
            value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
            return value;
        };
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