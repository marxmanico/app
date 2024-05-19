<?php
include("../../bd.php");

//INICIO instruccion de BORRADO
if(isset($_GET['txtID'] )){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sentencia=$conexion->prepare("DELETE FROM tbl_puestos WHERE id=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    header("Location:index.php");
}
//FIN instruccion de BORRADO

//INICIO instruccion de SELECCIONAR
$sentencia=$conexion->prepare("SELECT * FROM `tbl_puestos`");
$sentencia->execute();
$lista_tbl_puestos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
//print_r($lista_tbl_puestos);
//FIN instruccion de SELECCIONAR
?>


<?php include("../../templates/header.php");?> <!--INCLUIMOS EL header.php(Parte Superior cabezera)-->
<br/>
<div class="card">
    <div class="card-header">
        <a
            name=""
            id=""
            class="btn btn-primary"
            href="crear.php"
            role="button">
            Agregar Registro
        </a
        ></div>
    <div class="card-body">

<div class="card">
    <div class="card-header">Puestos</div>
    <div class="card-body">
    <div
    class="table-responsive-sm"
>
    <table class="table" id="tabla_id">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre del Puesto</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>

        <?php foreach($lista_tbl_puestos as $registro){?>

            <tr class="">
                <td scope="row"><?php echo $registro['id'];?></td>
                <td><?php echo $registro['nombredelpuesto'];?></td>
                <td>
                    <a class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id']?>" role="button">Editar</a>
                    <!--cortamos esta parte para mandar al script-->
                    <a class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id']; ?>);" role="button">Eliminar</a>
                
                </td>
            </tr>

            <?php } ?>


            
        </tbody>
    </table>
</div>


        
    </div>
    
</div>

<script>

function borrar(id){
    //alert(id);
    Swal.fire({
        title: "¿Desea borrar el registro?",
        //showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Si, Borrar",
        //denyButtonText: `No`
    }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            window.location="index.php?txtID="+id;
        }
})


    //index.php?txtID=
}
</script>





<?php include("../../templates/footer.php");?><!--INCLUIMOS EL Footer.php(Parte Inferior)-->