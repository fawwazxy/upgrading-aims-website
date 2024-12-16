<?php

	include ('../controller/auth.php');
	require "../model/aims_cert_function.php";
	require "../model/lookup.php";
	date_default_timezone_set("Asia/Kuala_Lumpur");
?>

<html>
<head>

<style>
img {
  float: left;
}

.butt0n{
float:right;
}

table{
  border-collapse:collapse; /* ボーダーをくっつける話す場合は値をseparateにする*/
}

table th, table td{
  border: 1px solid grey;/* ボーダー */
  padding: 6px; /* セル内の余白 */
}

table tr th{
  background-color: white; /* タイトルの背景色 */
}

table tr td{
  background-color: white; /* 項目の背景色 */
  text-align: center; /* 項目の配置 */
}
</style>

</head>

<body>

<p><img src="https://www.mprc.gov.my/sites/default/files/styles/medium/public/directories-logo/aims_logo.png?itok=VRmQNKpL" alt="Pineapple" style="width:170px;height:170px;margin-left:15px;">
<br><br><b>Aims Global Engineering Sdn Bhd</b>
<br>Bestari Centre, No 20 & 21 , Blok B,<br> Jalan Hiliran, 20300 Kuala Terengganu, Terengganu <br> No Tel : 09-622 8848
</p>

<br><br><br>
<hr>
<button onclick="window.print()">Print this page</button>
<br><br>

<div class="row">
                <div class="col-lg-12">

                        <div class="panel panel-default">
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<center>
                            <table>
                                <thead>
                                    <tr>
										<th width="5%">No.</th>
                                        <th width="30%">Certificates</th>
										<th width="30%">Remark</th>
										<th width="10%">Date Expired</th>
										<th width="10%">Status</th>
										
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                <?
                                    $sijil = listCert5();
                                    $i=1;
                                    while($ct = $sijil->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td><?echo $i++;?></td>
                                        <td><?echo $ct['certificate_name'];?> </td>
										<td><?echo $ct['remark'];?> </td>
										<td><strong><font size="3" color="blue"><?echo $ct['date_in'];?></font></strong></center></td>
										<td>
											   <?$days = date('Y/m/d');
											   $date_in = $ct['date_in'];
											   $exp = $ct['month2'];
											   $exp1 = $ct['month1'];
											   if(($exp1 <= date('Y-m-d')) && (date('Y-m-d') < $date_in) && (date('Y-m-d') > $exp)){
													echo "<span style='background-color:orange;padding:5px;border-radius:5px;font-weight:bold;color:black;'>WARNING</span><br><font color=red><strong>Almost Expired</strong></font>";
												}
												else if(($exp <= date('Y-m-d')) && (date('Y-m-d') < $exp1)){
													echo "<span style='background-color:yellow;padding:5px;border-radius:5px;font-weight:bold;color:black;'>SOFT REMINDER</span><br><font color=red><strong>Almost Expired</strong></font>";
												}
												else if((date('Y-m-d') < $date_in) && ($exp > date('Y-m-d')) && (date('Y-m-d') < $exp1)){
												echo "<span style='background-color:green;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>ACTIVE</span>";	
											}
											else{
													echo "<span style='background-color:red;padding:5px;border-radius:5px;font-weight:bold;color:black;'>EXPIRED</span><br><font color=red><strong>Already Expired</strong></font>";
												}?>
										
										</td>
										

                                    </tr>
                                <?}?> 
                                 
                                </tbody>
                            </table>
							</center>
                        </div>

                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
</body>
<script>
        // Delete row on delete button click
        
		$(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    
    </script>
</html>