<?php

    if (defined("SECURITY_CONSTANT")) {

        $bodyId = "informeFacturacionAnyoMes";
        $pageTitle = "Informe de facturacion por año y mes";

        require_once(SKEL_DIR . "/cabecera.php");
        
        require_once(SKEL_DIR . "/headStart.php");
        
?>
	<script type="text/javascript" src="<?php echo JS_DIR ?>/jplot/jquery.jqplot.min.js"></script>
	<script type="text/javascript" src="<?php echo JS_DIR ?>/jplot/jqplot.dateAxisRenderer.min.js"></script>
	<script type="text/javascript" src="<?php echo JS_DIR ?>/jplot/jqplot.canvasTextRenderer.min.js"></script>
	<script type="text/javascript" src="<?php echo JS_DIR ?>/jplot/jqplot.canvasAxisTickRenderer.min.js"></script>
	<script type="text/javascript" src="<?php echo JS_DIR ?>/jplot/jqplot.categoryAxisRenderer.min.js"></script>
	<script type="text/javascript" src="<?php echo JS_DIR ?>/jplot/jqplot.barRenderer.min.js"></script>
	<script type="text/javascript" src="<?php echo JS_DIR ?>/jplot/jqplot.pointLabels.min.js"></script>
	<script type="text/javascript">
	<!--

		$(document).ready(function() {

			var line1 = [
<?php
	$coma = ',';
	$numDatosInforme = sizeof($datosInforme);
	$labels = '';
	for ($i = 0; $i < $numDatosInforme; $i++) {
 
		if ($i == $numDatosInforme - 1)
			$coma = '';
		
		echo "\t\t\t\t['" . $datosInforme[$i]['fecha'] . "'," . $datosInforme[$i]['cantidad'] . "]" . $coma;
		$labels .= "'" . number_format($datosInforme[$i]['cantidad'], 2, ',', '.') . " €'" . $coma;

    } 
?>
			];
			 
			var plot1 = $.jqplot('chart1', [line1], {
				title: '',
				seriesDefaults: {renderer: $.jqplot.BarRenderer},
			    series:[{pointLabels:{
			        show: true,
			        labels:[<?php echo $labels ?>]
			      }}],
			    axesDefaults: {
			        tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
			        tickOptions: {
			          angle: -30,
			          fontSize: '10pt'
			        }
			    },
			    axes: {
			      xaxis: {
			        renderer: $.jqplot.CategoryAxisRenderer
			      }
			    },
			    highlighter: {
			        show: true,
			        sizeAdjust: 7.5
			    },
			    cursor: {
			        show: true
			    }
			});
		});
	
	//-->
</script>
<?php 

        require_once(SKEL_DIR . "/headEnd.php");
        
        require_once(SKEL_DIR . "/bodyStart.php");
        
        require_once(SKEL_DIR . "/menu.php");
        
?>
        <h1><?php echo $pageTitle ?></h1>
        
        <form class="filtroInforme ficha" method="post" action="index.php?controlador=factura&opcion=informeFacturacionAnyoMes">
        	<table>
        		<tr>
        			<td class="derecha"><label for="mes">Mes:</label></td>
        			<td><input type="text" name="mes" id="mes" value="<?php echo $mes ?>" /></td>
        		</tr>
        		<tr>
        			<td class="derecha"><label for="anyo">Año:</label></td>
        			<td><input type="text" name="anyo" id="anyo" value="<?php echo $anyo ?>" /></td>
        		</tr>
        		<!-- tr>
        			<td class="derecha"><label for="limite">Máx. resultados:</label></td>
        			<td><input type="text" name="limite" id="limite" value="<?php echo $limite ?>" /></td>
        		</tr -->
        		<tr>
        			<td></td>
        			<td class="derecha"><input type="submit" value="actualizar" /></td>
        		</tr>
        	</table>
        </form>

        <div id="chart1"></div>
<?php
        
        require_once(SKEL_DIR . "/bodyEnd.php");
        
        require_once(SKEL_DIR . "/pie.php");

    }

?>