import Swal from 'sweetalert2';

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
        fetchChamadas(); // Supondo que fetchChamadas esteja acessível aqui

    } catch (error) {
        console.error('Erro ao atualizar atendimento:', error);
        Swal.fire({
            icon: 'error',
            title: 'Erro ao atualizar atendimento',
            text: error.message
        });
    }
}

export { updateAtendimento };
