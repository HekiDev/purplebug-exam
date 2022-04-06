<?php

if (! function_exists('get_datetime')) {
    function get_datetime()
    {
        date_default_timezone_set('Asia/Manila');
        $current_dateTime = date("Y-m-d H:i:s");
        return $current_dateTime;
    }
}