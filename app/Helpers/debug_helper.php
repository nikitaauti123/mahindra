<?php


if (!function_exists('last_q')) {

    /**
     * use last_q function to print last query fired on the database.    
     */
    function last_q()
    {
        $db  = \Config\Database::connect();
        $query = $db->getLastQuery();
        echo (string) $query;
        die();
    }
}


