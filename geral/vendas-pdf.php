<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include(__DIR__ . '/../config/connection.php');
require_once __DIR__ . '/../autoload.inc.php';
global $con;

use Dompdf\Dompdf;
use Dompdf\Options;

$vendedorSelecionado = isset($_POST['vendedor']) ? $_POST['vendedor'] : null;

if (!$vendedorSelecionado) {
    header("Location: vendas-vendedor.php");
    exit();
}

$vendedoresQuery = "SELECT id_vendedores, nome FROM vendedores ORDER BY nome ASC";
$vendedoresResult = mysqli_query($con, $vendedoresQuery);

$query = "
    SELECT
        v.nome AS vendedor,
        COUNT(DISTINCT p.id_pedidos) AS total_pedidos_diferentes,
        SUM(p.valor_total) AS total_vendas
    FROM
        pedidos p
    JOIN
        vendedores v ON v.id_vendedores = p.id_vendedor
    WHERE
        (p.status_pedido = 'ativo' OR p.status_pedido = 'cancelado')
";

if ($vendedorSelecionado) {
    $query .= " AND v.id_vendedores = " . (int)$vendedorSelecionado;
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
    header("Location: vendas-vendedor.php");
    exit();
}

$html = '
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Relatório de Desempenho dos Vendedores</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h1>Desempenho dos Vendedores</h1>
    <table>
        <thead>
            <tr>
                <th>Vendedor</th>
                <th>Total de vendas Diferentes</th>
                <th>Total de Vendas (R$)</th>
            </tr>
        </thead>
        <tbody>';
        
        if (mysqli_num_rows($result) == 0) {
            $html .= "<tr><td colspan='3' style='text-align: center;'>Nenhuma venda encontrada.</td></tr>";
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                $html .= "<tr>
                            <td>{$row['vendedor']}</td>
                            <td>{$row['total_pedidos_diferentes']}</td>
                            <td>R$ " . number_format($row['total_vendas'], 2, ',', '.') . "</td>
                          </tr>";
            }
        }

$html .= '</tbody>
    </table>
</body>
</html>';

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("relatorio_vendedores.pdf", array("Attachment" => 0));

mysqli_close($con);
exit();
?>
