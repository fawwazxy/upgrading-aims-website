<?php

function LogKehadiran($request_body)
{
    date_default_timezone_set('Asia/Kuala_Lumpur');
    file_put_contents('log_kehadiran.txt', date("D M d 'y h.i A").' '.$request_body.PHP_EOL , FILE_APPEND | LOCK_EX);
}
