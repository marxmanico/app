<?php 
include("../../bd.php");

if($_POST){
    print_r($_POST);

    // Recolectamos los datos del método POST    
    $nombredelpuesto=(isset($_POST["nombredelpuesto"])?$_POST["nombredelpuesto"]:"");
    // Preparar la insercion de los datos
    $sentencia=$conexion->prepare("INSERT INTO tbl_puestos(id,nombredelpuesto)
                VALUES (null, :nombredelpuesto)");
    // Asignando los valores que vienen del método POST ( Los que vienen del formulario)
    $sentencia->bindParam(":nombredelpuesto",$nombredelpuesto);
    $sentencia->execute();
    header("Location:index.php");

}
?>


<?php include("../../templates/header.php");?> <!--INCLUIMOS EL header.php(Parte Superior cabezera)-->
<br/>

<div class="card">
    <div class="card-header">Puestos</div>
    <div class="card-body">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nombredelpuesto" class="form-label">Nombre del Puesto:</label>
            <input
                type="text"
                class="form-control"
                name="nombredelpuesto"
                id="nombredelpuesto"
                aria-describedby="helpId"
                placeholder="Nombre del Puesto"
            />
        </div>
        
        <button
            type="submit"
            class="btn btn-success"
        >
            Agregar
        </button>
        
        <a
            name=""
            id=""
            class="btn btn-primary"
            href="index.php"
            role="button"
            >Cancelar</a
        >
        


    </form>

    </div>
    <div class="card-footer text-muted">Footer</div>
</div>






<?php include("../../templates/footer.php");?><!--INCLUIMOS EL Footer.php(Parte Inferior)-->