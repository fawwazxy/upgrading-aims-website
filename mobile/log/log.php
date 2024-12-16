<?php

function LogAccessHistory($cmd, $executor, $filename,$all_parameters)
{

//Arrange the data //check the date
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $dump = $cmd.PHP_EOL.$executor.PHP_EOL.$filename.PHP_EOL.$all_parameters.PHP_EOL.date("D M d 'y h.i A").PHP_EOL.'------------------------------------------------------------------';
    $filepath = str_replace(' ', '_',date('Y').'/'.date('M'));

    if (is_dir($filepath)) {//if dir = filepath
        //empty
    }

    else{//create new dir
        mkdir($filepath,0777,true);
    }
    file_put_contents($filepath.'/'.date('Y M d').'.txt', $dump.PHP_EOL , FILE_APPEND | LOCK_EX);//write to file*/
}

//LogAccessHistory("cuti.php", "1", "f43taefwer4r3rfesfwe", "param a = 1, param b = 1, param c = 1");