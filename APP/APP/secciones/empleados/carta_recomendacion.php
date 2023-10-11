<?php
include("../../bd.php");

if (isset($_GET['txtID'])) {

    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";

    $sentencia = $conexion->prepare("SELECT *,(SELECT nombredelpuesto FROM tbl_puestos WHERE tbl_puestos.id = tbl_empleados.idpuesto limit 1) as puesto FROM `tbl_empleados` WHERE id = :id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    $primernombre = $registro['primernombre'];
    $segundonombre = $registro['segundonombre'];
    $primerapellido = $registro['primerapellido'];
    $segundoapellido = $registro['segundoapellido'];
    $foto = $registro['foto'];
    $cv = $registro['cv'];
    $puesto = $registro['puesto'];
    $fechadeingreso = $registro['fechadeingreso'];

    $currentdate = date("d-m-Y");
    $fechainicio = date("d-m-Y", strtotime($fechadeingreso));
}



ob_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de recomendacíon</title>
</head>

<body>
    <h1>Carta de recomendacíon</h1>

    Santiago de Chile, a <strong> <?php echo $currentdate; ?> </strong>
    Es un placer para mí recomendar enfáticamente a <strong><?php echo strtoupper($primernombre) . " " . strtoupper($primerapellido) ?></strong>
    <br><br />
    Quien ha trabajado con nosotros en el puesto de <strong><?php echo strtoupper($registro['puesto']); ?></strong> Igresó con fecha <strong> <?php echo $fechainicio; ?></strong>.
    <br><br />
    Durante su tiempo aquí, <strong><?php echo strtoupper($primernombre) . " " . strtoupper($primerapellido) ?></strong> demostró ser un empleado excepcional.
    <br><br />
    Es un profesional dedicado y altamente competente. Su compromiso con su trabajo y su capacidad para enfrentar desafíos demuestran su valía como empleado.
    <br><br />
    Siempre se esfuerza al máximo para lograr resultados sobresalientes en todas sus tareas y proyectos.
    <br><br />
    Además de su habilidad técnica, es una persona agradable y colaboradora que se integra bien en cualquier equipo.
    <br><br />
    Su actitud positiva y su disposición para asumir responsabilidades adicionales lo convierten en un activo valioso para cualquier organización.
    <br><br />
    En resumen, recomiendo a <strong><?php echo strtoupper($primernombre) . " " . strtoupper($primerapellido) ?></strong> sin ninguna reserva.
    <br><br />
    Estoy seguro de que continuará demostrando el mismo nivel de profesionalismo y compromiso en sus futuros desafíos laborales.
    <br><br />
    Por favor, no dude en ponerse en contacto conmigo si necesita información adicional.
    <br><br /><br><br /><br><br />





    ___________________________<br>
    <strong>Atentamente,
    <br><br />
    Oppici S.A</strong>

</body>

</html>


<?php

$HTML = ob_get_clean();
require_once("../../libs/dompdf/autoload.inc.php");

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$opciones = $dompdf->getOptions();
$opciones->set(array("isRemoteEnabled" => true));
$dompdf->setOptions($opciones);

$dompdf->loadHtml($HTML);
$dompdf->setPaper('letter');
$dompdf->render();

$dompdf->stream("archivo.pdf", array("Attachment" => false));

?>