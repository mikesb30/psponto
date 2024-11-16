<?php
session_start();
include('conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $novo_usuario = $_POST['novo_usuario'];
    $nova_senha = $_POST['nova_senha'];

    // Valida a nova senha (pode adicionar mais validações)
    if (strlen($nova_senha) < 6) {
        echo "A senha precisa ter pelo menos 6 caracteres.";
    } else {
        // Criptografa a nova senha
        $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

        // Atualiza o nome de usuário e senha no banco e marca como alterada
        $query = "UPDATE admin SET usuario = ?, senha = ?, senha_alterada = TRUE WHERE id = 1";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ss", $novo_usuario, $nova_senha_hash);
        $stmt->execute();

        echo "Nome de usuário e senha alterados com sucesso!";
        header("Location: painel_admin.php");
        exit();
    }
}
?>

<form method="POST" action="definir_usuario_senha.php">
    <input type="text" name="novo_usuario" placeholder="Novo Nome de Usuário" required><br>
    <input type="password" name="nova_senha" placeholder="Nova Senha" required><br>
    <button type="submit">Alterar Nome e Senha</button>
</form>
