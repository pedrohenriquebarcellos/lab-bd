<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include(__DIR__ . '/../config/connection.php');
require_once __DIR__ . '/../autoload.inc.php';
global $con;

use Dompdf\Dompdf;
use Dompdf\Options;

$initialDate = $_POST['data-inicial'] ?? null;
$finalDate = $_POST['data-final'] ?? null;

if (!$initialDate || !$finalDate) {
    $_SESSION['msg'] = '<span>Por favor, selecione um intervalo de datas.</span>';
    header("Location: filtrar-data.php");
    exit();
}

$finalDate = date('Y-m-d 23:59:59', strtotime($finalDate));

$queryVendedores = "
    SELECT
        v.nome AS vendedor,
        SUM(ip.quantidade * ip.preco_unit) AS total_vendas
    FROM
        pedidos p
    JOIN
        itens_pedido ip ON ip.id_pedido = p.id_pedidos
    JOIN
        vendedores v ON v.id_vendedores = p.id_vendedor
    WHERE
        p.data_pedido BETWEEN '$initialDate' AND '$finalDate'
    GROUP BY
        v.id_vendedores
    ORDER BY
        total_vendas DESC;
";

$queryTotal = "
    SELECT
        SUM(ip.quantidade * ip.preco_unit) AS total_vendas
    FROM
        pedidos p
    JOIN
        itens_pedido ip ON ip.id_pedido = p.id_pedidos
    WHERE
        p.data_pedido BETWEEN '$initialDate' AND '$finalDate' A;
";

$resultVendedores = mysqli_query($con, $queryVendedores);
$resultTotal = mysqli_query($con, $queryTotal);

if (!$resultVendedores || !$resultTotal) {
    $_SESSION['msg'] = '<span>Erro: Não foi possível obter os dados dos pedidos.</span>';
    header("Location: filtrar-data.php");
    exit();
}

$rowTotal = mysqli_fetch_assoc($resultTotal);
$totalVendasGeral = $rowTotal['total_vendas'] ?? 0;

$html = '
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Relatório de Vendas</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .totals { margin-top: 20px; }
        .totals p { font-weight: bold; }
    </style>
</head>
<body>
    <h1>Relatório de Vendas</h1>
    <p>Período: ' . date('d/m/Y', strtotime($initialDate)) . ' a ' . date('d/m/Y', strtotime($finalDate)) . '</p>
    <div class="totals">
        <p>Total Geral de Vendas: R$ ' . number_format($totalVendasGeral, 2, ',', '.') . '</p>
    </div>
    <h2>Vendas por Vendedor</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Vendedor</th>
                <th>Total de Vendas</th>
            </tr>
        </thead>
        <tbody>';

while ($row = mysqli_fetch_assoc($resultVendedores)) {
    $html .= '<tr>
                <td>' . htmlspecialchars($row['vendedor']) . '</td>
                <td>R$ ' . number_format($row['total_vendas'], 2, ',', '.') . '</td>
              </tr>';
}

$html .= '</tbody>
    </table>
</body>
</html>';

$options = new Options();
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("relatorio_vendas.pdf", array("Attachment" => 0));

mysqli_close($con);
exit();
?>
