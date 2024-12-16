     <?php


  

     function getNotificationPelulusSalMenuLeft($jenis_kelulusan){

     	 $conn=db();

     
           $sql="SELECT COUNT(noti_status_pelulus) AS noti FROM salary_approve 
					WHERE noti_status_pelulus='0'
					AND jenis_kelulusan='SDGDIPROSES'";



     	 $n_status_1= $conn->query($sql)->fetch_object()->noti;



       return $n_status_1;


     }

     function getNotificationPelulusClaimMenuLeft(){

       $conn=db();

     
           $sql="SELECT COUNT(noti_status_pelulus) AS noti FROM claim_approve 
          WHERE noti_status_pelulus='0'
          AND approve_status='SD'
          ";



       $n_status_1= $conn->query($sql)->fetch_object()->noti;



       return $n_status_1;


     }

function getNotiPengurusanProjek($no_staff){

       $conn=db();

     
           $sql="SELECT COUNT(noti_status_pegawai) AS noti 
FROM pesanan_belian
WHERE noti_status_pegawai='0'
AND status_penerimaan_tugas='DP'
AND ketua_projek='$no_staff'
          ";



       $n_status_1= $conn->query($sql)->fetch_object()->noti;



       return $n_status_1;


     }

     
     function getNotificationArkib($id){

       $conn=db();

     
           $sql="SELECT COUNT(notifikasi) AS noti
            FROM forum
            WHERE penerima='$id'";



       $n_status_1= $conn->query($sql)->fetch_object()->noti;



       return $n_status_1;


     }
     
     function accessMenu($role_code){
       $conn=db();  
       $sql="select * from sec_role_age srm
       left join `sec_module_age` smm 
       on srm.menu_id = smm.id 
       LEFT JOIN sec_modules_age sm 
       ON smm.module_code=sm.module_code 
       where srm.access_menu=1 and srm.role_code='$role_code'
       and smm.status=1
       order by sm.susunan ASC,smm.susunan ASC";

       $result= $conn->query($sql);
       return $result;
     }
     
     function addAudit($audit_link,$audit_ip,$audit_user) {
    $conn=db();
     $sql = "INSERT INTO audit_trail (audit_link,audit_ip,no_staff) 
        VALUES ('$audit_link','$audit_ip','$audit_user')";	
    $result = $conn->query($sql);
    return $result;
  }
  

     ?>