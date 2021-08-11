<?php

    if (defined("SECURITY_CONSTANT")) {

        $bodyId = "facturaListado";
        $pageTitle = "Listado de facturas servicio quirófano paciente &quot;" . $_POST["nombre_paciente"] . "&quot;";

        require_once(SKEL_DIR . "/cabecera.php");
        
        require_once(SKEL_DIR . "/headStart.php");
        
        // JS necesario para las tablas
        require_once(SKEL_DIR . "/dataTables.php");

        require_once(SKEL_DIR . "/headEnd.php");
        
        require_once(SKEL_DIR . "/bodyStart.php");
        
        require_once(SKEL_DIR . "/menu.php");
        
?>
        <h1><?php echo $pageTitle ?></h1>
        
        <p><a href="index.php?controlador=factura&amp;opcion=formularioServiciosQuirofanoPaciente"><img alt="Volver al al formulario de búsqueda" src="img/usuarios_32x32.png"/> Volver al al formulario de búsqueda</a></p>

        <table class="listado" cellspacing="0">
            <colgroup>
<!--                 <col width="5%" />
                <col width="10%" />
                <col width="45%" />
                <col width="10%" />
                <col width="5%" />
                <col width="10%" /> -->
            </colgroup>
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Intervención</th>
                    <th class="centrado">Fecha</th>
                    <th class="centrado">Importe</th>
                </tr>
            </thead>
            <tbody>
<?php

        $numFacturas = count($facturas);

        for ($i = 0; $i < $numFacturas; $i++) {
        
            $factura = (object)$facturas[$i];
                        
            $class = ($i % 2 == 0) ? "" : "class=\"impar\"";
            
?>
                <tr <?php echo $class ?>>
                    <td>
                        <a href="index.php?controlador=factura&amp;opcion=consulta&amp;id=<?php echo $factura->getFacturaId() ?>"><?php echo $factura->getFacturaNumero() ?></a>
                    </td>
                    <td>
                        <a href="index.php?controlador=factura&amp;opcion=consulta&amp;id=<?php echo $factura->getFacturaId() ?>"><?php echo $factura->getFacturaNombrepaciente() ?></a>
                	</td>
                	<td>
                    	<a href="index.php?controlador=factura&amp;opcion=consulta&amp;id=<?php echo $factura->getFacturaId() ?>"><?php echo $factura->getFacturaApellidospaciente() ?></a>
                    </td>
                    <td>
                    	<a href="index.php?controlador=factura&amp;opcion=consulta&amp;id=<?php echo $factura->getFacturaId() ?>"><?php echo $factura->getFacturaOperacion ?></a>
                    </td>
                    <td class="centrado">
                        <a href="index.php?controlador=factura&amp;opcion=consulta&amp;id=<?php echo $factura->getFacturaId() ?>"><?php echo $factura->getFacturaFechaoperacion() ?></a>
                	</td>
                    <td class="centrado">
                    	<a href="index.php?controlador=factura&amp;opcion=consulta&amp;id=<?php echo $factura->getFacturaId() ?>"><?php echo $factura->getFacturaTotal() ?></a>
                    </td>
                </tr>
<?php

        }

?>
            </tbody>
        </table>
        
        <p><a href="index.php?controlador=factura&amp;opcion=formularioServiciosQuirofanoPaciente"><img alt="Volver al al formulario de búsqueda" src="img/usuarios_32x32.png"/> Volver al al formulario de búsqueda</a></p>
<?php
        
        require_once(SKEL_DIR . "/bodyEnd.php");
        
        require_once(SKEL_DIR . "/pie.php");

    }

?>