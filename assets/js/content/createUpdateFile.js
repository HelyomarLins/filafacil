console.log('Função createUpdateFiles carregada');

function createUpdateFiles(form, urlAPI) {
    console.log("createUpdateFiles chamada!");

    // Desabilita o botão de submit para evitar envios duplicados
    form.querySelector('input[type="submit"]').disabled = true;

    // Cria um objeto FormData com os dados do formulário
    const dadosFormulario = new FormData(form);
    console.log('Dados do formulário:', ...dadosFormulario.entries());

    fetch(urlAPI, {
        method: "POST",
        body: dadosFormulario
    })
        .then(response => {
            console.log('Resposta completa da API:', response);
            if (response.ok) {
                return response.json();
            } else {
                return response.json().then(errorData => {
                    throw new Error(errorData.message || 'Erro ao cadastrar. Tente novamente.');
                });
            }
        })
        .then(resposta => {
            console.log('Resposta da API (JSON):', resposta);

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

            Toast.fire({
                icon: resposta.icon || "success",
                title: resposta.message
            }).then(() => {
                if (resposta.redirect) {
                    closeModalCad();
                    loadContent(resposta.redirect);
                } else {
                    console.warn('A resposta da API não contém um redirecionamento.');
                }
            });

            form.reset();
        })
        .catch(error => {
            console.error('Erro na requisição:', error);

            Swal.fire({
                text: error.message,
                icon: "error",
                confirmButtonColor: "#3085d6",
            });
        })
        .finally(() => {
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

// Chama a função para iniciar a validação **APENAS DENTRO DO DOMContentLoaded**
document.addEventListener('DOMContentLoaded', function () {
    const cadUsuarioForm = document.getElementById('cadForm');
    if (cadUsuarioForm) {
        // Aqui você pode adicionar a validação do formulário se necessário
    }
});
