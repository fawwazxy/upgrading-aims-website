<?php

    require '../../lib/db/connection.php';

    $action = $_POST['action'];
    if ($action=="get_aduan") {
        $id = clean($_POST['id']);
        $conn=db();
        $sql = "SELECT * FROM support
                WHERE id='$id'";
        $result = $conn->query($sql);
        $rows = $result->fetch_assoc();
        

        echo json_encode($rows);
        
    }

    //Function to sanitize values received from the form. Prevents SQL injection
    function clean($str) {
    $conn=db();
        $str = @trim($str);
        if(get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }
        return mysqli_real_escape_string($conn,$str);
    }

    function getSys($sys_id) {
        $conn=db();
        $sql = "SELECT s.*,c.short_name FROM sys_setting s LEFT JOIN company c ON c.sys_id=s.sys_id WHERE s.sys_id='$sys_id'";
        $result = $conn->query($sql);
        return $result;
    }

    function login($username,$password) {
        $conn=db();
        $sql = "SELECT * FROM staff WHERE username='$username' AND accs_pwd='$password'";
        $result = $conn->query($sql);
        return $result;
    }

    function getLogUser($com_id) {
        $conn=db();
        $sql = "SELECT * FROM staff WHERE company_id='$com_id'";
        $result = $conn->query($sql);
        return $result;
    }
    
    function getLogPemohon() {
        $conn=db();
        $sql = "SELECT p.*,r.role AS peranan,sp.desc,rg.role_group_name
                FROM pemohon p
                        LEFT JOIN role r ON r.code=p.role_id
                LEFT JOIN status_pemohon sp ON sp.code = p.status_pemohon
                LEFT JOIN role_group rg ON rg.id=r.role_group_id";
        $result = $conn->query($sql);
        return $result;
    }

    function getStaff() {
        $conn=db();
        $sql = "SELECT * FROM staff ";
        $result = $conn->query($sql);
        return $result;
    }
    
    function getCompany() {
        $conn=db();
        $sql = "SELECT * FROM company";
        $result = $conn->query($sql);
        return $result;
    }
    
    //edit 2019/10/06 by nik
    function addSupport($nama_projek,$nama_client,$aduan,$notel,$status_tindakan,$id_support,$id,$shortcode,$created_by){
        $conn=db();
        $sql = "INSERT INTO support(nama_projek,nama_client,aduan,notel,status_tindakan,norujukan_support,created_by,noti_status) 
                VALUES('$nama_projek','$nama_client','$aduan','$notel','BH',(SELECT CONCAT('$shortcode','/','ADN','/',YEAR(CURRENT_TIMESTAMP),'/',
                LPAD(IFNULL(MAX(a.id), 0) + 1, 4, '0')) AS norujukan_support 
                FROM support a ),'$created_by','1')"; 
        $result = $conn->query($sql) or die($conn->error);
        return $result;
    }

    function addSebutHarga($agensi_rujukan,$tajuk_sebut_harga,$jumlah_sebut_harga,$terma_sebut_harga,$tempoh_sah_sebut_harga,$id_lead,$nama_rujukan,$alamat_rujukan,$notel_rujukan,$shortcode){
        $conn=db();
        //$norujukan_sebut_harga=getRunning_No("norujukan_sebut_harga");
        $sql = "INSERT INTO sebut_harga(agensi_rujukan,tajuk_sebut_harga,jumlah_sebut_harga, terma_sebut_harga,tempoh_sah_sebut_harga,id_lead,nama_rujukan,alamat_rujukan,notel_rujukan,status_sebut_harga,norujukan_sebut_harga)  
                VALUES('$agensi_rujukan','$tajuk_sebut_harga','$jumlah_sebut_harga','$terma_sebut_harga','$tempoh_sah_sebut_harga','$id_lead','$nama_rujukan','$alamat_rujukan','$notel_rujukan','AKTIF',(SELECT CONCAT('$shortcode','/','SHG','/',YEAR(CURRENT_TIMESTAMP),'/', LPAD(IFNULL(MAX(a.id_sebut_harga), 0) + 1, 4, '0')) AS norujukan_sebut_harga FROM sebut_harga a )) ";
        $result = $conn->query($sql);
        return $result;
    }

    function getSupport($nama_projek){
        $conn=db();
        $sql = "SELECT sp.*, st.name AS namadev, sd.tarikh_mula, sd.tarikh_tamat,pin.nama_projek,sd.id_support,sd.level_developer FROM support sp
                LEFT JOIN support_developer sd ON sp.id=sd.id_support
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                WHERE sp.nama_projek='$nama_projek' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql);
        return $result;
    }

    function getSupportDP($nama_projek){
        $conn=db();
        $sql = "SELECT sp.*, st.name AS namadev, sd.tarikh_mula, sd.tarikh_tamat, pin.nama_projek,sd.level_developer FROM support sp
                LEFT JOIN support_developer sd ON sp.id=sd.id_support
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                WHERE sp.nama_projek='$nama_projek' AND sp.status_tindakan='DP' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql);
        return $result;

    }

    function getSupportDalamProses($nama_projek){
        $conn=db();
        $sql = "SELECT sp.*, st.name AS namadev, sd.tarikh_mula, sd.tarikh_tamat, pin.nama_projek,sd.level_developer FROM support sp
                LEFT JOIN support_developer sd ON sp.id=sd.id_support
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                WHERE sp.nama_projek='$nama_projek' AND sp.status_tindakan='T' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql);
        return $result;
    }

    function getSupportST($nama_projek){
        $conn=db();
        $sql = "SELECT sp.*, st.name AS namadev, sd.tarikh_mula, sd.tarikh_tamat, pin.nama_projek,sd.level_developer FROM support sp
                LEFT JOIN support_developer sd ON sp.id=sd.id_support
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                WHERE sp.nama_projek='$nama_projek' AND sp.status_tindakan='ST' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql);
        return $result;
    }

    function getSupportSemakanTerakhir($status_tindakan){
        $conn=db();
        $sql = "SELECT sp.*, st.name AS namadev, sd.tarikh_mula, sd.tarikh_tamat,pin.kod_projek, pin.nama_projek,sd.level_developer, sd.id AS id_support_developer FROM support sp
                LEFT JOIN support_developer sd ON sp.id=sd.id_support
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                WHERE sp.status_tindakan='$status_tindakan' AND sd.status_reassign='1' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
                ORDER BY sp.created_date DESC";
        $result = $conn->query($sql);
        return $result;
    }

    function getSupportDalamPenerimaan($status_tindakan){
        $conn=db();
        $sql = "SELECT sp.*, st.name AS namadev, sd.tarikh_mula, sd.tarikh_tamat,pin.kod_projek, pin.nama_projek,sd.level_developer, sd.id AS id_support_developer FROM support sp
                LEFT JOIN support_developer sd ON sp.id=sd.id_support
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                WHERE sp.status_tindakan='DP' AND sd.status_reassign='1' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
                ORDER BY sp.created_date DESC";
        $result = $conn->query($sql);
        return $result;
    }

    function getSupportTutup(){
        $conn=db();
        $sql = "SELECT sp.*, st.name AS namadev, sd.tarikh_mula, sd.tarikh_tamat, pin.nama_projek,sd.level_developer FROM support sp
                LEFT JOIN support_developer sd ON sp.id=sd.id_support
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                WHERE sp.status_tindakan='TA' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql);
        return $result;
    }


    function getSupportDalamProsesView($status_tindakan){
        $conn=db();
        $sql = "SELECT sp.*, st.name AS namadev,sd.tarikh_mula, sd.tarikh_tamat,pin.kod_projek, pin.nama_projek,sd.developer,sd.level_developer,sd.id AS id_support_developer,sd.status_reassign FROM support sp
                LEFT JOIN support_developer sd ON sp.id=sd.id_support
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                WHERE sd.status_reassign='1' AND sp.status_tindakan='$status_tindakan' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
                ORDER BY sp.created_date DESC";
        $result = $conn->query($sql);
        return $result;
    }


    function getSupportBatal($status_tindakan){
        $conn=db();
        $sql = "SELECT sp.*, st.name AS namadev, sd.tarikh_mula, sd.tarikh_tamat,pin.kod_projek, pin.nama_projek,sd.id_support,sd.level_developer FROM support sp
                LEFT JOIN support_developer sd ON sp.id=sd.id_support
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                WHERE sp.status_tindakan='C' AND (sd.status_reassign='1' OR sd.status_reassign IS NULL) AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
                GROUP BY sp.id ORDER BY sp.created_date DESC";
        $result = $conn->query($sql);
        return $result;
    }

    function getSupportSelesaiList($status_tindakan){
        $conn=db();
        $sql = "SELECT sp.*, st.name AS namadev, sd.tarikh_mula, sd.tarikh_tamat, pin.kod_projek, pin.nama_projek,sd.id_support,sd.level_developer FROM support sp
                LEFT JOIN support_developer sd ON sp.id=sd.id_support
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                WHERE sp.status_tindakan='S' AND (sd.status_reassign='1' OR sd.status_reassign IS NULL) AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
                ORDER BY sp.created_date DESC";
        $result = $conn->query($sql);
        return $result;
    }

    function getCatatan($id){
        $conn=db();
        $sql = "SELECT aduan FROM support WHERE id='$id'";     
        $result = $conn->query($sql);
        return $result;
    }

    function getSupportSelesai($nama_projek){
        $conn=db();
        $sql = "SELECT sp.*, st.name AS namadev, sd.tarikh_mula, sd.tarikh_tamat, pin.nama_projek,sd.level_developer FROM support sp
                LEFT JOIN support_developer sd ON sp.id=sd.id_support
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                WHERE sp.nama_projek='$nama_projek' AND sp.status_tindakan='S' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql);
        return $result;
    }


    function getSupportProgress($id){
        $conn=db();
        $sql="SELECT  st.name AS namadev, pin.nama_projek, sd.tarikh_mula,sd.tarikh_tamat, sp.nama_client,sp.notel,sp.id,sp.created_date,sp.status_tindakan FROM support sp
              LEFT JOIN support_developer sd ON sp.id=sd.id_support
              LEFT JOIN staff st ON sd.developer=st.no_staff
              LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
              LEFT JOIN progress p ON p.id_progress=sp.id
              WHERE sp.id='$id' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql);
        return $result;
    }

    function getSupportViewProgresses($id){
        $conn=db();
        $sql = "SELECT sp.*,pin.nama_projek, sd.catatan As catatan FROM support sp
                LEFT JOIN support_developer sd ON sp.id=sd.id_support
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek 
                WHERE sp.id='$id' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql);
        return $result;
    }

    function getCatatanPembatalan($id){
        $conn=db();
        $sql = "SELECT  sd.catatan FROM support_developer sd
                LEFT JOIN support s ON sd.id_support=s.id WHERE s.id='$id'";
        $result = $conn->query($sql);
        return $result;
    }

    function getSupportViewProgress($id){
        $conn=db();
        $sql = "SELECT sp.*,pin.nama_projek,sp.aduan FROM support sp
                LEFT JOIN support_developer sd ON sp.id=sd.id_support
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                WHERE sp.id='$id' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')"; 
        $result = $conn->query($sql);
        return $result; 
    }

    function getsupportImg($id){
        $conn=db();
        $sql=" SELECT aduan FROM support WHERE id='$id'";
        $result = $conn->query($sql);
        $default= $result-> fetch_assoc();
        echo '<img src="data:image/jpeg;base64,'.base64_encode( $default['photo'] ).'" style="width: 350px; height: 350px;"/>';
    }

    function getSupportUpdateDeveloper($id){
        $conn=db();
        $sql = "  SELECT s.*,sd.level_developer, sd.tarikh_mula, sd.tarikh_tamat, sd.jumlah_hari_siap, sd.catatan,pin.nama_projek,sd.remarks FROM support s
                  LEFT JOIN support_developer sd ON s.id=sd.id_support
                  LEFT JOIN projek_internal pin ON s.nama_projek=pin.kod_projek 
                  WHERE s.id='$id' AND sd.status_reassign='1' AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql);
        return $result;
    }

    function getTarikhProgress($id){
        $conn=db();
        $sql = "SELECT sd.*,s.* FROM support_developer sd
                LEFT JOIN support s ON sd.id_support=s.id
                WHERE sd.id='$id' AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql);
        return $result;
    }

    function getSupportDeveloper($no_staff,$status_tindakan){
        $conn=db();
        $sql = "SELECT sp.*, sd.id AS id_support_developer, sd.tarikh_mula,sd.tarikh_tamat,pin.kod_projek, pin.nama_projek,sd.level_developer,sp.norujukan_support FROM support sp 
                LEFT JOIN support_developer sd ON sp.id=sd.id_support 
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                WHERE sd.developer='$no_staff' AND sp.status_tindakan='DP' AND sd.status_reassign='1' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
                ORDER BY sp.created_date DESC";
        $result = $conn->query($sql);
        return $result;
    }

    function getSupportDeveloperAll($no_staff,$nama_projek){
        $conn=db();
        $sql = "SELECT sp.*, sd.id_support AS id_support, sd.tarikh_mula,sd.tarikh_tamat, pin.nama_projek,sd.developer,sd.level_developer FROM support sp 
                LEFT JOIN support_developer sd ON sp.id=sd.id_support 
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                WHERE sd.developer='$no_staff' AND sp.nama_projek='$nama_projek' AND sp.status_tindakan='DP' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql);
        return $result;

    }

    function getSupportDeveloperBS($no_staff,$status_tindakan){
        $conn=db();
        $sql = "SELECT sp.*, sd.id AS id_support_developer, sd.tarikh_mula AS tarikh_mula, sd.tarikh_tamat AS tarikh_tamat, pin.nama_projek, pin.kod_projek,sd.level_developer,sd.status_reassign FROM support sp 
                LEFT JOIN support_developer sd ON sp.id=sd.id_support 
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                WHERE sd.developer='$no_staff' AND sp.status_tindakan='T' AND sd.status_reassign='1' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
                ORDER BY sp.created_date DESC";
        $result = $conn->query($sql);
        return $result;
    }

    function getSupportSelesaiByDeveloper($no_staff){
        $conn=db();
        $sql = "SELECT sp.*, sd.id_support AS id_support, sd.tarikh_mula AS tarikh_mula, sd.tarikh_tamat AS tarikh_tamat,pin.kod_projek, pin.nama_projek,sd.level_developer,sd.status_reassign FROM support sp 
                LEFT JOIN support_developer sd ON sp.id=sd.id_support 
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                WHERE sd.developer='$no_staff' AND sp.status_tindakan='S' AND sd.status_reassign='1' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
                ORDER BY sp.created_date DESC";
        $result = $conn->query($sql);
        return $result;
    }

    function getSupportDeveloperSemakanTerakhir($no_staff,$status_tindakan){
        $conn=db();
        $sql = "SELECT sp.*, sd.id_support AS id_support, sd.tarikh_mula AS tarikh_mula, sd.tarikh_tamat AS tarikh_tamat,pin.kod_projek, pin.nama_projek,sd.level_developer FROM support sp 
                LEFT JOIN support_developer sd ON sp.id=sd.id_support 
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                WHERE sd.developer='$no_staff' AND sp.status_tindakan='ST' AND sd.status_reassign='1' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
                ORDER BY sp.created_date DESC";
        $result = $conn->query($sql);
        return $result;
    }

    function getSupportDeveloperBSSistem($no_staff,$status_tindakan,$nama_projek){
        $conn=db();
        $sql = "SELECT sp.*, sd.id_support AS id_support, sd.tarikh_mula,sd.tarikh_tamat, pin.nama_projek,sd.level_developer FROM support sp 
                LEFT JOIN support_developer sd ON sp.id=sd.id_support 
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                WHERE sd.developer='$no_staff' AND sp.status_tindakan='T' AND nama_projek='$nama_projek' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql);
        return $result;
    }

    function getSupportDeveloperST($no_staff,$status_tindakan,$nama_projek){
        $conn=db();
        $sql = "SELECT sp.*, sd.id_support AS id_support, sd.tarikh_mula,sd.tarikh_tamat, pin.nama_projek,sd.level_developer FROM support sp 
                LEFT JOIN support_developer sd ON sp.id=sd.id_support 
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                WHERE sd.developer='$no_staff' AND sp.status_tindakan='ST' AND nama_projek='$nama_projek' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql);
        return $result;

    }

    function getSupportDeveloperSelesai($no_staff,$status_developer,$nama_projek){
        $conn=db();
        $sql = "SELECT sp.*, sd.id_support AS id_support, sd.tarikh_mula,sd.tarikh_tamat, pin.nama_projek,sd.level_developer FROM support sp 
                LEFT JOIN support_developer sd ON sp.id=sd.id_support 
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                WHERE sd.developer='$no_staff' AND sp.status_tindakan='S' AND nama_projek='$nama_projek' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql);
        return $result;
    }

    function updateStatusSupport($status_tindakan,$id){
        $conn=db();
        $sql = "UPDATE support SET status_tindakan='DP', noti_status='1'
                WHERE id='$id'";
        $result = $conn->query($sql);
        return $result;
    }


    function updateStatusSupportHantarSimpan($status_tindakan,$id){
        $conn=db();
        $sql = "UPDATE support SET status_tindakan='DP', noti_status='1'
                WHERE id='$id'";
        $result = $conn->query($sql);
        $sql2 ="INSERT INTO support_developer (id_support)
                SELECT support.id FROM support WHERE support.id='$id'";
        $result = $conn->query($sql2);
        return $result;
    }

    function updateStatusTutupAduan($id,$id_support_developer){
        $conn=db();
        $sql = "UPDATE support SET status_tindakan='S', noti_status='1'
             WHERE id='$id'";
        $result = $conn->query($sql);
        return $result;
    }

    function updateStatusSupport2($status_tindakan,$id){
        $conn=db();
        $sql = "UPDATE support SET status_tindakan='T'
                WHERE id='$id'";
        $result = $conn->query($sql);
        return $result;
    }


    function updateStatusST($status_tindakan,$id){
        $conn=db();
        $sql = "UPDATE support SET status_tindakan='ST'
                WHERE id='$id'";
        $result = $conn->query($sql);
        return $result;

    }


    function updateStatusSelesai($status_tindakan,$id){
        $conn=db();
        $sql = "UPDATE support SET status_tindakan='S'
                WHERE id='$id'";
        $result = $conn->query($sql);
        return $result;
    }

    function updateStatusTerima($status_tindakan,$id){
        $conn=db();
        $sql = "UPDATE support SET status_tindakan='T'
                WHERE id='$id'";
        $result = $conn->query($sql);
        return $result;
    }


    function updateStatusSupportDeveloper($status_tindakan,$id){
        $conn=db();
        $sql = "UPDATE support SET status_tindakan = 'BS' 
                WHERE id='$id'";
        $result = $conn->query($sql);
        return $result;
    }

    function addDevLevel($id_support,$level_aduan,$developer,$id,$notel,$remarks,$created_by){
        $conn=db();
        $sql = "INSERT INTO support_developer(id_support,level_developer,developer,remarks,created_by) VALUES ('$id','$level_aduan','$developer','$remarks','$created_by') ";
        $result = $conn->query($sql);
        $sql2 = "UPDATE support SET notel='$notel', level_aduan='$level_aduan' WHERE id='$id' ";
        $result = $conn->query($sql2);
        return $result;
    }


    function updateReassign($id_support_developer,$id_support,$level_aduan,$developer,$tarikh_mula,$tarikh_tamat,$jumlah_hari_siap,$created_by,$remarks){
        $conn=db();

        $sql = "INSERT INTO support_developer(id_support, level_developer, developer, status_reassign, tarikh_mula, tarikh_tamat, jumlah_hari_siap, created_by, remarks) VALUES ('$id_support','$level_aduan','$developer','1','$tarikh_mula','$tarikh_tamat','$jumlah_hari_siap','$created_by','$remarks') ";
        $result = $conn->query($sql);
        $sql2 = "UPDATE support_developer SET status_reassign='0' WHERE id='$id_support_developer'";
        $result = $conn->query($sql2);
        return $result;
    }


    function addDevLevelSupport($level_aduan,$previous_dev,$developer,$id,$remarks,$created_by,$status_tindakan){
        $conn=db();
        if($status_tindakan=='TT'){
            $sql2 = "UPDATE support SET status_tindakan='BH', level_aduan='$level_aduan' WHERE id='$id'";
            $result = $conn->query($sql2) or die($conn->error);
            $sql2 = "UPDATE support_developer SET status_reassign='0' WHERE id='$previous_dev' ";
            $result = $conn->query($sql2) or die($conn->error);
            $sql2 = "INSERT INTO support_developer(developer, id_support, level_developer, remarks, created_by) VALUES('$developer','$id', '$level_aduan', '$remarks', '$created_by')";
            $result = $conn->query($sql2) or die($conn->error);
        }else if($status_tindakan=='BH'){
            $sql2 = "UPDATE support SET level_aduan='$level_aduan' WHERE id='$id'";
            $result = $conn->query($sql2) or die($conn->error);
            $sql2 = "UPDATE support_developer SET developer='$developer',level_developer='$level_aduan',remarks='$remarks', created_by='$created_by' WHERE id='$previous_dev' ";
            $result = $conn->query($sql2);
        }else if($status_tindakan == 'S'){
            $sql2 = "UPDATE support SET status_tindakan='BH', level_aduan='$level_aduan' WHERE id='$id'";
            $result = $conn->query($sql2) or die($conn->error);
            $sql2 = "UPDATE support_developer SET developer='$developer',level_developer='$level_aduan',remarks='$remarks', created_by='$created_by' WHERE id='$previous_dev' ";
            $result = $conn->query($sql2);
        }else if($status_tindakan !='TT' && $status_tindakan !='BH' && $status_tindakan != 'S'){
            $sql2 = "UPDATE support SET level_aduan='$level_aduan' WHERE id='$id'";
            $result = $conn->query($sql2) or die($conn->error);
        }
        return $result;
    }

    function addDeveloper($developer,$id){
        $conn=db();
        $sql = "UPDATE support SET developer='$developer' WHERE id='$id' ";
        $result = $conn->query($sql);
        return $result;
    }

    function addProgress($id_support,$tarikh,$catatan,$created_by_progress){
        $conn=db();
        $sql = "INSERT INTO progress (id_support,tarikh,catatan,created_by_progress) VALUES ('$id_support',STR_TO_DATE('$tarikh','%d/%m/%Y'),'$catatan','$created_by_progress') ";
        $result = $conn->query($sql);
        return $result;
    }

    function addLevel($level_aduan,$id){
        $conn=db();
        $sql = "UPDATE support SET level_aduan='$level_aduan' WHERE id='$id' ";
        $result = $conn->query($sql);
        return $result;
    }


    function updateSupportDeveloper($level_developer,$tarikh_mula,$tarikh_tamat,$jumlah_hari_siap,$status_tindakan,$catatan,$id_support_developer,$id){
        $conn=db();
        $sql = "UPDATE support_developer SET tarikh_mula=STR_TO_DATE('$tarikh_mula','%d/%m/%Y'), tarikh_tamat=STR_TO_DATE('$tarikh_tamat','%d/%m/%Y'), jumlah_hari_siap='$jumlah_hari_siap', catatan='$catatan', level_developer='$level_developer' WHERE id='$id_support_developer' ";
        $result = $conn->query($sql);
        $sql2="UPDATE support SET status_tindakan='$status_tindakan' WHERE id='$id' ";
        $result = $conn->query($sql2);
        return $result;
    }

    function updateSupportDeveloperTarikh($tarikh_mula,$tarikh_tamat,$jumlah_hari_siap,$catatan,$id){
        $conn=db();
        $sql = "UPDATE support_developer SET tarikh_mula=STR_TO_DATE('$tarikh_mula','%d/%m/%Y'), tarikh_tamat=STR_TO_DATE('$tarikh_tamat','%d/%m/%Y'), jumlah_hari_siap='$jumlah_hari_siap', catatan='$catatan' 
                WHERE id_support='$id' ";
        $result = $conn->query($sql);
        return $result;
    } 

    //EDIT 20191006
    function getNamaDeveloper($department_id){
        $conn=db();
        $sql="SELECT * FROM staff WHERE status='BEKERJA' AND role_id NOT IN ('ADMIN', 'SUPERADMIN','FOUNDER')";
        $result=$conn->query($sql);
        return $result; 
    }

    function getProduk(){
        $conn=db();
        $sql="SELECT * FROM produk ";
        $result=$conn->query($sql);
        return $result;
    }

    function getProjekSebutHarga(){
        $conn=db();
        $sql="SELECT * FROM pesanan_belian pb
              LEFT JOIN sebut_harga sh ON pb.id_sebut_harga = sh.id_sebut_harga";
        $result=$conn->query($sql);
        return $result;
    }

    function getCountSistemDeveloper($no_staff){
        $conn=db();
        $sql="SELECT pin.nama_projek AS tajuk_sebut_harga, COUNT(*) AS bilangan_projek, s.nama_projek, s.id,sd.developer FROM support s
              LEFT JOIN support_developer sd ON s.id=sd.id_support 
              LEFT JOIN staff st ON sd.developer=st.no_staff
              LEFT JOIN projek_internal pin ON s.nama_projek=pin.kod_projek
              WHERE sd.developer='$no_staff' AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
              GROUP BY pin.kod_projek";
        $result=$conn->query($sql);
        return $result;
    }

    function getLevel(){
        $conn=db();
        $sql="SELECT * FROM level_aduan_support ";
        $result=$conn->query($sql);
        return $result;
    }


    function getFAQ(){
        $conn=db();
        $sql="SELECT * FROM faq GROUP BY faq_produk";
        $result=$conn->query($sql);
        return $result;
    }

    function getFAQloop($faq_produk){
        $conn=db();
        $sql="SELECT * FROM faq WHERE faq_produk='$faq_produk'";
        $result=$conn->query($sql);
        return $result;
    }

    function getFAQlist(){
        $conn=db();
        $sql="SELECT * FROM faq";
        $result=$conn->query($sql);
        return $result;
    }


    function getFAQview($faq_produk){
        $conn=db();
        $sql="SELECT * FROM faq WHERE faq_produk='faq_produk' ";
        $result=$conn->query($sql);
        return $result;
    }


    function addFaq($faq_produk,$faq_title,$faq_answer){
        if(isset($_POST['faq_answer'])){
            $text= $_POST['faq_answer'];
            $conn=db();
            $sql = "INSERT INTO faq(faq_produk,faq_title,faq_answer) 
                    VALUES('$faq_produk','$faq_title', '$text')"; 
            $result = $conn->query($sql);
            return $result;

        }
    }

    function updateFaq($faq_produk,$faq_title,$faq_answer,$faq_id){
        $conn=db();
        $sql = "UPDATE faq SET faq_produk='$faq_produk', faq_title='$faq_title', faq_answer='$faq_answer' WHERE faq_id='$faq_id' ";
        $result = $conn->query($sql);
        return $result;
    }

    function getFAQid($faq_id){
        $conn=db();
        $sql="SELECT * FROM faq WHERE faq_id='$faq_id'";
        $result=$conn->query($sql);
        return $result;
    }

    function deleteFAQ($faq_id) {
        $conn=db();
        $sql = "DELETE FROM faq WHERE faq_id='$faq_id' ";
        $result = $conn->query($sql);
        return $result;
    }

    function getImgAduan($faq_id){
        $conn=db();
        $sql=" SELECT * FROM faq WHERE faq_id='$faq_id'";
        $result = $conn->query($sql);
        $default= $result-> fetch_assoc();
        echo '<img src="data:image/jpeg;base64,'.base64_encode( $default['document'] ).'" style="width: 350px; height: 350px;"/>';
    }

    function getNamaClient($id){
        $conn=db();
        $sql = "SELECT nama_client FROM support WHERE id='$id' ";
        $result = $conn->query($sql);
        return $result;
    }


    function getProgressList($id_progress){
        $conn=db();
        $sql="SELECT p.*,s.*, st.name AS oleh FROM progress p
              LEFT JOIN support s ON p.id_support=s.id
              LEFT JOIN staff st ON p.created_by_progress=st.no_staff
              WHERE p.id_support='$id_progress' AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
              ORDER BY p.created_date DESC";
        $result = $conn->query($sql);
        return $result;
    }

    function statusKelulusanSupport(){
        $conn=db();
        $sql="SELECT * FROM status_support WHERE CODE IN ('T','TT')";
        $result=$conn->query($sql);
        return $result;
    }

    function getcountStatusDeveloper($nama_projek,$no_staff){
        $conn=db();
        $sql = "SELECT COUNT(s.status_tindakan) AS countST ,pin.nama_projek AS tajuk_sebut_harga,ss.keterangan FROM support s
                LEFT JOIN support_developer sd ON s.id=sd.id_support
                LEFT JOIN projek_internal pin ON s.nama_projek=pin.kod_projek
                LEFT JOIN status_support ss ON s.status_tindakan = ss.code
                WHERE nama_projek='$nama_projek' AND  sd.developer='$no_staff' AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
                GROUP BY s.status_tindakan";
        $result = $conn->query($sql);
        return $result;
    }


    function getProgress($id_support){
        $conn=db();
        $sql = " SELECT * FROM progress pr WHERE id_support='$id_support'";
        $result = $conn->query($sql);
        return $result;
    }

    function getID(){
        $conn=db();
        $sql = " SELECT id FROM support ";
        $result = $conn->query($sql);
        return $result;
    }

    function getProgressView($id_support){
        $conn=db();
        $sql = "SELECT  st.name AS namadev, pin.nama_projek, sd.tarikh_mula,sd.tarikh_tamat, sp.nama_client, sd.id_support,sp.id,sp.notel FROM support sp
                LEFT JOIN support_developer sd ON sp.id=sd.id_support
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                LEFT JOIN progress p ON p.id_progress=sp.id
                WHERE sd.id_support='$id_support' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql);
        return $result;
    }

    function getNotificationStatus($status_tindakan){
    $conn=db();
    $sql="SELECT COUNT(noti_status) AS noti FROM support
          WHERE noti_status='1' AND status_tindakan='$status_tindakan' AND DATE_FORMAT(created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
    $n_status_1= $conn->query($sql)->fetch_object()->noti;
    return $n_status_1;
    }

    function getNotificationStatusST($status_tindakan){
        $conn=db();
        $sql="SELECT COUNT(noti_status) AS noti FROM support
              WHERE noti_status='1' AND status_tindakan='$status_tindakan' AND DATE_FORMAT(created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $n_status_1= $conn->query($sql)->fetch_object()->noti;
        return $n_status_1;
    }


    function getNotificationStatusDeveloper($status_tindakan,$no_staff){
        $conn=db();
        $sql="SELECT COUNT(s.noti_status) AS noti 
              FROM support s
              LEFT JOIN support_developer sd ON s.id=sd.id_support
              WHERE s.noti_status='1' AND sd.status_reassign='1' AND s.status_tindakan='$status_tindakan' AND sd.developer='$no_staff' AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $n_status_1= $conn->query($sql)->fetch_object()->noti;
        return $n_status_1;
    }


    function getNotificationStatusDeveloperBS($status_tindakan,$no_staff){
        $conn=db();
        $sql="SELECT COUNT(s.noti_status) AS noti FROM support s
              LEFT JOIN support_developer sd ON s.id=sd.id_support
              WHERE s.noti_status='1' AND s.status_tindakan='$status_tindakan' AND sd.status_reassign='1' AND sd.developer='$no_staff' AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $n_status_1= $conn->query($sql)->fetch_object()->noti;
        return $n_status_1;
    }

    function editProgress($tarikh,$catatan,$id_progress){
        $conn=db();
        $sql = "UPDATE progress SET tarikh='$tarikh', catatan='$catatan' WHERE id_progress='$id_progress'" ;
        $result = $conn->query($sql);
        return $result;
    }

    function ViewProgressUpdate($id_progress,$id){
        $conn=db();
        $sql = "SELECT  * FROM progress  WHERE id_progress='$id_progress' AND id_support='$id'" ;
        $result = $conn->query($sql);
        return $result;
    }


    function getReassign($id_support){
        $conn=db();
        $sql = "SELECT sp.*, st.name AS namadev, pin.nama_projek, sd.level_developer,sd.level_developer,sd.tarikh_mula,sd.tarikh_tamat,sd.jumlah_hari_siap,sd.id AS id_support_developer FROM support sp
                LEFT JOIN support_developer sd ON sp.id=sd.id_support
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                WHERE sd.id_support='$id_support' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql);
        return $result;
    }

    function getPrevDev($id_support){
        $conn=db();
        $sql = "SELECT st.name AS namadeveloper FROM  support_developer sd
                LEFT JOIN staff st ON sd.developer=st.no_staff
                WHERE sd.id_support='$id_support'";
        $result = $conn->query($sql);
        return $result;
    }

    //to diplay button for add or view Purchase Order
    function getDeveloperButton($id){
        $conn=db();
        $sql = "SELECT * FROM support_developer WHERE id_support='$id'";
        $result = $conn->query($sql);
        return $result;
    }


    function addMaklumBalas($client_feedback,$id){
        $conn=db();
        $sql = "UPDATE support SET client_feedback='$client_feedback'
                WHERE id='$id'";
        $result = $conn->query($sql);  
        return $result;
    }

    function getAnalisaStatus($nama_projek){
        $conn=db();
        $sql="SELECT COUNT(*) AS countx, ss.keterangan FROM support s
              LEFT JOIN status_support ss ON s.status_tindakan = ss.code
              WHERE nama_projek='$nama_projek'
              GROUP BY CONCAT(ss.keterangan) ";
        $result = $conn->query($sql);
        return $result;
    }

    function getBarChart(){
        $conn=db();
        $sql = "SELECT pin.nama_projek AS sistem,COUNT(status_tindakan) AS xcount FROM support sp
                LEFT JOIN support_developer sd ON sp.id=sd.id_support
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek  
                WHERE DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')     
                GROUP BY pin.nama_projek";
        $result = $conn->query($sql);
        return $result;
    }

    // ------------------------------9/10/2019 Updated by NIENA----------------------------------------------
    
    //dapatkan staff berdasarkan no_staff
    function getStaffByNoStaff($no_staff){
        $conn=db();
        $sql = "SELECT * FROM staff WHERE no_staff ='$no_staff' AND status='BEKERJA'";
        $result = $conn->query($sql);
        return $result;
    }
    //dapatkan maklumat aduan berdasarkan projek
    function getNamaSistem() {
        $conn=db();
        $sql = "SELECT pin.nama_projek,COUNT(*) AS bilangan_projek,pin.kod_projek, s.id FROM support s 
                LEFT JOIN projek_internal pin ON s.nama_projek = pin.kod_projek
                WHERE DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
                GROUP BY pin.kod_projek";
        $result = $conn->query($sql);
        return $result;
    }

    //dapatkan bilangan aduan berdasarkan projek
    function getCountSistem(){
        $conn=db();
        $sql="SELECT pin.nama_projek,COUNT(*) AS bilangan_projek,pin.kod_projek, s.id FROM support s 
                LEFT JOIN projek_internal pin ON s.nama_projek = pin.kod_projek
                WHERE DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
                GROUP BY pin.kod_projek";
        $result=$conn->query($sql);
        return $result;
    }

    //dapatkan bilangan aduan berdasarkan status tindakan
    function getcountStatus($kod_projek){
        $conn=db();
        $sql = "SELECT COUNT(s.status_tindakan) AS countST ,pin.nama_projek,ss.keterangan FROM support s 
                LEFT JOIN projek_internal pin ON s.nama_projek=pin.kod_projek
                LEFT JOIN status_support ss ON s.status_tindakan = ss.code 
                WHERE pin.kod_projek='$kod_projek' AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y') 
                GROUP BY s.status_tindakan";
        $result = $conn->query($sql);
        return $result;
    }

    //dapatkan bar chart maklumat aduan berdasarkan projek (start)
    function getSystem_report(){
        $conn=db();
        $sql = "SELECT pin.kod_projek AS sistem
                FROM support sp
                LEFT JOIN support_developer sd ON sp.id=sd.id_support
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek  
                GROUP BY pin.kod_projek";
        $result = $conn->query($sql);

        $txt_result="";
        $i=0;
        while ($row  = $result -> fetch_array()){
            if($i > 0) $txt_result .= ",";
            $txt_result .= "'".$row[0]."<br>".$row[1]."'";
            $i++;
        }
        //$conn->close();
        return $txt_result;
    }

    function getSupportStatus() {
        $conn=db();
        $sql = "SELECT DISTINCT(ss.keterangan) AS keterangan,s.status_tindakan FROM support s
                LEFT JOIN status_support ss ON s.status_tindakan = ss.code ";
        $result = $conn->query($sql);
        return $result;
    }

    function getCountSupportX() {
        $conn=db();
        $sql = "SELECT COUNT(*) AS xcount, ss.code, ss.keterangan, pin.nama_projek, pin.kod_projek
                FROM support s
                LEFT JOIN status_support ss ON s.status_tindakan = ss.code
                LEFT JOIN projek_internal pin ON s.nama_projek=pin.kod_projek
                GROUP BY pin.kod_projek";
        $result = $conn->query($sql);
        return $result;
    }

    function getCountSupportY($status_tindakan, $nama_projek) {
        $conn=db();
        $sql = "SELECT COUNT(status_tindakan) AS xcount FROM support s
                LEFT JOIN projek_internal pin ON s.nama_projek=pin.kod_projek
                WHERE s.status_tindakan='$status_tindakan' AND pin.kod_projek='$nama_projek'";
        $result=$conn->query($sql)->fetch_object()->xcount;
        return $result;
    }
    //dapatkan bar chart maklumat aduan berdasarkan projek (end)
    
    //dapatkan maklumat mingguan aduan
    function getWeekAduanAll($start_week,$end_week){
        $conn=db();
        $sql = "SELECT COUNT(s.status_tindakan) AS countTotalWeek
                FROM support s WHERE (date_format(s.created_date,'%Y-%m-%d') BETWEEN DATE_FORMAT('$start_week','%Y-%m-%d') AND DATE_FORMAT('$end_week','%Y-%m-%d'));";
        $result=$conn->query($sql)->fetch_object()->countTotalWeek;
        return $result;
    }
    
    //dapatkan maklumat bulanan aduan
    function getTotalAduanBulan($bulan){
        $conn=db();
        $sql = "SELECT COUNT(s.status_tindakan) AS countTotalBulan
                FROM support s 
                WHERE DATE_FORMAT(s.created_date,'%Y%m') = '$bulan'";
        $result=$conn->query($sql)->fetch_object()->countTotalBulan;
        return $result;
    }
    
    //dapatkan maklumat tahunan aduan
    function getTotalAduanTahunAll($tahun){
        $conn=db();
        $sql = "SELECT COUNT(s.status_tindakan) AS countTotalTahun 
                FROM support s WHERE YEAR(s.created_date) = '$tahun' ";
        $result=$conn->query($sql)->fetch_object()->countTotalTahun;
        return $result;
    }

    //dapatkan maklumat aduan berdasarkan projek
    function getSupportNamaProjek($kod_projek) {
        $conn=db();
        $sql = "SELECT pin.nama_projek,COUNT(*) AS bilangan_projek,pin.kod_projek FROM support s 
                LEFT JOIN projek_internal pin ON s.nama_projek = pin.kod_projek
                WHERE pin.kod_projek='$kod_projek' AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
                GROUP BY pin.kod_projek";
        $result = $conn->query($sql);
        return $result;
    }

    //dapatkan bilangan aduan projek berdasarkan status
    function getAduanProjectByStatus($kod_projek, $status){
        $conn=db();
        $sql = "SELECT COUNT(status_tindakan) AS countTotal
                FROM support WHERE status_tindakan='$status' 
                AND nama_projek='$kod_projek' AND DATE_FORMAT(created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result=$conn->query($sql)->fetch_object()->countTotal;
        return $result;
    }

    function getTotalAduan($kod_projek){
        $conn=db();
        $sql = "SELECT COUNT(status_tindakan) AS countTotal FROM support
                WHERE nama_projek='$kod_projek' AND DATE_FORMAT(created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql)->fetch_object()->countTotal;
        return $result;
    }

    function getTotalAduanSelesai($kod_projek){
        $conn=db();
        $sql = "SELECT COUNT(status_tindakan) AS countTotalSelesai  FROM support  
                WHERE status_tindakan='S' AND nama_projek='$kod_projek' AND DATE_FORMAT(created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql)->fetch_object()->countTotalSelesai;
        return $result;
    }

    function getTotalAduanSemakanTerakhir($kod_projek){
        $conn=db();
        $sql = "SELECT COUNT(status_tindakan) AS countTotalST FROM support 
                WHERE status_tindakan='ST' AND nama_projek='$kod_projek' AND DATE_FORMAT(created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql)->fetch_object()->countTotalST;
        return $result;
    }

    function getTotalAduanDalamProses($kod_projek){
        $conn=db();
        $sql = "SELECT COUNT(status_tindakan) AS countTotalT FROM support 
                WHERE status_tindakan='SP' AND nama_projek='$kod_projek' AND DATE_FORMAT(created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql)->fetch_object()->countTotalT;
        return $result;
    }

    function getTotalAduanDalamPenerimaan($kod_projek){
        $conn=db();
        $sql = "SELECT COUNT(status_tindakan) AS countTotalDalamPenerimaan FROM support 
                WHERE status_tindakan='DP' AND nama_projek='$kod_projek' AND DATE_FORMAT(created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql)->fetch_object()->countTotalDalamPenerimaan;
        return $result;
    }

    function getTotalAduanBaharu($kod_projek){
        $conn=db();
        $sql = "SELECT COUNT(status_tindakan) AS countTotalBaharu FROM support
                WHERE status_tindakan='BH' AND nama_projek='$kod_projek' AND DATE_FORMAT(created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql)->fetch_object()->countTotalBaharu;
        return $result;
    }

    //dapatkan maklumat bulanan aduan berdasarkan projek
    function getWeekAduan($start_week,$end_week,$kod_projek){
        $conn=db();
        $sql = "SELECT COUNT(status_tindakan) AS countTotalWeek
                FROM support WHERE (date_format(created_date,'%Y-%m-%d') BETWEEN DATE_FORMAT('$start_week','%Y-%m-%d') AND DATE_FORMAT('$end_week','%Y-%m-%d'))AND nama_projek='$kod_projek'";
        $result=$conn->query($sql)->fetch_object()->countTotalWeek;
        return $result;
    }

    //dapatkan maklumat bulanan aduan berdasarkan projek
    function getTotalAduanByMonth($bulan, $kod_projek){
        $conn=db();
        $sql = "SELECT COUNT(s.status_tindakan) AS countTotalBulan
                FROM support s 
                WHERE DATE_FORMAT(s.created_date,'%Y%m') = '$bulan' AND nama_projek='$kod_projek' ";
        $result=$conn->query($sql)->fetch_object()->countTotalBulan;
        return $result;
    }
    
    //dapatkan maklumat tahunan aduan berdasarkan projek

    function getTotalAduanTahun($tahun,$kod_projek){
        $conn=db();
        $sql = "SELECT COUNT(s.status_tindakan) AS countTotalTahun 
                FROM support s WHERE YEAR(s.created_date) = '$tahun' AND nama_projek='$kod_projek' ";
        $result=$conn->query($sql)->fetch_object()->countTotalTahun;
        return $result;
    }

    //dapatkan bar chart maklumat aduan projek berdasarkan status
    function getAduanStatusByProject($kod_projek){
        $conn=db();
        $sql = "SELECT COUNT(*) AS countx, ss.keterangan
                FROM support s
                LEFT JOIN status_support ss ON s.status_tindakan = ss.code
                WHERE s.nama_projek='$kod_projek' AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
                GROUP BY CONCAT(ss.keterangan) ";
        $result = $conn->query($sql);
        return $result;
    }

    //dapatkan senarai projek dalam projek_internal
    function getProjectList(){
        $conn=db();
        $sql="SELECT * FROM projek_internal WHERE kod_projek_parent=''";
        $result=$conn->query($sql);
        return $result;
    }

    //dapatkan senarai projek bagi developer
    function getAduanByDeveloper($no_staff){
        $conn=db();
        $sql="SELECT COUNT(*) AS bilangan_projek, pin.kod_projek, pin.nama_projek, s.id, sd.developer FROM support s
              LEFT JOIN support_developer sd ON s.id=sd.id_support 
              LEFT JOIN staff st ON sd.developer=st.no_staff
              LEFT JOIN projek_internal pin ON s.nama_projek=pin.kod_projek
              WHERE sd.developer='$no_staff' AND sd.status_reassign='1' AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
              GROUP BY pin.kod_projek";
        $result=$conn->query($sql);
        return $result;
    }

    //dapatkan bilangan aduan projek bagi developer
    function getAduanStatusByDeveloper($kod_projek,$no_staff){
        $conn=db();
        $sql = "SELECT COUNT(s.status_tindakan) AS countST,pin.nama_projek,pin.kod_projek,ss.keterangan,ss.code
                FROM support s
                LEFT JOIN support_developer sd ON s.id=sd.id_support
                LEFT JOIN projek_internal pin ON s.nama_projek=pin.kod_projek
                LEFT JOIN status_support ss ON s.status_tindakan = ss.code
                WHERE s.nama_projek='$kod_projek' AND sd.status_reassign='1' AND  sd.developer='$no_staff' AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
                GROUP BY s.status_tindakan";
        $result = $conn->query($sql);
        return $result;
    }

    //dapatkan maklumat staff berdasarkan no staff
    function getDeveloperByNoStaff($no_staff){
        $conn=db();
        $sql = "SELECT * FROM staff WHERE status = 'BEKERJA' AND no_staff='$no_staff'";
        $result = $conn->query($sql);
        return $result;
    }

    //dapatkan bilangan aduan projek developer
    function getCountAduanByDeveloper($kod_projek,$no_staff){
        $conn=db();
        $sql = "SELECT COUNT(s.status_tindakan) AS countST,pin.nama_projek,pin.kod_projek
                FROM support s
                LEFT JOIN support_developer sd ON s.id=sd.id_support
                LEFT JOIN projek_internal pin ON s.nama_projek=pin.kod_projek
                LEFT JOIN status_support ss ON s.status_tindakan = ss.code
                WHERE s.nama_projek='$kod_projek' AND  sd.developer='$no_staff' AND sd.status_reassign='1' AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y') ";
        $result = $conn->query($sql)->fetch_object()->countST;
        return $result;
    }

    //dapatkan bilangan status aduan projek developer
    function getAduanProjectStatusByDeveloper($no_staff,$kod_projek, $status){
        $conn=db();
        $sql = "SELECT COUNT(status_tindakan) AS countTotal FROM support s
                LEFT JOIN support_developer sd ON s.id=sd.id_support 
                WHERE s.status_tindakan='$status' AND s.nama_projek='$kod_projek' AND sd.developer='$no_staff' AND sd.status_reassign='1' AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y') ";
        $result=$conn->query($sql)->fetch_object()->countTotal;
        return $result;
    }

    //dapatkan maklumat bulanan aduan berdasarkan projek
    function getWeeklyProjectByDeveloper($no_staff, $start_week,$end_week,$kod_projek){
        $conn=db();
        $sql = "SELECT COUNT(s.status_tindakan) AS countTotalWeek FROM support s 
                LEFT JOIN support_developer sd ON s.id=sd.id_support 
                WHERE (date_format(s.created_date,'%Y-%m-%d') BETWEEN DATE_FORMAT('$start_week','%Y-%m-%d') AND DATE_FORMAT('$end_week','%Y-%m-%d')) AND nama_projek='$kod_projek' AND sd.developer='$no_staff' AND sd.status_reassign='1' ";
        $result=$conn->query($sql)->fetch_object()->countTotalWeek;
        return $result;
    }

    //dapatkan maklumat bulanan aduan berdasarkan projek
    function getMonthlyProjectByDeveloper($no_staff, $bulan, $kod_projek){
        $conn=db();
        $sql = "SELECT COUNT(s.status_tindakan) AS countTotalBulan FROM support s 
                LEFT JOIN support_developer sd ON s.id=sd.id_support 
                WHERE DATE_FORMAT(s.created_date,'%Y%m') = '$bulan' AND nama_projek='$kod_projek' AND sd.developer='$no_staff' AND sd.status_reassign='1' ";
        $result=$conn->query($sql)->fetch_object()->countTotalBulan;
        return $result;
    }
    
    //dapatkan maklumat tahunan aduan berdasarkan projek
    function getAnnualProjectByDeveloper($no_staff, $tahun, $kod_projek){
        $conn=db();
        $sql = "SELECT COUNT(s.status_tindakan) AS countTotalTahun FROM support s 
                LEFT JOIN support_developer sd ON s.id=sd.id_support 
                WHERE YEAR(s.created_date) = '$tahun' AND nama_projek='$kod_projek' AND sd.developer='$no_staff' AND sd.status_reassign='1' ";
        $result=$conn->query($sql)->fetch_object()->countTotalTahun;
        return $result;
    }

    //dapatkan bar chart maklumat aduan projek developer berdasarkan status
    function getAduanStatusByProjectDeveloper($no_staff,$kod_projek){
        $conn=db();
        $sql = "SELECT COUNT(*) AS countx, ss.keterangan
                FROM support s
                LEFT JOIN status_support ss ON s.status_tindakan = ss.code
                LEFT JOIN support_developer sd ON s.id = sd.id_support
                WHERE s.nama_projek='$kod_projek' AND sd.developer='$no_staff' AND sd.status_reassign='1' AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
                GROUP BY CONCAT(ss.keterangan) ";
        $result = $conn->query($sql);
        return $result;
    }

    //senarai maklumat aduan mengikut status


    //dapatkan nilai aduan berdasarkan id
    function getSupportUpdate($id){
        $conn=db();
        $sql = "SELECT sd.id AS id_support_developer, sp.*,pin.nama_projek, sd.catatan As catatan,sp.client_feedback, sd.developer, sd.level_developer,sp.status_tindakan, sd.remarks FROM support sp
                LEFT JOIN support_developer sd ON sp.id=sd.id_support
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek = pin.kod_projek 
                WHERE sp.id='$id' AND sd.status_reassign='1' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql);
        return $result;
    }

    function getSupportView($id){
        $conn=db();
        $sql = "SELECT sp.*,pin.nama_projek, sd.catatan As catatan,sp.client_feedback, sd.developer, sd.level_developer, sd.remarks FROM support sp
                LEFT JOIN support_developer sd ON sp.id=sd.id_support
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN projek_internal pin ON sp.nama_projek = pin.kod_projek 
                WHERE sp.id='$id' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql);
        return $result;
    }

    function getSupportBelumSah(){
        $conn=db();
        $sql = "SELECT sp.*, st.name AS namadev, sd.tarikh_mula, sd.tarikh_tamat,pin.kod_projek, pin.nama_projek,sd.developer,sd.level_developer,sd.id_support,las.keterangan, sd.id AS id_support_developer FROM support sp
                    LEFT JOIN support_developer sd ON sp.id=sd.id_support
                    LEFT JOIN staff st ON sd.developer=st.no_staff
                    LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                    LEFT JOIN level_aduan_support las ON sp.level_aduan=las.level
                    WHERE (sp.status_tindakan='BH' OR sp.status_tindakan='TT') AND (sd.status_reassign='1' OR sd.status_reassign IS NULL) AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
                    GROUP BY sp.id ORDER BY sp.created_date DESC";
        $result = $conn->query($sql) or die($conn->error);
        return $result;

    }

    function getSupportMaklumBalas($id){
        $conn=db();
        $sql = "SELECT sp.*, st.name AS namadev, sd.tarikh_mula, sd.tarikh_tamat,pin.kod_projek, pin.nama_projek,sd.id_support,sd.level_developer, ss.keterangan FROM support sp
                LEFT JOIN support_developer sd ON sp.id=sd.id_support
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN status_support ss ON sp.status_tindakan = ss.code
                LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                WHERE sp.id='$id'";
        $result = $conn->query($sql);
        return $result;
    }

    //dapatkan senarai aduan
    function getAduanList($nokp, $notel){
        $conn=db();
        $sql = "SELECT s.*, pin.nama_projek, ss.keterangan, sd.id AS id_support_developer FROM support s
                LEFT JOIN projek_internal pin ON s.nama_projek=pin.kod_projek
                LEFT JOIN status_support ss ON s.status_tindakan = ss.code
                LEFT JOIN support_developer sd ON s.id = sd.id_support  
                WHERE s.created_by='$nokp' OR s.notel = '$notel' AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
                order by pin.kod_projek ASC";
        $result=$conn->query($sql);
        return $result;
    }

    function batalAduan($id_support_developer,$id){
        $conn=db();
        $sql = "UPDATE support SET status_tindakan='C', noti_status='0'
                WHERE id='$id'";
        $result = $conn->query($sql);
        return $result;
    }

    function rateAduanDeveloper($id_support_developer,$level_developer){
        $conn=db();
        $sql = "UPDATE support_developer SET level_developer='$level_developer'
                WHERE id='$id_support_developer'";
        $result = $conn->query($sql);
        return $result;
    }

    //separate the long feedback into each developer
    function separate_support($nama_projek,$support_parent,$nama_client,$notel,$level_aduan,$developer,$remarks,$shortcode,$created_by,$staff_created,$comments){
        $conn=db();
        $sql = "UPDATE support SET noti_status='0' WHERE norujukan_support='$support_parent'";
        $result = $conn->query($sql);
        $sql = "INSERT INTO support(nama_projek,support_parent,nama_client,aduan,notel,status_tindakan,norujukan_support,created_by,level_aduan,noti_status) 
                VALUES('$nama_projek','$support_parent','$nama_client','$remarks','$notel','BH',(SELECT CONCAT('$shortcode','/','ADN','/',YEAR(CURRENT_TIMESTAMP),'/',
                LPAD(IFNULL(MAX(a.id), 0) + 1, 4, '0')) AS norujukan_support 
                FROM support a ),'$created_by','$level_aduan','1')";
        $result = $conn->query($sql);
        $id_support = $conn->insert_id;
        $sql = "INSERT INTO support_developer(id_support, level_developer, developer, status_reassign, created_by, remarks) VALUES ('$id_support','$level_aduan','$developer','1','$staff_created','$comments') ";
        $result = $conn->query($sql) or die($conn->error);
        return $result;
    }

    //get the reason of rejecting the feedback
    function getCatatanTolak($id){
        $conn=db();
        $sql = "SELECT * FROM support_developer WHERE id='$id'";
        $result = $conn->query($sql);
        return $result;
    }

    //get the number of feedback based on status of feedback progress
    function getCountByStatus($no_staff, $status){
        $conn=db();
        if($no_staff==''){
            $sql = "SELECT COUNT(*) AS nilai FROM support s
                    WHERE s.status_tindakan='$status' AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        }else{
            $sql = "SELECT COUNT(*) AS nilai FROM support s
                    LEFT JOIN support_developer sd ON s.id=sd.id_support
                    WHERE sd.developer='$no_staff' AND s.status_tindakan='$status' AND sd.status_reassign='1' AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        }
        $result=$conn->query($sql)->fetch_object()->nilai;
        return $result;
    }

    //get the number of rejected task by each developer
    function getCountRejected($no_staff,$kod_projek){
        $conn=db();
        if($no_staff=='' && $kod_projek==''){
            $sql = "SELECT COUNT(*) AS nilai FROM support_developer sd
                    LEFT JOIN support s ON sd.id_support=s.id
                    WHERE (sd.status_reassign='0' OR s.status_tindakan='TT') AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        }else if($no_staff !='' && $kod_projek == ''){
            $sql = "SELECT COUNT(*) AS nilai FROM support_developer sd
                    LEFT JOIN support s ON sd.id_support=s.id
                    WHERE sd.developer='$no_staff' AND (sd.status_reassign='0' OR s.status_tindakan='TT') AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        }else if($no_staff !='' && $kod_projek != ''){
           $sql = "SELECT COUNT(*) AS nilai FROM support_developer sd
                    LEFT JOIN support s ON sd.id_support=s.id
                    LEFT JOIN projek_internal pin ON s.nama_projek=pin.kod_projek
                    WHERE sd.developer='$no_staff' AND pin.kod_projek='$kod_projek' AND (sd.status_reassign='0' OR s.status_tindakan='TT') AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        }else if($no_staff =='' && $kod_projek!=''){
            $sql = "SELECT COUNT(*) AS nilai FROM support_developer sd
                    LEFT JOIN support s ON sd.id_support=s.id
                    LEFT JOIN projek_internal pin ON s.nama_projek=pin.kod_projek
                    WHERE pin.kod_projek='$kod_projek' AND (sd.status_reassign='0' OR s.status_tindakan='TT') AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        }
        $result=$conn->query($sql)->fetch_object()->nilai;
        return $result;
    }

    function getCountBaharu(){
        $conn=db();
        $sql = "SELECT COUNT(*) AS bilangan FROM support sp
                WHERE (sp.status_tindakan='BH' OR sp.status_tindakan='TT') AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')";
        $result = $conn->query($sql)->fetch_object()->bilangan;
        return $result;

    }


    //get number of task handled by developer for today
    function getCountByCurDate($no_staff) {
        $conn=db();
        if($no_staff==''){
            $sql = "SELECT COUNT(*) AS nilai FROM support s
                    LEFT JOIN support_developer sd ON s.id=sd.id_support
                    WHERE s.status_tindakan='S' AND (sd.status_reassign='1' OR sd.status_reassign IS NULL) AND DATE_FORMAT(s.created_date,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
        }else{
            $sql = "SELECT COUNT(*) AS nilai FROM support s
                    LEFT JOIN support_developer sd ON s.id=sd.id_support
                    WHERE s.status_tindakan='S' AND (sd.status_reassign='1' OR sd.status_reassign IS NULL) AND sd.developer='$no_staff'
                    AND DATE_FORMAT(s.created_date,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
        }
        $result=$conn->query($sql)->fetch_object()->nilai;
        return $result;
    }

    //get number of task handled by developer for current week
    function getCountByCurWeek($no_staff) {
        $conn=db();
        if($no_staff==''){
            $sql = "SELECT COUNT(*) AS nilai FROM support s
                    LEFT JOIN support_developer sd ON s.id=sd.id_support
                    WHERE s.status_tindakan='S' AND (sd.status_reassign='1' OR sd.status_reassign IS NULL) AND DATE_FORMAT(s.created_date,'%V') = DATE_FORMAT(CURRENT_TIMESTAMP,'%V')";
        }else{
            $sql = "SELECT COUNT(*) AS nilai FROM support s
                    LEFT JOIN support_developer sd ON s.id=sd.id_support
                    WHERE s.status_tindakan='S' AND sd.developer='$no_staff' AND (sd.status_reassign='1' OR sd.status_reassign IS NULL)
                    AND DATE_FORMAT(s.created_date,'%V') = DATE_FORMAT(CURRENT_TIMESTAMP,'%V')";
        }
        $result=$conn->query($sql)->fetch_object()->nilai;
        return $result;
    }

    //get number of task handled by developer for current month
    function getCountByCurMonth($no_staff) {
        $conn=db();
        if($no_staff==''){
            $sql = "SELECT COUNT(*) AS nilai FROM support s
                    LEFT JOIN support_developer sd ON s.id=sd.id_support
                    WHERE s.status_tindakan='S' AND (sd.status_reassign='1' OR sd.status_reassign IS NULL) AND DATE_FORMAT(s.created_date,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')";
        }else{
            $sql = "SELECT COUNT(*) AS nilai FROM support s
                    LEFT JOIN support_developer sd ON s.id=sd.id_support
                    WHERE s.status_tindakan='S' AND (sd.status_reassign='1' OR sd.status_reassign IS NULL) AND sd.developer='$no_staff'
                    AND DATE_FORMAT(s.created_date,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')";
        }
        $result=$conn->query($sql)->fetch_object()->nilai;
        return $result;
    }

    ////get number of task handled by developer for current year
    function getCountByCurYear($no_staff) {
        $conn=db();
        if($no_staff==''){
            $sql = "SELECT COUNT(*) AS nilai FROM support s
                    LEFT JOIN support_developer sd ON s.id=sd.id_support
                    WHERE s.status_tindakan='S' AND (sd.status_reassign='1' OR sd.status_reassign IS NULL) AND DATE_FORMAT(s.created_date,'%Y') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')";
        }else{
            $sql = "SELECT COUNT(*) AS nilai FROM support s
                    LEFT JOIN support_developer sd ON s.id=sd.id_support
                    WHERE s.status_tindakan='S' AND (sd.status_reassign='1' OR sd.status_reassign IS NULL) AND sd.developer='$no_staff'
                    AND DATE_FORMAT(s.created_date,'%Y') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')";
        }
        $result=$conn->query($sql)->fetch_object()->nilai;
        return $result;
    }

    //clicking analisa
    function getBilanganAduanByDay($date,$no_staff,$status_tindakan) {
        $conn=db();
        if($no_staff ==''){
            $sql = "SELECT COUNT(*) AS bil_task FROM support s
                    WHERE DATE_FORMAT('$date','%Y-%m-%d') = DATE_FORMAT(s.created_date,'%Y-%m-%d') AND s.status_tindakan='$status_tindakan'";
        }else if($no_staff != ''){
            $sql = "SELECT COUNT(*) AS bil_task FROM support s
                    LEFT JOIN support_developer sd ON s.id=sd.id_support
                    WHERE DATE_FORMAT('$date','%Y-%m-%d') = DATE_FORMAT(s.created_date,'%Y-%m-%d') AND sd.developer='$no_staff' AND s.status_tindakan='$status_tindakan' AND sd.status_reassign='1' ";
        }
        $result=$conn->query($sql)->fetch_object()->bil_task;
        return "<b><font size='3'>".$result."</font></b>";
        
    }

    function getBilanganAduanByWeek($start,$end,$no_staff,$status_tindakan) {
        $conn=db();
        if($no_staff ==''){
            $sql = "SELECT COUNT(*) AS bil_task FROM support s
                    WHERE (date_format(s.created_date,'%Y-%m-%d') BETWEEN DATE_FORMAT('$start','%Y-%m-%d') AND DATE_FORMAT('$end','%Y-%m-%d')) AND s.status_tindakan='$status_tindakan'";
        }else if($no_staff != ''){
            $sql = "SELECT COUNT(*) AS bil_task FROM support s
                    LEFT JOIN support_developer sd ON s.id=sd.id_support
                    WHERE (date_format(s.created_date,'%Y-%m-%d') BETWEEN DATE_FORMAT('$start','%Y-%m-%d') AND DATE_FORMAT('$end','%Y-%m-%d')) AND sd.developer='$no_staff' AND s.status_tindakan='$status_tindakan' AND sd.status_reassign='1'";
        }
        $result=$conn->query($sql)->fetch_object()->bil_task;
        return "<b><font size='3'>".$result."</font></b>";
    }

    function getBilanganAduanByMonth($value,$no_staff,$status_tindakan) {
        $conn=db();
        if($no_staff ==''){
            $sql = "SELECT COUNT(*) AS bil_task FROM support s
                    WHERE date_format(s.created_date,'%Y%m')='$value' AND s.status_tindakan='$status_tindakan'";
        }else if($no_staff != ''){
            $sql = "SELECT COUNT(*) AS bil_task FROM support s
                    LEFT JOIN support_developer sd ON s.id=sd.id_support
                    WHERE date_format(s.created_date,'%Y%m')='$value' AND sd.developer='$no_staff' AND s.status_tindakan='$status_tindakan' AND sd.status_reassign='1' ";
        }
        $result=$conn->query($sql)->fetch_object()->bil_task;
        return "<b><font size='3'>".$result."</font></b>";
    }

    function getBilanganAduanByYear($value,$no_staff,$status_tindakan) {
        $conn=db();
        if($no_staff ==''){
            $sql = "SELECT COUNT(*) AS bil_task FROM support s
                    WHERE date_format(s.created_date,'%Y')='$value' AND s.status_tindakan='$status_tindakan'";
        }else if($no_staff != ''){
            $sql = "SELECT COUNT(*) AS bil_task FROM support s
                    LEFT JOIN support_developer sd ON s.id=sd.id_support
                    WHERE date_format(s.created_date,'%Y')='$value' AND sd.developer='$no_staff' AND s.status_tindakan='$status_tindakan' AND sd.status_reassign='1'";
        }
        $result=$conn->query($sql)->fetch_object()->bil_task;
        return "<b><font size='3'>".$result."</font></b>";
    }

    //end analisa

    function getSupportById($id){
        $conn=db();
        $sql = "SELECT * FROM support WHERE id='$id'";
        $result = $conn->query($sql);
        return $result;
    }

    //dapatkan developer sebelum ini
    function getListSupportDeveloper($id){
        $conn=db();
        $sql = "SELECT *, count(sd.id) AS nom FROM support_developer sd
                LEFT JOIN staff st ON sd.developer=st.no_staff
                LEFT JOIN support s ON sd.id_support=s.id
                WHERE (sd.status_reassign='0' OR s.status_tindakan='TT') AND s.id='$id' AND DATE_FORMAT(s.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
                GROUP BY sd.developer";
        $result = $conn->query($sql);
        return $result;
    }

    function getListRejected($no_staff){
        $conn=db();
        if($no_staff ==''){
            $sql = "SELECT *, COUNT(*) AS bil FROM support_developer sd
                    LEFT JOIN staff st ON sd.developer=st.no_staff
                    LEFT JOIN support sp ON sd.id_support=sp.id
                    LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                    WHERE (sd.status_reassign='0' OR sp.status_tindakan='TT') AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
                    GROUP BY sp.id";
        }else if($no_staff != ''){
            $sql = "SELECT *, COUNT(*) AS bil FROM support_developer sd
                    LEFT JOIN staff st ON sd.developer=st.no_staff
                    LEFT JOIN support sp ON sd.id_support=sp.id
                    LEFT JOIN projek_internal pin ON sp.nama_projek=pin.kod_projek
                    WHERE (sd.status_reassign='0' OR sp.status_tindakan='TT') AND sd.developer='$no_staff' AND DATE_FORMAT(sp.created_date,'%Y')=DATE_FORMAT(CURRENT_DATE,'%Y')
                    GROUP BY sp.id";
        }
        $result = $conn->query($sql);
        return $result; 
    }

    function getSupportDetails($id){
        $conn=db();
        $sql = "SELECT s.*, pin.nama_projek, pin.kod_projek FROM support s
                LEFT JOIN projek_internal pin ON s.nama_projek=pin.kod_projek
                WHERE id='$id'";
        $result = $conn->query($sql);
        return $result;
    }

    function getSubSupportList($norujukan_support){
        $conn=db();
        $sql = "SELECT ss.*, s.* FROM support s
                LEFT JOIN status_support ss ON s.status_tindakan=ss.code
                WHERE s.support_parent='$norujukan_support'";
        $result = $conn->query($sql);
        return $result;
    }

    function getParentSub($norujukan_support){
        $conn=db();
        $sql = "SELECT s.*, pin.* FROM support s
                LEFT JOIN projek_internal pin ON s.nama_projek=pin.kod_projek
                WHERE s.norujukan_support='$norujukan_support'";
        $result = $conn->query($sql);
        return $result;
    }

    $conn->close();

?>