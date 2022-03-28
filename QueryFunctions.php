<?php

    function ExecQuery(){
        return 'SELECT waarden FROM mijntesttabel WHERE ROWID=?';
    }

    function AddRecord(){
        return 'INSERT INTO mijntesttabel (waarden) values (?)';
    }    

?>