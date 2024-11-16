<?php
session_start();
include('conexao.php'); // Inclui a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha_fornecida = $_POST['senha'];

    // Consulta ao banco para buscar o administrador
    $query = "SELECT * FROM admin WHERE id = 1"; 
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $admin = $resultado->fetch_assoc();

            // Verifica se o nome de usuário e senha são os padrões (primeiro acesso)
            if ($admin['usuario'] == 'pet' && $admin['senha'] == '1234') {
                // Redireciona para a página de definição do novo nome e senha
                header("Location: definir_usuario_senha.php");
                exit();
            }

            // Verifica se a senha fornecida corresponde ao hash no banco
            if (password_verify($senha_fornecida, $admin['senha'])) {
                // Se a senha for correta e já estiver alterada, login bem-sucedido
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['usuario'] = $admin['usuario'];
                header("Location: painel_admin.php");
                exit();
            } else {
                echo "Senha incorreta!";
            }
        } else {
            echo "Usuário não encontrado!";
        }
    } else {
        echo "Erro ao preparar a consulta: " . $mysqli->error;
    }
}
?>

<form method="POST" action="login_admin.php">
    <input type="text" name="usuario" placeholder="Usuário" required><br>
    <input type="password" name="senha" placeholder="Senha" required><br>
    <button type="submit">Login</button>
</form>
