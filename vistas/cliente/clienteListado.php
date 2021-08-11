<?php

    if (defined("SECURITY_CONSTANT")) {

        $bodyId = "clienteListado";
        $pageTitle = "Listado de clientes";

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
                <col width="60%" />
                <col width="10%" />
                <col width="20%" />
                <col width="10%" />
            </colgroup>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>NIF</th>
                    <th>Fecha de alta</th>
                    <th>Activo</th>
                </tr>
            </thead>
            <tbody>
<?php

        $numClientes = count($clientes);

        for ($i = 0; $i < $numClientes; $i++) {
        
            $cliente = (object)$clientes[$i];
            
            $class = ($i % 2 == 0) ? "" : "class=\"impar\"";
            
?>
                <tr <?php echo $class ?>>
                    <td>
                        <a href="index.php?controlador=cliente&amp;opcion=consulta&amp;id=<?php echo $cliente->getClienteId() ?>"><?php echo $cliente->getClienteNombre() ?></a>
                    </td>
                    <td>
                        <a href="index.php?controlador=cliente&amp;opcion=consulta&amp;id=<?php echo $cliente->getClienteId() ?>"><?php echo $cliente->getClienteNif() ?></a>
                    </td>
                    <td>
                        <a href="index.php?controlador=cliente&amp;opcion=consulta&amp;id=<?php echo $cliente->getClienteId() ?>"><?php echo $cliente->getClienteFechacreacion() ?></a>
                    </td>
                    <td>
                    	<?php
                    	    
                    	    $activo = ($cliente->getClienteActivo() == 1) ? '<span style="color: green">SÍ</span>' : '<span style="color: red">NO</span>';
							echo $activo;
                    	    
                	    ?>
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