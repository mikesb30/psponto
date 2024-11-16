<?php
// Verificar se uma sessão já está ativa, caso contrário, iniciar uma nova sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('conexao.php'); // Inclui a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha_fornecida = $_POST['senha'];

    // Verificar se a conexão foi estabelecida corretamente
    if (!$conn) {
        die("Erro ao conectar com o banco de dados!");
    }

    // Consulta ao banco para buscar o administrador com base no nome de usuário
    $query = "SELECT * FROM admin WHERE usuario = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param('s', $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $admin = $resultado->fetch_assoc();

            // Verifica se a senha fornecida corresponde à senha armazenada no banco
            if ($senha_fornecida === $admin['senha']) {
                // Se a senha for correta, login bem-sucedido
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['usuario'] = $admin['usuario'];
                header("Location: dashboard_admin.php");
                exit();
            } else {
                $erro = "Senha incorreta!";
            }
        } else {
            $erro = "Usuário não encontrado!";
        }
        $stmt->close();
    } else {
        $erro = "Erro na preparação da consulta!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Administrador</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #003c4f; /* Azul petróleo */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            border: 1px solid #d1d1d1;
        }

        .login-container h2 {
            color: #4CAF50; /* Verde do projeto */
            margin-bottom: 20px;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #FFB300; /* Amarelo do projeto */
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: #ffa000; /* Cor um pouco mais escura do amarelo */
        }

        .error-message {
            color: #D32F2F; /* Vermelho para erros */
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login - Administrador</h2>
        <form method="POST" action="login_admin.php">
            <input type="text" name="usuario" placeholder="Usuário" required><br>
            <input type="password" name="senha" placeholder="Senha" required><br>
            <button type="submit">Entrar</button>
        </form>

        <?php if (isset($erro)): ?>
            <div class="error-message"><?= $erro; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
