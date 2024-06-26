// JavaScript para abrir o modal e carregar os dados da fila
document.addEventListener('DOMContentLoaded', function () {
    const modalUtils = {
        modais: {} // Objeto para armazenar as instâncias dos modais
    };

    const modalMap = {
        // Mapeamento de classes de botões para IDs de modais
        'btnEditar': 'modalEditarFila', // Exemplo: btnEditar mapeado para modalEditarFila
        // Adicione mais mapeamentos conforme necessário
    };

    document.querySelectorAll('.open-modal').forEach(element => {
        element.addEventListener('click', () => {
            for (const className of element.classList) {
                if (modalMap[className]) {
                    const modalId = modalMap[className];
                    const modalElement = document.getElementById(modalId);

                    if (modalElement) {
                        let myModal = modalUtils.modais[modalId];
                        if (!myModal) {
                            myModal = new bootstrap.Modal(modalElement);
                            modalUtils.modais[modalId] = myModal;
                        }

                        // Obtém o ID da fila a partir do botão clicado
                        const filaId = element.getAttribute('data-id');

                        // Chamada AJAX para buscar os detalhes da fila
                        console.log('enviando dados para api');
                        fetch(`detalhes_fila.php?id_criar_fila=${filaId}`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Erro na requisição: ' + response.status);
                                }
                                return response.json();
                            })
                            .then(data => {
                                // Preencher os campos do modal com os dados retornados
                                document.getElementById('nome_fila').value = data.nome_fila;
                                document.getElementById('qtd_fila').value = data.qtd_fila;
                                document.getElementById('data_inicio_fila').value = data.data_inicio_fila;
                                document.getElementById('cod_acess_fila').value = data.cod_acess_fila;

                                // Abrir o modal após carregar os dados
                                myModal.show();
                            })
                            .catch(error => console.error('Erro ao carregar dados da fila:', error));
                        alert('Erro ao carregar dados da fila, tente novamdnte');
                    } else {
                        console.error(`Elemento modal com ID "${modalId}" não encontrado!`);
                    }

                    break; // Sai do loop após encontrar a classe correspondente
                }
            }
        });
    });
});
