function confirmarSolicitacao(codigoSolicitacao) {
    // Solicitar confirmação antes de executar a ação
    if (confirm('Tem certeza de que deseja confirmar esta solicitação?')) {
        // Enviar requisição AJAX para confirmar a solicitação no banco de dados
        fetch('confirmar_solicitacao.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ codigoSolicitacao: codigoSolicitacao }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Ocorreu um erro ao confirmar a solicitação.');
            }
            // Remover a solicitação da interface após a confirmação
            const solicitacaoElement = document.getElementById(`solicitacao-${codigoSolicitacao}`);
            solicitacaoElement.remove();
        })
        .catch(error => {
            console.error(error);
            alert('Ocorreu um erro ao confirmar a solicitação. Por favor, tente novamente.');
        });
    }
}

function negarSolicitacao(codigoSolicitacao) {
    // Solicitar confirmação antes de executar a ação
    if (confirm('Tem certeza de que deseja negar esta solicitação?')) {
        // Enviar requisição AJAX para negar a solicitação no banco de dados
        fetch('negar_solicitacao.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ codigoSolicitacao: codigoSolicitacao }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Ocorreu um erro ao negar a solicitação.');
            }
            // Remover a solicitação da interface após a negação
            const solicitacaoElement = document.getElementById(`solicitacao-${codigoSolicitacao}`);
            solicitacaoElement.remove();
        })
        .catch(error => {
            console.error(error);
            alert('Ocorreu um erro ao negar a solicitação. Por favor, tente novamente.');
        });
    }
}
