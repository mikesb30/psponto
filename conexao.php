<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "controle_ponto";

try {
    // Criar conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar se houve algum erro na conexão
    if ($conn->connect_error) {
        throw new Exception("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Definir charset para evitar problemas com caracteres especiais
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    // Para ambiente de desenvolvimento, mostre a mensagem de erro detalhada
    // Para produção, considere registrar o erro em um log e mostrar uma mensagem genérica
    die("Conexão falhou. Por favor, tente novamente mais tarde.");
}

// Se desejar usar a variável de conexão em outros arquivos:
// global $conn;
?>
