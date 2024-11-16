<?php
include 'conexao.php';

$usuario = 'admin';
$senha = password_hash('admin', PASSWORD_DEFAULT); // Senha mais segura

// Usando prepared statements para evitar injeção de SQL
$sql = "INSERT INTO admin (usuario, senha) VALUES (?, ?)";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ss", $usuario, $senha); // "ss" significa dois parâmetros do tipo string
    if ($stmt->execute()) {
        echo "Administrador criado com sucesso!";
    } else {
        echo "Erro ao criar administrador: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Erro ao preparar a consulta: " . $conn->error;
}
?>
