<?php

    // Conexão ao banco de dados
    $conn = new mysqli('localhost', 'root', '', 'clinicav11');
    
    // Verifica a conexão
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }
    
// Código do confirmar_solicitacao.php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmar'])) {
    $codigo_solicitacao = $_POST['codigo_solicitacao'];

    // Seleciona os dados da solicitação
    $stmt = $conn->prepare("SELECT codigo_paciente, codigo_servico, horario FROM solicitacoes WHERE codigo_solicitacao = ?");
    $stmt->bind_param("i", $codigo_solicitacao);
    $stmt->execute();
    $result = $stmt->get_result();
    $solicitacao = $result->fetch_assoc();
    
    // Determina o código do funcionário
    $horario = strtotime($solicitacao['horario']);
    $codigo_fun = (date('H', $horario) < 13) ? 1 : 4;
    
    // Insere a consulta na agenda
    $stmt = $conn->prepare("INSERT INTO agenda (codigo_paciente, codigo_servico, codigo_fun, codigo_clinica, codigo_solicitacao, horario) VALUES (?, ?, ?, 1, ?, ?)");
    $stmt->bind_param("iiiis", $solicitacao['codigo_paciente'], $solicitacao['codigo_servico'], $codigo_fun, $codigo_solicitacao, $solicitacao['horario']);
    $stmt->execute();
    
    
    // Atualiza o status da solicitação para confirmado e registra na agenda
    $stmt = $conn->prepare("UPDATE solicitacoes SET situacao = 'C', hora_visto = NOW() WHERE codigo_solicitacao = ?");
    $stmt->bind_param("i", $codigo_solicitacao);
    $stmt->execute();
    
    // Fecha a conexão
    $stmt->close();
    $conn->close();
    
    // Redireciona de volta para a página principal
    header("Location: gerenciar_solicitacao.php");
    exit();
}
?>

<?php
// Código do negar_solicitacao.php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['negar'])) {
    $codigo_solicitacao = $_POST['codigo_solicitacao'];
    
    // Atualiza o status da solicitação para negado
    $stmt = $conn->prepare("UPDATE solicitacoes SET situacao = 'N', hora_visto = NOW() WHERE codigo_solicitacao = ?");
    $stmt->bind_param("i", $codigo_solicitacao);
    $stmt->execute();
    
    // Fecha a conexão
    $stmt->close();
    $conn->close();
    
    // Redireciona de volta para a página principal
    header("Location: gerenciar_solicitacao.php");
    exit();
}
?>

<?php
// Código principal (gerenciar_solicitacao.php)
$conn = new mysqli('localhost', 'root', '', 'clinicav11');

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$stmt = $conn->prepare("
    SELECT 
        s.codigo_solicitacao,
        dp.nome AS nome_paciente,
        se.nome AS nome_servico,
        DATE_FORMAT(s.horario, '%H:%i %d-%m') AS horario_formatado
    FROM 
        solicitacoes s
    INNER JOIN paciente p ON s.codigo_paciente = p.codigo_paciente
    INNER JOIN dados_pessoa dp ON p.codigo_pessoa = dp.codigo_pessoa
    INNER JOIN servicos se ON s.codigo_servico = se.codigo_servico
    WHERE 
        s.situacao = 'E'
");
$stmt->execute();
$result = $stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/projeto_final/css/agenda.css">
    <link rel="stylesheet" href="/projeto_final/css/main.css">
    <title>Gerenciar Solicitações</title>
</head>
<body>
    <div class="buttom">
        <a href="http://localhost/projeto_unificado/projeto_final/sistema.php?pagina=menu" class="button">Voltar</a>
    </di>
    <table>
        <h1>Solicitações em Aguardo</h1>
        <div class="buttom">
            <a href="http://localhost/projeto_unificado/projeto_final/sistema.php?pagina=menu" class="button">Voltar</a>
        </div>
        <thead>
            <tr>
                <th>Nome do Paciente</th>
                <th>Nome do Serviço</th>
                <th>Horário</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['nome_paciente'] ?></td>
                    <td><?= $row['nome_servico'] ?></td>
                    <td><?= $row['horario_formatado'] ?></td>
                    <td>
                        <form method="post" action="gerenciar_solicitacao.php">
                            <input type="hidden" name="codigo_solicitacao" value="<?= $row['codigo_solicitacao'] ?>">
                            <button type="submit" name="confirmar">Confirmar</button>
                        </form>
                        <form method="post" action="gerenciar_solicitacao.php">
                            <input type="hidden" name="codigo_solicitacao" value="<?= $row['codigo_solicitacao'] ?>">
                            <button type="submit" name="negar">Negar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <script>"/projeto_final/js/gerenciar_solicitacao.js"</script>
</body>
</html>
