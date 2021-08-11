<?php

    if (defined("SECURITY_CONSTANT")) {
        
        $bodyId = "bodyFormularioServiciosQuirofanoPaciente";
        $pageTitle = "Servicios quirófano paciente";
        $action = "index.php?controlador=factura&amp;opcion=listadoServiciosQuirofanoPaciente";
        
        require_once(SKEL_DIR . "/cabecera.php");
        
        require_once(SKEL_DIR . "/headStart.php");
        
?>

        <script charset="utf-8" type="text/javascript">
        </script>
        
<?php
        
        require_once(SKEL_DIR . "/headEnd.php");
        
        require_once(SKEL_DIR . "/bodyStart.php");
        
        require_once(SKEL_DIR . "/menu.php");

?>
        <h1><?php echo $pageTitle ?></h1>
                
        <div id="formularioServiciosQuirofanoPaciente">
                                
            <form id="" class="ficha" method="post" action="<?php echo $action ?>" onsubmit="">
                <fieldset>
                    <legend>Formulario de búsqueda de servicios quirófano paciente</legend>
                    <p>
                        <label for="nombre_paciente">Nombre paciente:</label>
                        <input type="text" name="nombre_paciente" id="nombre_paciente" value="" />
                    </p>
                    <p>
                        <input type="submit" value="Buscar" />
                    </p>
                </fieldset>
            </form>
                                
        </div>
<?php
        
        require_once(SKEL_DIR . "/bodyEnd.php");
        
        require_once(SKEL_DIR . "/pie.php");

    }

?>
