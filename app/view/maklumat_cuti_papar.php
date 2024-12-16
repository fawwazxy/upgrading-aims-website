<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
include ('../controller/auth.php');


require "../model/cuti_function.php";

date_default_timezone_set("Asia/Kuala_Lumpur");
$date_month = date(m);
$date_year = date(Y);
$date_day = date(d);
$current_date = $date_year."-".$date_month."-".$date_day;
$id=$_POST['id'];
$no_staff = $_GET['no_staff'];
$staff_record_id = $_GET['staff_record_id'];
$leave_approval = $_SESSION['SESS_NO_STAFF'];
$approvement = $_GET['approvement'];
$row_pemohon= getMaklumatPemohonCuti($id,$staff_record_id)->fetch_assoc();


?>             

     <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"><b>Maklumat Permohonan Cuti</b></h4>
             </div>
            <div class="modal-body">
                          <table width="100%">
                                <tr>
                                    <th width="30%"></th>
                                    <th width="3%"></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td><label>Nama</label></td>
                                    <td><label>:</label></td>
                                    <td><?php echo $row_pemohon['name']?></td>
                                </tr>

                                <tr>
                                    <td><label>No. Kad Pengenalan</label></td>
                                    <td><label>:</label></td>
                                    <td><?php echo $row_pemohon['noic']?></td>
                                </tr>

                                <tr>
                                    <td><label>No. Telefon</label></td>
                                    <td><label>:</label></td>
                                    <td><?php echo $row_pemohon['phone'] ?></td>
                                </tr>
                                
                                <tr>
                                    <td><label>Email</label></td>
                                    <td><label>:</label></td>
                                    <td><?php echo $row_pemohon['email']?></td>
                                </tr>

                                <tr>
                                    <td><label>Jawatan</label></td>
                                    <td><label>:</label></td>
                                    <td><?php echo $row_pemohon['role']?></td>
                                </tr>

                                <tr>
                                    <td><label>Bahagian</label></td>
                                    <td><label>:</label></td>
                                    <td><?php echo $row_pemohon['department_name']?></td>
                                </tr>

                                <tr>
                                    <td><label>Jenis Cuti</label></td>
                                    <td><label>:</label></td>
                                    <td><?php if($row_pemohon['type_leave'] == 'AL' ) {
                                                        echo '<b>'.'Annual leave'.'</b>';}
                                                    else if($row_pemohon['type_leave'] == 'MC') {
                                                        echo '<b>'.'Medical leave'.'</b>';}
                                                    else if($row_pemohon['type_leave'] == 'LP') {
                                                        echo '<b>'.'Leave Without Pay'.'</b>';}
													else if($row_pemohon['type_leave'] == 'CL') {
                                                        echo '<b>'.'Compassionate Leave'.'</b>';}
                                                    else if($row_pemohon['type_leave'] == 'HL') {
                                                        echo '<b>'.'Hospitalization Leave'.'</b>';}
                                                    else if($row_pemohon['type_leave'] == 'RP') {
                                                        echo '<b>'.'Replacement Leave'.'</b>';}     
                                                    else {
													echo '<b>'.'Leave Without Record'.'</font></b>'; }?></td>
                                </tr>

                                <tr>
                                    <td><label>Jum. Keseluruhan Cuti</label></td>
                                    <td><label>:</label></td>
                                    <td><?php echo $row_pemohon['total_cuti']?></td>
                                </tr>

                                <tr>
                                    <td><label>Baki Cuti Semasa</label></td>
                                    <td><label>:</label></td>
                                    <td><?php echo $row_pemohon['baki_cuti'];?></td>
                                </tr>

                                <tr>
                                    <td><label>Baki Cuti Permohonan</label></td>
                                    <td><label>:</label></td>
                                    <td><?php echo $row_pemohon['baki_cuti_pohon'];?></td>
                                </tr>

                                
                            </table>
                                                      </div>
                                                     <div class="modal-footer">
                                                     <button type="button" class="btn btn-primary" data-dismiss="modal">Kembali</button>
                                                  </div>
                                             </div>
      
                                         </div>

    <!-- /.panel-body -->
</div>
 <script>
    $(document).ready(function() {
        $('#example2').DataTable({
            responsive: true
        }); 
    });
</script>