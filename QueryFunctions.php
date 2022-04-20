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

?>