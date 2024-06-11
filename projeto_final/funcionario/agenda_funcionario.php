<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="projeto_final/css/agenda.css"> <!-- Verifique o caminho -->
    <title>Agenda</title>
</head>
<body>
    <div class="buttom">
        <a href="http://localhost/projeto_unificado/projeto_final/sistema.php?pagina=menu" class="button">Voltar</a>
    </div>
    <div class="container">
        <h1>Agenda</h1>
        <form method="post" action="agenda_funcionario.php">
            <div class="form-row">
                <label for="data">Selecione a Data:</label>
                <input id="data" type="date" name="data" value="<?= htmlspecialchars($data) ?>" required>
                <span>Mostrando Data: <?= date('d/m/Y', strtotime($data)) ?></span>
            </div>
            <div class="form-row">
                <button type="submit">Pesquisar</button>
            </div>
        </form>

        <!-- Tabela de agendamentos aqui -->
        <?php if ($result): ?>
            <table>
                <thead>
                    <tr>
                        <th>Horário</th>
                        <th>Nome do Paciente</th>
                        <th>Nome do Serviço</th>
                        <th>Nome do Funcionário</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Generate all time slots
                    $start_time = strtotime('08:00');
                    $end_time = strtotime('17:00');

                    $times = [];
                    for ($time = $start_time; $time <= $end_time; $time = strtotime('+60 minutes', $time)) {
                        $times[date('H:i', $time)] = [];
                    }

                    // Fill in appointments
                    if ($result->num_rows > 0): 
                        while ($row = $result->fetch_assoc()): 
                            if (is_null($row['situacao'])) {
                                $times[date('H:i', strtotime($row['horario']))] = [
                                    'nome_paciente' => $row['nome_paciente'],
                                    'nome_servico' => $row['nome_servico'],
                                    'nome_funcionario' => $row['nome_funcionario']
                                ];
                            }
                        endwhile; 
                    endif;

                    // Display time slots and appointments
                    foreach ($times as $time => $appointment): ?>
                        <tr>
                            <td><?= $time ?></td>
                            <td><?= $appointment['nome_paciente'] ?? '' ?></td>
                            <td><?= $appointment['nome_servico'] ?? '' ?></td>
                            <td><?= $appointment['nome_funcionario'] ?? '' ?></td>
                            <td>
                                <?php if (!empty($appointment)): ?>
                                    <form method="post" action="agenda_funcionario.php" style="display:inline;">
                                        <input type="hidden" name="horario" value="<?= date('Y-m-d H:i:s', strtotime($data . ' ' . $time)) ?>">
                                        <button type="submit" name="desmarcar_horario">Desmarcar</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
