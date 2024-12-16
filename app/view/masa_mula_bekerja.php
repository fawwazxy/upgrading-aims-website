<?php

	include ('../controller/auth.php');

	require "../model/kehadiran_functions.php";
?>
<?
         
		 $bln=$_GET['mnt'];
        
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
		<? 
						$flagScreen="tab_4";
						include ('../global/menu_kehadiran.php'); 
		?>
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Masa Mula Bekerja</h1>
				</br>
			</div>
			
		</div>
		
			<div class="row" align="right">
			<div class="col-lg-12">
			</div>
		</div>
                <div class="row">
                <div class="col-lg-12">
						<div class="row">
        </div>
					<div class="panel panel-default">
                        <div class="panel-heading">
                            Senarai Waktu Bekerja
                        </div>
						
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>#</th>
										<th>Shift</th>
										<th>Masa Bekerja</th>
										<th>Butiran</th>									
										<th>Tindakan</th>										
									</tr>
								</thead>
								<tbody>
								<td>.</td>
								<div class="form-group" align="left">
								<td>
									<form method="post" action="../controller/waktu_bekerja_exec.php?act=waktu_bekerja_add">
									<input type="time" id="masa_bekerja" class="form-control"  name="masa_bekerja" value = "08:00:00 AM">
								</td>
								<td>
									<input type="text" id="shift_code" class="form-control"  name="shift_code" value = "<?echo $shift_code?>" required>
								</td>
								<td>
									<input type="text" id="description" class="form-control"  name="description" value = "<?echo $description?>" required>
								</td>
								  <td>
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                    </td>

							</form>
								<?               
                                    $i= 1;
                                    $data = getAllWaktuBekerja("");
                                    while($row_data = $data->fetch_assoc()) {
                                    ?>
									<tr class="odd gradeX">
										<td><?php echo $i; ?></td>
								        <td><?echo $row_data['masa_bekerja'];?></td>
										<td><?php echo $row_data['shift_code']; ?></td>
										<td><?php echo $row_data['description']; ?></td>
										<td>
                                <a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>
                                   <a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info " onClick="updateId('<?php echo $row_data['id']; ?>')">Kemaskini</button></a> 
                                  <input type="hidden" id="row_id" value = "<?php echo $row_data['id']; ?>">
								  
								<?if(isShiftCodeExist($row_data['shift_code'])){
									echo '';
								}else {
									?>
									<a href="../controller/waktu_bekerja_exec.php?act=waktu_bekerja_delete&id_masa_kehadiran=<? echo $row_data['id'];?>"><button type="button" class="btn btn-danger" onclick="return Confirm()">Padam</button>	
								<?}?>
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
	
	$(document).ready(function() {
        $(document).on("click", ".add", function(){
        var empty = false;
        var input = $(this).parents("tr").find('input[type="text"], input[type="time"], input[type="hidden"]');
        input.each(function(){
            if(!$(this).val()){
                $(this).addClass("error");
                empty = true;
            } else{
                $(this).removeClass("error");
            }
        });
        $(this).parents("tr").find(".error").first().focus();
        var dataArray = ["",""];
        if(!empty){
            var i=0;
            var data = new FormData();
            data.append('action','waktu_bekerja_update');

            input.each(function(){
                if (i==0){
                    $(this).parent("td").html($(this).val());
                    data.append('masa_bekerja',$(this).val());
                }else if (i==1){
                    $(this).parent("td").html($(this).val());
                    data.append('shift_code',$(this).val());
                }else if (i==2){
                    $(this).parent("td").html($(this).val());
                    data.append('description',$(this).val());
                
                }
				else if (i==3){
                    data.append('id',$(this).val());
                }
                //alert($(this).val());
                dataArray[i]=$(this).val();
                i++;
            });         
            $(this).parents("tr").find(".add, .edit").toggle();
            $(".add-new").removeAttr("disabled");


            
            $.ajax({
            url: "../model/kehadiran_functions.php",
            type: "POST",
            processData: false,
            contentType:false,
            data: data,
            success: function (response) {
               // you will get response from your php page (what you echo or print)                 
                //$.alert('test here:'+response);
                location.reload();
           
            },
            error: function(jqXHR, textStatus, errorThrown) {
               console.log(textStatus, errorThrown);
            }


            });
        }   
       
        
        
    });
    // Edit row on edit button click
    $(document).on("click", ".edit", function(){
        var i=0;
      
        $(this).parents("tr").find("td:not(:last-child)").each(function(){
            if (i==1){
                var selected = '';
                  var dropdown ='<input type="time" id="masa_bekerja" class="form-control"  name="masa_bekerja" value="'+$(this).text()+'" required=""/>';
            $(this).html(dropdown);
            } else if (i==2){
                 var selected = '';
                  var dropdown ='<input type="text" class="form-control"  name="shift_code" value="'+$(this).text()+'" required="">';
            $(this).html(dropdown);
            } else if (i==3){
                var selected = '';
                  var dropdown ='<input type="text" class="form-control"  name="description" value="'+$(this).text()+'" required="">';
            $(this).html(dropdown);
            }
            i++;
        });     
        $(this).parents("tr").find(".add, .edit").toggle();
        $(".add-new").attr("disabled", "disabled");
    });
});
</script>
