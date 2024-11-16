<?php
include 'conexao.php';
session_start();

// Verificar se o administrador está logado
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

// Obter o ID do ponto a ser corrigido
$ponto_id = $_GET['ponto_id'];

// Buscar os dados do ponto selecionado
$sql = "SELECT p.*, c.nome FROM pontos p 
        JOIN colaboradores c ON p.colaborador_id = c.id 
        WHERE p.id = $ponto_id";
$resultado = $conn->query($sql);
$ponto = $resultado->fetch_assoc();

// Atualizar o registro de ponto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inicio_jornada = $_POST['inicio_jornada'];
    $saida_almoco = $_POST['saida_almoco'];
    $retorno_almoco = $_POST['retorno_almoco'];
    $fim_jornada = $_POST['fim_jornada'];
    $justificativa = $_POST['justificativa'];

    // Atualizar no banco de dados
    $sql_update = "UPDATE pontos SET 
                    inicio_jornada = '$inicio_jornada',
                    saida_almoco = '$saida_almoco',
                    retorno_almoco = '$retorno_almoco',
                    fim_jornada = '$fim_jornada',
                    justificativa = '$justificativa'
                  WHERE id = $ponto_id";
    $conn->query($sql_update);

    echo "<p style='color: green;'>Ponto atualizado com sucesso!</p>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correção de Ponto</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* Estilo geral da página */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background-color: #003c4f;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 36px;
        }

        .back-link {
            margin-top: 10px;
            display: inline-block;
            background-color: #FFB300;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
        }

        .back-link:hover {
            background-color: #FF8F00;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
        }

        .form-container input,
        .form-container textarea,
        .form-container button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        /* Ajuste para inputs de tempo */
        .form-container input[type="time"] {
            font-size: 14px;
            padding: 8px;
            width: auto; /* Permitir que o campo se ajuste ao tamanho do conteúdo */
            max-width: 120px; /* Limitar a largura do campo de hora */
        }

        .form-container textarea {
            font-size: 16px;
            resize: vertical;
        }

        .form-container button {
            background-color: #FFB300;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border: none;
        }

        .form-container button:hover {
            background-color: #FF8F00;
        }

        .message {
            color: green;
            margin-top: 20px;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            header h1 {
                font-size: 28px;
            }

            .back-link {
                padding: 8px 15px;
                font-size: 16px;
            }

            .form-container label {
                font-size: 14px;
            }

            .form-container input,
            .form-container textarea,
            .form-container button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Correção de Ponto para <?php echo $ponto['nome']; ?></h1>
        </header>

        <a href="dashboard_admin.php" class="back-link">Voltar ao Painel</a>

        <div class="form-container">
            <form method="POST">
                <label>Início da Jornada:</label>
                <input type="time" name="inicio_jornada" value="<?php echo $ponto['inicio_jornada']; ?>" required><br>

                <label>Saída para Almoço:</label>
                <input type="time" name="saida_almoco" value="<?php echo $ponto['saida_almoco']; ?>"><br>

                <label>Retorno do Almoço:</label>
                <input type="time" name="retorno_almoco" value="<?php echo $ponto['retorno_almoco']; ?>"><br>

                <label>Fim da Jornada:</label>
                <input type="time" name="fim_jornada" value="<?php echo $ponto['fim_jornada']; ?>" required><br>

                <label>Justificativa:</label>
                <textarea name="justificativa" rows="4"><?php echo $ponto['justificativa']; ?></textarea><br>

                <button type="submit">Atualizar Ponto</button>
            </form>
        </div>

        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <div class="message">
            Ponto atualizado com sucesso!
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
