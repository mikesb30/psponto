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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1a2a4b; /* Azul escuro */
            color: white;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #ff7f32; /* Laranja */
            padding: 20px;
            text-align: center;
        }
        header img {
            max-width: 150px;
        }
        .content {
            padding: 20px;
            text-align: center;
        }
        h2 {
            color: #ff7f32; /* Laranja */
        }
        form {
            background-color: #2c3e50; /* Azul escuro */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            margin: 40px auto;
        }
        label {
            font-size: 18px;
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #fff;
            border-radius: 5px;
            background-color: #34495e; /* Azul mais claro */
            color: white;
            font-size: 16px;
        }
        button {
            background-color: #ff7f32; /* Laranja */
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #e65c2d; /* Laranja escuro */
        }
        .message {
            color: red;
            font-size: 18px;
            margin-top: 20px;
        }
        .link-voltar {
            display: block;
            margin-top: 20px;
            font-size: 16px;
            color: #ff7f32; /* Laranja */
            text-decoration: none;
        }
        .link-voltar:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <img src="petstop.png" alt="Logo Pet Stop">
    </header>
    <div class="content">
        <h2>Login do Colaborador</h2>
        
        <?php if (isset($erro)): ?>
            <p class="message"><?php echo $erro; ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>

            <button type="submit">Entrar</button>
        </form>

        <a class="link-voltar" href="index.php">Voltar à Página Inicial</a>
    </div>
</body>
</html>
