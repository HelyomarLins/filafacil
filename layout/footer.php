<!-- Seção de Footer/Rodapé -->

<div class="sidebar close">
    <?php
    // Incluir a sidebar correta de acordo com o nível do usuário
    include_once(__DIR__ . '/../API/function/switchNiveis.php');
    ?>
</div>

<!-- SCRIPTS BOOTSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

<!-- SCRIPTS -->
<!-- SCRIPTS -->
<script src="../assets/js/content/loadContent.js"></script>
<script src="../assets/js/content/initDynamicContent.js"></script>
<script src="../assets/js/content/manage_modals.js"></script>
<script src="../assets/js/content/createUpdateFile.js"></script>
<script srr="../assets/js/content/accessAlert.js"></script>
<script src="../assets/js/content/logout.js"></script>

</body>

</html>