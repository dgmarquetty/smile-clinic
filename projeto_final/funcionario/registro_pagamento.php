<?php
session_start();

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cpf'])) {
    $cpf = $_POST['cpf'];

    // Conexão ao banco de dados
    $conn = new mysqli('localhost', 'root', '', 'clinicav11');

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    // Seleciona os serviços não pagos do cliente
    $stmt = $conn->prepare("
        SELECT 
            a.atendimento,
            s.nome AS servico,
            s.valor AS valor,
            a.horario AS data_horario,
            dp.nome AS nome_paciente,
            dp.cpf AS cpf
        FROM 
            dados_pessoa dp
            INNER JOIN paciente p ON dp.codigo_pessoa = p.codigo_pessoa
            INNER JOIN agenda a ON p.codigo_paciente = a.codigo_paciente
            INNER JOIN servicos s ON a.codigo_servico = s.codigo_servico
            LEFT JOIN pagamentos pg ON a.codigo_pagamento = pg.codigo_pagamento
        WHERE 
            dp.cpf = ?
            AND pg.codigo_pagamento IS NULL;
    ");
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fecha a conexão
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/projeto_final/css/main.css">
    <link rel="stylesheet" href="/projeto_final/css/agenda.css">
    <title>Registro de Pagamento</title>
    <script>
        function showAlert(message) {
            alert(message);
        }
    </script>
</head>
<body>
    <h1>Registro de Pagamento</h1>
    <div class="buttom">
        <a href="http://localhost/projeto_unificado/projeto_final/sistema.php?pagina=menu" class="button">Voltar</a>
    </div>
    <br>
    <?php
    if (isset($_SESSION['success'])) {
        echo '<script>showAlert("Pagamento registrado com sucesso!");</script>';
        unset($_SESSION['success']);
    }
    ?>
    <form method="post" action="">
        <div class="form-row">
            <label for="cpf">CPF do Cliente:</label>
            <input type="text" name="cpf" id="cpf"required>
        </div>
        <div class="form-row">
            <button type="submit">Buscar Serviços</button>
        </div>
    </form>

    <?php if (isset($result) && $result->num_rows > 0): ?>
        <form method="post" action="processar_pagamento.php">
            <input type="hidden" name="cpf" value="<?= htmlspecialchars($cpf) ?>">
            <div class="form-row">
                <label for="servico">Serviço:</label>
                <select name="atendimento" id="servico" required>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <option value="<?= $row['atendimento'] ?>">
                            <?= htmlspecialchars($row['servico']) ?> - R$ <?= number_format($row['valor'], 2, ',', '.') ?> - <?= date('H:i d-m', strtotime($row['data_horario'])) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-row">
                <label for="valor">Valor:</label>
                <input type="text" name="valor" id="valor" required>
            </div>
            <div class="form-row">
                <label for="codigo_transacao">Código da Transação:</label>
                <input type="text" name="codigo_transacao" id="codigo_transacao" required>
            </div>
            <div class="form-row">
                <label for="forma">Forma de Pagamento:</label>
                <select name="forma" id="forma" required>
                    <option value="Pix">Pix</option>
                    <option value="Débito">Débito</option>
                    <option value="Crédito">Crédito</option>
                </select>
            </div>
            <div class="form-row">
                <button type="submit">Confirmar Pagamento</button>
            </div>
        </form>
    <?php elseif (isset($result)): ?>
        <p>Não há serviços não pagos para este cliente.</p>
    <?php endif; ?>
</body>
</html>
