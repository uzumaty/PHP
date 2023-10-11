<?php
include("../../bd.php");

//actualizar registro se captura el id y se ejecuta la sentencia:
if (isset($_GET['txtID'])) {

    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";

    $sentencia = $conexion->prepare("SELECT * FROM `tbl_puestos` WHERE id = :id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    $nombredelpuesto = $registro['nombredelpuesto'];
    
}

if ($_POST) {

    //recolectamos datos del formulario metodo post
    $txtID = (isset($_POST['txtID'])) ? $_GET['txtID'] : "";
    $nombredelpuesto = (isset($_POST['nombredelpuesto'])) ? $_POST['nombredelpuesto'] : "";
    //preparamos la consulta
    $sentencia = $conexion->prepare("UPDATE tbl_puestos SET nombredelpuesto=:nombredelpuesto WHERE id=:id");
    // asignanco los valores que vienen del formulario
    $sentencia->bindParam(':nombredelpuesto', $nombredelpuesto);
    $sentencia->bindParam(':id', $txtID);
    //ejecutamos la sentencia
    $sentencia->execute();
    //redireccionamos a la pagina index
    $mensaje = "Registro actualizado";
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
                <label for="" class="form-label">ID:</label>
                <input type="text" value="<?php echo $txtID; ?>" class="form-control" readonly name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID">
            </div>

            <div class="mb-3">
                <label for="nombredelpuesto" class="form-label">Nombre del puesto:
                </label>
                <input type="text" value="<?php echo $nombredelpuesto; ?>" class="form-control" name="nombredelpuesto" id="nombredelpuesto" aria-describedby="helpId" placeholder="Nombre del puesto">
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
        </form>

    </div>
    <div class="card-footer text-muted"> </div>
</div>



<?php include("../../templates/footer.php"); ?>