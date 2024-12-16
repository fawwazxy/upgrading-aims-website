<?php

include ('../controller/auth.php');

require "../model/aims_car_function.php";
require "../model/lookup.php";

$car_model=$_GET['car_model'];
$year=$_GET['year'];
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bullframe.css">
    <? require "../global/header.php"; ?>
</head>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 5px;
  font-size:10px;
  
}

</style>

<body>

    <div id="wrapper">
			
			<div class="row">
<div class="col-lg-12">
    
<div class="form-group" align="right">
<button id="printbtn" onclick="window.print()">Print this page</button>
<button id="printbtn" onclick="goBack()" >Back</button>
</div>
</div>
</div>
			
			<?
			
			$car_model = $_GET['car_model'];		
             $model = getcarByModel($car_model)->fetch_assoc();
            ?>
		
            <div class="row">
                <div class="col-lg-12">
                    <!-- /.panel-heading -->
					
                    <div class="panel-body">
                        <table>
						  <tr>
							<td colspan="2" style="text-align:center" width="50%"><b>ASSET OF COMPANY</b>
							<br> <b> COMPANY NAME : </b><? echo $model['description'];?></td>
						  </tr>
						  <tr>
							<td colspan="2" style="text-align:center" width="50%"><b>DETAILS OF ASSET</b></td>
						  </tr>
						  <tr>
							<td width="50%"><b>Category : </b> <? echo $model['car_category'];?></td>
							<td><b>Cost and Date Of Receipt : </b> <? echo $model['cost_receipt'];?> (<? echo $model['date_receipt'];?>)</td>
						  </tr>
						  <tr>
							<td width="50%"><b>Type : </b> <? echo $model['car_type'];?></td>
							<td><b>Registration No : </b> <? echo $model['car_plate_no'];?></td>
						  </tr>
						  <tr>
							<td width="50%"><b>Brand or Model : </b> <? echo $model['car_model'];?></td>
							<td width="50%"><b>Suppliers : </b> <? echo $model['suppliers'];?></td>
						  </tr>
						  <tr>
							<td width="50%"><b>Type & Engine No : </b> <? echo $model['engine_no'];?></td>
							<td width="50%"><b>Hire Purchases Account No : </b> <? echo $model['hire_account_no'];?> (<? echo $model['name_account'];?>)</td>
						  </tr>
						  <tr>
							<td width="50%"><b>Chassis No : </b> <? echo $model['chassis_no'];?></td>
							<td width="50%"><b>The Original Colour : </b> <? echo $model['color'];?></td>
						  </tr>
						</table>
                    </div>
					
					
                        <table class="bf-table" id="sum_table" width="100%">
						  <tr>
							<td colspan="15" style="text-align:center" width="50%"><b>PARTICULARS OF ASSETS MAINTENANCE <? echo $year?></b></td>
						  </tr>
						  <tr>
							<td colspan="7"><b>TYPE, BRAND AND MODEL : <? echo $model['car_model'];?></b></td>
							<td colspan="8"><b>REGISTRATION NO : </b> <? echo $model['car_plate_no'];?></td>
						  </tr>
						  <tr>
							<td rowspan="2">DATE INSPECTION ISSUE</td>
							<td rowspan="2">ISSUE IDENTIFIED DURING INSPECTION</td>
							<td rowspan="2">KILOMETRE READING (KM)</td>
							<td rowspan="2">ACTUAL KILOMETRE SERVICE (KM)</td>
							<td rowspan="2">DATE</td>
							<td colspan="2">SERVICE DETAIL</td>
							<td colspan="3">PLACE OF SERVICE/REPAIRS</td>
							<td rowspan="2">ISSUE IDENTIFIED DURING INSPECTION</td>
							<td rowspan="2">DURATION PERIOD</td>
							<td rowspan="2">STATUS ACTION</td>
						  </tr>
						  
						  <tr>
						  <td>JOB DESCRIPTION</td>
						  <td>ITEM DESCRIPTION</td>
						  <td>SUPPLIER</td>
						  <td>COSTING</td>
						  <td>INVOICE</td>
						  </tr>
						   <?
									$OPEN = 'OPEN';
									$CLOSED = 'CLOSED';
                                    $car1 = getcarByinspec($car_model,$year);
                                    $i=1;
                                    while($listinspec = $car1->fetch_assoc()) {
                            ?>
						
							
						  <tr>
							<td rowspan="2"><? echo $listinspec['dep_date']; ?></td>
							<td><? echo $listinspec['exterior_car'];?></td>
							<td rowspan="2"><? echo $listinspec['km_read']; ?></td>
							<td rowspan="2"><? echo $listinspec['odom_read'];?></td>
							<td rowspan="2"><? echo $listinspec['date'];?></td>
							<td rowspan="2"><? echo $listinspec['job_desc'];?></td>
							<td rowspan="2"><? echo $listinspec['item_desc'];?></td>
							<td rowspan="2"><? echo $listinspec['place_service'];?></td>
							<td rowspan="2" id="loop"><? echo $listinspec['costing'];?></td>
							<td rowspan="2"><? echo $listinspec['invoice_no'];?></td>
							<td rowspan="2"><? echo $listinspec['issue'];?></td>
							<td rowspan="2"><? echo $listinspec['duration'];?></td>
							<td><? if ($listinspec['status_1'] != '') {?>
							<? echo $listinspec['status_1'];?>
							<?}?>
							<? if ($listinspec['status_1'] == '') {?>
							<? echo 'PENDING'?>
							<?}?>
							</td>
						    </tr>
							<tr>
							<td><? echo $listinspec['interior_car'];?></td>
							<td><? if ($listinspec['status_2'] != '') {?>
							<? echo $listinspec['status_2'];?>
							<?}?>
							<? if ($listinspec['status_2'] == '') {?>
							<? echo 'PENDING'?>
							<?}?></td>
							<?}?>
							</tr>
						</table>
						
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>
		<br><br><br>
		<div class="row">
		<div class="col-lg-12">
		<div class="form-group" align="right">
		<div class="col-xs-8">
		</div>
		<div class="col-xs-2">
		<b>Total Cost : RM </b>
		</div>
		<div class="col-xs-2">
		<input type="text" id="total" />
		</div>
		</div>
		</div>
		</div>
<!-- 
        <!-- /#page-wrapper -->

   </div>


    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
			$("#car_model").change(function(){
		 var selected_cawangan=$(this).val();
		 sendType(selected_cawangan);
		 });
		 
		 $("#year").change(function(){
					if($("#car_model").val()=='' ){
						alert('SELECT CAR MODEL!')
						$("#year").val('');
					}else{
						var selected_year=$(this).val();
						var selected_car_model = $("#car_model").val();
						reloadYear(selected_year,selected_car_model);

					}
				});
		
        });

        function sendType(type)
	 {
		window.location.href="aims_car_maintenance.php?car_model="+type;
		
	}
	
	function reloadYear(selected_year,selected_car_model){
	            //console.log(obj);
	            location.href = "aims_car_maintenance.php?car_model="+selected_car_model+"&year="+selected_year;
	        }
	$(document).ready(function(){



});
    
    </script>

<script type="text/javascript">
    $(function() {

       var TotalValue = 0;

       $("tr #loop").each(function(index,value){
         currentRow = parseFloat($(this).text());
         TotalValue += currentRow
       });

       document.getElementById('total').value = TotalValue;
	   

});
</script>


		<script>
	$('#dataTables-example').DataTable({
                responsive: true
            });
				function goBack() {
				window.history.back();}
</script>

<style type="text/css">
@media print {
    #printbtn {
        display :  none;
    }
}
</style>

</body>

</html>