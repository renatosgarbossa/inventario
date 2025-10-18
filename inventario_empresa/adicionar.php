<?php
// Inclui o arquivo de conexão, tornando $conn disponível
include 'includes/db_conexao.php'; 

// Verifica se o formulário foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Sanitiza os dados
    $tipo = $conn->real_escape_string($_POST['tipo']);
    $patrimonio = $conn->real_escape_string($_POST['patrimonio']);
    $marca_modelo = $conn->real_escape_string($_POST['marca_modelo']);
    $configuracao = $conn->real_escape_string($_POST['configuracao']);
    $teclado = $conn->real_escape_string($_POST['teclado']);
    $mouse = $conn->real_escape_string($_POST['mouse']);
    $nobreak = $conn->real_escape_string($_POST['nobreak']);
    $localizacao = $conn->real_escape_string($_POST['localizacao']);

    // 2. Prepara e executa a query SQL
    $sql = "INSERT INTO eletronicos (tipo, patrimonio, marca_modelo, configuracao, teclado, mouse, nobreak, localizacao) 
            VALUES ('$tipo', '$patrimonio', '$marca_modelo', '$configuracao', '$teclado', '$mouse', '$nobreak', '$localizacao')";

    if ($conn->query($sql) === TRUE) {
        // Redireciona para a página principal após o sucesso
        echo "<script>alert('Novo equipamento cadastrado com sucesso! Patrimônio: $patrimonio'); window.location.href = 'index.html';</script>";
    } else {
        // Trata erro de patrimônio duplicado (código 1062)
        if ($conn->errno == 1062) {
             echo "<script>alert('ERRO: O Nº de Patrimônio ($patrimonio) já existe no sistema.'); window.history.back();</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar: " . $conn->error . "'); window.history.back();</script>";
        }
    }
}

// Fecha a conexão
$conn->close();
?>