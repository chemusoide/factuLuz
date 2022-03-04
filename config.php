<?php

    // Whitelist con los archivos que permitimos cargar
    define(
    	"ALLOWED_CONTROLLERS", 
        serialize( 
            array(
                "cliente",
                "config",
            	"factura",
            	"general",
            	"tipoIva",
            	"tipoIrpf",
                "usuario"
            )
        )
    );

    // Directorio donde alojamos los archivos del esqueleto común de las vistas
    define("SKEL_DIR", "skel");

    // Directorio donde alojamos las vistas
    define("VIEWS_DIR", "vistas");
    
    // Directorio donde alojamos los controladores
    define("CONTROLLERS_DIR", "controladores");

    // Directorio de los Data Access Object
    define("DAO_DIR", "dao");
    
    // Directorios para JavaScript u CSS
    define("JS_DIR", "js");
    define("CSS_DIR", "css");
    
    //Constante para el redondeo de decimales.
    define ("DECIMALES", 2);
    
    //Tipos de Series de factura
    //Factura normal
    define ("SERIE_BBDD_NORMAL", 0);
    
    //Factira rectificativa
    define ("SERIE_BBDD_RECTIFICATIVA", 1);
    
    //Constantes para las series en 2016
    //CPQ
    //define ("SERIE_NORMAL", "2016P");
    //define ("SERIE_RECTIFICATIVA", "R2016P");
    //GATOPANI
    //define ("SERIE_NORMAL", "2016G");
    //define ("SERIE_RECTIFICATIVA", "R2016G");
    //Clínica Luz
    
//Añadido Chema 02.01.2017 - Solucionar problema Fecha Serie Factura. Archivos: config.php e index.php - Begin   
    /*Se define el año para poder jugar con el como número y evitar
	    Problemas en las BBDD antiguas sino pone por ejemplo: 2016P estando en 2017
	    */
	$ano_actual = date("Y");
	
	define ("ANO_ACTUAL", $ano_actual);
	
	/*contamos los años entre el actual y en inicio de esta versión del programa en 2016*/
	$contador_anos = $ano_actual - 2015; 
    
    for ($i = 1; $i <= $contador_anos; $i++) {
    	//echo ("anos: $i");
    	$listado_anos_anteriores[] = $ano_actual-$i;
	}
	
	//Base de datos = Nombre_BD_SIN_ANO + ano_actual (o listado_anos_anteriores[])
	define ("NOMBRE_BD_SIN_ANO", "factuluz");
	//Listado_anos_anteriores: 0 -> ano_actual -1, 1: ano_actual -2, etc.
    

//Añadido Chema 02.01.2017 - Solucionar problema Fecha Serie Factura - END
    
    
    //define ("SERIE_NORMAL", "2017L");
    //define ("SERIE_RECTIFICATIVA", "R2017L");
    
     /********************************************
     * definimos el valor del id del cliente ASISA segun la BBDD
     */
    define ("ID_ASISA_BBDD", 10);
    
    /**************************************
     ** Para que muestre la fecha en local *
    **************************************/
    date_default_timezone_set('Europe/Madrid');
    
    /********************************************************
     *** Configuración de acceso a la base de datos **********
    ********************************************************/
    //LOCAL
    /*
    define("DB_DRIVER", "mysqli");
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASSWORD", "root");
    define("DB_DATABASE", "polic_factg15");
    define("DB_DEBUGMODE", "false"); // Ojo, a true desactiva las citas vía AJAX/JSON.
    define("DB_OLD_DATABASES", serialize(array("polic_factg...")));
     */
    
    //REMOTO
    
    //define("DB_DRIVER", "mysql");
    define("DB_DRIVER", "mysqli"); //este para que coja la conexión mysqli sino en versiones altas de PHP no fucniona
    define("DB_HOST", "localhost");
    define("DB_USER", "DB_USER");
    define("DB_PASSWORD", "DB_PASSWORD");
    define("DB_DATABASE", NOMBRE_BD_SIN_ANO.$ano_actual);
    define("DB_DEBUGMODE", "false"); // Ojo, a true desactiva las citas vía AJAX/JSON.
    define("DB_OLD_DATABASES", serialize(array(NOMBRE_BD_SIN_ANO.$listado_anos_anteriores[0],NOMBRE_BD_SIN_ANO.$listado_anos_anteriores[1],NOMBRE_BD_SIN_ANO.$listado_anos_anteriores[2],NOMBRE_BD_SIN_ANO.$listado_anos_anteriores[3],NOMBRE_BD_SIN_ANO.$listado_anos_anteriores[4])));
     //futuros años: define("DB_OLD_DATABASES", serialize(array(NOMBRE_BD_SIN_ANO.$listado_anos_anteriores[0],NOMBRE_BD_SIN_ANO.$listado_anos_anteriores[1]),NOMBRE_BD_SIN_ANO.$listado_anos_anteriores[2]));
   
    
//    define("DB_DRIVER", "mysql");
//    define("DB_HOST", "localhost");
//    define("DB_USER", "educalia_arturo");
//    define("DB_PASSWORD", "r2d2");
//    define("DB_DATABASE", "educalia_factuweb2013");
//    define("DB_DEBUGMODE", "false");
//	  define("DB_OLD_DATABASES", serialize(array("educalia_factuweb2012")));

?>
