<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include(__DIR__ . '/../config/connection.php');
global $con;

$vendedorSelecionado = isset($_POST['vendedor']) ? $_POST['vendedor'] : null;

$vendedoresQuery = "SELECT id_vendedores, nome FROM vendedores ORDER BY nome ASC";
$vendedoresResult = mysqli_query($con, $vendedoresQuery);

$query = "
    SELECT
        v.nome AS vendedor,
        COUNT(DISTINCT ip.id_produto) AS total_itens_diferentes,
        SUM(ip.quantidade * ip.preco_unit) AS total_vendas
    FROM
        pedidos p
    JOIN
        vendedores v ON v.id_vendedores = p.id_vendedor
    JOIN
        itens_pedido ip ON ip.id_pedido = p.id_pedidos
";

if ($vendedorSelecionado) {
    $query .= " WHERE v.id_vendedores = " . (int)$vendedorSelecionado;
}

$query .= "
    GROUP BY
        v.id_vendedores
    ORDER BY
        total_vendas DESC;
";

$result = mysqli_query($con, $query);

if (!$result) {
    $_SESSION['msg'] = '<span>Erro: Não foi possível obter os dados dos vendedores.</span>';
    header("Location: listar-vendedores.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listar Vendedores</title>
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
        <h1>Desempenho dos Vendedores</h1>

        <form method="POST" action="">
            <div class="form-group">
                <label for="vendedor">Filtrar por Vendedor:</label>
                <select name="vendedor" id="vendedor">
                    <option value="">Todos</option>
                    <?php while ($vendedor = mysqli_fetch_assoc($vendedoresResult)) : ?>
                        <option value="<?= $vendedor['id_vendedores']; ?>" <?= $vendedor['id_vendedores'] == $vendedorSelecionado ? 'selected' : ''; ?>>
                            <?= $vendedor['nome']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn">Filtrar</button>
        </form>

        <div class="table-container">
            <table class="responsive-table">
                <thead>
                    <tr>
                        <th>Vendedor</th>
                        <th>Total de Itens Diferentes</th>
                        <th>Total de Vendas (R$)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) == 0) {
                        echo "<tr><td colspan='3' style='text-align: center;'>Nenhum vendedor encontrado.</td></tr>";
                    } else {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['vendedor']}</td>
                                    <td>{$row['total_itens_diferentes']}</td>
                                    <td>R$ " . number_format($row['total_vendas'], 2, ',', '.') . "</td>
                                  </tr>";
                        }
                    }
                    mysqli_close($con);
                    ?>
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
