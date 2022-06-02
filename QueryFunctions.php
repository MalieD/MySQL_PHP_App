<?php

    function ExecQuery(){
        return 'SELECT waarden FROM mijntesttabel WHERE ROWID=?';
    }

    function GetNewestRecord(){
        return 'SELECT Waarden FROM `mijntesttabel` ORDER BY ROWID DESC LIMIT 1';
    }
    
    function GetAllIDs(){
        return 'SELECT ROWID FROM `mijntesttabel` ORDER BY ROWID';
    }
    
    function AddRecord(){
        return 'INSERT INTO mijntesttabel (waarden) values (?)';
    }  
    
    function AddPhoto(){
        return 'INSERT INTO mijntesttabel (PhotoPath) values (?)';
    }  

    function LoadPhotoPath(){
        return 'SELECT PhotoPath FROM `mijntesttabel` WHERE ROWID=?';
    }  

    function UpdateRecord(){
        return 'UPDATE mijntesttabel 
                SET waarden=? 
                WHERE ROWID=?';
    }    

?>