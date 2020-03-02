<?php
function connect()
{
    $db_user = "root";
    $db_psw = "root";
    $mysqli = new mysqli("127.0.0.1", $db_user, $db_psw, "Portal", 8889);
    if ($mysqli->connect_error) {
        die('Errore di connessione(' . $mysqli->connection_errno . ')' . $mysqli->connection_error);
    } else {
        //echo 'Connesso. ' . $mysqli->host_info . "\n";
    }
    return $mysqli;
}


function insertRecords($table, $row2add)
{
    $mysqli = connect();
    $string = "INSERT INTO `$table` (";
    foreach ($row2add as $key => $value) {
        if (array_key_last($row2add) == $key)
            $string = $string . " `" . $key . "`";
        else
            $string = $string . " `" . $key . "` ,";
    }
    $string = $string . ") VALUES (";
    foreach ($row2add as $key => $value) {
        if (array_key_last($row2add) == $key)
            $string = $string . " '" . $value . "'";
        else if (is_null($value))
            $string = $string . "NULL,";
        else
            $string = $string . " '" . $value . "' ,";
    }
    $string = $string . ")";
    if (!$res = $mysqli->query($string))
        return "Error";
    else return $res;
};
function selectAll($nameTable, $arrayFilter)
{
    $mysqli = connect();
    if ($arrayFilter->is_null)
        return "SELECT * FROM $nameTable";
    else {
        $string = "SELECT * FROM $nameTable WHERE ";
        foreach ($arrayFilter as $key => $value) {
            if (array_key_last($arrayFilter) == $key)
                $string = $string . $key . "= '" . $value . "'";
            else
                $string = $string . $key . "= '" . $value . "' AND ";
        }
    }
    return $mysqli->query($string);
};
