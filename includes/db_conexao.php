<?php
// Configurações do Banco de Dados
$servername = "localhost";
$username = "inventario_user"; // Use um usuário que não seja o root!
$password = "sua_senha_secreta"; 
$dbname = "inventario_db";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checa a conexão
if ($conn->connect_error) {
    // Para ambientes de produção, não mostre a mensagem de erro ao usuário!
    die("Erro de Conexão com o Banco de Dados. Contate o suporte. " . $conn->connect_error);
}
// Se a conexão for bem-sucedida, a variável $conn estará disponível
// para os scripts que incluírem este arquivo.
?>