<?php
include("../../bd.php");

if($_POST){
    print_r($_POST);
    print_r($_FILES);

    // Recolectamos los datos del método POST    
    $primernombre=(isset($_POST["primernombre"])?$_POST["primernombre"]:"");
    $segundonombre=(isset($_POST["segundonombre"])?$_POST["segundonombre"]:"");
    $primerapellido=(isset($_POST["primerapellido"])?$_POST["primerapellido"]:"");
    $segundoapellido=(isset($_POST["segundoapellido"])?$_POST["segundoapellido"]:"");
    
    $foto=(isset($_FILES["foto"]['name'])?$_FILES["foto"]['name']:"");
    $cv=(isset($_FILES["cv"]['name'])?$_FILES["cv"]['name']:"");

    $idpuesto=(isset($_POST["idpuesto"])?$_POST["idpuesto"]:"");
    $fechadeingreso=(isset($_POST["fechadeingreso"])?$_POST["fechadeingreso"]:"");

    // Preparar la insercion de los datos
    $sentencia=$conexion->prepare("INSERT INTO 
    `tbl_empleados` (`id`, `primernombre`, `segundonombre`, `primerapellido`, `segundoapellido`, `foto`, `cv`, `idpuesto`, `fechadeingreso`) 
    VALUES (NULL, :primernombre,:segundonombre,:primerapellido,:segundoapellido,:foto,:cv,:idpuesto,:fechadeingreso);");

    // Asignando los valores que vienen del método POST ( Los que vienen del formulario)
    $sentencia->bindParam(":primernombre",$primernombre);
    $sentencia->bindParam(":segundonombre",$segundonombre);
    $sentencia->bindParam(":primerapellido",$primerapellido);
    $sentencia->bindParam(":segundoapellido",$segundoapellido);
    
    //CODIGO PARA ADJUNTAR LA FOTO
    $fecha_=new DateTime();
    //PARA FOTO
    $nombreArchivo_foto=($foto!='')?$fecha_->getTimestamp()."_".$_FILES["foto"]['name']:"";
    $tmp_foto=$_FILES["foto"]['tmp_name'];
    if($tmp_foto!=''){
        move_uploaded_file($tmp_foto,"./".$nombreArchivo_foto);
    }
    $sentencia->bindParam(":foto",$nombreArchivo_foto);
    //PARA CV
    $nombreArchivo_cv=($cv!='')?$fecha_->getTimestamp()."_".$_FILES["cv"]['name']:"";
    $tmp_cv=$_FILES["cv"]['tmp_name'];
    if($tmp_cv!=''){
        move_uploaded_file($tmp_cv,"./".$nombreArchivo_cv);
    }
    $sentencia->bindParam(":cv",$nombreArchivo_cv);

    $sentencia->bindParam(":idpuesto",$idpuesto);
    $sentencia->bindParam(":fechadeingreso",$fechadeingreso);


    $sentencia->execute();
    $mensaje="Registro Agregado";
    header("Location:index.php?mensaje=".$mensaje);



}

//INICIO instruccion de SELECCIONAR
$sentencia=$conexion->prepare("SELECT * FROM `tbl_puestos`");
$sentencia->execute();
$lista_tbl_puestos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
//FIN instruccion de SELECCIONAR

?>

<?php include("../../templates/header.php");?> <!--INCLUIMOS EL header.php(Parte Superior cabezera)-->
<br/>
<div class="card">
    <div class="card-header">Datos del Empleado</div>
    <div class="card-body">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="" class="form-label">Primer Nombre</label>
            <input type="text" class="form-control" name="primernombre" id="primernombre" aria-describedby="helpId" placeholder="Primer Nombre">
        </div>

        <div class="mb-3">
            <label for="segundonombre" class="form-label">Segundo Nombre</label>
            <input
                type="text"
                class="form-control"
                name="segundonombre"
                id="segundonombre"
                aria-describedby="helpId"
                placeholder="Segundo Nombre">
        </div>

        <div class="mb-3">
            <label for="primerapellido" class="form-label">Primer Apellido</label>
            <input
                type="text"
                class="form-control"
                name="primerapellido"
                id="primerapellido"
                aria-describedby="helpId"
                placeholder="Primer Apellido">
        </div>

        <div class="mb-3">
            <label for="segundoapellido" class="form-label">Segundo Apellido</label>
            <input
                type="text"
                class="form-control"
                name="segundoapellido"
                id="segundoapellido"
                aria-describedby="helpId"
                placeholder="Segundo Apelllido">
        </div>
        
        <div class="mb-3">
            <label for="" class="form-label">Foto</label>
            <input
                type="file"
                class="form-control"
                name="foto"
                id="foto"
                aria-describedby="helpId"
                placeholder="Foto">
        </div>

        <div class="mb-3">
            <label for="" class="form-label">CV(PDF)</label>
            <input
                type="file"
                class="form-control"
                name="cv"
                id="cv"
                aria-describedby="helpId"
                placeholder="CV">
        </div>
        
        <div class="mb-3">
            <label for="idpuesto" class="form-label">Puesto:</label>
            
            <select class="form-select form-select-sm" name="idpuesto" id="idpuesto">
                <?php foreach($lista_tbl_puestos as $registro){?>    
                    <option value="<?php echo $registro['id'] ?>"><?php echo $registro['nombredelpuesto'] ?></option>
                <?php } ?>
            </select>

        </div>
        
        <div class="mb-3">
            <label for="fechadeingreso" class="form-label">Fecha de Ingreso</label>
            <input
                type="date"
                class="form-control"
                name="fechadeingreso"
                id="fechadeingreso"
                aria-describedby="emailHelpId"
                placeholder="Fecha de ingreso">
        </div>
        
        <button type="submit" class="btn btn-primary">Agregar Registro</button>
        <a
            name=""
            id=""
            class="btn btn-success"
            href="index.php"
            role="button"
            >Cancelar</a>
        

        


    </form>

    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include("../../templates/footer.php");?><!--INCLUIMOS EL Footer.php(Parte Inferior)-->