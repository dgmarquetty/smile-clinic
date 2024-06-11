<?php 
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'clinicav11');

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Variável para o código do paciente
$codigo_paciente = 1; // Exemplo fixo; ajustar conforme necessário

// Obter os serviços disponíveis
$servicos = $conn->query("SELECT codigo_servico, nome FROM servicos");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmar'])) {
    // Obter os dados do formulário
    $codigo_servico = $_POST['codigo_servico'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];

    // Combinar data e hora em um único campo
    $data_horario = $data . ' ' . $hora . ':00';

    // Validar se a data e horário são válidos
    $data = new DateTime($data_horario);
    $dia_semana = (int)$data->format('N'); // 1 (segunda) a 7 (domingo)

    if ($dia_semana >= 6) {
        echo "Horário inválido. Por favor, escolha um horário de segunda a sexta.";
    } else {
        // Inserir a solicitação no banco de dados
        $stmt = $conn->prepare("INSERT INTO solicitacoes (codigo_solicitacao, codigo_paciente, codigo_servico, codigo_clinica, horario, situacao) VALUES (NULL, ?, ?, 1, ?, 'E')");
        $stmt->bind_param('iis', $codigo_paciente, $codigo_servico, $data_horario);

        if ($stmt->execute()) {
            echo "Solicitação de agendamento enviada com sucesso!";
        } else {
            echo "Erro ao enviar solicitação: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/projeto_final/css/agenda.css">
    <title>Solicitação de Agendamento</title>
        <div class="buttom">
            <a href="http://localhost/projeto_unificado/projeto_final/sistema.php?pagina=menu" class="button">Voltar</a>
        </div>
    <script>
        function validateDateTime() {
            const dateInput = document.getElementById('data');
            const selectedDate = new Date(dateInput.value);
            const dayOfWeek = selectedDate.getUTCDay(); // 0 (Domingo) - 6 (Sábado)

            if (dayOfWeek === 0 || dayOfWeek === 6) {
                alert('Data inválida. Por favor, escolha um dia de segunda a sexta.');
                dateInput.value = '';
            }
        }
    </script>
</head>
<body>
    <h1>Solicitação de Agendamento</h1>
    <form method="post">
        <label for="servico">Serviço:</label>
        <select name="codigo_servico" id="servico" required>
            <?php while ($row = $servicos->fetch_assoc()): ?>
                <option value="<?= $row['codigo_servico'] ?>"><?= $row['nome'] ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="data">Data:</label>
        <input type="date" name="data" id="data" required onchange="validateDateTime()"><br><br>

        <label for="hora">Hora:</label>
        <select name="hora" id="hora" required>
            <?php for ($i = 8; $i <= 17; $i++): ?>
                <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>:00"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>:00</option>
            <?php endfor; ?>
        </select><br><br>

        <button type="submit" name="confirmar">Confirmar</button>
    </form>
</body>
</html>
