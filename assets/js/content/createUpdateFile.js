console.log('Função createUpdateFiles carregada');

function createUpdateFiles(form, urlAPI) {
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            console.log("createUpdateFiles chamada!");

            // Desabilita o botão de submit para evitar envios duplicados
            form.querySelector('button[type="submit"]').disabled = true;

            const dadosFormulario = new FormData(form);

            try {
                console.log('Enviando dados para a API...', dadosFormulario);
                const response = await fetch(urlAPI, {
                    method: "POST",
                    body: dadosFormulario
                });

                console.log('Resposta completa da API:', response);

                if (response.ok) {
                    const resposta = await response.json();
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
                            closeModalCad();  // Fechar o modal
                            loadContent(resposta.redirect);  // Redirecionar se necessário
                        } else {
                            console.warn('A resposta da API não contém um redirecionamento.');
                        }
                    });

                    // Limpa o formulário após o cadastro bem-sucedido
                    form.reset();
                } else {
                    console.error('Erro na requisição:', response.status);

                    const errorData = await response.json().catch(() => { });
                    const mensagemErro = errorData ? errorData.message : 'Erro ao cadastrar. Tente novamente.';

                    Swal.fire({
                        text: mensagemErro,
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                    });
                }
            } catch (error) {
                console.error('Erro ao processar dados:', error);
                Swal.fire({
                    text: 'Erro ao tentar processar dados. Tente novamente.',
                    icon: "error",
                    confirmButtonColor: "#3085d6",
                });
            } finally {
                // Reativa o botão de submit após o processamento
                form.querySelector('button[type="submit"]').disabled = false;
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