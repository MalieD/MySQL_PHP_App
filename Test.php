<?php

// include "connection.php";
// include "QueryFunctions.php";

// $sql = GetAllIDs();

// $data = mysqli_query($conn, $sql);

// if ($data === false) {
//     $Exitcode = mysqli_error($conn);
// }
// else {
//     $Exitcode = 100;
// }

// if ($Exitcode == 100) {
//     if ($data) {
//         $result = array();

//         while ($row = mysqli_fetch_row($data)) {
//             array_push($result, $row[0]);
//         }
//     }

//     echo json_encode($result);
// }
// else {
//     echo json_encode(array("Exitcode" => $Exitcode));
// }

// CloseConnection();


// $imagedata = file_get_contents('./Plaatjes/abc.jpeg');
// $base64 = base64_encode($imagedata);
// echo $base64;

phpinfo();

?>