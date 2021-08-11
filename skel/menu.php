<?php

	if (defined("SECURITY_CONSTANT")) {
		
?>
		<div id="menu">
    		<ul id="nav">
                <li><a href="#">Clientes</a>
                	<ul>
                        <li><a href="index.php?controlador=cliente&amp;opcion=listado" title="Listado de clientes">Listado de clientes</a></li>
                        <li><a href="index.php?controlador=cliente&amp;opcion=precreacion" title="Nuevo cliente">Nuevo cliente</a></li>
                  	</ul>
                </li>
                <li><a href="#">Facturas</a>
                	<ul>
                        <li><a href="index.php?controlador=factura&amp;opcion=listado" title="Listado de facturas">Listado de facturas</a></li>
                        <li><a href="index.php?controlador=factura&amp;opcion=precreacion&amp;factura_tipo=servicio" title="Nueva factura de servicio">Nueva factura servicio clínica</a></li>
                        <li><a href="index.php?controlador=factura&amp;opcion=precreacion&amp;factura_tipo=quirofano" title="Nueva factura de quirófano">Nueva factura servicio quirófano</a></li>
                  	</ul>
                </li>
                <li><a href="#">Usuarios</a>
                	<ul>
                		<li><a href="index.php?controlador=usuario&amp;opcion=listado" title="Listado de usuarios">Listado de usuarios</a></li>
                        <li><a href="index.php?controlador=usuario&amp;opcion=precreacion" title="Nuevo usuario">Nuevo usuario</a></li>
                  	</ul>
                </li>
                <li><a href="#">Configuración</a>
                	<ul>
                		<li><a href="index.php?controlador=tipoIva&amp;opcion=listado" title="Tipos de IVA">Tipos de IVA</a></li>
                		<li><a href="index.php?controlador=tipoIva&amp;opcion=precreacion" title="Nuevo tipo de IVA">Nuevo tipo de IVA</a></li>
                		<li><a href="index.php?controlador=tipoIrpf&amp;opcion=listado" title="Tipos de IRPF">Tipos de IRPF</a></li>
                		<li><a href="index.php?controlador=tipoIrpf&amp;opcion=precreacion" title="Nuevo tipo de IRPF">Nuevo tipo de IRPF</a></li>
                        <li><a href="index.php?controlador=general&amp;opcion=backupDB" title="Backup base de datos">Backup base de datos</a></li>
                        <li><a href="index.php?controlador=config&amp;opcion=consulta" title="Editar configuración">Editar configuración</a></li>
                  	</ul>
                </li>
                <li><a href="#">Informes</a>
                	<ul>
                	    <li><a href="index.php?controlador=factura&amp;opcion=formularioServiciosQuirofanoPaciente" title="Servicios quirófano paciente">Servicios quirófano paciente</a></li>
                		<li><a href="index.php?controlador=factura&amp;opcion=informeFacturacionAnyoMes" title="Informe de facturacion año/mes">Informe de facturacion año/mes</a></li>
                        <li><a onclick="alert('no implementado')" href="#" title="">Informe 2</a></li>
                  	</ul>
                </li>
            </ul>
        </div>
<?php
		
	}

?>