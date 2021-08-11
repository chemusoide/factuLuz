<?php

    if (defined("SECURITY_CONSTANT")) {

        $bodyId = "usuarioListado";
        $pageTitle = "Listado de usuarios";

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
                <col width="100%" />
            </colgroup>
            <thead>
                <tr>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
<?php

        $numUsuarios = count($usuarios);

        for ($i = 0; $i < $numUsuarios; $i++) {
        
            $usuario = (object)$usuarios[$i];
            
            $class = ($i % 2 == 0) ? "" : "class=\"impar\"";
            
?>
                <tr <?php echo $class ?>>
                    <td>
                        <a href="index.php?controlador=usuario&amp;opcion=consulta&amp;id=<?php echo $usuario->getUsuarioId() ?>"><?php echo $usuario->getUsuarioNombre() ?></a>
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