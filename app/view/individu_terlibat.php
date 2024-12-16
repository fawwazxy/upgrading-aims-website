<?
require "../model/meeting_functions.php";
$id=$_GET['id'];
$list = kemaskiniEvents($id)->fetch_assoc();

$id_staff=$list['id_staff'];


?>
				<div class="row">
                <div class="col-lg-12">
					             <div class="panel panel-default">

                       
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          <ol>
                            <?
                                $i= 1;
                                $staff= getStaffNameByID($id_staff);
                                while($list = $staff->fetch_assoc()) {
                              ?>
                              <li><? echo $list['name'];?></li>


                              <?}?>

                          </ol>
                            
						
                            </div>
                          </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
            </div>
                <!-- /.row -->
            <!-- /.container-fluid -->
			
