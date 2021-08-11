<?php

    if (defined("SECURITY_CONSTANT")) {
        
        $bodyId = "facturaFicha";
        $pageTitle = "Ficha de factura";
        $action = "index.php?controlador=factura&amp;";
        
        /*
         * Definimos una variable global para el redondeo de decimales.
         * Recordar que si cambiamos el número de decimales, también hay que cambiarlo en la base de datos.
         * Referencias: 
         * 	Paso de variables PHP - JS -> http://www.gestiweb.com/?q=content/cómo-pasar-variables-de-javascript-php-y-viceversa
         * 	Ámbito de las variables PHP -> http://php.net/manual/es/language.variables.scope.php
         * */
        global $decimales; //variable para el redondeo de decimales.
        $decimales = DECIMALES;
  
        // Desplegable de tipos de IVA para las líneas de factura generadas con JQuery
        $selectTiposIva = '<select onchange="recalculaTotalFactura(this)" class="select_factura_iva" name="select_factura_iva[]">';
        
        if ( isset($tiposIva) ) {
        	
            foreach ($tiposIva as $x) {
                
                $selectTiposIva .= '<option value="' . $x->getTipoIvaPorcentaje() . '">' . $x->getTipoIvaPorcentaje() . '%</option>';
                
            }
            
        }

        $selectTiposIva .= '</select>';
        
        // Desplegable de tipos de IRPF para las líneas de factura generadas con JQuery
        $selectTiposIrpf = '<select onchange="recalculaTotalFactura(this)" class="select_factura_irpf" name="select_factura_irpf[]">';
        
        if ( isset($tiposIrpf) ) {
        
        	foreach ($tiposIrpf as $x) {
        
        		$selectTiposIrpf .= '<option value="' . $x->getTipoIrpfPorcentaje() . '">' . $x->getTipoIrpfPorcentaje() . '%</option>';
        
        	}
        
        }
        
        $selectTiposIrpf .= '</select>';
        
        $disabled = "";
        
        if ( isset($factura) ) {
        	
        	//miramos el tipo de factura
        	$serie_numero = $factura -> getFacturaSerie();
        	if($serie_numero == 0){
        		$serie = SERIE_NORMAL;
        	}else{
        		$serie = SERIE_RECTIFICATIVA;
        	}
        	
        	$pageTitle = $pageTitle . " :: " .$serie. $factura->getFacturaNumero();
        	$action = $action . "opcion=modificacion";
        	
        	// Desactivamos los controles si la factura está cerrada
            $disabled = ($factura->getFacturaCerrada() == 1) ? "readonly=\"readonly\"" : "";
        	
        } else {
        	
        	$pageTitle = $pageTitle . " :: Nueva factura servicio clínica";
        	$action = $action . "opcion=creacion";
        	
        }

        require_once(SKEL_DIR . "/cabecera.php");
        
        require_once(SKEL_DIR . "/headStart.php");
        
?>

		<script charset="utf-8" type="text/javascript">
		/* <![CDATA[ */
            
            $(function() {
            	$('.date-pick').datepicker();
            });
                        
        /* ]]> */
		</script>

		<!-- Validaciones JQuery -->
		<script type="text/javascript">
		/* <![CDATA[ */
		
		function validarForm() {

    		if ( $('#factura_idcliente').val() == "" ) {
        		alert("El campo 'Cliente' no puede estar vacío");
        		$('#factura_idcliente').focus();
        		return false;
    		}

    		if ( confirm("¿Está seguro?") )
        		$("#formFichaFactura").submit();

        }

        function confirmarFacturaRectificativa() {

        	return confirm("¿Está seguro de querer crear una factura rectificativa sobre esta factura? Compruebe primero que ya no exista una creada, por favor.");

        }

        function confirmarCerrarFactura() {

        	return confirm("¿Está seguro de querer cerrar esta factura? No podrá volver a modificarla una vez hecho esto.");

        }
        function confirmarConvertirAbono() {

        	return confirm("¿Está seguro de querer Convertir en Abono esta factura?");

        }
                 
        /* ]]> */
		</script>
		
		<script type="text/javascript">
		/* <![CDATA[ */
		
			function addCommas(nStr) {
            	nStr = nStr.toString().replace(/\./g, ',');
            	return nStr;
            }

			function removeCommas(nStr) {
            	nStr = nStr.toString().replace(/,/g, '.');
            	return nStr;
            }
		
			function nuevaLineaFactura() {

				$('#lineasFacturaTableBody').append('<tr>' +
                    '<td class="tdFecha"><input type="text" class="lfactura_fechaservicio date-pick" name="lfactura_fechaservicio[]" value="" /></td>' +
            		'<td class="tdPaciente"><input type="text" class="lfactura_pacienteservicio" name="lfactura_pacienteservicio[]" value="" /></td>' +
                    '<td class="tdIntervencion"><input type="text" class="lfactura_intervencionservicio" name="lfactura_intervencionservicio[]" value="" /></td>' +
                    '<td class="tdBimp"><input type="text" onkeyup="this.value=this.value.explode(\'.\').join(\',\' )" onchange="recalculaTotalFactura()" class="lfactura_bimp" name="lfactura_bimp[]" value="0,00" /></td>' + 
                    '<td class="tdBorrar"><input type="button" onclick="borraLineaFactura(this)" value="Borrar" /></td>'+
            	'</tr>');

				// Aplicamos calendario al nuevo campo de fecha creado
				$('.date-pick').datepicker();

			}

			function borraLineaFactura(element) {

				$(element).parent().parent().remove();
				recalculaTotalFactura();
				
			}

			function recalculaTotalLinea(element) {

				var decimales = "<?php echo $decimales; ?>" ;//cogemos la variable de decimales
	
				var trNode = $(element).parent().parent();
				var totalNode = $(trNode).children(".tdTotal").children(".lfactura_total");
				var parcialNode = $(trNode).children(".tdParcial").children(".lfactura_parcial");
				/*var ivaNodeVal = $(trNode).children(".tdIva").children(".lfactura_iva").val();
				var irpfNodeVal = $(trNode).children(".tdIrpf").children(".lfactura_irpf").val();*/
				var bimpNodeVal = removeCommas($(trNode).children(".tdBimp").children(".lfactura_bimp").val());

				/*$(totalNode).val( addCommas(parseFloat(bimpNodeVal * (1 + (ivaNodeVal/100) - (irpfNodeVal/100))).toFixed(decimales)) );
				$(parcialNode).val( addCommas(parseFloat(bimpNodeVal * (1 + (ivaNodeVal/100))).toFixed(decimales)) );*/

				//alert( $(totalNode).val() );
				//alert( $(parcialNode).val() );

				recalculaTotalFactura();

			}

			function recalculaTotalFactura() {
				var decimales = "<?php echo $decimales; ?>" ;//cogemos la variable de decimales
				
				var lineasFactura = $("#lineasFacturaTableBody").children("tr");

				// alert(lineasFactura.length);

				var total = parseFloat(0);
				var parcial = parseFloat(0);
				var ivaFactura = parseFloat(0);
				var irpfFactura = parseFloat(0);
				
				for (var i = 0; i < lineasFactura.length; i++) {

					var totalLinea = parseFloat( removeCommas($(lineasFactura[i]).children(".tdBimp").children(".lfactura_bimp").val()) );
					
					// Este isNaN() es necesario ya que, al borrar una línea de factura, parece que aún coge "algo", al menos en FF.
					// Supongo que "undefined".
					if ( !isNaN(totalLinea) ){
						total = total + totalLinea;
						
					}
					//TODO: NO CALCULA TOTALES SI TENEMOS ESTA LÍNEA
					/*if ( !isNaN(parcialLinea) ){
						parcial = parcial + parcialLinea;
					}*/

				}

				var baseFactura = total;
				
				var ivaFactura = parseFloat( removeCommas($(".factura_iva").val()));
				var totalIvaFactura = ((ivaFactura * total)/100);
				
				var irpfFactura = parseFloat( removeCommas($(".factura_irpf").val()));
				var totalIrpfFactura = ((irpfFactura * total)/100);

				var total_factura = (baseFactura+totalIvaFactura);
				var total_pagar = (baseFactura+totalIvaFactura-totalIrpfFactura);

				$("#baseFactura").html(addCommas(total.toFixed(decimales))); //El que se ve en pantalla
				$("#factura_base").val(addCommas(total.toFixed(decimales))); //El input hidden que enviamos
		
				$("#ivaFactura").html(addCommas(totalIvaFactura.toFixed(decimales)));
				//$("#factura_iva").val(addCommas(ivaFactura.toFixed(decimales)));
				$("#factura_iva_total").val(addCommas(totalIvaFactura.toFixed(decimales)));

				$("#irpfFactura").html(addCommas(totalIrpfFactura.toFixed(decimales)));
				//$("#factura_irpf").val(addCommas(irpfFactura.toFixed(decimales)));
				$("#factura_irpf_total").val(addCommas(totalIrpfFactura.toFixed(decimales)));

				$("#parcialFactura").html(addCommas(total_factura.toFixed(decimales)));
				$("#factura_parcial").val(addCommas(total_factura.toFixed(decimales)));
				
				$("#totalFactura").html(addCommas(total_pagar.toFixed(decimales)));
				$("#factura_total").val(addCommas(total_pagar.toFixed(decimales)));

			}

			function getChar(event) {

				var keyCode = ('which' in event) ? event.which : event.keyCode;

	            if (parseInt(keyCode) == 13) // enter
	            	nuevaLineaFactura();

			}

			function getDatosCliente() {

				var cliente_id = $("#factura_idcliente").val();

				if ( !isNaN(cliente_id) ) {

					$.ajax({
    					data: "controlador=cliente&opcion=consultaAjax&cliente_id=" + cliente_id,
    					type: "GET",
    					dataType: "json",
    					url: "index.php",
    					success: function(data){ actualizarDatosCliente(data); },
						error:function (xhr, ajaxOptions, thrownError){
							alert("Error en llamada AJAX");
    	                    alert(xhr.status);
    	                    alert(thrownError);
    	                }    
					});

				}
				
			}

			function actualizarDatosCliente(datos) {
				
				$("#cliente_nif").html(datos.cliente_nif);
				$("#cliente_direccion").html(datos.cliente_direccion);
				
			}

		/* ]]> */
		</script>

<?php
        
        require_once(SKEL_DIR . "/headEnd.php");
        
        require_once(SKEL_DIR . "/bodyStart.php");
        
        require_once(SKEL_DIR . "/menu.php");

?>
        <h1><?php echo $pageTitle ?></h1>
                
        <div id="fichaFactura">
        
        	<p><a href="index.php?controlador=factura&amp;opcion=listado"><img alt="Volver al listado de facturas" src="img/invoice_32x32.png"/> Volver al listado de facturas</a></p>
        	
        	<?php if ( isset($factura) ) { ?>
    		<p><a href="index.php?controlador=factura&opcion=imprimir&id=<?php echo $factura->getFacturaId() ?>" title="Imprimir factura"><img alt="Imprimir factura" src="img/printer_32x32.png"/> Imprimir factura</a></p>
    		<?php } ?>
        
        	<form id="formFichaFactura" class="ficha" method="post" action="<?php echo $action ?>" onsubmit="">
        		<fieldset>
        			<legend>Formulario de creación/edición de facturas</legend>
        			<table id="tablaFichaFactura">
        				<tbody>
        					<tr>
        						<td>
        							<p>
                        				<label for="factura_idcliente">Cliente:</label>
                        				<select <?php echo $disabled ?> onchange="getDatosCliente()" name="factura_idcliente" id="factura_idcliente">
                    						<option value="">SIN SELECCIÓN</option>
                						<?php 
                						    
                						    $numClientes = count($clientes);
                
                                            for ($i = 0; $i < $numClientes; $i++) {
                                            
                                                $tmp = (object)$clientes[$i];
                                                $selected = ( isset($factura) && $tmp->getClienteId() == $factura->getFacturaIdCliente() )
                                                                || ( isset( $_GET["opcion"] ) && $_GET["opcion"] == "precreacion" && isset( $_GET["idcliente"] ) && $_GET["idcliente"] == $tmp->getClienteId() )
                						
                						?>
                							<option <?php if ($selected) { echo "selected=\"selected\""; } ?> value="<?php echo $tmp->getClienteId() ?>"><?php echo $tmp->getClienteNombre() ?></option>
                						<?php
                						
                                            }
                						
                						?>
                    					</select>
                        			</p>
                        			<div>
                        				<p><b>NIF/CIF:</b> <span id="cliente_nif"><?php if ( isset($cliente) ) echo $cliente->getClienteNif(); ?></span></p>
                        				<p><b>Dirección:</b> <span id="cliente_direccion"><?php if ( isset($cliente) ) echo $cliente->getClienteDireccion(); ?></span></p>
                        			</div>
        						</td>
        						<td>
        							<?php if ( isset($factura) ) { ?>
                        			<p>
                        				<label for="factura_numero">Número de factura:</label>
                        				<?php //creo factura_numero porque en la base de datos el número de factura solo puede ser un número y no podemos añadir el texto?>
                        				<input readonly="readonly" type="text" name="factura_numero_mostrar" id="factura_numero_mostrar" value="<?php if ( isset($factura) ) { echo $serie.$factura->getFacturaNumero(); } ?>" />
                    					<input type="hidden" name="factura_numero" id="factura_numero" value="<?php if ( isset($factura) ) { echo $factura->getFacturaNumero(); } ?>" />
                    				</p>
                    				<?php } ?>
        						</td>
        					</tr>
        					<tr>
        						<td>
        							<?php if ( isset($factura) ) { ?>
                    				<p>
                    					<label for="factura_fechacreacion">Fecha de creación:</label>
                    					<input disabled="disabled" type="text" name="factura_fechacreacion" id="factura_fechacreacion" value="<?php echo $factura->getFacturaFechacreacion() ?>" />
                    				</p>
                    				<input type="hidden" name="factura_id" value="<?php echo $factura->getFacturaId() ?>" />
                    				<?php } ?>
        						</td>
        					</tr>
        					<tr>
        						<td>
        							<p>
                        				<label for="factura_pagada">Pagada ?:</label>
                    					<input <?php if ( isset($factura) && $factura->getFacturaPagada() == 1 ) { echo "checked=\"checked\""; } ?> type="checkbox" name="factura_pagada" id="factura_pagada" value="1" />
                        				<label for="factura_fechacobro">Fecha de cobro:</label>
                    					<input class="date-pick" type="text" name="factura_fechacobro" id="factura_fechacobro" value="<?php if ( isset($factura) ) { echo $factura->getFacturaFechacobro(); } ?>" />
                        			</p>
        						</td>
        						<td>
        							<p>
                        				<label for="factura_contabilizada">Contabilizada ?:</label>
                    					<input <?php if ( isset($factura) && $factura->getFacturaContabilizada() == 1 ) { echo "checked=\"checked\""; } ?> type="checkbox" name="factura_contabilizada" id="factura_contabilizada" value="1" />
                    					<label for="factura_fechacontabilizada">Fecha contabilizada:</label>
                    					<input class="date-pick" type="text" name="factura_fechacontabilizada" id="factura_fechacontabilizada" value="<?php if ( isset($factura) ) { echo $factura->getFacturaFechacontabilizada(); } ?>" />
                        			</p>
        						</td>
        					</tr>
        					<tr>
        						<td>
        							<p>
                    					<label>Tipo de factura:</label> servicio
                    					<input type="hidden" name="factura_tipo" value="servicio" />
                    				</p>
        						</td>
        						<td></td>
        					</tr>
        					
        					<tr>
        						<td class="tdIva">
	        						<?php 
	        						if ( isset($factura)) {
	        							//$ivaFacturaParteEntera = intval($factura->getFacturaIva());
	        							
	        							$facturaBase 	 = $factura->getFacturaBase();
	        							$facturaBase_OK	 = str_replace (",", ".", "$facturaBase"); //convertirmos la , en . para poder sumar
										$facturaIva 	 = $factura->getFacturaIva();
										$facturaIva_OK	 = str_replace (",", ".", "$facturaIva"); //convertirmos la , en . para poder sumar
										$facturaBase_iva = $facturaBase_OK + $facturaIva_OK;
										$tipoIva = (($facturaBase_iva - $facturaBase_OK)*100)/$facturaBase_OK;
										/*
										echo "Factura Base: $facturaBase <br>";
										echo "Factura Base OK: $facturaBase_OK <br>";
										echo "Factura IVA: $facturaIva <br>";
										echo "Factura IVA OK: $facturaIva_OK <br>";
										echo "Factura Base IVA: $facturaBase_iva <br>";
										echo "Factura Tipo IVA: $tipoIva <br>";
										echo $tipoIva ."= ((". $facturaBase_iva ."-".$facturaBase_OK .")*100)/".$facturaBase_OK.")<br>";
										echo "tipoIva = (facturaBase_iva OK - facturaBase OK)/facturabase OK)*100<br>";
										echo $tipoIva ."= ((". $facturaBase_iva ."-".$facturaBase .")*100)/".$facturaBase.")<br>";
										echo "tipoIva = (facturaBase_iva  - facturaBase )/facturaBase )*100<br>";
										*/
										
	        						}
	        						
	        						?>
        							<label>IVA:</label>
                            		<select <?php echo $disabled ?> 
                            				name="factura_iva"
                            				class="factura_iva"
                            				onchange="recalculaTotalFactura()" 
                            		>

                            			<?php 
                            			
                            			foreach ($tiposIva as $x) { ?>
                            				
                            				<option <?php 
                            				
                            					if (isset ($factura)){
													
                            						if ($tipoIva == $x->getTipoIvaPorcentaje()) { 
														echo 'selected="selected"';
													} 
													
												}?>
												
													value="<?php echo $x->getTipoIvaPorcentaje() ?>"
											>
                            				
                            					<?php echo $x->getTipoIvaPorcentaje() ?>%
                            					
                            				</option>

                            			<?php 
										} //end foreach?>
                            			
                        			</select>
                    			</td>
        					</tr>
        					
        					<tr>
        						<td class="tdIrpf">
	        						<?php 
	        						if ( isset($factura)) {
	        							//$irpfFacturaParteEntera = intval($factura->getFacturaIrpf());
	        							$facturaBase 	 = $factura->getFacturaBase();
	        							$facturaBase_OK	 = str_replace (",", ".", "$facturaBase"); //convertirmos la , en . para poder sumar
										$facturaIrpf 	 = $factura->getFacturaIrpf();
										$facturaIrpf_OK	 = str_replace (",", ".", "$facturaIrpf"); //convertirmos la , en . para poder sumar
										$facturaBase_irpf = $facturaBase_Ok - $facturaIrpf_OK;
										$tipoIrpf = round((($facturaBase - $facturaBase_irpf)/$facturaBase)*100,0);
	        						}
	        						?>
        							<label>IRPF:</label>
                            		<select <?php echo $disabled ?> 
                            				name="factura_irpf"
                            				class="factura_irpf"
                            				onchange="recalculaTotalFactura()" 
                            		>
                            			<?php 
                            			foreach ($tiposIrpf as $x) { ?>
                            				
                            				<option <?php 
                            					if (isset ($factura)){
                            						if ($tipoIrpf == $x->getTipoIrpfPorcentaje()) {
														echo 'selected="selected"'; 
													} 
												}?> 
														value="<?php echo $x->getTipoIrpfPorcentaje() ?>"
											>
                            				
                            					<?php echo $x->getTipoIrpfPorcentaje() ?>%
                            					
                            				</option>

                            			<?php 
										} ?>
                            			
                        			</select>
                    			</td>
        					</tr>
        					
        				</tbody>
        			</table>
    	
                	<div id="lineasFactura">
                	        	        		        		
                		<table cellspacing="0">
                			<colgroup>
                				<col width="75" />
                				<col width="200" />
                				<col width="150" />
                				<col width="75" />
                				
                				<col width="75" />
                			</colgroup>
                            <thead>
                            	<tr>
                            		<th>Fecha</th>
                            		<th>Paciente</th>
                            		<th>Concepto</th>
                            		<th class="derecha">Base €</th>
                            		
                            		<th><!-- borrar --></th>
                            	</tr>
                        	<tbody id="lineasFacturaTableBody">
                            	<?php
                            		
                            	    if ( isset($lfacturas) ) {

                                	    $numLfacturas = count($lfacturas);    

                                	    for ($i = 0; $i < $numLfacturas; $i++) {
                                	        
                                	        $lfactura = (object)$lfacturas[$i];
                            	
                            	?>
            					<tr>
            						<td class="tdFecha">
            							<input <?php echo $disabled ?> 
            									type  = "text" 
            									class = "lfactura_fechaservicio date-pick" 
            									name  = "lfactura_fechaservicio[]" 
            									value = "<?php echo $lfactura -> getLfacturaFechaservicio() ?>" 
            							/>
            						</td>
            						<td class="tdPaciente">	
            							<input <?php echo $disabled ?> 
            									type="text" 
            									class="lfactura_pacienteservicio" 
            									name="lfactura_pacienteservicio[]" 
            									value="<?php echo $lfactura->getLfacturaPacienteservicio() ?>" 
            							/>
            						</td>
                            		<td class="tdIntervencion">	
                            			<input <?php echo $disabled ?> 
                            					type="text" 
                            					class="lfactura_intervencionservicio" 
                            					name="lfactura_intervencionservicio[]" 
                            					value="<?php echo $lfactura->getLfacturaIntervencionservicio() ?>" 
                            			/>
                            		</td>
                            		<td class="tdBimp">	
                            			<input <?php echo $disabled ?> 
                            					type="text" 
                            					onkeyup="this.value=this.value.explode('.').join(',' )" 
                            					onchange="recalculaTotalFactura()" 
                            					class="lfactura_bimp" 
                            					name="lfactura_bimp[]" 
                            					value="<?php echo $lfactura->getLfacturaBimp() ?>" 
                            			/>
                            		</td>
                            	
                					<td class="tdBorrar"><input <?php echo $disabled ?> type="button" onclick="borraLineaFactura(this)" value="Borrar" /></td>
                				</tr>
                            	<?php
                            	
                            	        } // end for
                            	        
                            	    } // end if isset
                            	    
                            	?>
                            	
                            </tbody>
                		</table>
                		
                		<p><input <?php echo $disabled ?> type="button" onclick="nuevaLineaFactura()" value="Nuevo concepto" /></p>
                		
                		<p id="contenedorBaseFactura">
                			Total Base : <span id="baseFactura"><?php if ( isset($factura) ) { echo $factura->getFacturaBase(); } else { echo "0,00"; } ?></span> €
                		</p>
                		<input type="hidden" name="factura_base" id="factura_base" value="<?php if ( isset($factura) ) { echo $factura->getFacturaBase(); } else { echo "0,00"; } ?>" />
                		
                		<p id="contenedorIvaFactura">
                			Total IVA : <span id="ivaFactura"><?php if ( isset($factura) ) { echo $factura->getFacturaIva(); } else { echo "0,00"; } ?></span> €
                		</p>
                		<input type="hidden" name="factura_iva_total" id="factura_iva_total" value="<?php if ( isset($factura) ) { echo $factura->getFacturaIva(); } else { echo "0,00"; } ?>" />
						
						<p id="contenedorIrpfFactura">
                			Total IRPF : <span id="irpfFactura"><?php if ( isset($factura) ) { echo $factura->getFacturaIrpf(); } else { echo "0,00"; } ?></span> €
                		</p>
                		<input type="hidden" name="factura_irpf_total" id="factura_irpf_total" value="<?php if ( isset($factura) ) { echo $factura->getFacturaIrpf(); } else { echo "0,00"; } ?>" />
						
                		<p id="contenedorParcialFactura">
                			Total Factura (sin IRPF): <span id="parcialFactura"><?php if ( isset($factura) ) { echo $factura->getFacturaParcial(); } else { echo "0,00"; } ?></span> €
                		</p>
                		<input type="hidden" name="factura_parcial" id="factura_parcial" value="<?php if ( isset($factura) ) { echo $factura->getFacturaParcial(); } else { echo "0,00"; } ?>" />
                		
                		<p id="contenedorTotalFactura">
                			Total a Pagar: <span id="totalFactura"><?php if ( isset($factura) ) { echo $factura->getFacturaTotal(); } else { echo "0,00"; } ?></span> €
                		</p>
                		<input type="hidden" name="factura_total" id="factura_total" value="<?php if ( isset($factura) ) { echo $factura->getFacturaTotal(); } else { echo "0,00"; } ?>" />
                		<input type="hidden" name="factura_serie" value= "<?php if ( isset($factura) ) { echo $factura->getFacturaSerie(); } else { echo SERIE_BBDD_NORMAL; } ?> "/>
                		
                		<?php
                		if ( isset($factura) ) {
	                		if ( $factura->getFacturaIdrectificativa() != NULL && $factura->getFacturaIdrectificativa() != "") { ?>
	                			<input type="hidden" name="factura_idRectificativa" value="<?php echo $factura->getFacturaIdrectificativa() ?>" />
	                			<input type="hidden" name="factura_serie" value= "<?php if ( isset($factura) ) { echo $factura->getFacturaSerie(); } else { echo SERIE_BBDD_RECTIFICATIVA; } ?> "/>
	                			
                		<?php     
							}
						}
						?>         		
                		              		
                	</div>
                	
            		<p>
    					<?php if ( isset($factura) ) { ?>
    					<!--
    						Estos inputs son de tipo button en vez de submit ya que, cuando le damos a enter en el input del total,
							se envía la señal de submit y se activa el evento onclick. Lo evitamos poniendo el tipo button y forzamos
							que sólo se active este evento haciendo clic en el botón.
						-->
						<input type="button" value="Modificar factura" onclick="return validarForm()" />
						<input type="button" value="Modificar factura y volver" onclick="$('#formFichaFactura').attr('action', $('#formFichaFactura').attr('action') + '&volver=true'); return validarForm()" />
    					<?php     if ($factura->getFacturaCerrada() == 1) { ?>
    					<span style="color: red; font-weight: bold;">(factura cerrada)</span>
    					<?php     } ?>
    					<?php } else { ?>
    					<input type="button" value="Crear factura" onclick="return validarForm()" />
    					<input type="button" value="Crear factura y volver" onclick="$('#formFichaFactura').attr('action', $('#formFichaFactura').attr('action') + '&volver=true'); return validarForm()" />
    					<?php } ?>
					</p>
        		</fieldset>
        	</form>
        	
        	<?php if ( isset($factura) ) { ?>
        	
        	<?php     if ($factura->getFacturaCerrada() == 0 ) { ?>
        	
        	<form id="formCerrarFactura" class="ficha" method="post" action="index.php?controlador=factura&amp;opcion=cerrarFactura" onsubmit="return confirmarCerrarFactura()">
        		<fieldset>
        			<legend>Cerrar factura</legend>
        			<input type="hidden" name="factura_id" value="<?php echo $factura->getFacturaId() ?>" />
        			<p>
        				<input type="submit" value="Cerrar factura" />
        				<input type="submit" value="Cerrar factura y volver" onclick="$('#formCerrarFactura').attr('action', $('#formCerrarFactura').attr('action') + '&volver=true')" />
    				</p>
        		</fieldset>
        	</form>
        	<?php     if ($factura->getFacturaSerie() == 0 ) { ?>
	        	<form id="formConvertirAbono" class="ficha" method="post" action="index.php?controlador=factura&amp;opcion=convertirAbono" onsubmit="return confirmarConvertirAbono()">
	        		<fieldset>
	        			<legend>Convertir en Abono (factura rectificativa)</legend>
	        			<i>Poner la serie R (solo se puede hacer antes de cerrar).</i>
	        			<input type="hidden" name="factura_id" value="<?php echo $factura->getFacturaId() ?>" />
	        			<p>
	        				<input type="submit" value="Convertir en abono" />
	        				<input type="submit" value="Convertir en abono y volver" onclick="$('#formConvertirAbono').attr('action', $('#formConvertirAbono').attr('action') + '&volver=true')" />
	    				</p>
	        		</fieldset>
	        	</form>
        	<?php }else{?>
	        	<form id="formDesconvertirAbono" class="ficha" method="post" action="index.php?controlador=factura&amp;opcion=desconvertirAbono" onsubmit="return confirmarConvertirAbono()">
	        		<fieldset>
	        			<legend>Desconvertir en Abono (volver a factura normal)</legend>
	        			<i>Quitará la serie R (solo se puede hacer antes de cerrar).</i>
	        			<input type="hidden" name="factura_id" value="<?php echo $factura->getFacturaId() ?>" />
	        			<p>
	        				<input type="submit" value="Desconvertir en abono" />
	        				<input type="submit" value="Desconvertir en abono y volver" onclick="$('#formDesconvertirAbono').attr('action', $('#formDesconvertirAbono').attr('action') + '&volver=true')" />
	    				</p>
	        		</fieldset>
	        	</form>
        	<?php }
			} 

			if ( $factura->getFacturaIdrectificativa() == NULL || $factura->getFacturaIdrectificativa() == "") { ?>
        	
        	<form class="ficha" method="post" action="index.php?controlador=factura&amp;opcion=facturaRectificativa" onsubmit="return confirmarFacturaRectificativa()">
        		<fieldset>
        			<legend>Crear abono</legend>
        			<input type="hidden" name="factura_id" value="<?php echo $factura->getFacturaId() ?>" />
        			<input type="hidden" name="factura_serie" value="<?php echo SERIE_BBDD_RECTIFICATIVA ?>" />
        			<p>
        				<input type="submit" value="Crear" />
    				</p>
        		</fieldset>
        	</form>
        	
        	<?php     } else { ?>
        	
        	<form class="ficha">
    	        <fieldset>
    				<legend>Abono</legend> 	   
        			<p>Esta factura posee un <strong>ABONO</strong> asociado: <a href="index.php?controlador=factura&opcion=consulta&id=<?php echo $factura->getFacturaIdrectificativa() ?>">Ir a abono</a></p>
        		</fieldset>
        	</form>
        	
        	<?php     } ?>
        	
        	<?php } ?>
        	     	        	
    		<p><a href="index.php?controlador=factura&amp;opcion=listado"><img alt="Volver al listado de facturas" src="img/invoice_32x32.png"/> Volver al listado de facturas</a></p>
        	
        	<?php if ( isset($factura) ) { ?>
    		<p><a href="index.php?controlador=factura&opcion=imprimir&id=<?php echo $factura->getFacturaId() ?>" title="Imprimir factura"><img alt="Imprimir factura" src="img/printer_32x32.png"/> Imprimir factura</a></p>
    		<?php } ?>
        
        </div>
        
<?php
        
        require_once(SKEL_DIR . "/bodyEnd.php");
        
        require_once(SKEL_DIR . "/pie.php");

    }

?>
