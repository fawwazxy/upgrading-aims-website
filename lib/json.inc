<?php
require_once('db/connection.php');



if (!function_exists('json_encode'))
{
    function json_encode($a=false)
    {
        if (is_null($a)) return 'null';
        if ($a === false) return 'false';
        if ($a === true) return 'true';
        if (is_scalar($a))
        {
            if (is_float($a))
            {
                // Always use "." for floats.
                return floatval(str_replace(",", ".", strval($a)));
            }

            if (is_string($a))
            {
                static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
                return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
            }
            else
                return $a;
        }
        $isList = true;
        for ($i = 0, reset($a); $i < count($a); $i++, next($a))
        {
            if (key($a) !== $i)
            {
                $isList = false;
                break;
            }
        }
        $result = array();
        if ($isList)
        {
            foreach ($a as $v) $result[] = json_encode($v);
            return '[' . join(',', $result) . ']';
        }
        else
        {
            foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
            return '{' . join(',', $result) . '}';
        }
    }
}

if (!function_exists('file_put_contents')) {
    function file_put_contents($filename, $data) {
        $f = @fopen($filename, 'w');
        if (!$f) {
            return false;
        } else {
            $bytes = fwrite($f, $data);
            fclose($f);
            return $bytes;
        }
    }
}

// class SimpleLoginSystem
class Json extends DB {

    // constructor
    function Json() {
        parent::__construct();
    }

    /*
    $output = $JsonSystem->getJSONData("select b.support_fullname name,a.chat_detail msg,
    a.created_date time from chat_public_history a,support b
    where a.created_by = b.support_id");
    $output_to_send = "{\"output\":[{$output}]}";
    */
    function getJSONData($query,$statetime='0',$vLink) {

        $isLinkNull = false;
        if($vLink==null){
            $isLinkNull = true;
            $vLink = mysqli_connect($this->host, $this->sDbUser, $this->sDbPass);
        }

        mysqli_select_db($vLink, $this->sDbName);

        $vRes = mysqli_query($vLink, $query);
        error_log($query);
        $output = Array("result"=>"false");
        $jsonOutput = json_encode($output);
        if ($vRes) {

            $arrayDate;
            $i=0;
            while ($i < mysqli_num_fields($vRes)) {
                $meta = mysqli_fetch_field($vRes, $i);
                $counter = 0;
                if ($meta) {
                    $columnname = $meta->name;
                    $type = $meta->type;
                    if($type=='datetime'){
                        $arrayDate[$counter] = $columnname;
                        $counter++;
                    }
                }
                $i++;
            }


            //$jsonOutput = json_encode($vRes);
            $jsonOutput = '';
            $counter = 0;
            while($result = mysqli_fetch_array($vRes)) {

                for($j=0;$j<count($arrayDate);$j++){
                    $newvalue = $this->showTime($result[$arrayDate[$j]],$statetime);
                    $result[$arrayDate[$j]] = $newvalue;
                }

                $koma = ',';
                if($counter==0)$koma='';
                $jsonOutput = $jsonOutput.$koma.json_encode($result);
                $counter++;
            }
        }

        if(mysqli_error()){
            error_log("SQL error: ".mysqli_error()."");
        }

        if(!$isLinkNull){
            mysqli_close($vLink);
        }

        return $jsonOutput;
    }

    function showTime($time,$state){
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $output=date("d M Y, g:i a",strtotime($time));
        switch($state){
            case '1':$output=$this->nicetime($time);
                break;

        }
        return $output;
    }



    function isset_or(&$check, $alternate = NULL)
    {
        return (isset($check)) ? (empty($check) ? $alternate : $check) : $alternate;
    }

    function getGETPOST($var)
    {
        return $this->isset_or($_GET[$var],$this->isset_or($_POST[$var],""));
    }

    function getFormData($tablename){
        $vLink = $vLink = mysqli_connect($this->host, $this->sDbUser, $this->sDbPass);
        mysqli_select_db($vLink, $this->sDbName);
        $result = mysqli_query($vLink,'select * from '.$tablename);

        $arrayquery = array('-1'=>'-1','empty'=>'empty');
        if ($result) {

            $i = 0;
            $i2 = 0;

            while ($i < mysqli_num_fields($result)) {
                $meta = mysqli_fetch_field($result, $i);
                if ($meta) {
                    // $meta->blob

                    $columnname = $meta->name;
                    $value = $this->getGETPOST($columnname);
                    if($value!=''){
                        $arrayquery[$i2]=$columnname;
                        $arrayquery[$columnname]=$value;
                        if($value=='autodate'){
                            $arrayquery[$columnname] = $this->autoDate();
                        }
                        $i2++;
                    }


                    $i++;
                }
            }

        }
        mysqli_free_result($result);

        if(mysqli_error()){
            error_log("SQL error: ".mysqli_error()."");
        }

        mysqli_close($vLink);
        return $arrayquery;

    }

    //$output = $JsonSystem->operateFormData('update','company','comp_id');
    function operateFormData($operation,$tablename,$primarykey,$supportid='',$return_type=0){

        $arrayForm = $this->getFormData($tablename);
        //error_log(json_encode($arrayForm));
        $count = count($arrayForm);
        $count = ($count-2)/2;
        $query = '';
        $query2 = '';
        $newkey = '';
        $value = '';

        for($i=0;$i<$count;$i++){
            $koma = ',';
            if($i==0) { $koma=''; }
            if($operation=='insert'){
                $query = $query.$koma.$arrayForm[$i];
                $value = $arrayForm[$arrayForm[$i]];

                if($arrayForm[$i]==$primarykey){
                    $newkey = $this->getGeneratedKey($tablename,$supportid);
                    $value=$newkey;
                }
                $query2 = $query2.$koma.'\''.$value.'\'';
            }else if($operation=='update'){
                $query = $query.$koma.$arrayForm[$i].'='.'\''.$arrayForm[$arrayForm[$i]].'\'';
            }
        }
        if($operation=='insert'){
            $query = 'insert into '.$tablename.' ('.$query.') values('.$query2.')';
        }else if($operation=='update'){
            $query = 'update '.$tablename.' set '.$query.' where '.$primarykey.'=\''.$arrayForm[$primarykey].'\'';
        }

        //error_log($query);
        $result = $this->executeOperation($query);
        $result["result"]=$newkey;

        $output_return = json_encode($result);
        if($return_type!=0)$output_return=$newkey;
        return $output_return;
        //return $query;

    }


    function getGeneratedKey($tablename,$anothervalue=''){
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $date = date('YmdHis');
        $key = $date;
        switch($tablename){
            case "company": $key = 'CO'.$key;
                break;
            case "support": $key = 'SU'.$key;
                break;
            case "client" : $key = 'CL'.$key;
                break;
            case "client_project" : $key = 'PR'.$key;
                break;
            case "chat_group" : $key = 'GR'.$key;
                break;
            case "department" : $key = 'DE'.$key;
                break;
            case "user_account" : $key = 'UA'.$key;
                break;
            case "support_ticket_activity" : $key = 'AC'.$key;
                break;
            case "chat_public_history" : $key = 'CP'.$key.$anothervalue;
                break;
            case "chat_group_history" : $key = 'CG'.$key.$anothervalue;
                break;
            case "support_location" : $key = 'LC'.$key.$anothervalue;
                break;
            case "client_ticket" : $key = 'TC'.$key.$anothervalue;
                break;
            case "notification" : $key = 'NT'.$key;
                break;

        }
        return $key;
    }

    function autoDate(){
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $date = date('YmdHis');
        return $date;
    }

    function readableDate(){
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $date = date('d/m/Y');
        return $date;
    }

    function readableDateTime(){
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $date = date('d/m/Y g:i a');
        return $date;
    }


    function executeOperation($query){
        $vLink = $vLink = mysqli_connect($this->host, $this->sDbUser, $this->sDbPass);
        mysqli_select_db($vLink, $this->sDbName);
        //error_log($query);
        mysqli_query($vLink, $query);
        $result = array("result"=>"success");
        if(mysqli_error()){
            error_log("SQL error: ".mysqli_error()."");
            $result["result"]=mysqli_error();
        }

        mysqli_close($vLink);
        return $result;

    }

    function executeOperation2($query){
        $vLink = $vLink = mysqli_connect($this->host, $this->sDbUser, $this->sDbPass);
        mysqli_select_db($vLink, $this->sDbName);
        //error_log($query);
        mysqli_query($vLink, $query);
        //$result = array("result"=>"success");
        $last_id = $vLink->insert_id;
        if(mysqli_error()){
            error_log("SQL error: ".mysqli_error()."");
            $last_id["result"]=mysqli_error();
        }

        mysqli_close($vLink);
        return $last_id;

    }


    function nicetime($date,$now=null)
    {
        if(empty($date)) {
            return "No date provided";
        }

        $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths         = array("60","60","24","7","4.35","12","10");

        if($now){
            $now = strtotime($now);
        }else {
            $now             = time();
        }
        $unix_date         = strtotime($date);

        // check validity of date
        if(empty($unix_date)) {
            return "Bad date";
        }

        // is it future date or past date
        if($now > $unix_date) {
            $difference     = $now - $unix_date;
            $tense         = "ago";

        } else {
            $difference     = $unix_date - $now;
            $tense         = "from now";
        }

        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if($difference != 1) {
            $periods[$j].= "s";
        }

        return "$difference $periods[$j] {$tense}";
    }


    function resize_png($src,$dst,$dstw,$dsth) {
        list($width, $height, $type, $attr) = getimagesize($src);
        $im = imagecreatefrompng($src);
        $tim = imagecreatetruecolor($dstw,$dsth);
        imagecopyresampled($tim,$im,0,0,0,0,$dstw,$dsth,$width,$height);
        $tim = ImageTrueColorToPalette2($tim,false,255);
        imagepng($tim,$dst);
    }
    //zmorris at zsculpt dot com function, a bit completed
    function ImageTrueColorToPalette2($image, $dither, $ncolors) {
        $width = imagesx( $image );
        $height = imagesy( $image );
        $colors_handle = ImageCreateTrueColor( $width, $height );
        ImageCopyMerge( $colors_handle, $image, 0, 0, 0, 0, $width, $height, 100 );
        ImageTrueColorToPalette( $image, $dither, $ncolors );
        ImageColorMatch( $colors_handle, $image );
        ImageDestroy($colors_handle);
        return $image;
    }


    function getData($query) {

        $vLink = $vLink = mysqli_connect($this->host, $this->sDbUser, $this->sDbPass);
        mysqli_select_db($vLink, $this->sDbName);

        $vRes = mysqli_query($vLink,$query);
        //error_log($query);

        $sMessages = null;

        if ($vRes) {
            // while(
            $aMessages = mysqli_fetch_array($vRes);//) {

            $sMessages = $aMessages;
            //}
        } else {
            $sMessages = null;
        }

        if(mysqli_error()){
            error_log("SQL error: ".mysqli_error()."");
        }

        mysqli_close($vLink);

        return $sMessages;
    }

    function getArrayData($query) {

        $vLink = $vLink = mysqli_connect($this->host, $this->sDbUser, $this->sDbPass);
        mysqli_select_db($vLink, $this->sDbName);

        $vRes = mysqli_query($vLink,$query);
        //error_log($query);

        $sMessages = array("0"=>"-1");

        //if ($vRes) {
        $count = 0;
        while($aMessages = mysqli_fetch_array($vRes)) {

            $sMessages[$count] = $aMessages;
            $count++;
            //}
        }
        //error_log($count);

        if(mysqli_error()){
            error_log("SQL error: ".mysqli_error()."");
        }

        mysqli_close($vLink);

        return $sMessages;
    }



    function getJSONData2($query,$statetime='0',$vLink) {
        $isLinkNull = false;
        if($vLink==null){
            $isLinkNull = true;
            $vLink = $vLink = mysqli_connect($this->host, $this->sDbUser, $this->sDbPass);
        }

        mysqli_select_db($vLink, $this->sDbName);
        $vRes = mysqli_query($vLink,$query);
        error_log($query);
        $output = Array("result"=>"false");
        $jsonOutput = json_encode($output);
        if ($vRes) {


            $arrayDate;
            while ($i < mysqli_num_fields($vRes)) {
                $meta = mysqli_fetch_field($vRes, $i);
                $counter = 0;
                if ($meta) {
                    $columnname = $meta->name;
                    $type = $meta->type;
                    if($type=='datetime'){
                        $arrayDate[$counter] = $columnname;
                        $counter++;
                    }
                }
                $i++;
            }


            //$jsonOutput = json_encode($vRes);
            $jsonOutput = '';
            $counter = 0;
            while($result = mysqli_fetch_array($vRes)) {

                /*for($k=0;$k<count($result);$k++){
                $item_desc = $result[$k];
                if($item_desc==null){
                $result[$k] = "null";
                }else{
                $item_desc = preg_replace("/[\\n\\r]+/", " ", $item_desc);
                $result[$k] = $item_desc;
                }
                }*/


                for($j=0;$j<count($arrayDate);$j++){
                    $newvalue = $this->showTime($result[$arrayDate[$j]],$statetime);
                    $result[$arrayDate[$j]] = $newvalue;
                }

                $koma = ',';
                if($counter==0)$koma='';
                $jsonOutput = $jsonOutput.$koma.json_encode($result);
                $counter++;
            }
        }

        if(mysqli_error()){
            error_log("SQL error: ".mysqli_error()."");
        }

        if(!$isLinkNull){
            mysqli_close($vLink);
        }

        return $jsonOutput;
    }


}

?>