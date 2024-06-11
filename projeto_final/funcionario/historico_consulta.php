<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'clinicav11');

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Consulta para obter todos os nomes de pacientes
$stmt = $conn->prepare("SELECT codigo_pessoa, nome FROM dados_pessoa");
$stmt->execute();
$result = $stmt->get_result();

// Exibe uma lista de nomes de pacientes como links
echo "<h2>Lista de Pacientes</h2>";
echo "<ul>";
while ($row = $result->fetch_assoc()) {
    echo "<li><a href='#' class='nomePaciente'>" . $row['nome'] . "</a></li>";
}
echo "</ul>";

// Fecha a conexão
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Consultas</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <h1>Histórico de Consultas</h1>
    <form id="formBusca">
        <label for="nomePaciente">Nome do Paciente:</label>
        <input type="text" name="nomePaciente" id="nomePaciente">
        <button type="submit" name="buscar">Buscar</button>
    </form>
    <div id="historico">
        <!-- Resultados serão exibidos aqui -->
    </div>

    <script>
    $(document).ready(function() {
        $('#formBusca').submit(function(e) {
            e.preventDefault();
            var nomePaciente = $('#nomePaciente').val();

            // Requisição AJAX para buscar histórico do paciente
            $.ajax({
                type: 'POST',
                url: 'buscar_historico.php',
                data: { nomePaciente: nomePaciente },
                success: function(response) {
                    $('#historico').html(response);
                }
            });
        });

        $('#nomePaciente').keyup(function() {
            var pesquisa = $(this).val();

            // Requisição AJAX para buscar lista de pacientes
            $.ajax({
                type: 'POST',
                url: 'buscar_pacientes.php',
                data: { pesquisa: pesquisa },
                success: function(response) {
                    $('#historico').html(response);
                }
            });
        });
    });
    document.querySelectorAll('.nomePaciente').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Impede o comportamento padrão do link
            // Preenche o campo de entrada com o nome do paciente clicado
            document.getElementById('nomePaciente').value = this.textContent;
            // Aciona a função de busca
            document.getElementById('btnBuscar').click();
        });
    });
    </script>
</body>
</html>
