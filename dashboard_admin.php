<?php
include 'conexao.php';
session_start();

// Verificar se o administrador está logado
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

// Buscar todos os colaboradores
$sql = "SELECT * FROM colaboradores";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Administrador</title>
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

        /* Barra de navegação */
        nav {
            display: flex;
            justify-content: flex-end;
            margin: 20px 0;
        }

        nav a {
            color: #FFB300;
            text-decoration: none;
            padding: 10px 15px;
            background-color: #fff;
            border-radius: 5px;
            margin-left: 20px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        nav a:hover {
            background-color: #FF8F00;
        }

        /* Botão de cadastro */
        .btn-cadastrar {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-bottom: 20px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-cadastrar:hover {
            background-color: #45a049;
        }

        /* Tabela de colaboradores */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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

            nav {
                flex-direction: column;
                align-items: flex-start;
            }

            nav a {
                margin-left: 0;
                margin-bottom: 10px;
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
            <h1>Painel de Administração</h1>
        </header>

        <nav>
            <a href="logout.php">Logout</a>
        </nav>

        <!-- Botão para cadastrar colaborador -->
        <a href="cadastro_colaborador.php" class="btn-cadastrar">Cadastrar Colaborador</a>

        <h3>Lista de Colaboradores</h3>
        
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Função</th>
                    <th>Celular</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($colaborador = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $colaborador['nome']; ?></td>
                    <td><?php echo $colaborador['cpf']; ?></td>
                    <td><?php echo $colaborador['funcao']; ?></td>
                    <td><?php echo $colaborador['celular']; ?></td>
                    <td>
                        <a href="detalhes_colaborador.php?id=<?php echo $colaborador['id']; ?>">Ver Detalhes</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
