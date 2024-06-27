console.log('Lista de filas do usário carregada');

document.addEventListener('DOMContentLoaded', function () {
    const listAccessForm = document.getElementById('listAccessForm');

    if (listAccessForm) {
        listAccessForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (listAccessForm.checkValidity() === false) {
                e.stopPropagation();
                listAccessForm.classList.add('was-validated');
                return;
            }

            // Prepara dados do formulário para envio via FETCH
            const dadosLogin = new FormData(listAccessForm);

            try {
                const response = await fetch('http://localhost/Fila_Facil/system/filas/loistaAccessUsu.php', {
                    method: "POST",
                    body: dadosLogin
                });

                // Converte a resposta devolvida para json
                const resposta = await response.json();

                if (resposta.status) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 500,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer);
                            toast.addEventListener('mouseleave', Swal.resumeTimer);
                        }
                    });

                    Toast.fire({
                        icon: "success",
                        title: resposta.msg
                    }).then(() => {
                        closeModalAccess();
                        // Redireciona para a página dash
                        window.location.href = "./layout/dash.php";
                    });
                } else {
                    Swal.fire({
                        text: resposta.msg,
                        icon: "error",
                        confirmButtonColor: "#3085d6"
                    });
                }
            } catch (error) {
                console.error("Erro durante o login:", error);
                Swal.fire({
                    text: 'Ocorreu um erro ao tentar logar. Tente novamente.',
                    icon: "error",
                    confirmButtonColor: "#3085d6"
                });
                closeModalAccess();
            }
        });

        listAccessForm.addEventListener('input', function (event) {
            if (event.target.checkValidity()) {
                event.target.classList.remove('is-invalid');
                event.target.classList.add('is-valid');
            } else {
                event.target.classList.remove('is-valid');
                event.target.classList.add('is-invalid');
            }
        }, false);
    }
});

function closeModalAccess() {
    const modal = document.getElementById('modalListar');
    if (modal) {
        const modalInstance = bootstrap.Modal.getInstance(modal);
        if (modalInstance) {
            modalInstance.hide();
        }
    }

    const inputs = document.querySelectorAll('#listAccessForm input');
    inputs.forEach(input => {
        input.value = '';
        input.classList.remove('is-valid', 'is-invalid');
    });

    const listAccessForm = document.getElementById('listAccessForm');
    if (listAccessForm) {
        listAccessForm.classList.remove('was-validated');
    }
}
