<?php

if (!function_exists('current_page_url')) {

    /**
     * use last_q function to print last query fired on the database.    
     */
    function current_page_url()
    {
        $request = \Config\Services::request();

        $uri = $request->getUri();
        $current_url['path'] = $uri->getPath();
        $current_url['segment'] = $uri->getSegments();
        return $current_url;
    }
}