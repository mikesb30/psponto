<?php
include 'conexao.php';
session_start();

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];

    // Buscar o colaborador pelo CPF
    $sql = "SELECT * FROM colaboradores WHERE cpf = '$cpf'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $colaborador = $resultado->fetch_assoc();

        // Verificar a senha
        if (password_verify($senha, $colaborador['senha'])) {
            // Salvar informações na sessão e redirecionar para a página de ponto
            $_SESSION['colaborador_id'] = $colaborador['id'];
            $_SESSION['colaborador_nome'] = $colaborador['nome'];
            header("Location: registrar_ponto.php");
            exit();
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Colaborador não encontrado!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login do Colaborador</title>
</head>
<body>
    <h2>Login do Colaborador</h2>
    <?php if (isset($erro)): ?>
        <p style="color: red;"><?php echo $erro; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>CPF:</label><br>
        <input type="text" name="cpf" required><br><br>

        <label>Senha:</label><br>
        <input type="password" name="senha" required><br><br>

        <button type="submit">Entrar</button>
    </form>
    <br>
    <a href="index.php">Voltar à Página Inicial</a>
</body>
</html>
