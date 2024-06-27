import Swal from 'sweetalert2';

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

export { handleChamada };
