/* == CRIAR FILAS == */
console.log('Função createUpdateFiles carregada');

function createUpdateFiles(form, urlAPI) {
    console.log("createUpdateFiles chamada!");

    // Desabilita o botão de submit para evitar envios duplicados
    form.querySelector('input[type="submit"]').disabled = true;

    // Cria um objeto FormData com os dados do formulário
    const dadosFormulario = new FormData(form);

    fetch(urlAPI, {
        method: "POST",
        body: dadosFormulario
    })
        .then(response => {
            console.log('Resposta completa da API:', response);
            if (response.ok) {
                // Converte a resposta da API (JSON) para um objeto JavaScript
                return response.json();
            } else {
                return response.json().then(errorData => {
                    throw new Error(errorData.message || 'Erro ao cadastrar. Tente novamente.');
                });
            }
        })
        .then(resposta => {
            console.log('Resposta da API (JSON):', resposta);

            // Cria uma instância do SweetAlert2 para exibir notificações
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            // Exibe a notificação de sucesso
            Toast.fire({
                icon: resposta.icon || "success",
                title: resposta.message
            }).then(() => {
                if (resposta.redirect) {
                    closeModalCad(); // Fecha o modal de cadastro
                    loadContent(resposta.redirect); // Carrega o conteúdo da URL especificada
                } else {
                    console.warn('A resposta da API não contém um redirecionamento.');
                }
            });

            // Limpa o formulário após o cadastro bem-sucedido
            form.reset();
        })
        .catch(error => {
            console.error('Erro na requisição:', error);

            // Exibe um alerta de erro com a mensagem definida
            Swal.fire({
                text: error.message,
                icon: "error",
                confirmButtonColor: "#3085d6",
            });
        })
        .finally(() => {
            // Garante que o botão de submit seja reativado após o processamento
            form.querySelector('input[type="submit"]').disabled = false;
        });
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

document.addEventListener("DOMContentLoaded", () => {
    const createForm = document.querySelector("#createFilesUser");
    const editForm = document.querySelector("#editFilesUser");

    if (createForm) {
        createForm.addEventListener('submit', function (e) {
            e.preventDefault();
            createUpdateFiles(this, '/Fila_Facil/API/access_1.php');
        });
    }

    if (editForm) {
        editForm.addEventListener('submit', function (e) {
            e.preventDefault();
            createUpdateFiles(this, '/Fila_Facil/API/access_1.php');
        });
    }
});

