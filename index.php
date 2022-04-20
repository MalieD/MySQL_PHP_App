
<?php
    include "connection.php";
    include "QueryFunctions.php";
    
    // Afvangen van de call voor welke functie aangeroepen wordt.
	if(isset($_POST['function2call']) && !empty($_POST['function2call'])) {
		if (strlen($_POST['function2call']) > 50){trigger_error('Function call is te lang.', E_USER_ERROR);die;}
		$function2call = $_POST['function2call'];
		
		switch($function2call) {			
			// Bestanden hoofdpagina.
			case 'ExecQuery' : ;							
				// Richt de (eventueel) geparameteriseerde query in. Als geen parameters, dan zonder uitvoeren.					
                $sql = $_POST["function2call"]();

                if(isset($_POST["params"])){
                    if(is_array($_POST["params"])){							
                        $params = $_POST["params"];	
                    } else {
                        $params = array($_POST["params"]);
                    }		
          
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('i', $_POST["params"]);
                    $stmt->execute();	
                    
                    $result = $stmt->get_result();
                    $data = $result->fetch_all(MYSQLI_ASSOC);
                }
                else{
                    $data = mysqli_query( $conn, $sql);
                }	

                if( $data === false) {
                    $Exitcode = mysqli_errors();
                } else {																
                    
                    $Exitcode = 100;	
                   mysqli_free_result( $result);
                }

				if ($Exitcode == 100) {					
					echo json_encode(array("Exitcode" => $Exitcode, "Result" => $data));
				} else {
					echo json_encode(array("Exitcode" => $Exitcode));
				}	
				
                CloseConnection();				
			break;
            
            case 'AddRecord' : ;							
				// Richt de (eventueel) geparameteriseerde query in. Als geen parameters, dan zonder uitvoeren.					
                $sql = $_POST["function2call"]();

                if(isset($_POST["params"])){
                    if(is_array($_POST["params"])){							
                        $params = $_POST["params"];	
                    } else {
                        $params = array($_POST["params"]);
                    }		
          
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('s', $_POST["params"]);
                    $stmt->execute();	
                    
                }
                else{
                    $data = mysqli_query( $conn, $sql);
                }	

                if( $data === false) {
                    $Exitcode = mysqli_errors();
                } else {																
                    
                    $Exitcode = 100;	
                }

				if ($Exitcode == 100) {					
					echo json_encode(array("Exitcode" => $Exitcode, "Result" => $data));
				} else {
					echo json_encode(array("Exitcode" => $Exitcode));
				}	
				
                CloseConnection();				
			break;	

			default:
				header("HTTP/1.1 404");
			break;		
		}
	}	


?>

