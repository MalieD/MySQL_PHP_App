<?php
    $Local='GreenHost';        

    // Create connection
    // if ($Local=='Saco'){
    //     $servername = "localhost";
    //     $dbname = "test";            
    //     $username = "StdGebruiker";
    //     $password = "5x4X]vr2YddodN0t";        
    // } else if ($Local=='Dennis') {
    //     $servername = "localhost";
    //     $dbname = "test";
    //     $username = "";
    //     $password = "D3nn1sM";        
    // } else if ($Local=='MijnHost') {
    //     $servername = "95.211.95.215";
    //     $dbname = "e103741_testdatabase";
    //     $username = "e103741_dennism";
    //     $password = "D3nn1sM";
    // } else if ($Local=='GreenHost') {
        $servername = "3ddeal1.sql.ghserv.net";
        $dbname = "testdatabase";
        $username = "3ddeal";
        $password = "wixvulfoykofjoowfickcajTudfec4";                
    // }

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