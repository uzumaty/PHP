<?php include("templates/header.php"); ?>
<br />
<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Bienvenido</h1>
        <p class="col-md-8 fs-4">Usuario: <?php echo $_SESSION['usuario']; ?></p>
    </div>
</div>

<?php include("templates/footer.php"); ?>