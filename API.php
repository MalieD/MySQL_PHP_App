
<?php
include "Source/connection.php";
include "QueryFunctions.php";

//?function2call=GetAllIDs

// Afvangen van de call voor welke functie aangeroepen wordt.
if (isset($_POST['function2call']) && !empty($_POST['function2call'])) {
    if (strlen($_POST['function2call']) > 50) {
        trigger_error('Function call is te lang.', E_USER_ERROR);
        die;
    }
    $function2call = $_POST['function2call'];

    switch ($function2call) {
        // Bestanden hoofdpagina.
        case 'ExecQuery':
            ;
            // Richt de (eventueel) geparameteriseerde query in. Als geen parameters, dan zonder uitvoeren.					
            $sql = $_POST["function2call"]();

            if (isset($_POST["params"])) {
                if (is_array($_POST["params"])) {
                    $params = $_POST["params"];
                }
                else {
                    $params = array($_POST["params"]);
                }

                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $_POST["params"]);
                $stmt->execute();

                $result = $stmt->get_result();
                $data = $result->fetch_all(MYSQLI_ASSOC);

                mysqli_free_result($result);
            }
            else {
                $data = mysqli_query($conn, $sql);
            }

            if ($data === false) {
                $Exitcode = mysqli_error($conn);
            }
            else {

                $Exitcode = 100;
            }

            if ($Exitcode == 100) {
                echo json_encode(array("Exitcode" => $Exitcode, "Result" => $data));
            }
            else {
                echo json_encode(array("Exitcode" => $Exitcode));
            }

            CloseConnection();
            break;

        case 'GetNewestRecord':
            ;
            // Richt de (eventueel) geparameteriseerde query in. Als geen parameters, dan zonder uitvoeren.					
            $sql = $_POST["function2call"]();

            $data = mysqli_query($conn, $sql);

            if ($data === false) {
                $Exitcode = mysqli_error($conn);
            }
            else {
                $Exitcode = 100;
            }

            if ($Exitcode == 100) {
                if ($data) {
                    while ($row = mysqli_fetch_row($data)) {
                        $result = $row[0];
                    }
                }

                echo json_encode($result);
            }
            else {
                echo json_encode(array("Exitcode" => $Exitcode));
            }

            CloseConnection();
            break;
        case 'GetAllIDs':
            ;
            // Richt de (eventueel) geparameteriseerde query in. Als geen parameters, dan zonder uitvoeren.					
            $sql = $_POST["function2call"]();

            $data = mysqli_query($conn, $sql);

            if ($data === false) {
                $Exitcode = mysqli_error($conn);
            }
            else {
                $Exitcode = 100;
            }

            if ($Exitcode == 100) {
                if ($data) {
                    $result = array();

                    while ($row = mysqli_fetch_row($data)) {
                        array_push($result, $row[0]);
                    }
                }

                //echo json_encode(array("Data" => $result));
                echo json_encode($result);
            }
            else {
                echo json_encode(array("Exitcode" => $Exitcode));
            }

            CloseConnection();
            break;
        case 'AddRecord':
            ;
            // Richt de (eventueel) geparameteriseerde query in. Als geen parameters, dan zonder uitvoeren.					
            $sql = $_POST["function2call"]();

            if (isset($_POST["params"])) {
                if (is_array($_POST["params"])) {
                    $params = $_POST["params"];
                }
                else {
                    $params = array($_POST["params"]);
                }

                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $_POST["params"]);
                $stmt->execute();

            }
            else {
                $data = mysqli_query($conn, $sql);
            }

            if ($data === false) {
                $Exitcode = mysqli_error($conn);
            }
            else {

                $Exitcode = 100;
            }

            if ($Exitcode == 100) {
                echo json_encode(array("Exitcode" => $Exitcode, "Result" => $data));
            }
            else {
                echo json_encode(array("Exitcode" => $Exitcode));
            }

            CloseConnection();
            break;
        case 'UpdateRecord':
            ;
            // Richt de (eventueel) geparameteriseerde query in. Als geen parameters, dan zonder uitvoeren.					
            $sql = $_POST["function2call"]();

            if (isset($_POST["params"])) {
                if (is_array($_POST["params"])) {
                    $params = $_POST["params"];
                }
                else {
                    $params = array($_POST["params"]);
                }

                $stmt = $conn->prepare($sql);
                $params = json_decode($_POST["params"]);
                $par1 = $params[0]["id"];
                $par2 = $params[0]["waarde"];
                $stmt->bind_param('i', $par1);
                $stmt->bind_param('s', $par2);
                $stmt->execute();

            }
            else {
                $data = mysqli_query($conn, $sql);
            }

            if ($data === false) {
                $Exitcode = mysqli_error($conn);
            }
            else {

                $Exitcode = 100;
            }

            if ($Exitcode == 100) {
                echo json_encode(array("Exitcode" => $Exitcode, "Result" => $data));
            }
            else {
                echo json_encode(array("Exitcode" => $Exitcode));
            }

            CloseConnection();
            break;
        case 'GetThePicture':
            $imagedata = file_get_contents('Plaatjes/abc.jpeg');
            $base64 = base64_encode($imagedata);
            echo $base64;

            break;
        default:
            header("HTTP/1.1 404");
            break;
    }
}
else {
    echo "Well, it seems like this didn't really work...";
}



?>
