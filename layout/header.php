<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fila Fácil - On Line</title>

    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/container.css">
    <link rel="shortcut icon" href="../assets/img/icon.png" type="image/x-icon">

    <!-- SweetAlert CDN Link -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <div id="dynamic-content">
        <h1>TABELAS AQUI</h1>
    </div>
    <!-- Modal CRIAR FILA -->
    <div class="modal fade" id="modalCriarFila" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="cadLoginUsers" class="needs-validation box" novalidate name="form"
                    onsubmit="createUpdateFiles(this, '/Fila_Facil/API/access_1.php'); return false;">
                    <div class="modal-header">
                        <img src="./assets/img/Screenshot_4.png" alt="">
                    </div>
                    <div class="modal-body">

                        <!--DADOS PARA CADASTRAR NA TABELA-->
                        <input type="hidden" value="editar">
                        <input type="hidden" name="tabela" value="criarfila">
                        <input type="text" class="form-control" id="pessoa_idUsu" name="pessoa_idUsu"
                            value="<?php echo isset($_SESSION['id_usu']) ? $_SESSION['id_usu'] : ''; ?>">

                        <input type="text" name="nome_fila" placeholder="Nome" class="form-control" required>
                        <div class="invalid-feedback">Preencha o nome da fila.</div>

                        <input type="number" name="qtd_fila" placeholder="Quantidade" class="form-control" required>
                        <div class="invalid-feedback">Preencha a quantidade da fila.</div>

                        <input type="password" name="cod_acess_fila" placeholder="Codigo de acesso" class="form-control"
                            autocomplete="curent-password" required>
                        <div class="invalid-feedback">Digite o código para acesso.</div>

                        <input id="btnCloseModal" type="submit" name="" value="Cadastrar" href="#">
                    </div>

                    <div class="modal-footer">
                        <p class="text-muted">
                            <a href="#" onclick="logout()">SAIR<i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Modal ACESSO -->
    <div class="modal fade" id="modalAcesso" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="loginAccessForm" class="needs-validation box" novalidate name="form">
                    <div class="modal-header">
                        <img src="../assets/img/Screenshot_1.png" alt="Logo Fila Fácil">
                    </div>
                    <div class="modal-body">
                        <input type="email" name="email_usu" placeholder="E-mail" class="form-control"
                            autocomplete="email" required>
                        <div class="invalid-feedback">Por favor preencha o e-mail para acesso.</div>
                        <input type="password" name="pass_usu" placeholder="Senha" class="form-control"
                            autocomplete="current-password" required>
                        <div class="invalid-feedback">Por favor preencha uma senha válida.</div>
                        <a class="forgot text-muted" href="#">Esqueceu a senha?</a>
                        <input id="btnClose" type="submit" value="Acessar" href="#">
                        <div>
                            <ul class="social-network social-circle">
                                <li><a href="#" class="icoFacebook" title="Facebook"><i
                                            class="fab fa-facebook-f"></i></a>
                                </li>
                                <li><a href="#" class="icoTwitter" title="Twitter"><i class="fab fa-twitter"></i></a>
                                </li>
                                <li><a href="#" class="icoGoogle" title="Google +"><i
                                            class="fab fa-google-plus"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <p>Não tem cadastro? <a id="cadastro" href="#!"> Cadastre-se</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>