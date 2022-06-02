<?php
    $servername = "localhost";
	$dbname = "e103741_testdatabase";
	$username = "e103741_dennism";
	$password = "D3nn1sM";

    // Verbinding maken
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   
    function CloseConnection(){
        global $conn;
        $conn->close();
    }
    
?>