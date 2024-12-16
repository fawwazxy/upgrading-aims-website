<?php

	//include ('../controller/auth.php');
	require "../model/pemohon_functions.php";

?>



<?php
    $id = $_GET['no_staff'];
    $no_staff = $_GET['no_staff'];
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <? require "../global/header.php"; ?>
    <? require "../../resources/css/surat.css";?>
<script language="javascript" type="text/javascript">


</script>
<style type="text/css"> 
body {
    background-image: url("../../resources/images/certificate.jpg");
    background-size: 100% auto;
    background-repeat: no-repeat;
    background-position: center top;
    background-color: #cccccc;
}

</style>

</head>

<body>

<? 
		$list = getStaffInfo($no_staff);
		$com = getCompany()->fetch_assoc();
		$info= getStaffRecord($id);
	 
?>







<table width="1800px" align="center">
    <tr>
        <td width="20%"><? echo '<img src="data:image/png;base64,'.base64_encode( $com['logo'] ).'"/>';?></td>
        <td width="60%">
            <? echo $com['name'];?><br><? echo $com['registration_no'];?><br>
            <? echo $com['address'];?><br>
            <? echo $com['tel'];?>
            <? echo $com['email'];?>
            <? echo $com['website'];?>
        
        </td>
        <td width="20%"></td>
    </tr>
    <tr>
        <td width="20%"></td>
        <td width="60%">Sijil Penghargaan</td>
        <td width="20%"></td>
    </tr>
    <tr>
        <td width="20%"></td>
        <td width="60%">
            	Dengan sukacita kami merakamkan setinggi-tinggi penghargaan dan terima kasih kepada<br>
            	<b><u><?  echo $list['name'] ;?></u><br><?  echo $list['noic'] ;?>)</b><br>
            	di atas penglibatan dan komitmen beliau dalam menjalani<br>
            	<b>PROGRAM LATIHAN INDUSTRI</b><br>
            	pada<br>
            	<b><? echo date("d",strtotime($info['tarikh_mula']));?> <? echo getMonthString(date("n",strtotime($info['tarikh_mula'])));?> <? echo date("Y",strtotime($info['tarikh_mula']));?></b> hingga <b><? echo date("d",strtotime($info['tarikh_akhir']));?> <? echo getMonthString(date("n",strtotime($info['tarikh_akhir'])));?> <? echo date("Y",strtotime($info['tarikh_akhir']));?></b><br>
            	
        </td>
        <td width="20%"></td>
    </tr>
    <tr>
        <td width="20%"></td>
        <td width="60%"></td>
        <td width="20%"></td>
    </tr>
    <tr>
        <td width="20%">
            Tarikh : <? echo date("d",strtotime($info['tarikh_akhir']));?> <? echo getMonthString(date("n",strtotime($info['tarikh_akhir'])));?> <? echo date("Y",strtotime($info['tarikh_akhir']));?>
        </td>
        <td width="60%">
            <? echo '<image class="cop"  src="data:image/png;base64,'.base64_encode( $com['company_stamp'] ).'"/>'; ?> <br>
	        <? echo '<image style="left: 0px;" class="sign" src="data:image/png;base64,'.base64_encode( $com['authorized_signatory'] ).'"/>'; ?> 
	        <b><? echo $com['authorized_name'];?></b><br><? echo $com['authorized_position'];?><br> <b><? echo $com['name'];?></b>
        </td>
        <td width="20%"></td>
    </tr>
    
	
</table>	
</body>

</html>