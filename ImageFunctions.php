<?php

function GetPicture($imageFile, $maxPx, $asThumbnail)
{
    if ($asThumbnail == false || $asThumbnail == "false") {
        $imageString = file_get_contents($imageFile);
    }
    else {
        list($width, $height) = getimagesize($imageFile);

        if ($width > $height) {
            $verhouding = $height / $width;
            $newWidth = $maxPx;
            $newHeight = $newWidth * $verhouding;
        } else {
            $verhouding = $width / $height;
            $newHeight = $maxPx;
            $newWidth = $newHeight * $verhouding;
        }

        $thumb = imagecreatetruecolor($newWidth, $newHeight);

        if (preg_match('/[.](jpg|jpeg)$/i', $imageFile)) {
            $image_source = imagecreatefromjpeg($imageFile);
        }
        else if (preg_match('/[.](gif)$/i', $imageFile)) {
            $image_source = imagecreatefromgif($imageFile);
        }
        else if (preg_match('/[.](png)$/i', $imageFile)) {
            $image_source = imagecreatefrompng($imageFile);
        }
        else {
            $image_source = imagecreatefromjpeg($imageFile);
        }

        imagecopyresized($thumb, $image_source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        ob_start();
        if (preg_match('/[.](jpg|jpeg)$/i', $imageFile)) {
            imagejpeg($thumb);
        }
        else if (preg_match('/[.](gif)$/i', $imageFile)) {
            imagegif($thumb);
        }
        else if (preg_match('/[.](png)$/i', $imageFile)) {
            imagepng($thumb);
        }
        else {
            imagejpeg($thumb);
        }
        $imageString = ob_get_contents();
        ob_end_clean();
    }

    return base64_encode($imageString);
}
?>