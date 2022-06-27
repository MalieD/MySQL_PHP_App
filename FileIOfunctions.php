<?php
function GetAllTextFiles()
{
    $files = array();

    foreach (glob("*") as $file) {
        if ($file == '.' || $file == '..')
            continue;
        array_push($files, $file);
    }

    return $files;
}

function GetTextFile($params)
{
    $filename = $params[0]['value'];
    
    try {
        $file = file_get_contents($filename, true);
    } catch (\Throwable $th) {
        //throw $th;
    }

    return $file;
}


?>