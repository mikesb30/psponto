<?php
session_start();
include 'conexao.php';

// Verifica se o colaborador está logado (substitua 'cpf' e 'senha' com a lógica de autenticação)
if (!isset($_SESSION['cpf'])) {
    header("Location: login.php"); // Redireciona para login se não estiver autenticado
    exit();
}

// Recupere o id do colaborador da sessão
$colaborador_id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Ponto</title>
    <script>
        // Função para mostrar o horário atual
        function mostrarHora() {
            var data = new Date();
            var horas = data.getHours().toString().padStart(2, '0');
            var minutos = data.getMinutes().toString().padStart(2, '0');
            var segundos = data.getSeconds().toString().padStart(2, '0');
            var horarioAtual = horas + ':' + minutos + ':' + segundos;
            document.getElementById('horaAtual').innerHTML = horarioAtual;
            setTimeout(mostrarHora, 1000); // Atualiza o horário a cada segundo
        }
    </script>
</head>
<body onload="mostrarHora()">

    <h1>Registrar Ponto</h1>
    <p>Hora Atual: <span id="horaAtual"></span></p>
    
    <form method="POST" action="registrar_ponto.php">
        <input type="hidden" name="colaborador_id" value="<?php echo $colaborador_id; ?>">

        <!-- Mostrar as etapas de registro de ponto -->
        <label for="tipoPonto">Escolha a Etapa:</label>
        <select name="tipoPonto" id="tipoPonto" required>
            <option value="inicio_jornada">Início da Jornada</option>
            <option value="saida_almoco">Saída para Almoço</option>
            <option value="retorno_almoco">Retorno do Almoço</option>
            <option value="fim_jornada">Fim da Jornada</option>
        </select><br><br>

        <button type="submit">Bater Ponto</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Pega os dados do formulário
        $colaborador_id = $_POST['colaborador_id'];
        $tipoPonto = $_POST['tipoPonto'];
        $horaAtual = date('H:i:s'); // Hora atual no formato de 24 horas

        // Verifica qual tipo de ponto está sendo registrado
        if ($tipoPonto == 'inicio_jornada') {
            $sql = "UPDATE pontos SET inicio_jornada = '$horaAtual' WHERE colaborador_id = $colaborador_id AND data = CURDATE()";
        } elseif ($tipoPonto == 'saida_almoco') {
            $sql = "UPDATE pontos SET saida_almoco = '$horaAtual' WHERE colaborador_id = $colaborador_id AND data = CURDATE()";
        } elseif ($tipoPonto == 'retorno_almoco') {
            $sql = "UPDATE pontos SET retorno_almoco = '$horaAtual' WHERE colaborador_id = $colaborador_id AND data = CURDATE()";
        } elseif ($tipoPonto == 'fim_jornada') {
            $sql = "UPDATE pontos SET fim_jornada = '$horaAtual' WHERE colaborador_id = $colaborador_id AND data = CURDATE()";
        }

        // Conexão com o banco e execução da query
        $result = $conn->query($sql);

        if ($result) {
            echo "<p>Ponto registrado com sucesso para o tipo: $tipoPonto às $horaAtual.</p>";
        } else {
            echo "<p>Erro ao registrar o ponto. Tente novamente.</p>";
        }
    }

    $conn->close();
    ?>

</body>
</html>
