<?php

        include ('../controller/auth.php');

    require "../model/staff_function.php";
    

    
  

?>



 <?
  $salary_id = $_GET['salary_id'];
  $no_staff = $_GET['no_staff'];
    $bulan= $_GET['bulan'];
    $tahun= $_GET['tahun'];
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
    
    <? require "../../resources/css/niaga.css";?>
    <?
    date_default_timezone_set("Asia/Kuala_lumpur");
    $date = new DateTime();
?>
<style>

 body{
            margin-left: 1.5cm;
            margin-right: 1.5cm;
            font-size: 11px;
            
        }

        @media print {
        #printPageButton {
        display: none;
        size: landscape;
        
            }
            #kembaliPageButton {
        display: none;
        
            }
        }
         td.A{
            
            text-align: right;
            
        }
        
        h1.A{
            
            text-align:  left;
            
        }
        
          p.A{
            
            text-align:  left;
            
        }
        td{
            padding-left: 5px;
            padding-right: 5px;
        }

</style>

  <script>
function goBack()
{
window.history.back()
}
</script>
    
<body>
    
<input class="btn btn-success" align="left" type="button" id="kembaliPageButton" value="Kembali" onclick="goBack()">    
    <button class="btn btn-info" id="printPageButton" onClick="window.print();">Cetak</button>

</head>

<body>
   <table width="100%" id="dataTables-example">
             <?         

            $list_staff =getStaffInfo($no_staff) -> fetch_assoc();
             $list_salary =getSalaryInfo($salary_id) -> fetch_assoc(); 
            $baki_bayar=getBelumBayar($no_staff,$bulan,$tahun)-> fetch_assoc();
             $baki_bayar1=$baki_bayar['baki_bayar'];
                $com = getCompany()->fetch_assoc();
                
                        
    ?>
    <tr>
    <td width="150px" valign="bottom">
    <? 
                    echo '<img src="data:image/png;base64,'.base64_encode( $com['logo'] ).'"/>';
                     ?>
    
    </td>
    <td>
    
    <strong><h3 align="left"><? echo $com['name'];?></h3>
    <h4 align="left"><? echo $com['registration_no'];?></h4></strong>
    <h5 align="left"><? echo $com['address'];?></h5>
    <h6 align="left">No. Telefon: <? echo $com['tel'];?> | Emel: <? echo $com['email'];?> | Website : <? echo $com['website'];?></h6>
   </td>
   <td valign="top">
    
    <strong><h3 align="right">SLIP GAJI</h3>
    <h5 align="right">No.Slip: <? echo $list_salary['no_slip'] ;?></h5></strong>
    <h5 align="right">Tarikh Bayaran: <? echo date("d",strtotime($list_salary['tarikh_bayar']));?> <? echo getMonthString(date("n",strtotime($list_salary['tarikh_bayar'])));?> <? echo date("Y",strtotime($list_salary['tarikh_bayar']));?></h5>
     <h5 style="text-align:right;">Bulan: <? echo getMonthString(date("n",strtotime($list_salary['tarikh_bayar'])));?>, <? echo date("Y",strtotime($list_salary['tarikh_bayar']));?> Gaji Pokok: RM <? echo $list_salary['gaji_pokok'] ?></h5>
    
    
   </td>
   </tr>
   </table>
   <br>
 
   <table width="100%" id="dataTables-example" border="1px solid black" >
        
        <input name="no_staff" type="hidden" class="input-short" value="<?echo $no_staff;?>" />
        <!--input name="no_staff_login" type="hidden" class="input-short" value="<//s?echo $no_staff;?>" /-->
        
             
      
            

    
    <tr>
        <td valign="top">
        Nama:<br>
         No. Pekerja : <br>
            No. Kad Pengenalan : <br><br><br><br>
            
        </td>
    <td colspan="2" valign="top">
        <?echo $list_staff['name']?> <br>
        <?echo $list_staff['no_staff']?> <br>
        <?echo $list_staff['noic']?><br>
        <br>
        <br>
    </td>
        
    <td colspan="2" valign="top">
      
       Bahagian: <br>
       No. EPF :<br>
            No. SOCSO: <br><br><br><br>
    
    </td> 
        
     <td colspan="2" valign="top">

     <?echo $list_staff['department']?><br>
     <?echo $list_staff['no_epf']?><br>
     <?echo $list_staff['no_socso']?>


     <br><br><br><br>
         
    </td>
    </tr>
            
<tr>
        
    
    <td bgcolor="#dddddd" colspan="3" valign="top"> <center> Pendapatan (RM)</center></td>
    
    
    <td bgcolor="#dddddd" colspan="3" valign="top"><center>Penolakan (RM)</center></td>
       
        
</tr>
      
             
    
<tr>
    <td valign="top"> 
        Gaji Pokok (RM): <br>
        Jumlah Elaun (RM): <br>
        Jumlah Tuntutan (RM): <br>
        

    </td>
    
   
    
    <td class="A" colspan="2" valign="top">
        <?echo $list_salary['gaji_pokok']?><br>
        <?echo $list_salary['elaun']?><br>
        <?echo $list_salary['claim']?><br>

        <br>
        
   
    </td>
    
    <td colspan="2" valign="top">
        EPF (RM): <br>
        SOCSO (RM):<br>
        Gaji Terdahulu Belum Bayar (RM):<br>
        Penolakan Gaji Tambahan (RM): 
    </td>
    
    <td class="A" valign="top">
        <span id="kwsp"><?echo $list_salary['kwsp']?></span><br>
        <span id="socso"><?echo $list_salary['socso']?></span><br>
        <span id="baki_bayar"> <?echo $list_salary['belum_bayar']?></span><br>
        <span id="socso"><?echo $list_salary['tolak_gaji']?></span><br>
         <br>
    </td>
</tr>
        
    
<tr>
        
    <td bgcolor="#dddddd" valign="top">Jumlah Pendapatan (RM):</td>
    
    <td bgcolor="#dddddd" class="A" colspan="2" valign="top"><b><span></span></b><?echo $list_salary['gaji_kasar']?></td>
   
    <td bgcolor="#dddddd" colspan="2" valign="top">Jumlah Potongan (RM):</td>
   
    
    <td bgcolor="#dddddd" class="A" colspan="2" valign="top"><b><span></span><?echo $list_salary['jumlah_potongan']?></td>
         
</tr>

        
       
        
<tr>
    <td valign="top">Pendapatan Bersih (RM):<br>
        <br></td>
        
    <td class="A" colspan="2" valign="top"><b><span></span></b><?echo $list_salary['gaji_bersih']?><br><br></td>
    
     
    
    
    <td colspan="2" valign="top">
        SOCSO Majikan (RM):<br>
        KWSP Majikan (RM):<br><br></td>
    
    <td class="A" valign="top" ><b><span></span></b>
    <?echo $list_salary['socso_majikan']?><br>
   <?echo $list_salary['kwsp_majikan']?><br><br></td>
        
</tr>
<?  $namalist=getNamaPemohon($salary_id)->fetch_assoc() ?>


<tr>

    <td height="100" bgcolor="#dddddd">Disediakan Oleh : </td>
    <td bgcolor="#dddddd"colspan="2"  ><? echo $namalist['name'] ?> <span><? echo '<image class="cop" width="80px"
    height="80px" src="data:image/png;base64,'.base64_encode( $com['company_stamp'] ).'"/>'; ?> </td>
    
    <td bgcolor="#dddddd" colspan="2">Diterima Oleh:: </td>
    <td bgcolor="#dddddd"><?echo $list_staff['name']?></td>
        
        
</tr>

    
     <? 
                $list_cuti =getCutiTahunan($no_staff) -> fetch_assoc(); 
              ?>
    
<tr>
        <td colspan="6" height="30"  >Cuti Tahunan Diberi:<?echo $list_cuti['total_cuti']?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Cuti Diambil: <? if(isset($list_cuti['total'])) 
                                echo $list_cuti['total']; 
                                else 
                                     echo 0 ?>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Baki Cuti:  <? if(isset($list_cuti['baki_cuti'])) 
                                echo $list_cuti['baki_cuti']; 
                                else 
                                     echo 0 ?></td>
     
        </tr>
      
    </table>
 <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>
    
</body>

</html>