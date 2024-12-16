<?php
function getNotificationPelulusSalMenuLeft($jenis_kelulusan){
    $conn=db();
    $sql="SELECT COUNT(noti_status_pelulus) AS noti FROM salary_approve 
					WHERE noti_status_pelulus='0'
					AND jenis_kelulusan='SDGDIPROSES'";
    return $conn->query($sql)->fetch_object()->noti;
}

function getNotificationPelulusClaimMenuLeft(){
    $conn=db();
    $sql="SELECT COUNT(noti_status_pelulus) AS noti FROM claim_approve 
          WHERE noti_status_pelulus='0'
          AND approve_status='SD'";
    return $conn->query($sql)->fetch_object()->noti;
}

function getNotiPengurusanProjek($no_staff){
    $conn=db();
    $sql="SELECT COUNT(noti_status_pegawai) AS noti 
            FROM pesanan_belian
            WHERE noti_status_pegawai='0'
            AND status_penerimaan_tugas='DP'
            AND ketua_projek='$no_staff'";
    return $conn->query($sql)->fetch_object()->noti;
}


function getNotificationArkib($id){
    $conn=db();
    $sql="SELECT COUNT(notifikasi) AS noti
            FROM forum
            WHERE penerima='$id'";
    return $conn->query($sql)->fetch_object()->noti;
}

function accessMenu($role_code){
    $conn=db();
    $sql="SELECT *,smm.new_tab FROM sec_role_menu srm
       LEFT JOIN `sec_module_menu` smm 
       ON srm.menu_id = smm.id 
       LEFT JOIN sec_module sm 
       ON smm.module_code=sm.module_code 
       WHERE srm.access_menu=1 AND srm.role_code='$role_code'
       AND smm.status=1
       ORDER BY smm.susunan ASC, smm.id ASC";
    return $conn->query($sql);
}

function addAudit($audit_link,$audit_ip,$audit_user,$dummy) {
    $conn=db();
    $sql = "INSERT INTO audit_trail (audit_link,audit_ip,no_staff,dummy) 
        VALUES ('$audit_link','$audit_ip','$audit_user','$dummy')";
    return $conn->query($sql);
}
