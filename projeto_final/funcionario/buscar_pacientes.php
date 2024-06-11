<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'clinicav11');

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

if (isset($_POST['pesquisa'])) {
    $pesquisa = '%' . $_POST['pesquisa'] . '%';
    $stmt = $conn->prepare("SELECT nome FROM dados_pessoa WHERE nome LIKE ?");
    $stmt->bind_param('s', $pesquisa);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<li>" . $row['nome'] . "</li>";
        }
    } else {
        echo "<li>Nenhum paciente encontrado.</li>";
    }

    $stmt->close();
    $conn->close();
}
?>
