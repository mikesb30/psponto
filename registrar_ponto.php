<?php
include 'conexao.php';
session_start();

// Definir o fuso horário para Brasília
date_default_timezone_set('America/Sao_Paulo');

// Verificar se o colaborador está logado
if (!isset($_SESSION['colaborador_id'])) {
    header("Location: login_colaborador.php");
    exit();
}

$colaborador_id = $_SESSION['colaborador_id'];
$colaborador_nome = $_SESSION['colaborador_nome'];

// Buscar as horas acumuladas
$sql = "SELECT SUM(TIMESTAMPDIFF(HOUR, inicio_jornada, fim_jornada)) AS horas_trabalhadas 
        FROM pontos WHERE colaborador_id = $colaborador_id AND fim_jornada IS NOT NULL";
$resultado = $conn->query($sql);
$horas = $resultado->fetch_assoc();
$horas_acumuladas = $horas['horas_trabalhadas'] ?? 0;

// Verificar o tipo de ponto (início, almoço, retorno, fim)
$tipo_ponto = '';
$hoje = date('Y-m-d');

$sql_ponto = "SELECT * FROM pontos WHERE colaborador_id = $colaborador_id AND data = '$hoje'";
$resultado_ponto = $conn->query($sql_ponto);
$ponto = $resultado_ponto->fetch_assoc();

if (!$ponto) {
    $tipo_ponto = 'inicio_jornada';
} elseif (empty($ponto['saida_almoco'])) {
    $tipo_ponto = 'saida_almoco';
} elseif (empty($ponto['retorno_almoco'])) {
    $tipo_ponto = 'retorno_almoco';
} elseif (empty($ponto['fim_jornada'])) {
    $tipo_ponto = 'fim_jornada';
} else {
    $mensagem = "Você já registrou todos os pontos de hoje.";
}

// Registrar o ponto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $tipo_ponto) {
    // Captura o horário atual de Brasília
    $hora_atual = date('H:i:s'); // Agora pega o horário ajustado para Brasília

    if ($tipo_ponto == 'inicio_jornada') {
        $sql_insert = "INSERT INTO pontos (colaborador_id, data, inicio_jornada) VALUES ($colaborador_id, '$hoje', '$hora_atual')";
    } else {
        $sql_insert = "UPDATE pontos SET $tipo_ponto = '$hora_atual' WHERE id = {$ponto['id']}";
    }
    
    $conn->query($sql_insert);
    $mensagem = "Ponto registrado com sucesso!";
    header("Refresh:0"); // Atualizar a página para mostrar o próximo tipo de ponto
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Ponto</title>
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
        p {
            font-size: 18px;
        }
        .content {
            padding: 20px;
            text-align: center;
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
        #hora_atual {
            font-size: 20px;
            margin-top: 20px;
            font-weight: bold;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #fff;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #ff7f32; /* Laranja */
        }
        td {
            background-color: #2c3e50; /* Azul escuro */
        }
    </style>
</head>
<body>
    <header>
        <img src="petstop.png" alt="Logo Pet Stop">
    </header>
    <div class="content">
        <!-- Hora atual agora acima do nome -->
        <div id="hora_atual">Hora Atual: <span id="hora"></span></div>

        <h2>Olá, <?php echo $colaborador_nome; ?>!</h2>
        <p>Horas Acumuladas: <?php echo $horas_acumuladas; ?> horas</p>

        <?php if (isset($mensagem)): ?>
            <p class="message"><?php echo $mensagem; ?></p>
        <?php elseif ($tipo_ponto): ?>
            <form method="POST">
                <button type="submit">Registrar <?php echo ucfirst(str_replace('_', ' ', $tipo_ponto)); ?></button>
            </form>
        <?php else: ?>
            <p>Todos os pontos foram registrados para hoje.</p>
        <?php endif; ?>

        <!-- Quadro com os registros de ponto do dia -->
        <h3>Registros de Ponto do Dia</h3>
        <table>
            <thead>
                <tr>
                    <th>Início Jornada</th>
                    <th>Saída para Almoço</th>
                    <th>Retorno de Almoço</th>
                    <th>Fim Jornada</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Buscar todos os registros de ponto do dia
                $sql_registros = "SELECT inicio_jornada, saida_almoco, retorno_almoco, fim_jornada 
                                  FROM pontos 
                                  WHERE colaborador_id = $colaborador_id AND data = '$hoje'";
                $resultados_registros = $conn->query($sql_registros);

                // Exibir os registros
                if ($resultados_registros->num_rows > 0) {
                    while ($registro = $resultados_registros->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . ($registro['inicio_jornada'] ? $registro['inicio_jornada'] : '-') . "</td>";
                        echo "<td>" . ($registro['saida_almoco'] ? $registro['saida_almoco'] : '-') . "</td>";
                        echo "<td>" . ($registro['retorno_almoco'] ? $registro['retorno_almoco'] : '-') . "</td>";
                        echo "<td>" . ($registro['fim_jornada'] ? $registro['fim_jornada'] : '-') . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Nenhum ponto registrado para hoje.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <a class="logout" href="logout.php">Sair</a>
    </div>

    <script>
        // Função para exibir a hora atual
        function mostrarHora() {
            var data = new Date();
            var horas = data.getHours().toString().padStart(2, '0');
            var minutos = data.getMinutes().toString().padStart(2, '0');
            var segundos = data.getSeconds().toString().padStart(2, '0');
            var horaAtual = horas + ':' + minutos + ':' + segundos;
            document.getElementById('hora').innerText = horaAtual;
        }

        // Atualizar a hora a cada segundo
        setInterval(mostrarHora, 1000);
    </script>
</body>
</html>
