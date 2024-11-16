<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Testando a conexão com o banco de dados...<br>";

// Teste de conexão com o banco
$servername = "localhost"; 
$username = "root"; // substitua com o seu usuário do MySQL, se necessário
$password = ""; // substitua com a senha do seu banco de dados
$dbname = "controle_ponto"; // nome do seu banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
} else {
    echo "Conexão bem-sucedida ao banco de dados!";
}
?>
