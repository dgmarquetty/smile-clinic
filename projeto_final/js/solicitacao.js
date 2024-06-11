document.addEventListener("DOMContentLoaded", function() {
    // Seleciona todos os botões "Disponível"
    var disponivelButtons = document.querySelectorAll(".disponivel-btn");

    // Adiciona um evento de clique a cada botão "Disponível"
    disponivelButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            // Obtém o horário correspondente ao botão clicado
            var horario = button.getAttribute("data-horario");

            // Exibe o modal correspondente ao horário
            var modal = document.getElementById("modal-servico-" + horario);
            if (modal) {
                modal.style.display = "block";
            }
        });
    });

    // Fecha o modal quando o usuário clica no botão "Fechar"
    var closeButtons = document.querySelectorAll(".close");
    closeButtons.forEach(function(closeButton) {
        closeButton.addEventListener("click", function() {
            var modal = closeButton.parentElement.parentElement;
            modal.style.display = "none";
        });
    });
});
