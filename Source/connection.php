<?php
// server address    
if ($_SERVER['SERVER_ADDR'] == "95.211.95.215") {
    $servername = "localhost";
}
else {
    $servername = "95.211.95.215";
}

$dbname = "e103741_testdatabase";
$username = "e103741_dennism";
$password = "D3nn1sM";


// Verbinding maken
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function CloseConnection()
{
    global $conn;
    $conn->close();
}

function test()
{
    return "TestDinges";
}

?>