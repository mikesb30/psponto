<?php
// Incluir a conexão com o banco de dados
include 'conexao.php';

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receber os dados do formulário
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $funcao = $_POST['funcao'];
    $celular = $_POST['celular'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografar a senha

    // Inserir os dados no banco de dados
    $sql = "INSERT INTO colaboradores (nome, cpf, funcao, celular, senha) 
            VALUES ('$nome', '$cpf', '$funcao', '$celular', '$senha')";

    if ($conn->query($sql) === TRUE) {
        $mensagem = "Colaborador cadastrado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Colaborador</title>
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
        h2 {
            color: #ff7f32; /* Laranja */
        }
        .content {
            padding: 20px;
            text-align: center;
        }
        form {
            background-color: #2c3e50; /* Azul escuro */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            margin: 0 auto;
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
            color: green;
            font-size: 18px;
            margin-top: 20px;
        }
        .error {
            color: red;
            font-size: 18px;
            margin-top: 20px;
        }
        .logout {
            display: block;
            margin-top: 20px;
            text-align: center;
            font-size: 16px;
            color: #ff7f32; /* Laranja */
            text-decoration: none;
        }
        .logout:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <img src="petstop.png" alt="Logo Pet Stop">
    </header>
    <div class="content">
        <h2>Cadastro de Colaborador</h2>
        
        <?php if (isset($mensagem)): ?>
            <p class="<?php echo isset($mensagem) && strpos($mensagem, 'sucesso') !== false ? 'message' : 'error'; ?>">
                <?php echo $mensagem; ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required><br>

            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" maxlength="11" required><br>

            <label for="funcao">Função:</label>
            <input type="text" name="funcao" id="funcao"><br>

            <label for="celular">Celular:</label>
            <input type="text" name="celular" id="celular"><br>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required><br>

            <button type="submit">Cadastrar</button>
        </form>
        
        <a class="logout" href="dashboard_admin.php">Voltar</a>
    </div>
</body>
</html>
