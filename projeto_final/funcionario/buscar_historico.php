<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'clinicav11');

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

if (isset($_POST['nomePaciente'])) {
    // Obtém o nome do paciente pesquisado
    $nomePacientePesquisado = $_POST['nomePaciente'];

    // Exibe o nome do paciente pesquisado
    echo "<h2>Histórico de Consultas para $nomePacientePesquisado</h2>";

    // Consulta para obter o código do paciente
    $stmt = $conn->prepare("SELECT codigo_pessoa FROM dados_pessoa WHERE nome = ?");
    $stmt->bind_param('s', $nomePacientePesquisado);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $codigoPaciente = $row['codigo_pessoa'];

        // Consulta para obter o histórico de consultas do paciente
        $stmt = $conn->prepare("
            SELECT a.*, s.nome AS nome_servico
            FROM agenda a
            INNER JOIN servicos s ON a.codigo_servico = s.codigo_servico
            WHERE a.codigo_paciente = ? AND DATE(a.horario) < CURDATE()
        ");
        $stmt->bind_param('i', $codigoPaciente);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<h3>Histórico de Consultas</h3>";
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>Serviço: " . $row['nome_servico'] . " - Data: " . $row['horario'] . "</li>";
        }
        echo "</ul>";

        // Consulta para obter os pagamentos do paciente
        $stmt = $conn->prepare("
            SELECT p.*, s.nome AS nome_servico
            FROM pagamentos p
            INNER JOIN agenda a ON p.codigo_pagamento = a.codigo_pagamento
            INNER JOIN servicos s ON a.codigo_servico = s.codigo_servico
            WHERE p.codigo_paciente = ?
        ");
        $stmt->bind_param('i', $codigoPaciente);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<h3>Pagamentos</h3>";
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>Valor: " . $row['valor'] . " - Data: " . $row['horario'] . " - Forma: " . $row['forma'] . " - Código da Transação: " . $row['codigo_transacao'] . " - Serviço: " . $row['nome_servico'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Nenhum paciente encontrado.";
    }

    $stmt->close();
    $conn->close();
}
?>
