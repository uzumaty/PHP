<?php
include("../../bd.php");

if ($_POST) {
    print_r($_POST);

    //recolectamos datos del formulario metodo post
    $nombredelpuesto = (isset($_POST['nombredelpuesto'])) ? $_POST['nombredelpuesto'] : "";
    //preparamos la consulta
    $sentencia = $conexion->prepare("INSERT INTO tbl_puestos(id,nombredelpuesto) VALUES(null,:nombredelpuesto)");
    // asignanco los valores que vienen del formulario
    $sentencia->bindParam(':nombredelpuesto', $nombredelpuesto);
    //ejecutamos la sentencia
    $sentencia->execute();
    //redireccionamos a la pagina index
    $mensaje = "Registro creado";
    header("Location: index.php?mensaje=$mensaje");
}
?>

<?php include("../../templates/header.php"); ?>
<br />

<div class="card">
    <div class="card-header">
        Puestos
    </div>
    <div class="card-body">

        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="nombredelpuesto" class="form-label">Nombre del puesto:
                </label>
                <input type="text" class="form-control" name="nombredelpuesto" id="nombredelpuesto" aria-describedby="helpId" placeholder="Nombre del puesto">
            </div>

            <button type="submit" class="btn btn-primary">Agregar</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
        </form>

    </div>
    <div class="card-footer text-muted"> </div>
</div>


<?php include("../../templates/footer.php"); ?>