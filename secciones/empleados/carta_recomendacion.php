<?php
include("../../bd.php");
if(isset($_GET['txtID'] )){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    //Buscar el Archivo relacionado con el empleado
    $sentencia=$conexion->prepare("SELECT *,(SELECT nombredelpuesto 
    FROM tbl_puestos 
    WHERE tbl_puestos.id=tbl_empleados.idpuesto limit 1) as puesto FROM tbl_empleados WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);

    //print_r($registro);

    $primernombre=$registro["primernombre"];
    $segundonombre=$registro["segundonombre"];
    $primerapellido=$registro["primerapellido"];
    $segundoapellido=$registro["segundoapellido"];
    $foto=$registro["foto"];

    $nombreCompleto=$primernombre." ".$segundonombre." ".$primerapellido." ".$segundoapellido;



    $cv=$registro["cv"];
    $idpuesto=$registro["idpuesto"];
    $puesto=$registro["puesto"];

    $fechadeingreso=$registro["fechadeingreso"];

    $fechaInicio= new DateTime($fechadeingreso);
    $fechaFin= new DateTime(date('Y-m-d'));
    $diferencia=date_diff($fechaInicio,$fechaFin);
}
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de Recomendacion</title>
</head>
<body>

<h1>Carta de Recomendacion Laboral</h1>
<br/><br/>
Departamente de Puno, Peru a <strong> <?php echo date('d M Y');?></strong>
<br/><br/>
A quien pueda interesar:
<br/><br/>
A travéz de estas líneas deseo hacer de su conocimiento que Sr(a) <strong><?php echo $nombreCompleto ?></strong>,
quien laboró en mi organización durante  <strong> <?php echo $diferencia->y;?> año(s) </strong>
es un ciudadano con una conducta intachable. Ha ser un gran trabajador,
comprometido, responsable y fiel cumplidor de sus tareas.
Siempre ha manifestado preocupación por mejorar, capacitarse y actualizar sus conocimientos.
<br/><br/>
Durante estos años se ha desempeñado como: <strong><?php echo $puesto; ?> </strong>
Es por ello le sugiero considere esta recomendación, la confianza de que estará a la altura de sus compromisos y responsabilidades
<br/><br/>
Sin más nada a que referirme y, esperando que esta misiva sea en tomada en cuenta, dejo mi núnero de contacto para cualquier información de interés.
<br/><br/><br/><br/><br/><br/><br/><br/>
___________________________________<br/>
Atentamente,
<br/>
Ing. Carlos Marx Gomez Sanchez Mamani
</body>
</html>
<?php
$HTML=ob_get_clean();
require_once("../../libs/autoload.inc.php");
use Dompdf\Dompdf;
$dompdf= new Dompdf();

$opciones=$dompdf->getOptions();
$opciones->set(array("isRemoteEnable"=>true));

$dompdf->setOptions($opciones);

$dompdf->loadHTML($HTML);

$dompdf->setPaper('letter');
$dompdf->render();

$dompdf->stream("CartaRecomendacion",array("Attachment"=>false));
?>