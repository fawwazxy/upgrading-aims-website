<?

    // require "../model/project_management_function.php";
    require "../model/kehadiran_functions.php";
    require"../controller/auth.php";


    date_default_timezone_set("Asia/Kuala_Lumpur");
    $sys = getSys(1)->fetch_assoc();
    $com = getCompanyDetails(1)->fetch_assoc();
    // $id = $_GET['id'];
    // $no_staff = $_GET['no_staff'];
    $bln=$_GET['mnt'];
    $thn=$_GET['thn'];
    $noic = $_GET['noic'];
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" type="image/x-icon" href="../../resources/images/favicon.ico" />
    <title><? echo $sys['sys_name']; ?> :: <? echo $sys['sys_tagline']; ?></title>

    <link href="../../js/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
   
    <style>

       
                
        table { page-break-inside:auto }
        tr { page-break-inside:avoid; page-break-after:auto }
        @media print {
        tr {
            -webkit-print-color-adjust: exact; 
        }}
            @media print {
        #printPageButton {
        display: none;
    }
    } 

    @media print {
      #html-content-holder {
        display: none;
      }
      #btn-Preview-Image {
        display: none;
      }
    } 
    table { page-break-inside:auto }
    tr { page-break-inside:avoid; page-break-after:auto }
    td.a{
        font-size: 11px;
    }

    </style>
</head>
<body>
    <button id="printPageButton" onClick="window.print();">Cetak</button>

    <? /* Start Frontpage Cover */ ?>

    <?
        $kehadiran = getStaffName($noic)->fetch_assoc();
    ?>



<table width="100%" class="top">
    <tr>
        <td rowspan="2" width="10%"><?echo '<img src="data:image/png;base64,'.base64_encode( $com['logo'] ).'"style="width: 50px; height: 50px;"/>';?></td>
        <td width="10%">&nbsp;</td>
        <td style="text-align:center" width="45%"><strong>Electronic Time Card</strong></td>
        <td style="text-align:right" width="20%"><? echo date("Y-m-d h:i:s A");?></td>
        <td width="15%">&nbsp;</td>
    </tr>
    <tr>
        <td valign="bottom" class="a" style="text-align:center"><i class="fa fa-check" aria-hidden="true"></i>=Excused</td>
        <td style="text-align:center"><? echo $kehadiran['name']; ?></td>
        <td></td>
        <td><? echo $kehadiran['cawangan'];?>/<? echo $kehadiran['jabatan'];?></td>
    </tr>

</table>
<table width="100%" style="border-collapse: collapse;">
    <tr>
        <th class="a" style="border: 1px solid black;border-right:0;border-left:0;">Date</th>
        <th class="a" style="border: 1px solid black;border-right:0;border-left:0;">Weekday</th>
        <th class="a" style="border: 1px solid black;border-right:0;border-left:0;">Day Type</th>
        <th class="a" style="border: 1px solid black;border-right:1;border-left:0;">Sche</th>
        <th class="a" style="border: 1px solid black;border-right:0;border-left:0;">In</th>
        <th class="a" style="border: 1px solid black;border-right:0;border-left:0;">Break</th>
        <th class="a" style="border: 1px solid black;border-right:0;border-left:0;">Resume</th>
        <th class="a" style="border: 1px solid black;border-right:0;border-left:0;">Out</th>
        <th class="a" style="border: 1px solid black;border-right:0;border-left:0;">OT</th>
        <th class="a" style="border: 1px solid black;border-right:1;border-left:0;">Done</th>
        <th class="a" style="border: 1px solid black;border-right:0;border-left:1;">Work</th>
        <th class="a" style="border: 1px solid black;border-right:0;border-left:0;">Overtime</th>
        <th class="a" style="border: 1px solid black;border-right:1;border-left:0;">Short</th>
        <th class="a" style="border: 1px solid black;">Leave Taken</th>
		<th class="a" style="border: 1px solid black;">Location</th>
        <th class="a" style="border: 1px solid black;border-right:0;border-left:1;">Remark</th>
        
    </tr>

    <?
            $i= 0;
            $workday=0;
            $offday=0;
            $present=0;
            $absent=0;
            //$jumwork="";
            $jumot=0;
            $jumshort=0;

            $data = getTarikhBekerja($bln,$thn,$kehadiran['no_staff']);
            while($row_data = $data->fetch_assoc()) {
                $masa= getKehadiranElektronik($row_data['tarikh'],$kehadiran['no_staff'])->fetch_assoc();
				$lokasi_masuk=$masa['remark_masuk'];
				$lokasi_keluar=$masa['remark_keluar'];
				$masa_keluar=$masa['masa_keluar'];
				$total=$masa['total'];
				$overtime="";
               $short="";
               if($masa['beza']>"00:00"){
                $overtime=$masa['beza'];
                $jumot+=seconds_from_time($overtime);
               }
               if($masa['beza']<"00:00"){
                $short=str_replace('-', '', $masa['beza']);
                $jumshort+=seconds_from_time($short);
               }
				
				if($lokasi_keluar=="TIADA IMBASAN KELUAR"){
					$masa_keluar="";
					$total="";
					$overtime="";
					$short="";
				}
				
				$leave_taken="";
                $data_cuti="";
                if(is_null($row_data['perkara'])){
                    if($row_data['status']=="1"){
                        $type="WORKDAY";
						$scheme=$row_data['description'];
                        $cuti=getElektronikCuti($kehadiran['no_staff'],$row_data['tarikh'])->fetch_assoc();
                        $leave_taken="TIDAK HADIR";
                        if($cuti['bil']>0){
                            $leave_taken="";
                            $data_cuti='<b>'.'<font color = "orange">BERCUTI</font>'.'</b><br>Mula: '.$cuti['mula'].' Tamat: '.$cuti['tamat'];
                            
                        }
                        if(checkKehadiran($row_data['tarikh'],$kehadiran['no_staff'])>0){
                            $leave_taken="";
                            $present++;
                            //echo $jumwork+=seconds_from_time($masa['total']);

                        }else{
                            $absent++;
                        }
                        $workday++;

                    }else{
                        $type="OFFDAY";
						$scheme="";
                        $offday++;
                    }
                }else{
                     $type="HOLIDAY";
					 $scheme=$row_data['description'];
                        $data_cuti='<b>'.'<font color = "orange">'.$row_data['perkara'].'</font>';
                        $holiday++;

                }
             

              
               
              
            
        ?>
    <tr>
        <td class="a" style="border: 1px solid black;border-right: 0;border-left:0;border-bottom:0;;border-top: 0;"><? echo $row_data['tarikh'];?></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"><? echo $row_data['hari'];?></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0;"><? echo $type;?></td>
        <td class="a" style="border: 1px solid black;border-right:1;border-left:0;border-bottom:0;border-top: 0;"><? echo $scheme;?><? //echo $row_data['description'];?></td>
        <td class="a" style="border: 1px solid black;border-right-style:dashed;border-left-style:dashed;border-bottom-style:dotted;border-top-style:dotted;"><? echo $masa['masa_masuk'];?></td>
        <td class="a" style="border: 1px solid black;border-right-style:dashed;border-left-style:dashed;border-bottom-style:dotted;border-top-style:dotted;"></td>
        <td class="a" style="border: 1px solid black;border-right-style:dashed;border-left-style:dashed;border-bottom-style:dotted;border-top-style:dotted;"></td>
        <td class="a" style="border: 1px solid black;border-right-style:dashed;border-left-style:dashed;border-bottom-style:dotted;border-top-style:dotted;"><? echo $masa_keluar;?></td>
        <td class="a" style="border: 1px solid black;border-right-style:dashed;border-left-style:dashed;border-bottom-style:dotted;border-top-style:dotted;"></td>
        <td class="a" style="border: 1px solid black;border-left-style:dashed;border-bottom-style:dotted;border-top-style:dotted;"></td>
        <td class="a" style="border: 1px solid black;border-right-style:dashed;border-bottom-style:dotted;border-top-style:dotted;"><? echo $total;?></td>
        <td class="a" style="border: 1px solid black;border-right-style:dashed;border-left-style:dashed;border-bottom-style:dotted;border-top-style:dotted;"><? echo $overtime;?></td>
        <td class="a" style="border: 1px solid black;border-left-style:dashed;border-bottom-style:dotted;border-top-style:dotted;"><? echo $short;?></td>
       <td class="a" style="border: 1px solid black;border-bottom-style:dotted;border-top-style:dotted;"><? echo $leave_taken?></td>
	   <td class="a" style="border: 1px solid black;border-bottom-style:dotted;border-top-style:dotted;">IN : <? echo $lokasi_masuk;?><br> OUT : <? echo $lokasi_keluar;?></td>
       <td class="a" style="border: 1px solid black;border-bottom-style:dotted;border-top-style:dotted;border-right:0;">
           <?php if($masa['status_kehadiran'] == 'AWAL') {
                echo '<b>'.'<font color = "green">'.$masa['status_kehadiran'].'</font>'.'</b>';
            }
            else if($masa['status_kehadiran'] == 'TEPAT') {
                echo '<b>'.'<font color = "purple">'.$masa['status_kehadiran'].'</font>'.'</b>'; 
            }
            else {
                echo '<b>'.'<font color = "red">'.$masa['status_kehadiran'].'</font>'.'</b>';
            } ?><br>
            <?php echo $masa['sebab_kelewatan']; ?>
            <? echo $data_cuti;
            ?>
       </td>
        
    </tr>
    <?$i++;}?>

</table>
<table  width="100%" style="border-collapse: collapse;">
    <tr>
        <td class="a" style="border: 1px solid black;border-right: 0;border-left:0;border-bottom:0;;border-top: 1;">Day Type</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 1">Total Days</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 1">Present</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 1">Absent</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 1">Work</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 1">Overtime</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 1">Short</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 1">TIDAK HADIR</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 1"><? echo $absent;?></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 1">HAJI</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 1"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 1"></td>
    </tr>
    <tr>
        <td class="a" style="border: 1px solid black;border-right: 0;border-left:0;border-bottom:0;;border-top: 0;">WORKDAY</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"><? echo $workday;?></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"><? echo $present;?></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"><? echo $absent;?></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"><?echo getJumlahMasaBekerja($noic,$bln,$thn);?></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"><?echo time_from_seconds($jumot);?></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"><?echo time_from_seconds($jumshort);?></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0">CUTI TAHUNAN</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0">UMRAH</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
    </tr>

    <tr>
        <td class="a" style="border: 1px solid black;border-right: 0;border-left:0;border-bottom:0;;border-top: 0;">HOLIDAY</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"><? echo $holiday;?></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0">SICK</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0">KURSUS</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
    </tr>
    <tr>
        <td class="a" style="border: 1px solid black;border-right: 0;border-left:0;border-bottom:0;;border-top: 0;">RESTDAY</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0">HOSPITAL</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0">BENGKEL</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
    </tr>
    <tr>
        <td class="a" style="border: 1px solid black;border-right: 0;border-left:0;border-bottom:0;;border-top: 0;">OFFDAY</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:1;border-top: 0"><? echo $offday;?></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:1;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:1;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:1;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:1;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:1;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0">MATERNITY</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0">PEPERIKSAAN</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
    </tr>
    <tr>
        <td class="a" style="border: 1px solid black;border-right: 0;border-left:0;border-bottom:0;;border-top: 0;"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 1"><? echo $i;?></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 1"><? echo $present;?></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 1"><? echo $absent;?></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 1"><?echo getJumlahMasaBekerja($noic,$bln,$thn);?></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 1"><?echo time_from_seconds($jumot);?></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 1"><?echo time_from_seconds($jumshort);?></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0">PATERNITI</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0">SUKAN</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
    </tr>
    <tr>
        <td class="a" style="border: 1px solid black;border-right: 0;border-left:0;border-bottom:0;;border-top: 0;"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:1;border-top: 0">EMERGENCY</td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:1;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:1;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:1;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:1;border-top: 0"></td>
    </tr>
    <tr>
        <td class="a" style="border: 1px solid black;border-right: 0;border-left:0;border-bottom:0;;border-top: 0;"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 0"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 1"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 1"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 1"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 1"></td>
        <td class="a" style="border: 1px solid black;border-right:0;border-left:0;border-bottom:0;border-top: 1"><? echo $absent;?></td>
    </tr>
</table>

<? /* End Frontpage Cover */ ?>
<p style="page-break-after:always;"></p>

<!---------------------------------------------------------------------------------------->

