console.log('Modais internos carregados');

// Define o objeto modalUtils no escopo global
const modalUtils = {
    modais: {} // Objeto para armazenar as instâncias dos modais
};

// Função para abrir o modal com base nas classes dos botões
function openModal(btnCriar, modalCriarFila, btnEditar, modalEditarFila, btnDeletar, modalDeletarFila) {
    // Mapeamento de classes de botões para IDs de modais
    const modalMap = {
        [btnCriar]: modalCriarFila,
        [btnEditar]: modalEditarFila,
        [btnDeletar]: modalDeletarFila
        // Adicione mais mapeamentos conforme necessário
    };

    document.querySelectorAll('.open-modal').forEach(element => {
        element.addEventListener('click', () => {
            console.log('Elemento clicado:', element);

            // Itera sobre as classes do elemento para encontrar a correspondente no mapeamento
            for (const className of element.classList) {
                if (modalMap[className]) {
                    const modalId = modalMap[className];
                    console.log(`Abrindo modal "${modalId}"`);

                    // Obtém o elemento modal correspondente
                    const modalElement = document.getElementById(modalId);
                    if (modalElement) {
                        // Verifica se o modal já foi instanciado
                        let myModal = modalUtils.modais[modalId];
                        if (!myModal) {
                            // Instancia o modal se necessário
                            myModal = new bootstrap.Modal(modalElement);

                            // Armazena a instância
                            modalUtils.modais[modalId] = myModal;
                        }

                        // Abre o modal
                        myModal.show();
                    } else {
                        console.error(`Elemento modal com ID "${modalId}" não encontrado!`);
                    }

                    // Sai do loop após encontrar a classe correspondente
                    break;
                }
            }
        });
    });
}


