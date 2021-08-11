<?php
    
    if (defined("SECURITY_CONSTANT")) {
    	
    	if (isset($_GET["opcion"])) {
    	
	        switch ($_GET["opcion"]) {
	
	            case "backupDB":
	                
	                $baseName = DB_DATABASE . "_" . date("Ymd_His") . '.gz';
	                $backupFile = "/tmp/" . $baseName;
                    $command = "mysqldump --opt --host=" . DB_HOST . " --user=" . DB_USER . " --password=" . DB_PASSWORD . " " . DB_DATABASE . " | gzip > $backupFile";
                    system($command, $return);
                    
                    if ($return == 0) {
                        
                        header("Content-Disposition: attachment; filename=$baseName");
                        header("Content-type: application/x-gzip");
                        echo file_get_contents($backupFile);
                        
                    } else {
                        
                        echo "<h1>Se produjo algún error</h1>";
                        
                    }
                    
	            	break;
	            		            	
                default:
	            	
	                require_once(VIEWS_DIR . "/inicio.php");
	
	        }
	        
    	} else {
    		
            require_once(VIEWS_DIR . "/inicio.php");
    		
    	}

    }

?>