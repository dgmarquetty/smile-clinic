<?php
session_start();

// Código do processar_pagamento.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf = $_POST['cpf'];
    $codigo_atendimento = $_POST['atendimento'];
    $valor = $_POST['valor'];
    $codigo_transacao = $_POST['codigo_transacao'];
    $forma = $_POST['forma'];

    // Conexão ao banco de dados
    $conn = new mysqli('localhost', 'root', '', 'clinicav11');

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    // Insere o pagamento
    $stmt = $conn->prepare("INSERT INTO pagamentos (valor, horario, forma, codigo_transacao, cpf) VALUES (?, NOW(), ?, ?, ?)");
    $stmt->bind_param("dsss", $valor, $forma, $codigo_transacao, $cpf);
    $stmt->execute();
    $codigo_pagamento = $stmt->insert_id;

    // Atualiza a tabela agenda com o código do pagamento
    $stmt = $conn->prepare("UPDATE agenda SET codigo_pagamento = ? WHERE atendimento = ?");
    $stmt->bind_param("ii", $codigo_pagamento, $codigo_atendimento);
    $stmt->execute();

    // Fecha a conexão
    $stmt->close();
    $conn->close();

    // Define uma variável de sessão para indicar sucesso
    $_SESSION['success'] = 1;

    // Redireciona de volta para a página de registro de pagamento
    header("Location: registro_pagamento.php");
    exit();
}
?>
