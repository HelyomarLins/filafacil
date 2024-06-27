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
            const row = chamadasList.insertRow();
            row.innerHTML = `
                <td>${chamada.nome_chamada}</td>
                <td>${chamada.nome_fila_chamada}</td>
                <td>${chamada.posicao_chamada}</td>
                <td><button class="btn btn-primary btn-sm" data-id="${chamada.id_chamada}">Atender</button></td>
            `;
            row.querySelector('button').addEventListener('click', () => handleChamada(chamada));
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
