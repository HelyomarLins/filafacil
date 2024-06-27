// Função para deletar acesso
async function deleteAccess(urlAPI, parametroId, idChamada) {
    try {
        // Construir a URL completa para a API
        const apiUrlCompleta = `${urlAPI}?${parametroId}=${idChamada}&cacheBust=${Math.random()}`;
        console.log("URL completa:", apiUrlCompleta);

        // Fazendo a requisição DELETE para a API
        const response = await fetch(apiUrlCompleta, {
            method: 'DELETE'
        });

        // Verificar a resposta da API
        if (response.ok) {
            const data = await response.json();

            // Exibir mensagem de sucesso com SweetAlert
            Swal.fire({
                icon: 'success',
                title: data.msg,
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                // Recarregar a página após exclusão
                location.reload();
            });

        } else {
            // Exibir mensagem de erro se a resposta da API não for ok
            const errorData = await response.json();
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: errorData.msg || 'Erro ao excluir o registro.'
            });
        }

    } catch (error) {
        // Exibir mensagem de erro se ocorrer um erro na requisição
        Swal.fire({
            icon: 'error',
            title: 'Erro',
            text: 'Erro ao excluir o registro. Tente novamente.'
        });
    }
}

// Captura de cliques nos botões de delete
document.addEventListener('click', function (e) {
    if (e.target.closest('.btnDeleteAccess')) {
        e.preventDefault();

        const idChamada = e.target.closest('.btnDeleteAccess').getAttribute('data-id');
        const nomeFila = e.target.closest('.btnDeleteAccess').getAttribute('data-nome');

        console.log("ID chamada:", idChamada);
        console.log("Nome da fila:", nomeFila);

        // Chama a função deleteAccess passando os parâmetros necessários
        deleteAccess('/Fila_Facil1/API/function/delete_acces_file.php', 'id_chamada', idChamada);
    }
});
