// Objeto para gerenciar os modais
let modalUtils = {
    modais: {},
    closeModal: function (modalId) {
        const modalElement = document.querySelector(`#${modalId}`);
        if (modalElement) {
            const modalInstance = modalUtils.modais[modalId];
            if (modalInstance) {
                modalInstance.hide();
            } else {
                console.error('Modal instance not found.');
            }
        } else {
            console.error('Modal element not found.');
        }
    }
};

// Evento de clique para abrir os modais
document.addEventListener('click', function (event) {
    let modalElement, modalId;

    if (event.target.id === 'openLogin') {
        console.log('Botão de abrir Login clicado');
        modalElement = document.getElementById('modalAcesso');
        modalId = 'modalAcesso';
    } else if (event.target.id === 'openCadastro') {
        console.log('Botão de abrir Cadastro clicado');
        modalElement = document.getElementById('modalCadastro');
        modalId = 'modalCadastro';
    } else if (event.target.id === 'openListar') {
        console.log('Botão de listar Filas clicado');
        modalElement = document.getElementById('modalListar'); s
        modalId = 'modalListar';
    } else if (event.target.classList.contains('btnDeleteAccess')) {
        console.log('Botão de deletar acesso clicado');
        modalElement = document.getElementById('modalDeletar');
        modalId = 'modalDeletar';
    }

    if (modalElement) {
        let myModal = modalUtils.modais[modalId];

        if (!myModal) {
            myModal = new bootstrap.Modal(modalElement);
            modalUtils.modais[modalId] = myModal;
        }

        myModal.show();
    }
});

// Método para fechar o modal de acesso ao clicar em "Cadastre-se" e abrir o modal de cadastro
document.getElementById('cadastro').addEventListener('click', function () {
    if (modalUtils.modais['modalAcesso']) {
        modalUtils.closeModal('modalAcesso');
    }

    let modalCadastro = document.getElementById('modalCadastro');
    let myModal = modalUtils.modais['modalCadastro'];

    if (!myModal) {
        myModal = new bootstrap.Modal(modalCadastro);
        modalUtils.modais['modalCadastro'] = myModal;
    }

    myModal.show();
});

// Adicionando evento de clique para abrir o modal de Listar Filas
document.getElementById('openListar').addEventListener('click', function () {
    let modalElement = document.getElementById('modalListar');
    let myModal = modalUtils.modais['modalListar'];

    if (!myModal) {
        myModal = new bootstrap.Modal(modalElement);
        modalUtils.modais['modalListar'] = myModal;
    }

    myModal.show();
});
