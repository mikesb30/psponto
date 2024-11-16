<?php
session_start();
include('conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nova_senha = $_POST['nova_senha'];

    // Valida a nova senha (pode adicionar mais validações)
    if (strlen($nova_senha) < 6) {
        echo "A senha precisa ter pelo menos 6 caracteres.";
    } else {
        // Criptografa a nova senha
        $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

        // Atualiza a senha no banco e marca como alterada
        $query = "UPDATE admin SET senha = ?, senha_alterada = TRUE WHERE id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("si", $nova_senha_hash, $_SESSION['admin_id']);
        $stmt->execute();

        echo "Senha alterada com sucesso!";
        header("Location: painel_admin.php");
        exit();
    }
}
?>

<form method="POST" action="alterar_senha.php">
    <input type="password" name="nova_senha" placeholder="Nova Senha" required><br>
    <button type="submit">Alterar Senha</button>
</form>
