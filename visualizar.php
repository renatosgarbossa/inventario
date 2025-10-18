<?php
// Inclui o arquivo de conexão
include 'includes/db_conexao.php';

// Query para selecionar todos os dados
$sql = "SELECT id, tipo, patrimonio, marca_modelo, configuracao, teclado, mouse, nobreak, localizacao, data_cadastro FROM eletronicos ORDER BY data_cadastro DESC";
$result = $conn->query($sql);

// Verifica se o download foi solicitado pelo botão
if (isset($_GET['download']) && $_GET['download'] == 'true') {
    // ---------------------------------------------
    // 1. MODO DOWNLOAD CSV
    // ---------------------------------------------
    
    $filename = 'inventario_' . date('Ymd_His') . '.csv';

    // Headers para forçar o download
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    // Abre o ponteiro de saída
    $output = fopen('php://output', 'w');
    
    // Adiciona o cabeçalho CSV (usando ';' como delimitador para compatibilidade com Excel)
    $header = array('ID', 'Tipo', 'Patrimônio', 'Marca/Modelo', 'Configuração', 'Teclado', 'Mouse', 'Nobreak', 'Localização', 'Data Cadastro');
    fputcsv($output, $header, ';'); 

    // Itera e escreve os dados
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data = array(
                $row['id'], 
                $row['tipo'], 
                $row['patrimonio'], 
                $row['marca_modelo'], 
                $row['configuracao'], 
                $row['teclado'], 
                $row['mouse'], 
                $row['nobreak'], 
                $row['localizacao'], 
                $row['data_cadastro']
            );
            fputcsv($output, $data, ';');
        }
    }
    
    fclose($output);
    $conn->close();
    exit(); // Finaliza a execução

} else {
    // ---------------------------------------------
    // 2. MODO VISUALIZAÇÃO HTML (para o iframe)
    // ---------------------------------------------
    
    // CSS simples para a tabela de visualização
    echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><style>
        body { font-family: sans-serif; margin: 5px; }
        table { width: 100%; border-collapse: collapse; font-size: 0.8em; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; color: #333; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style></head><body>";
    
    echo "<table>";
    echo "<thead><tr><th>Tipo</th><th>Patrimônio</th><th>Marca/Modelo</th><th>Localização</th><th>Data Cadastro</th></tr></thead>";
    echo "<tbody>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['tipo']) . "</td>";
            echo "<td>" . htmlspecialchars($row['patrimonio']) . "</td>";
            echo "<td>" . htmlspecialchars($row['marca_modelo']) . "</td>";
            echo "<td>" . htmlspecialchars($row['localizacao']) . "</td>";
            echo "<td>" . htmlspecialchars($row['data_cadastro']) . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Nenhum equipamento cadastrado.</td></tr>";
    }

    echo "</tbody></table>";
    echo "</body></html>";
}

$conn->close();
?>