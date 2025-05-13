<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include(__DIR__ . '/../config/connection.php');

$initialDate = $_POST['data-inicial'] ?? null;
$finalDate = $_POST['data-final'] ?? null;

$queryResult = null;

if ($initialDate && $finalDate) {

    $query = "
        SELECT id_pedidos, valor_total, status_pedido, fp.descricao FROM pedidos p 
        JOIN vendedores v ON v.id_vendedores = p.id_vendedor
        JOIN forma_pagamento fp ON fp.id_pagamentos = p.id_forma_pagamento
        WHERE p.data_pedido BETWEEN '$initialDate' AND '$finalDate'
        ORDER BY id_pedidos ASC;
    ";

    $queryResult = mysqli_query($con, $query);

    if ($queryResult === false) {
        $_SESSION['msg'] = '<span>Erro na consulta ao banco de dados.</span>';
    }
}
?>

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
        <a href="../pedido/pesquisar-pedidos.php" class="go-back">
            <i class="fa-solid fa-arrow-left"></i>
            <h3>Voltar</h3>
        </a>
        <?php
        if (isset($_SESSION['msg'])) {
            echo "<div class='alert'>" . $_SESSION['msg'] . "</div>";
            unset($_SESSION['msg']);
        }
        ?>
        <h1>Resultado pesquisa por Data</h1>

        <div class="table-container">
            <table class="responsive-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Valor Total</th>
                        <th>Forma de Pagamento</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    if (!$queryResult) {
                        echo "<tr><td colspan='5' style='text-align: center;>Erro ao buscar os pedidos.</td></tr>";
                    } elseif (mysqli_num_rows($queryResult) == 0) {
                        echo "<tr><td colspan='5' style='text-align: center;'>Nenhum pedido encontrado.</td></tr>";
                    } else {
                        $totalVendas = 0;

                        while ($reg = mysqli_fetch_array($queryResult)) {
                            $totalVendas += $reg['valor_total'];

                            echo "<tr><td>" . $reg['id_pedidos'] . "</td>";
                            echo "<td>R$" . $reg['valor_total'] . "</td>";
                            echo "<td>" . $reg['descricao'] . "</td>";
                            echo "<td>" . $reg['status_pedido'] . "</td>";
                            echo "<td><a href='editar-pedido.php?id=" . $reg['id_pedidos'] . "' class='btn-edit'><i class='fas fa-edit'></i> Editar</a></td></tr>";
                        }
                    }

                    mysqli_close($con);
                    ?>
                </tbody>
            </table>

            <?php if ($initialDate && $finalDate && $totalVendas > 0): ?>
                <div class="totals">
                    <h2>Total de vendas entre <?= date('d/m/Y', strtotime($initialDate)) ?> e <?= date('d/m/Y', strtotime($finalDate)) ?>:</h2>
                    <p><strong>R$ <?= number_format($totalVendas, 2, ',', '.') ?></strong></p>
                </div>
            <?php endif; ?>
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