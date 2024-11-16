<?php
include 'conexao.php';
session_start();

// Verificar se o administrador está logado
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

$colaborador_id = $_GET['id'];

// Buscar dados do colaborador
$sql_colaborador = "SELECT * FROM colaboradores WHERE id = $colaborador_id";
$colaborador = $conn->query($sql_colaborador)->fetch_assoc();

// Buscar registros de ponto do colaborador
$sql_pontos = "SELECT * FROM pontos WHERE colaborador_id = $colaborador_id ORDER BY data DESC";
$pontos = $conn->query($sql_pontos);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Colaborador</title>
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
            max-width: 1200px;
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

        .colaborador-info {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .colaborador-info p {
            font-size: 18px;
            margin: 10px 0;
        }

        .table-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #4CAF50;
            color: white;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        table a {
            color: #FFB300;
            text-decoration: none;
            font-weight: bold;
        }

        table a:hover {
            color: #FF8F00;
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

            .colaborador-info p {
                font-size: 16px;
            }

            table th, table td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Detalhes do Colaborador</h1>
        </header>

        <a href="dashboard_admin.php" class="back-link">Voltar para a lista de colaboradores</a>

        <div class="colaborador-info">
            <p><strong>Nome:</strong> <?php echo $colaborador['nome']; ?></p>
            <p><strong>CPF:</strong> <?php echo $colaborador['cpf']; ?></p>
            <p><strong>Função:</strong> <?php echo $colaborador['funcao']; ?></p>
        </div>

        <div class="table-container">
            <h3>Registros de Ponto</h3>
            <table>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Início</th>
                        <th>Saída Almoço</th>
                        <th>Retorno Almoço</th>
                        <th>Fim</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($ponto = $pontos->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $ponto['data']; ?></td>
                        <td><?php echo $ponto['inicio_jornada']; ?></td>
                        <td><?php echo $ponto['saida_almoco']; ?></td>
                        <td><?php echo $ponto['retorno_almoco']; ?></td>
                        <td><?php echo $ponto['fim_jornada']; ?></td>
                        <td>
                            <a href="corrigir_ponto.php?ponto_id=<?php echo $ponto['id']; ?>">Corrigir</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
