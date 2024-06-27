<div class="container mt-5">
    <h1>Fila de Chamadas</h1>
    <ul id="chamadas-list" class="list-group"></ul>
</div>

<script>
    async function fetchChamadas() {
        try {
            const response = await fetch('/Fila_Facil/API/function/get_chamadas.php');
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const chamadas = await response.json();
            const chamadasList = document.getElementById('chamadas-list');
            chamadasList.innerHTML = '';
            chamadas.forEach(chamada => {
                const listItem = document.createElement('li');
                listItem.className = 'list-group-item';
                listItem.textContent = `${chamada.nome_chamada} (Fila: ${chamada.nome_fila_chamada})`;
                listItem.onclick = () => handleChamada(chamada);
                chamadasList.appendChild(listItem);
            });
        } catch (error) {
            console.error('Erro ao buscar chamadas:', error);
            Swal.fire({
                icon: 'error',
                title: 'Erro ao carregar chamadas',
                text: error.message
            });
        }
    }

    function handleChamada(chamada) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: `${chamada.nome_chamada}\n ${chamada.posicao_chamada}`,
            text: `${chamada.nome_fila_chamada}`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "Atendido!",
            cancelButtonText: "Não!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                updateAtendimento(chamada.id_chamada, 'sim');
                swalWithBootstrapButtons.fire({
                    title: "Atendido!",
                    text: "Atendimento fechado com sucesso!",
                    icon: "success"
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                updateAtendimento(chamada.id_chamada, 'não');
                swalWithBootstrapButtons.fire({
                    title: "Não atendido!",
                    text: "Atendimento pendente!",
                    icon: "warning"
                });
            }
        });
    }

    async function updateAtendimento(id_chamada, atendido) {
        try {
            const formData = new FormData();
            formData.append('id_chamada', id_chamada);
            formData.append('atendido', atendido);

            const response = await fetch('/Fila_Facil/API/function/update_atendimento.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const result = await response.text();
            console.log('Update result:', result);
            fetchChamadas();
        } catch (error) {
            console.error('Erro ao atualizar atendimento:', error);
            Swal.fire({
                icon: 'error',
                title: 'Erro ao atualizar atendimento',
                text: error.message
            });
        }
    }

    document.addEventListener('DOMContentLoaded', fetchChamadas);
</script>