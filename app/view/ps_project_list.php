<?php

	
	include ('../controller/auth.php');

	require "../model/project_schedule_function.php";
	
 	
?>
<?
         
		 $id_project=$_GET['id_project'];
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
				<h1 class="page-header">Maklumat Projek</h1>
			</div>
        </div>
		<div class="row" align="right">
			<div class="col-lg-12">
		<a href="ps_project_add.php"> <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tambah Baharu</button></a>
		<br>
		</br>
		</div>
		</br>
        </div>
                <div class="row">
                <div class="col-lg-12">
						<div class="row">
        </div>
					<div class="panel panel-default">
                        <div class="panel-heading">
                            Senarai Projek
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>#</th>
										<th>Kod Projek</th>
										<th>Nama Projek</th>
										<th>Nama Pelanggan</th>
										<th>Jenis Kerja</th>
										<th>Tarikh Mula</th>
										<th>Tindakan</th>
										
									</tr>
								</thead>
								<tbody>
								
								<?               
                                    $i= 1;
                                    $data = getProjectDetails();
                                    while($row_data = $data->fetch_assoc()) {
                                        
                                        $id = $row_data['id'];
                                    ?>
									
									<tr class="odd gradeX">
										<td><?php echo $i; ?></td>
								        <td><?php echo $row_data['project_code']; ?></td>
										<td><?php echo $row_data['project_name']; ?></td>
										<td><?php echo $row_data['client_name']; ?></td>
										<td><?php echo $row_data['type_of_job']; ?></td>
										<td><?php echo $row_data['start_date']; ?></td>
										

										<td>
                                           
                                    <a href="ps_project_add.php?id_project=<?echo $row_data['id'];?>">  <button class="btn btn-info" type="button" >Kemaskini</button></a>
                                    <a href="ps_member.php?id_project=<?echo $row_data['id'];?>">  <button class="btn btn-info" type="button" >Members</button></a>
                                    <a href="ps_schedule_add.php?id_project=<?echo $row_data['id'];?>"> <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Jadual Kerja</button></a>
                                    <a href="ps_schedule_view.php?id_project=<? echo $id; ?>" target="_blank"> <button type="button" class="btn btn-info">Gantt</button></a>
                                    </td>
								<?php $i++; } ?>
								</tbody>
							</table>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
                <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

</html>
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
	
</script>
