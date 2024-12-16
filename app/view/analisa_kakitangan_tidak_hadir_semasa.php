<?php

	include ('../controller/auth.php');

	require "../model/analisa_kehadiran_functions.php";
	require "../model/lookup.php";
	$cawangan=$_GET['cawangan_kod'];
	$jabatan=$_GET['jabatan'];
	
	if(!isset($cawangan)){
				$cawangan = $_SESSION['SESS_CAWANGAN'];

			}
	if(!isset($jabatan)){
				$jabatan = $_SESSION['SESS_DEPARTMENT'];

           }
	if($_SESSION['SESS_ROLE']=="ADMIN" || $_SESSION['SESS_ROLE']=="SUPERADMIN"){

		$disable="";
    }else{

    		$disable="disabled";
	}


function getMonthString($num)
    {

          
      switch($num)
      {
        case 1:
          $month="Januari";
          break;
        case 2:
          $month="Februari";
          break;
        case 3:
          $month="Mac";
          break;
        case 4:
          $month="AprilL";
          break;
        case 5:
          $month="Mei";
          break;
        case 6:
          $month="Jun";
          break;
        case 7:
          $month="Julai";
          break;
        case 8:
          $month="Ogos";
          break;
        case 9:
          $month="September";
          break;
        case 10:
          $month="Oktober";
          break;
        case 11:
          $month="November";
          break;
        case 12:
          $month="Disember";
          break;
        default:
          $month="Invalid month";
      }
      return $month;
    }
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
   


<script language="JavaScript" type="text/javascript">
function Confirm(){
    return confirm('Adakah Anda Pasti untuk tekan butang berhenti ini?');
}

function Confirm2(){
    return confirm('Adakah Anda Pasti untuk tekan butang bekerja ini??');
}


</script>
<script language="javascript" type="text/javascript">
<!--
function popitup(url) {
	/*newwindow=window.open(url,'name','height=842,width=595');*/
	newwindow=window.open(url,'name','height=595,width=842');
	if (window.focus) {newwindow.focus()}
	return false;
}

// -->
</script>
<style type="text/css">
  th{
    text-align: center;
    background-color: #D6DBDF;
  }

</style>
</head>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

            <!-- /.navbar-header -->
			<? include ('../global/menu_top.php'); ?>

            <!-- /.navbar-top-links -->

			<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <!--li>
							<center><img src="images/pic.jpg" class="user-image img-responsive"/></center>
						</li-->

						<? include ('../global/menu_left.php'); ?>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        
        <div id="page-wrapper">
	
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Analisa Kakitangan Tidak Hadir Semasa</h1>
				</br>
			</div>
			
		</div>
     <div class="col-lg-4">
                              
                        </div>
                       <div class="col-lg-4">
                              <select  required class="form-control" name="cawangan_kod" id="cawangan_kod" <? echo $disable;?>>
                                  <option value="">-- Pilih Cawangan--</option>
                                  <? echo getDropDown("lkp_cawangan","cawangan_kod","nama",$cawangan);?>
                                  </select> 
                        </div>
                         <div class="col-lg-4">
                              <select  required class="form-control" name="jabatan" id="jabatan" <? echo $disable;?>>
                                  <option value="">-- Pilih Jabatan--</option>
                                  <? echo getDropDownJabatan($jabatan);?>
                                  </select> 
                        </div>
                        
		
                <div class="row">
                <div class="col-lg-12">
                      
						
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          <div class="panel panel-red">
                          <!-- /.panel-heading -->
                          <div class="panel-heading">
                            <center><b>Analisa Kakitangan Tidak Hadir</b></center>
                          </div>
                          <table width="100%" class="table  table-bordered">

                            <thead>
                              <th width="25%">Bil. Kakitangan</th>
                              <th width="25%">Bil. Tidak Hadir</th>
                              <th width="25%">Bil. Bercuti</th>
                              <th width="25%">Peratus Ketidakhadiran</th>
                            </thead>
                            <?
                              $bil_staf = getBilStaf($cawangan,$jabatan);
                              $bil_tidak_hadir = getBilStafTidakHadir($cawangan,$jabatan);
                              $bil_bercuti=getCountCuti($cawangan,$jabatan);
                              if($bil_staf!=0){
                                $peratus=$bil_tidak_hadir/$bil_staf*100;

                              }else{
                                $peratus='0.00';

                              }

                            ?>
                           
                            <tbody>
                              <td align="center"><strong><font size="6" color="black"><? echo $bil_staf;?></font></strong></td>
                              <td align="center"><strong><font size="6" color="red"><? echo $bil_tidak_hadir;?></font></strong></td>
                              <td align="center"><strong><font size="6" color="orange"><? echo $bil_bercuti;?></font></strong></td>
                              <td align="center"><strong><font size="6" color="black"><? echo round($peratus,2);?>%</font></strong></td>
                             
                            </tbody>
                          </table>
                        </div>


                           
                            
                        </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Senarai Kakitangan Tidak Hadir
                        </div>
                    
            
            
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                              <input name="no_staff" type="hidden" class="input-short" value="<? echo $no_staff;?>" />
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Nama</th>
                                  <th>Jawatan</th>
                                  <th>Status</th>
                                  <th>No Telefon</th>
                                  <th>Tindakan</th>
                                </tr>
                              </thead>
                              <tbody>
                            
                              <?
                                $i= 1;
                                $data_staff = getSenaraiStafTidakHadir($cawangan,$jabatan);
                                while($row_data_staff = $data_staff->fetch_assoc()) {
                                  $data_cuti = getCutiStaff($row_data_staff['no_staff'])->fetch_object(); 
                                  $flag_color = "";
                                  if($data_cuti->tarikh_mula != ''){
                                    $status = "BERCUTI";
                                    $flag_color = 'style="background: yellow;"';
                                    $font_color = 'style="color: orange;"';
                                  }else{
                                    $status="BELUM LOG";
                                     $font_color = 'style="color: red;"';
                                  }
                                  
                                
                              ?>
                                <tr class="odd gradeX" <? echo $flag_color;?>>
                                  <td><?php echo $i; ?></td>
                                  <td><?php echo $row_data_staff['name']; ?></td>
                                  <td><?php echo $row_data_staff['role']; ?></td>
                                  <td><strong><font <?echo $font_color;?> size="4"><?php echo $status; ?></font></strong></td>
                                  <td>
                                      <?php echo $row_data_staff['phone']; ?>
                                  </td>
                                  <td>
                                      <button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $row_data_staff['phone']; ?>')" >WhatsApp</button><br>
                                  </td>
                                                     
                                </tr>
                              <?php $i++; } ?>
                              
                            
                              </tbody>

                            </table>

                        </div>

                        <!-- /.panel-body -->
                    </div>
                        <!-- /.panel-body -->
                   
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
                <!-- /.row -->
            <!-- /.container-fluid -->
        </div>
        <div class="footer-section">
            <div class="copy-section">
                <!--<div class="container">-->
                    <center>
                        <p>Hakcipta Terpelihara &copy;<strong><? echo $sys['sys_name']; ?></strong>&nbsp;<? echo $date_year;?>.<br>
                        Hasil Ciptaan, Konsep dan Rekabentuk oleh <a href="http://www.indeepreneur.com" target="blank">Indeepreneur.com</a>
                    </center>
                <!--</div>-->
            </div>
        </div>

<script>
  $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
        $("#cawangan_kod").change(function(){

       var selected_cawangan=$(this).val();
       sendType(selected_cawangan);
       });
        $("#jabatan").change(function(){
          if($("#cawangan_kod").val()==''){
            alert('SILA PILIH CAWANGAN DAHULU!');
            $("#jabatan").val('');
          }else{
            var selected_jabatan=$(this).val();
            var cawangan = $("#cawangan_kod").val();
            sendType2(selected_jabatan,cawangan);

          }
     });

    });
   function sendType(type)
   {
    window.location.href="analisa_kakitangan_tidak_hadir_semasa.php?cawangan_kod="+type;
    
  }
  function sendType2(jabatan,cawangan)
   {
    window.location.href="analisa_kakitangan_tidak_hadir_semasa.php?cawangan_kod="+cawangan+"&jabatan="+jabatan;
    
  }
</script>
</body>
</html>

