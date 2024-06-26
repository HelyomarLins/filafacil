console.log('Função createUpdateFiles carregada');

function createUpdateFiles(form, urlAPI) {
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault(); // Previne o comportamento padrão de envio do formulário
            console.log("createUpdateFiles chamada!");

            // Desabilita o botão de submit para evitar envios duplicados
            form.querySelector('input[type="submit"]').disabled = true;

            const dadosFormulario = new FormData(form); // Cria um objeto FormData com os dados do formulário

            try {
                console.log('Enviando dados para a API...', dadosFormulario);
                const response = await fetch(urlAPI, { // Faz a requisição para a API
                    method: "POST",
                    body: dadosFormulario
                });

                console.log('Resposta completa da API:', response);

                // Verifica se a requisição foi bem-sucedida (código 200-299)
                if (response.ok) {
                    const resposta = await response.json(); // Converte a resposta da API (JSON) para um objeto JavaScript
                    console.log('Resposta da API (JSON):', resposta);

                    // Cria uma instância do SweetAlert2 para exibir notificações
                    const Toast = Swal.mixin({
                        toast: true, // Exibe como uma notificação toast
                        position: "top-end", // Posição da notificação
                        showConfirmButton: false, // Não exibe botão de confirmação
                        timer: 1000, // Tempo de exibição em milissegundos
                        timerProgressBar: true, // Exibe uma barra de progresso
                        didOpen: (toast) => { // Função executada quando a notificação é aberta
                            toast.addEventListener('mouseenter', Swal.stopTimer); // Pausa o timer ao passar o mouse
                            toast.addEventListener('mouseleave', Swal.resumeTimer); // Continua o timer ao retirar o mouse
                        }
                    });

                    // Exibe a notificação de sucesso
                    Toast.fire({
                        icon: resposta.icon || "success", // Ícone da notificação (usa "success" como padrão)
                        title: resposta.message // Mensagem da notificação
                    }).then(() => {
                        // Após a notificação ser fechada
                        if (resposta.redirect) {
                            closeModalCad(); // Fecha o modal de cadastro
                            loadContent(resposta.redirect); // Carrega o conteúdo da URL especificada
                        } else {
                            console.warn('A resposta da API não contém um redirecionamento.');
                        }
                    });

                    // Limpa o formulário após o cadastro bem-sucedido
                    form.reset();
                } else {
                    // A requisição não foi bem-sucedida
                    console.error('Erro na requisição:', response.status);

                    // Tenta converter a resposta da API para JSON (caso seja um erro formatado)
                    const errorData = await response.json().catch(() => { });

                    // Define a mensagem de erro a ser exibida
                    // Se errorData existir e tiver a propriedade message, usa essa mensagem
                    // Caso contrário, usa a mensagem padrão 'Erro ao cadastrar. Tente novamente.'
                    const mensagemErro = errorData ? errorData.message : 'Erro ao cadastrar. Tente novamente.';

                    // Exibe um alerta de erro com a mensagem definida acima
                    Swal.fire({
                        text: mensagemErro,
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                    });
                }
            } catch (error) {
                // Captura erros durante a execução do código assíncrono
                console.error('Erro ao processar dados:', error);

                // Exibe um alerta de erro genérico
                Swal.fire({
                    text: 'Erro ao tentar processar dados. Tente novamente.',
                    icon: "error",
                    confirmButtonColor: "#3085d6",
                });
            } finally {
                // Garante que o botão de submit seja reativado após o processamento, 
                // independentemente do sucesso ou falha da requisição.
                form.querySelector('input[type="submit"]').disabled = false;
            }
        });
    } else {
        console.error('Formulário não encontrado!');
    }
}
// Função para fechar o modal e limpar o formulário
function closeModalCad() {
    const modais = document.querySelectorAll('.modal.fade');
    modais.forEach(modal => {
        const modalInstance = bootstrap.Modal.getInstance(modal);
        if (modalInstance) {
            modalInstance.hide();
        }
    });
}

// Chama a função para iniciar a validação **APENAS DENTRO DE createUpdateFiles**
document.addEventListener("DOMContentLoaded", () => {
    const formulario = document.querySelector("#cadLoginUsers");
    if (formulario) {
        createUpdateFiles(formulario, '/Fila_Facil/API/access_1.php');
    }
});