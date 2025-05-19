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
        SUM(CASE WHEN p.status_pedido = 'ativo' THEN p.valor_total ELSE 0 END) AS total_ativo,
        SUM(CASE WHEN p.status_pedido = 'cancelado' THEN p.valor_total ELSE 0 END) AS total_cancelado
    FROM
        pedidos p
    JOIN
        vendedores v ON v.id_vendedores = p.id_vendedor
    WHERE
        p.data_pedido BETWEEN '$initialDate' AND '$finalDate'
    GROUP BY
        v.id_vendedores
    ORDER BY
        v.nome;
";

$queryTotal = "
    SELECT
        SUM(CASE WHEN p.status_pedido = 'ativo' THEN p.valor_total ELSE 0 END) AS total_ativo,
        SUM(CASE WHEN p.status_pedido = 'cancelado' THEN p.valor_total ELSE 0 END) AS total_cancelado
    FROM
        pedidos p
    WHERE
        p.data_pedido BETWEEN '$initialDate' AND '$finalDate';
";

$resultVendedores = mysqli_query($con, $queryVendedores);
$resultTotal = mysqli_query($con, $queryTotal);

if (!$resultVendedores || !$resultTotal) {
    $_SESSION['msg'] = '<span>Erro: Não foi possível obter os dados dos pedidos.</span>';
    header("Location: filtrar-data.php");
    exit();
}

$rowTotal = mysqli_fetch_assoc($resultTotal);
$totalVendasAtivo = $rowTotal['total_ativo'] ?? 0;
$totalVendasCancelado = $rowTotal['total_cancelado'] ?? 0;

$html = '
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Relatório de Vendas por Vendedor</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .totals { margin-top: 20px; }
        .totals p { font-weight: bold; }
    </style>
</head>
<body>
    <h1>Relatório de Vendas por Vendedor</h1>
    <p>Período: ' . date('d/m/Y', strtotime($initialDate)) . ' a ' . date('d/m/Y', strtotime($finalDate)) . '</p>
    <div class="totals">
        <p>Total Geral de Vendas Ativas: R$ ' . number_format($totalVendasAtivo, 2, ',', '.') . '</p>
        <p>Total Geral de Vendas Canceladas: R$ ' . number_format($totalVendasCancelado, 2, ',', '.') . '</p>
    </div>
    <h2>Vendas por Vendedor</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Vendedor</th>
                <th>Total de Vendas Ativas</th>
                <th>Total de Vendas Canceladas</th>
            </tr>
        </thead>
        <tbody>';

while ($row = mysqli_fetch_assoc($resultVendedores)) {
    $html .= '<tr>
                <td>' . htmlspecialchars($row['vendedor']) . '</td>
                <td>R$ ' . number_format($row['total_ativo'], 2, ',', '.') . '</td>
                <td>R$ ' . number_format($row['total_cancelado'], 2, ',', '.') . '</td>
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
$dompdf->stream("relatorio_vendas_vendedores.pdf", array("Attachment" => 0));

mysqli_close($con);
exit();
?>
