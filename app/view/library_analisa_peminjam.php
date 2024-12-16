<?php
require "../model/library_functions.php";
date_default_timezone_set("Asia/Kuala_Lumpur");
$date_month = date(m);
$date_year = date(Y);
$date_day = date(d);
$current_date = $date_year."-".$date_month."-".$date_day;
   
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php require "../global/header.php"; ?>    
<script src="../../js/jquery/moment.js"></script>
<style type="text/css">
	td.a{
		padding-bottom: 15px;	}
	#menu {
		background: hsla(1,0%,100%,.9);
		position: absolute;
		top: 50;
		right: 0;
		left: 0;
		min-height: 100%;
		padding-top: 10px;
	}
	td.red{
		color: red;
	}
	td.green{
		color: green;
	}
	td.blue{
		color: blue;
	}
	td.orange{
		color: orange;
	}
</style>

<script language="javascript" type="text/javascript">
// setInterval(function () {
    
//   location.reload();
     
    
// }, 30000);
setInterval(function () {
     var date = new Date();
    $('#timeRunningDate').html(moment().format('ddd MMM D YYYY, HH:mm:ss '));
       
    showTime();
}, 1000);

function showTime(){
    var date = new Date();
    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
    var s = date.getSeconds(); // 0 - 59
    var session = "AM";
    
    if(h == 0){
        h = 12;
    }
    
    if(h > 12){
        h = h - 12;
        session = "PM";
    }
    
    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;
    
    var time = h + ":" + m + ":" + s + " " + session;
    document.getElementById("MyClockDisplay").innerHTML = time;
    document.getElementById("MyClockDisplay").textContent = time;
    //$('#timeRunningDate').html(time);
    
    

    //setTimeout(showTime, 1000);
    
}


</script>

</head>
<body id="refresh">

    

    <div class="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <table align="left" border="0" width="100%">
                    <tr bgcolor="yellow">
                        <td width="10%" align="right">
                        </td>
                        <td  align="center" width="70%" rowspan="2">
                            &nbsp;&nbsp;<strong><font size="5">ANALISA REKOD PEMINJAM</font></strong>
                        </td>
                        <td width="60%">
                            <h1 align="right">
                                <font color="black">
                                    <div id="MyClockDisplay" class="clock"><? echo date('h:i:s A')?></div>
                                </font>
                            </h1>
                            <h4 align="right">
                                <font color="black">
                                    <span id="timeRunningDate"><? echo date('D M d Y, H:i:s ')?></span>
                                </font>
                            </h4>
                        </td>
                        <td width="30%">&emsp;&emsp;</td>
                    </tr>
                </table>
            </div>
        </nav>
        <br>
	 	<div class="col-lg-12">	   
	 		<div class="col-lg-12">
	        	<div class="panel panel-red">
				<!-- /.panel-heading -->
				<div class="panel-heading">
					<center><b>Analisa Rekod Peminjam</b></center>
				</div>
					<table width="100%" class="table table-striped table-bordered table-hover">
						<thead>
							<tr >
							
								<th bgcolor="yellow" width="7%"><center>Bil.</center></th>
								<th bgcolor="yellow" width="40%">Nama Peminjam</th>
                                <th bgcolor="yellow" width="15%"><center>No. Kad Pengenalan</center></th>
                                <th bgcolor="yellow" width="15%"><center>No. Telefon</center></th>
								<th bgcolor="yellow" width="12%"><center>Jumlah Pinjaman</center></th>
								
							</tr>
						</thead>
						<tbody>
							
							   <?
                        $data_peminjam = getAnalisaPeminjam();
                        $i=1;
                        while($list_peminjam = $data_peminjam->fetch_assoc()) {
                            ?>
                            <tr href="#myModal2" data-toggle="modal" data-id="<? echo $list_peminjam['nokp'];?>">
                                    <td><center><b><?echo $i++;?></b></center></td>
                                   	<td><?echo $list_peminjam['nama'] ;?></td>
                                   	<td><?echo $list_peminjam['nokp'];?></td>
                                   	<td><center><b><font size="4" color="brown">+6<?echo $list_peminjam['notel'];?></font></b></center></td>
                                    <td><b><center><font size="5" color="green"><?echo $list_peminjam['bil_pinjaman'];?></font></center></b></td>
                            </tr>
                                <?}?>
						</tbody>
					</table>
				
				<!-- /.panel-body -->
			</div>
		</div>
	        </div>     
		</div><!--col-lg-12 -->

        <div class="footer-section">
            <div class="copy-section">
                <!--<div class="container">-->
                    <center>
                        <p>Hakcipta Terpelihara &copy;<strong><? echo $sys['sys_name']; ?></strong>&nbsp;<? echo $date_year;?>.<br>
                        Hasil Ciptaan, Konsep dan Rekabentuk oleh <a href="http://www.indeepreneur.com" target="blank">Indeepreneur.com</a></p>
                    </center>
                <!--</div>-->
            </div>
        </div>
    </div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel2">Senarai Rekod Pinjaman</h4>
        </div>
        <div class="modal-body" id="demo1">
        <script type="text/javascript">
          $('#myModal2').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            // $('#demo').html(rowid);
            $.ajax({
              type:'POST',
              url:'library_analisa_transaksi_pinjaman.php',
              data:{nokp:rowid},
              success:function(html){
                $('#demo1').html(html);
              }
            });
          });
        </script>
        </div>                                                                       
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

<script>
 </script>
</body>
</html>