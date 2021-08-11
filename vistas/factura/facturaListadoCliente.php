<?php

    if (defined("SECURITY_CONSTANT")) {

        $bodyId = "facturaListadoCliente";
        $pageTitle = "Listado de facturas";

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
            	<col widht="5%" />
                <col width="5%" />
                <col width="10%" />
                <col width="25%" />
                <col width="10%" />
                <col width="5%" />
                <col width="10%" />
                <col width="5%" />
                <col width="10%" />
                <col width="5%" />
                <col width="10%" />
            </colgroup>
            <thead>
                <tr>
                	<th>Fichero</th>
                    <th>Número</th>
                    <th class="centrado">Fecha</th>
                    <th>Cliente</th>
                    <th>Tipo</th>
                    <th>Pagada</th>
                    <th class="centrado">Fecha pago</th>
                    <th>Contabilizada</th>
                    <th class="centrado">Fecha Contable</th>
                    <th>Cerrada</th>
                    <th class="derecha">Total €</th>
                </tr>
            </thead>
            <tbody>
<?php

        $numFacturas = count($facturas);

        for ($i = 0; $i < $numFacturas; $i++) {
        
            $factura = (object)$facturas[$i];
            
            //miramos el tipo de factura
            $serie_numero = $factura -> getFacturaSerie();
            if($serie_numero == 0){
            	$serie = SERIE_NORMAL;
            }else{
            	$serie = SERIE_RECTIFICATIVA;
            }
                        
            $class = ($i % 2 == 0) ? "" : "class=\"impar\"";
            
?>
                <tr <?php echo $class ?>>
                	<td>
                		<?php 
                		$fichero_asisa = ($factura->getFacturaAddficheroasisa() == 1) ? '<span style="color: green">SÍ</span>' : '<span style="color: red">NO</span>';
                		echo "$fichero_asisa";
                		?>
                    </td>
                    <td>
                        <a href="index.php?controlador=factura&amp;opcion=consulta&amp;id=<?php echo $factura->getFacturaId() ?>"><?php echo $serie.$factura->getFacturaNumero() ?></a>
                    </td>
                    <td class="centrado">
                        <a href="index.php?controlador=factura&amp;opcion=consulta&amp;id=<?php echo $factura->getFacturaId() ?>"><?php echo $factura->getFacturaFechaCreacion() ?></a>
                	</td>
                	<td>
                    	<a href="index.php?controlador=factura&amp;opcion=consulta&amp;id=<?php echo $factura->getFacturaId() ?>"><?php echo $factura->getFacturaNombreCliente() ?></a>
                    </td>
                    <td>
                    	<a href="index.php?controlador=factura&amp;opcion=consulta&amp;id=<?php echo $factura->getFacturaId() ?>"><?php echo $factura->getFacturaTipo() ?></a>
                    </td>
                    <td>
                    	<?php
                    	    
                    	    $pagada = ($factura->getFacturaPagada() == 1) ? '<span style="color: green">SÍ</span>' : '<span style="color: red">NO</span>';
							echo $pagada;
                    	    
                	    ?>
                    </td>
                    <td class="centrado">
                        <a href="index.php?controlador=factura&amp;opcion=consulta&amp;id=<?php echo $factura->getFacturaId() ?>"><?php echo $factura->getFacturaFechacobro() ?></a>
                	</td>
                	<td>
                    	<?php
                    	    
                    	    $contablizada = ($factura->getFacturaContabilizada() == 1) ? '<span style="color: green">SÍ</span>' : '<span style="color: red">NO</span>';
							echo $contablizada;
                    	    
                	    ?>
                    </td>
                    <td class="centrado">
                        <a href="index.php?controlador=factura&amp;opcion=consulta&amp;id=<?php echo $factura->getFacturaId() ?>"><?php echo $factura->getFacturaFechacontabilizada() ?></a>
                	</td>
                    <td>
                    	<?php
                    	    
                    	    $cerrada = ($factura->getFacturaCerrada() == 1) ? '<span style="color: green">SÍ</span>' : '<span style="color: red">NO</span>';
							echo $cerrada;
                    	    
                	    ?>
                    </td>
                    <td class="derecha">
                    	<a href="index.php?controlador=factura&amp;opcion=consulta&amp;id=<?php echo $factura->getFacturaId() ?>"><?php echo $factura->getFacturaTotal() ?></a>
                    </td>
                </tr>
<?php

        }

?>
            </tbody>
        </table>
        
        <p><a href="index.php?controlador=cliente&amp;opcion=consulta&amp;id=<?php echo $cliente->getClienteId() ?>">Volver a ficha de <?php echo $cliente->getClienteNombre() ?></a>
<?php
        
        require_once(SKEL_DIR . "/bodyEnd.php");
        
        require_once(SKEL_DIR . "/pie.php");

    }

?>