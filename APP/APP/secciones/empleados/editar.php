<?php
include("../../bd.php");
//actualizar registro se captura el id y se ejecuta la sentencia:
if (isset($_GET['txtID'])) {

    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";

    $sentencia = $conexion->prepare("SELECT * FROM `tbl_empleados` WHERE id = :id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    $primernombre = $registro['primernombre'];
    $segundonombre = $registro['segundonombre'];
    $primerapellido = $registro['primerapellido'];
    $segundoapellido = $registro['segundoapellido'];
    $foto = $registro['foto'];
    $cv = $registro['cv'];
    $idpuesto = $registro['idpuesto'];
    $fechadeingreso = $registro['fechadeingreso'];

    $sentencia = $conexion->prepare("SELECT * FROM `tbl_puestos`");
    $sentencia->execute();
    $lista_tbl_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
}
if ($_POST) {

    //recolectamos datos del formulario metodo post
    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
    $primernombre = (isset($_POST['primernombre'])) ? $_POST['primernombre'] : "";
    $segundonombre = (isset($_POST['segundonombre'])) ? $_POST['segundonombre'] : "";
    $primerapellido = (isset($_POST['primerapellido'])) ? $_POST['primerapellido'] : "";
    $segundoapellido = (isset($_POST['segundoapellido'])) ? $_POST['segundoapellido'] : "";
    $idpuesto = (isset($_POST['idpuesto'])) ? $_POST['idpuesto'] : "";
    $fechadeingreso = (isset($_POST['fechadeingreso'])) ? $_POST['fechadeingreso'] : "";

    //preparamos la consulta
    $sentencia = $conexion->prepare("
    UPDATE tbl_empleados 
    SET
        primernombre = :primernombre,
        segundonombre = :segundonombre,
        primerapellido = :primerapellido,
        segundoapellido = :segundoapellido,
        idpuesto = :idpuesto,
        fechadeingreso = :fechadeingreso
    WHERE id = :id
    ");

    // se asignan los valores que vienen del formulario
    $sentencia->bindParam(':primernombre', $primernombre);
    $sentencia->bindParam(':segundonombre', $segundonombre);
    $sentencia->bindParam(':primerapellido', $primerapellido);
    $sentencia->bindParam(':segundoapellido', $segundoapellido);
    $sentencia->bindParam(':idpuesto', $idpuesto);
    $sentencia->bindParam(':fechadeingreso', $fechadeingreso);
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();

    $foto = (isset($_FILES['foto']['name'])) ? $_FILES['foto']['name'] : "";

    //genero una variable de fecha para asignarla a la foto y al cv
    $fecha_ = new DateTime();

    //asigno el nombre de la foto con la fecha actual para que no se repita
    $nombreArchivo = ($foto != "") ? $fecha_->getTimestamp() . "_" . $_FILES["foto"]["name"] : "";
    $tmp_foto = $_FILES["foto"]["tmp_name"];
    if ($tmp_foto != "") {
        move_uploaded_file($tmp_foto, "./" . $nombreArchivo);
        //buscar archivo relacionado con el empleado
        $sentencia = $conexion->prepare("SELECT foto,cv FROM `tbl_empleados` WHERE id = :id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);


        if (isset($registro_recuperado['foto']) && $registro_recuperado['foto'] != "") {
            if (file_exists("./" . $registro_recuperado['foto'])) {
                unlink("./" . $registro_recuperado['foto']);
            }
        }

        $sentencia = $conexion->prepare("UPDATE tbl_empleados SET foto = :foto WHERE id = :id");
        $sentencia->bindParam(':foto', $nombreArchivo);
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
    }

    $cv = (isset($_FILES['cv']['name'])) ? $_FILES['cv']['name'] : "";
    //asigno el nombre del cv con la fecha actual para que no se repita
    $nombreArchivocv = ($cv != "") ? $fecha_->getTimestamp() . "_" . $_FILES["cv"]["name"] : "";
    $tmp_cv = $_FILES["cv"]["tmp_name"];
    if ($tmp_cv != "") {
        move_uploaded_file($tmp_cv, "./" . $nombreArchivocv);

        //buscar archivo relacionado con el empleado
        $sentencia = $conexion->prepare("SELECT foto,cv FROM `tbl_empleados` WHERE id = :id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);
        if (isset($registro_recuperado['cv']) && $registro_recuperado['cv'] != "") {
            if (file_exists("./" . $registro_recuperado['cv'])) {
                unlink("./" . $registro_recuperado['cv']);
            }
        }

        $sentencia = $conexion->prepare("UPDATE tbl_empleados SET cv = :cv WHERE id = :id");
        $sentencia->bindParam(':cv', $nombreArchivocv);
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        header("Location: index.php");
    }

    $mensaje = "registro actualizado";
    header("Location: index.php?mensaje=$mensaje");

    //print_r($_POST); //lo usamos para validar que los datos se esten enviando correctamente
    //print_r($_FILES); //lo usamos para validar que los datos se esten enviando correctamente
}
?>
<?php include("../../templates/header.php"); ?>

</br>
<div class="card">
    <div class="card-header">
        Datos del empleado
    </div>

    <div class="card-body">

        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="" class="form-label">ID:</label>
                <input type="text" value="<?php echo $txtID; ?>" class="form-control" readonly name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID">
            </div>
            <div class="mb-3">
                <label for="primernombre" class="form-label">Primer nombre</label>
                <input type="text" value="<?php echo $primernombre; ?>" class="form-control" name="primernombre" id="primernombre" aria-describedby="helpId" placeholder="Primer nombre">
            </div>


            <div class="mb-3">
                <label for="segundonombre" class="form-label">Segundo nombre</label>
                <input type="text" value="<?php echo $segundonombre; ?>" class="form-control" name="segundonombre" id="segundonombre" aria-describedby="helpId" placeholder="Segundo nombre">
            </div>




            <div class="mb-3">
                <label for="primerapellido" class="form-label">Primer apellido</label>
                <input type="text" value="<?php echo $primerapellido; ?>" class="form-control" name="primerapellido" id="primerapellido" aria-describedby="helpId" placeholder="Primer apellido">

            </div>


            <div class="mb-3">
                <label for="segundoapellido" class="form-label">Segundo apellido</label>
                <input type="text" value="<?php echo $segundoapellido; ?>" class="form-control" name="segundoapellido" id="segundoapellido" aria-describedby="helpId" placeholder="Segundo apellido">

            </div>

            <div class="mb-3">
                <label for="" class="form-label">Foto</label><br>
                <img width="100" src="<?php echo $registro['foto']; ?>" class="img-fluid rounded-top" alt=""></br>
                <br>"<?php echo $foto; ?>"

                <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="Foto">
            </div>

            <div class="mb-3">
                <label for="" class="form-label">CV(PDF): </label>
                </br>
                <a href="<?php echo $cv; ?>"><?php echo $cv; ?></a>
                <input type="file" class="form-control" name="cv" id="cv" aria-describedby="helpId" placeholder="CV">
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Puestos:</label>
                <select class="form-select form-select-lg" name="idpuesto" id="idpuesto">
                    <?php foreach ($lista_tbl_puestos as $registro) { ?>



                        <option <?php echo ($idpuesto == $registro['id']) ? "selected" : ""; ?> value="<?php echo $registro['id'] ?>">
                            <?php echo $registro['nombredelpuesto'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fechadeingreso" class="form-label">Fecha de ingreso:</label>
                <input type="date" value="<?php echo $fechadeingreso; ?>  class=" form-control" name="fechadeingreso" id="fechadeingreso" aria-describedby="emailHelpId" placeholder="Fecha de ingreso">
            </div>



            <button type="submit" class="btn btn-success">Guardar</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>


        </form>

    </div>
</div>


<?php include("../../templates/footer.php"); ?>