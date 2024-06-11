<?php
// Define o fuso horário 
date_default_timezone_set('America/Sao_Paulo');

#require_once 'funcoes.php';

$erro = false;
$result = null;
$data = date('Y-m-d'); // Data atual como padrão

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['data'] ?? $data;
}

// Conexão ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'clinicav11');

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Consulta SQL usando prepared statement
$stmt = $conn->prepare("
    SELECT 
        a.horario
    FROM 
        agenda a
    WHERE 
        DATE(a.horario) = ?
");
$stmt->bind_param('s', $data);
$stmt->execute();
$result = $stmt->get_result();

// Fecha a conexão
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/projeto_final/css/agenda.css">
    <title>Agenda - Paciente</title>
</head>
<body>
    <div class="buttom">
        <a href="http://localhost/projeto_unificado/projeto_final/sistema.php?pagina=menu" class="button">Voltar</a>
    </div>
    <div class="container">
        <h1>Agenda - Paciente</h1>
        <form method="post" action="agenda_paciente.php">
            <div class="form-row">
                <label for="data">Selecione a Data:</label>
                <input id="data" type="date" name="data" value="<?= htmlspecialchars($data) ?>" required>
            </div>
            <div class="form-row data-selecionada">
                <span>Data selecionada: <?= date('d/m/Y', strtotime($data)) ?></span>
            </div>
            <div class="form-row">
                <button type="submit">Pesquisar</button>
            </div>
            <div class="buttom">
                <a href="http://localhost/projeto_unificado/projeto_final/paciente/solicitacao_agendamento.php" class="button">Marcar Horario</a>
            </div>

        <!-- Tabela de horários disponíveis -->
        <?php if ($result): ?>
            <table>
                <thead>
                    <tr>
                        <th>Horário</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Generate all time slots
                    $start_time = strtotime('08:00');
                    $end_time = strtotime('17:00');

                    $times = [];
                    for ($time = $start_time; $time <= $end_time; $time = strtotime('+60 minutes', $time)) {
                        $times[date('H:i', $time)] = '';
                    }

                    // Fill in appointments
                    if ($result->num_rows > 0): 
                        while ($row = $result->fetch_assoc()): 
                            $times[date('H:i', strtotime($row['horario']))] = 'ocupado';
                        endwhile; 
                    endif;

                    // Display time slots and availability
                    foreach ($times as $time => $availability): ?>
                        <tr>
                            <td><?= $time ?></td>
                            <td class="<?= $availability ? 'ocupado' : 'disponivel' ?>"><?= $availability ? 'Ocupado' : 'Disponível' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
