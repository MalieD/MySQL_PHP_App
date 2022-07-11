
<?php
include "Source/connection.php";
include "QueryFunctions.php";
include "ImageFunctions.php";
include "StringFunctions.php";
include "FileIOfunctions.php";

$function2call = validate_Function2Call();
$queryFunction= validate_QueryFunction();
$params = validate_Params();

// Afvangen van de call voor welke functie aangeroepen wordt.
if ($function2call != null) {    
    switch ($function2call) {
        // Bestanden hoofdpagina.
        case 'ExecQuery':
            echo ExecQuery($queryFunction(), $params, false);
            break;
        case 'GetData':
            echo GetData($queryFunction, $params, true);
            break;
        case 'GetNewestRecord':
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
            // Richt de (eventueel) geparameteriseerde query in. Als geen parameters, dan zonder uitvoeren.					
            $sql = $function2call();
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
                        $result = array($row[0]);
                        //array_push($result, $row[0]);
                    }
                }

                //echo json_encode(array("Data" => $result));
                echo json_encode(array("Exitcode" => $Exitcode, "result" => $result));
            }
            else {
                echo json_encode(array("Exitcode" => $Exitcode));
            }

            CloseConnection();
            break;
        case 'AddRecord':
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
            $folder = 'uploads';
            $files = scandir($folder, true);
            $file = $folder . '/' . $files[0];
            $imagedata = file_get_contents($file);
            $base64 = base64_encode($imagedata);
            echo $base64;

            break;
        case 'GetSinglePicture':
            $folder = './uploads';
            $file = $folder . '/' . $queryFunction;
            if ($params==null) {
                $test = GetPicture($file, 100, true); 
            } else {
                $test = GetPicture($file, 100, $params); 
            }
            
            echo $test;
            break;
        case 'GetThePictureNames':
            $data = listAllFiles("uploads");            
            $Exitcode = 100;
            $myJson = json_encode(array("Exitcode" => $Exitcode, "data" => $data), true);
            echo $myJson;
            break;
        case 'GetThePictures':
            $folder = 'uploads';
            $files = scandir($folder, true);
            $file = $folder . '/' . $files[0];
            $imagedata = file_get_contents($file);
            $base64 = base64_encode($imagedata);
            echo $base64;

            break;
        case 'CheckPassword':
            if ($params!=null) {
                if ($params[0]['value'] == DevellopSitePassword()) {
                    $result = true;
                }
                else {
                    $result = false;
                }

                $Exitcode = 100;
            }
            else {
                $Exitcode = 404;
            }

            if ($Exitcode == 100) {
                echo json_encode(array("Exitcode" => $Exitcode, "data" => $result));
            }
            else {
                echo json_encode(array("Exitcode" => $Exitcode));
            }

            break;        
        default:
            header("HTTP/1.1 404");
            break;
    }
}
else {
    echo "Well, it seems like this didn't really work...";
}

function validate_Function2Call()
{
    if (isset($_POST['function2call']) && !empty($_POST['function2call'])) {
        if (strlen($_POST['function2call']) > 50) {
            trigger_error('Function call is te lang.', E_USER_ERROR);
            die;
        }

        return $_POST['function2call'];
    }
    else {
        return null;
    }
}

function validate_QueryFunction()
{
    if (isset($_POST['queryFunction']) && !empty($_POST['queryFunction'])) {
        if (strlen($_POST['queryFunction']) > 50) {
            trigger_error('Function call is te lang.', E_USER_ERROR);
            die;
        }

        return $_POST['queryFunction'];
    }
    else {
        return null;
    }
}

function validate_Params()
{
    if (isset($_POST['params']) && !empty($_POST['params'])) {
        return $_POST['params'];
    }
    else {
        return null;
    }
}

function listAllFiles($dir)
{
    $array = array_diff(scandir($dir), array('.', '..'));

    foreach ($array as $item) {
        $item = $dir . $item;
    }

    unset($item);

    foreach ($array as $item) {
        if (is_dir($item)) {
            $array = array_merge($array, listAllFiles($item . DIRECTORY_SEPARATOR));
        }
    }

    return $array;
}

function ExecQuery($sql, $params, $jsonEncodedResult)
{
    global $conn;
    $data = array();

    $stmt = $conn->prepare($sql);

    if (isset($_POST["params"])) {
        $params = $_POST["params"];

        foreach ($params as $value) {
            if ($value["dataType"] == "string") {
                $value["dataType"] = "s";
            }
            else if ($value["dataType"] == "integer") {
                $value["dataType"] = "i";
            }
            else if ($value["dataType"] == "double") {
                $value["dataType"] = "d";
            }
            else if ($value["dataType"] == "blob") {
                $value["dataType"] = "b";
            }

            $stmt->bind_param($value["dataType"], $value["value"]);
        }
    }

    $stmt->execute();

    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);    

    if ($data !== false) {
        $Exitcode = 100;
        if ($jsonEncodedResult == true) {
            $resultJson = json_encode(array("Exitcode" => $Exitcode, "data" => $data));
        }
        else {
            $resultJson = array("Exitcode" => $Exitcode, "data" => $data);
        }
    }
    else {
        $Exitcode = mysqli_error($conn);
        if ($jsonEncodedResult == true) {
            $resultJson = json_encode(array("Exitcode" => $Exitcode));
        }
        else {
            $resultJson = array("Exitcode" => $Exitcode);
        }
    }

    unset($data);
    mysqli_free_result($result);
    CloseConnection();

    return json_encode($resultJson);
}

function GetData($function, $params, $jsonEncodedResult)
{
    try {
        if ($params<>"") {            
            $data = $function($params);
        }
        else {
            $data = $function();
        }
        $Exitcode = 100;
    }
    catch (\Throwable $th) {
        $Exitcode = 404;
    }

    if ($Exitcode == 100) {
        if ($jsonEncodedResult == true) {
            return json_encode(array("Exitcode" => $Exitcode, "data" => $data));
        }
        else {
            return array("Exitcode" => $Exitcode, "data" => $data);
        }
    }
    else {
        if ($jsonEncodedResult == true) {
            return json_encode(array("Exitcode" => $Exitcode));
        }
        else {
            return array("Exitcode" => $Exitcode);
        }
    }
}


?>

