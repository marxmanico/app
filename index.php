<?php include("templates/header.php");?> <!--INCLUIMOS EL header.php(Parte Superior cabezera)-->
</br><!--CONTENIDO CENTRAL-->
        <div class="p-5 mb-4 bg-light rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold">Bienvenido al Sistema</h1>
                <p class="col-md-8 fs-4">Usuario: <?php echo $_SESSION['usuario'];?></p>
                <button class="btn btn-primary btn-lg" type="button">
                    Example button
                </button>
            </div>
        </div>
<?php include("templates/footer.php");?><!--INCLUIMOS EL Footer.php(Parte Inferior)-->