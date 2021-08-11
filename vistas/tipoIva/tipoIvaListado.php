<?php

    if (defined("SECURITY_CONSTANT")) {

        $bodyId = "tipoIvaListado";
        $pageTitle = "Listado de tipos de IVA";

        require_once(SKEL_DIR . "/cabecera.php");
        
        require_once(SKEL_DIR . "/headStart.php");

        // JS necesario para las tablas
        require_once(SKEL_DIR . "/dataTables.php");
        
        require_once(SKEL_DIR . "/headEnd.php");
        
        require_once(SKEL_DIR . "/bodyStart.php");
        
        require_once(SKEL_DIR . "/menu.php");
        
?>
        <h1><?php echo $pageTitle ?></h1>

        <table class="listado" cellspacing="0">
            <colgroup>
                <col width="90%" />
                <col width="10%" />
            </colgroup>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
<?php

        $numTipoIvas = count($tipoIvas);

        for ($i = 0; $i < $numTipoIvas; $i++) {
        
            $tipoIva = (object)$tipoIvas[$i];
            
            $class = ($i % 2 == 0) ? "" : "class=\"impar\"";
            
?>
                <tr <?php echo $class ?>>
                    <td>
                        <a href="index.php?controlador=tipoIva&amp;opcion=consulta&amp;id=<?php echo $tipoIva->getTipoIvaId() ?>"><?php echo $tipoIva->getTipoIvaNombre() ?></a>
                    </td>
                    <td class="derecha">
                        <a href="index.php?controlador=tipoIva&amp;opcion=consulta&amp;id=<?php echo $tipoIva->getTipoIvaId() ?>"><?php echo $tipoIva->getTipoIvaPorcentaje() ?>%</a>
                    </td>
                </tr>
<?php

        }

?>
            </tbody>
        </table>
<?php
        
        require_once(SKEL_DIR . "/bodyEnd.php");
        
        require_once(SKEL_DIR . "/pie.php");

    }

?>