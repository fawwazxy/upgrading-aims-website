<?php

	include ('../controller/auth.php');
	require "../model/aims_car_function.php";
	require "../model/lookup.php";

?>

<head>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bullframe.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
    <? require "../global/header.php"; ?>
</head>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'>
</script>
<style>
.modal-header{
  background-color:#f1c40f;
}


</style>

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
  font-size:12px;
  
}

#car_models,
textarea[type="text"],
input[type="text"],
input[type="date"] {
  background: transparent;
  border: none;
  border-bottom: 1px solid #000000;
  -webkit-box-shadow: none;
  box-shadow: none;
  border-radius: 0;
}

#car_models:focus,
textarea[type="text"]:focus,
input[type="text"]:focus,
input[type="date"]:focus {
  -webkit-box-shadow: none;
  box-shadow: none;
}

 .card{
  background: #fff;
  border-radius: 2px;
  display: inline-block;
  height: 400px;
  margin: 1rem;
  position: relative;
  width: 100%;
  padding: 50px;
}

.card-3 {
  box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
}

form{
	margin-top: -10px;
}

 .cards{
  background: #fff;
  display: inline-block;
  margin: 1rem;
  position: relative;
  width: 100%;
}

</style>

<body>
		
				<div class="row">
                <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel panel-body">
                     <br><br>
                      <form method="post" action="../controller/aims_car_maintenance_add_exec.php" enctype="multipart/form-data">  
							
							  <input id="created_by" name="created_by" type="hidden" value="<?php echo $_SESSION['SESS_NAME'] ?>"/>
								
								<div align="left">
							    <div class="col-xs-3">
								  <label>Car Model</label>
								  <select  name="car_model" id="car_models">
									<option value="">-- Choose Vehicle--</option>
									<? echo getDropDown("aims_car_info","car_model","car_model",$car_model);?>
								  </select>
								</div>
								
								<div class="col-xs-3">
								  <label>Date Inspection Issue<font color="red">**</font>&nbsp;</label>
								  <input type="date" placeholder=" " name="dep_date" value="" >
								</div>
								
								<div class="col-xs-3">
								  <label>Costing Inspection<font color="red">**</font>&nbsp;</label>
								  <input type="text"placeholder=" " name="costing" value="" >
								</div>	

								<div class="col-xs-3">
								  <label>Kilmetre Reading(KM)<font color="red">**</font>&nbsp;</label>
								  <input type="text" placeholder=" " name="km_read" value="" >
								</div>
								</div>
								
								<label><b>Issue Identified During Inspection : </b></label>
								<div class="form-group row" align="left">
								<div class="col-xs-4">
								  <label>Interior<font color="red">**</font>&nbsp;</label>
								  <input type="text" placeholder=" " name="interior_car1" value="" >
								</div>							  
							  
							   <div class="col-xs-4">
								  <label>Exterior<font color="red">**</font>&nbsp;</label>
								  <input type="text" placeholder=" " name="exterior_car1" value="" >
								</div>
								
								<div class="col-xs-4">
								  <label>Odometre Reading<font color="red">**</font>&nbsp;</label>
								  <input type="text" placeholder=" " name="odom_read" value="" >
								</div>
								</div>
								
								<div class="form-group row" align="left">
								<div class="col-xs-3">
								  <label>Date<font color="red">**</font>&nbsp;</label>
								  <input type="date" placeholder=" " name="date" value="" >
								</div>								

								<div class="col-xs-3">
								  <label>Duration Period<font color="red">**</font>&nbsp;</label>
								  <input type="text" placeholder=" " name="duration" value="" >
								</div>
								
								<div class="col-xs-3">
								 <label>Place Of Service<font color="red">**</font>&nbsp;</label>
								 <input type="text" placeholder="" name="place_service" value="" >
								</div>
								
								<div class="col-xs-3">
								  <label>Invoice No.<font color="red">**</font>&nbsp;</label>
								  <input type="text" placeholder="" name="invoice_no" value="" >
								</div>
								</div>
								
								<div class="form-group row" align="left">
								<div class="col-xs-4">
								 <label>Job Description<font color="red">**</font>&nbsp;</label>
                                 <textarea type="text" rows="2" cols="50" placeholder="" name="job_desc" value=""></textarea>
								</div>
								
								<div class="col-xs-4">
								  <label>Item Description<font color="red">**</font>&nbsp;</label>
                                  <textarea type="text" rows="2" cols="50" placeholder="" name="item_desc"  value=""></textarea>
								</div>
								
								<div class="col-xs-4">
								 <label>Issue During Inspection<font color="red">**</font>&nbsp;</label>
								 <textarea type="text" rows="2" cols="50" placeholder="" name="issue" value=""></textarea>
								</div>
								</div>
								
                                   <center><button type="submit">Save</button></center>
							 </form>
							 
				</div>
				</div>
				</div>
				</div>
</body>