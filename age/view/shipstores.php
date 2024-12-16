<?php

	include ('../controller/auth.php');

	require "../model/aims_ssr_function.php";

?>

<?
  $ssr_id = $_GET['id'];
  $ssr_no = $_GET['ssr_no'];
  $info = shipshoresById($ssr_no)->fetch_assoc();
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

	
<script language="javascript" type="text/javascript">
function updateId(curr_updt_id){
	document.getElementById('curr_updt_id').value = curr_updt_id;
}

function updatessr_no(updatessr_no){
	document.getElementById('updatessr_no').value = updatessr_no;
}

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
		<br><br>

        <div id="page-wrapper">
		
						
		
	<div class="panel-heading" align="right">
		<!--<button class="btn btn-primary add-new" data-toggle="modal"  data-target="#myModal">Tambah Baru</button></a>-->

        <a href="#addNew" id="TambahBaru" class="btn btn-primary" data-toggle="modal" data-id="<? echo $ssr_id;?>" data-name="<? echo $ssr_no;?>"
           title="Tambah Baru">Tambah Baru</a>
		
	</div>
	
			<label>SSR NO : </label> <? echo $ssr_no;?>
                <div class="row">
                <div class="col-lg-12">
					<div class="panel panel-default">
                        <div class="panel-heading">
                            SHIP STORES REQUISITION
                        </div>
						
						<input type="hidden" width="30%" name="ssr_no" id="ssr_no" value="<? echo $ssr_no;?>" >
						<input type="hidden" class="form-control" name="ssr_id" id="ssr_id" value="<? echo $ssr_id;?>">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>Description Of Items</th>
										<th>Unit</th>
										<th>Quantity Required</th>
                                        <th>Balance On Board</th>
										<th>Quantity Approved</th>
										<th>IMPA Code</th>
										<th>Remarks</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?
									$i= 1;
									$list_education = shipshoresById($ssr_no);
									while($row_data_education = $list_education->fetch_assoc()) {
								?>
								
								<tr class="odd gradeX">
								      
									<td><?php echo $row_data_education['description']; ?>
										<td><?php echo $row_data_education['unit']; ?></td>
										<td><?php echo $row_data_education['quantity_required']; ?></td>
										<td><?php echo $row_data_education['balance']; ?></td>
										<td><?php echo $row_data_education['quantity_approved']; ?></td>
										<td><?php echo $row_data_education['sparepart_no']; ?></td>
										<td><?php echo $row_data_education['remarks']; ?></td>
										
										<td>
											
												<a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary" onClick="updatessr_no('<?php echo $row_data_education['ssr_no']; ?>')">Simpan</button></a>
												<a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info " onClick="updateId('<?php echo $row_data_education['id']; ?>')">Kemaskini</button></a>
											    <a class="delete" title="Delete" data-toggle=""><button type="button" class="btn btn-danger" onClick="del_claim('<?php echo $row_data_education['id']; ?>')">Padam</button></a>
												<input type="hidden" id="id" value="<?php echo $row_data_education['id']; ?>">                                      
											    <input type="hidden" id="ssr_no" value="<?php echo $row_data_education['ssr_no']; ?>">                                        
											

                                             <? 
                                                    }

                                                ?>

										</td>
										
								</tr>
									
								
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

        <!-- /#page-wrapper -->

        <!-- Modal Tambah Baru -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 90%;margin-top: 50px;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="modal-title" id="exampleModalLongTitle" style="font-size: 120%">Tambah Baru</span>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body" id="modal-add">
                        <!--Modal Script-->
                        <script>
                            $('#addNew').on('show.bs.modal', function (e) {
                                var rowid = $(e.relatedTarget).data('id');
                                var rowname = $(e.relatedTarget).data('name');
                                console.log(rowid);
                                console.log(rowname);
                                $.ajax({
                                    type:'POST',
                                    url:'shipstores_add.php',
                                    data:{id:rowid,no:rowname},
                                    success:function(html){
                                        $('#modal-add').html(html);
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /#wrapper -->
	<? include ('../global/footer.php'); ?>

	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
		$('[data-toggle="tooltip"]').tooltip();
	/*var actions = $("table td:last-child").html();*/
	// Append table with add row form on add new button click
   /* $(".add-new").click(function(){
		$(this).attr("disabled", "disabled");
		var index = $("table tbody tr:last-child").index();
        var row = '<tr>' +
            '<td><input type="text" class="form-control" name="description" id="description" style="text-transform:uppercase"></td>' +
			'<td><input type="text" class="form-control" name="unit" id="unit" value="PCS" style="text-transform:uppercase"></td>' +
			'<td><input type="number" class="form-control" name="quantity_required" id="quantity_required"></td>'+
			'<td><input type="number" class="form-control" name="balance" id="balance" ></td>'+
			'<td><input type="number" class="form-control" name="quantity_approved" id="quantity_approved"></td>'+
			'<td><input type="text" class="form-control" name="sparepart_no" id="sparepart_no" value="NONE" style="text-transform:uppercase"></td>' +
			'<td><input type="text" class="form-control" name="remarks" id="remarks" style="text-transform:uppercase"></td>'+
			'<td>' + 
			'<a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>'+
			'<a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-primary">Kemaskini</button></a>'+			  
			'</td>' +
        '</tr>';
    	$("table").append(row);		
		$("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
        $('[data-toggle="tooltip"]').tooltip();
    0});*/
	// Add row on add button click
	$(document).on("click", ".add", function(){
		var empty = false;
		var input = $(this).parents("tr").find('input');
		
        input.each(function(){
			if(!$(this).val()){
				$(this).addClass("error");
				empty = true;
			} else{
                $(this).removeClass("error");
            }
		});
		$(this).parents("tr").find(".error").first().focus();
		var dataArray = ["","","","","","","",""];
		
		if(!empty){
			var i=0;

			input.each(function(){
				if(i<=1){
				$(this).parent("td").html($(this).val());
				}
				//alert($(this).val());
				dataArray[i]=$(this).val();
				i++; 
			});		
			
			var ssr_no = document.getElementById("ssr_no").value;
			var ssr_id = document.getElementById("ssr_id").value;
		
		$.ajax({
        url: "../model/aims_ssr_function.php",
        type: "POST",
        data: {action:"update_claim",ssr_id:ssr_id,ssr_no:ssr_no,description:dataArray[0],unit:dataArray[1],quantity_required:dataArray[2],balance:dataArray[3],quantity_approved:dataArray[4],sparepart_no:dataArray[5],remarks:dataArray[6],id:dataArray[7]},
        success: function (response) {
                        // you will get response from your php page (what you echo or print)                 
                        //$.alert(response);
                        $.confirm({
                        title: 'Info',
                        content: response,
                        buttons: {
                            OK: function () {
							  var ssr_no = document.getElementById("ssr_no").value;
							  var ssr_id = document.getElementById("ssr_id").value;
                              location.href="../view/shipstores.php?ssr_no="+ssr_no+"&ssr_id="+ssr_id;
                            }
                        }
                    });
                        
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                     console.log(textStatus, errorThrown);
                     location.href = "shipstores.php";
                 }

                });
		}
    });
	// Edit row on edit button click
	$(document).on("click", ".edit", function(){
            var i=0;;
            $(this).parents("tr").find("td:not(:last-child)").each(function(){
            var selectedText = $(this).html();
			 if (i=0){
				  $(this).html('<input type="text" class="form-control" style="text-transform:uppercase" size="15%" value="' + $(this).text() + '">');
                }else{
                     $(this).html('<input type="text" class="form-control" style="text-transform:uppercase" size="15%" value="' + $(this).text() + '">');
                }
                
                i++;
            }); 

            $(this).parents("tr").find(".add, .edit").toggle();
            $(".add-new").attr("disabled", "disabled");
        });
	// Delete row on delete button click
	// 	$(document).on("click", ".delete", function(){
    //         var row_id = $(this).parents("tr").find('input[type="hidden"]');
    //         var curr_id="";
    //         row_id.each(function(){
    //             curr_id = $(this).val();
    //         });
    //
    //         $(this).parents("tr").remove();
    //         $(".add-new").removeAttr("disabled");
    //     });
		
    });
	
	   function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }

    function del_claim(id){
        if(confirm("Delete selected ship stores requisition?") == true){
            $.ajax({
               url: "../model/aims_ssr_function.php",
               type: "POST",
               data: {action:"del_claim",id:id},
               success: function (response) {
                   // you will get response from your php page (what you echo or print)
                   //$.alert('test here:'+response);
                   var ssr_no = document.getElementById("ssr_no").value;
                   window.location="shipstores.php?ssr_no="+ssr_no;
               },
               error: function(jqXHR, textStatus, errorThrown) {
                   console.log(textStatus, errorThrown);
               }
            });
        }
    }
    </script>

</body>

</html>