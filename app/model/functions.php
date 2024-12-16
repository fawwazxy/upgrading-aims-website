<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
require '../../lib/db/connection.php';

$action = $_POST['action'];
if($action == "moduleAdd"){
    $module_code = $_POST['module_code'];
    $module = $_POST['module'];
    $module_id = $_POST['module_id'];
    $conn=db();

    if($module_id > 0 ){
        $sql = "update sec_module set module_code=upper('$module_code'),module=upper('$module') 
			where id='$module_id' ";
        $result = $conn->query($sql) or die($conn->error);
        echo "Data berjaya diproses";
    }else{
        $sqlid = "select count(id) as count from sec_module where module_code = '$module_code' ";
        $count = $conn->query($sqlid)->fetch_object()->count;

        if($count == 0){
            $sql = "insert into sec_module (module_code,module) 
				values(upper('$module_code'),upper('$module'))";
            $result = $conn->query($sql) or die($conn->error);
            echo "Data berjaya diproses";
        }else{
            echo "Data telah wujud!";
        }

    }


    //return $result;

}


// Function to sanitize values received from the form. Prevents SQL injection
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

function getCompanyDetails($sys_id) {
    $conn=db();
    $sql = "SELECT * FROM company WHERE sys_id='$sys_id'";
    $result = $conn->query($sql);
    return $result;
}

function login($username) {
    $conn=db();
    $sql = "SELECT * FROM staff WHERE username='$username' AND status='BEKERJA'";
    return $conn->query($sql);
}

function getLogUser($com_id) {
    $conn=db();
    $sql = "SELECT * FROM staff WHERE company_id='$com_id'";
    $result = $conn->query($sql);
    return $result;
}

function getPicture() {
    $conn=db();
    $sql = "SELECT * FROM tbl_images ORDER BY id DESC";
    $result = $conn->query($sql);
    return $result;
}


function addPicture() {
    $conn=db();
    $sql = "INSERT INTO staff(photo) 
        VALUES('photo')";
    $result = $conn->query($sql);
    return $result;
}

function carianRentas($itemtofind) {
    $conn=db();
    $sql_search = "select * from carian_rentas_view where ";

    $sqlcols = "SHOW COLUMNS FROM carian_rentas_view";

    $resultcols = $conn->query($sqlcols);
    $sql_search_fields = Array();
    while ($r = $resultcols->fetch_array()) {
        $colum = $r[0];
        $sql_search_fields[] = $colum . " like('%" . $itemtofind . "%')";
    }

    if($itemtofind == ""){
        $sql_search .= "id_rentas = '-xxxxx9999xxxx'";
    }else{
        $sql_search .= implode(" OR ", $sql_search_fields);
    }


    $result = $conn->query($sql_search) or die($conn->error);


    return $result;
}

function getModule() {
    $conn=db();
    $sql = "SELECT * FROM sec_module ORDER BY susunan ASC";
    $result = $conn->query($sql);
    return $result;
}

function getModuleMenu($module_code) {
    if($module_code != ""){
        $module_code = "AND module_code = '$module_code'";
    }
    $conn=db();
    $sql = "SELECT * FROM sec_module_menu WHERE status IN (1,0) $module_code ORDER BY module_code ASC";
    return $conn->query($sql);
}

function getModuleMenuAktif($role_code) {
    $conn=db();
    $sql = "SELECT scm.*,srm.role_code,srm.access_menu,srm.views,srm.edits,srm.adds,srm.deletes FROM sec_module_menu scm
		left join sec_role_menu srm on scm.id=srm.menu_id  AND srm.access_menu=1 
		AND srm.role_code='$role_code'
		WHERE scm.status=1 ORDER BY scm.module_code,scm.menu ASC";
    $result = $conn->query($sql);
    return $result;
}

function getMaxSusunan() {
    $conn=db();
    $sql = "SELECT max(susunan)+1 as susunan FROM sec_module_menu";
    $result = $conn->query($sql) or die($conn->error);
    return $result->fetch_object()->susunan;
}

function menuAddEdit($id,$module_code,$menu,$susunan,$link,$status,$new_tab){
    $conn=db();
    $sql = "INSERT INTO sec_module_menu (module_code,menu,susunan,link,status,new_tab) 
		values ('$module_code','$menu','$susunan','$link','$status','$new_tab')";

    if($id > 0){
        $sql = "UPDATE sec_module_menu set module_code='$module_code',menu='$menu',
			susunan='$susunan',link='$link',status='$status', new_tab = '$new_tab' WHERE id='$id' ";
    }

    $result = $conn->query($sql) or die($conn->error);
    return $result;
}

function roleAddEdit($role_code,$menu_id){
    $conn=db();
    $sql = "SELECT id FROM sec_role_menu WHERE role_code='$role_code' AND menu_id='$menu_id' limit 1";
    $role_menu_id = $conn->query($sql)->fetch_object()->id;

    $sql_menu = "";
    if($role_menu_id != "" && $role_menu_id > 0){
        $sql_menu = "UPDATE sec_role_menu set access_menu='1' WHERE id='$role_menu_id' ";
    }else{
        $sql_menu = "INSERT INTO sec_role_menu (role_code,menu_id,access_menu) 
			values ('$role_code','$menu_id','1')";
    }

    //echo $sql_menu."<br>";
    $result = $conn->query($sql_menu) or die($conn->error);
    return $result;
}

function roleAccessInactive($role_code){
    $conn=db();
    $sql = "UPDATE sec_role_menu set access_menu='0' WHERE role_code='$role_code'";

    $result = $conn->query($sql) or die($conn->error);
    return $result;
}

function rolePermission($role_code,$menu_id,$columnname){
    $conn=db();
    $sql = "SELECT id FROM sec_role_menu WHERE role_code='$role_code' AND menu_id='$menu_id' limit 1";
    $role_menu_id = $conn->query($sql)->fetch_object()->id;

    $sql_menu = "";
    if($role_menu_id != "" && $role_menu_id > 0){
        $sql_menu = "UPDATE sec_role_menu set $columnname='1' WHERE id='$role_menu_id' ";
    }else{
        $sql_menu = "INSERT INTO sec_role_menu (role_code,menu_id,$columnname) 
			values ('$role_code','$menu_id','1')";
    }

    //echo $sql_menu."<br>";
    $result = $conn->query($sql_menu) or die($conn->error);
    return $result;
}

function rolePermissionInactive($role_code,$columnname){
    $conn=db();
    $sql = "UPDATE sec_role_menu set $columnname='0' WHERE role_code='$role_code'";

    $result = $conn->query($sql) or die($conn->error);
    return $result;
}

function sysSettingEdit($sys_name, $sys_tagline, $sys_owner, $sys_domain, $sys_email, $sys_hotline, $sys_address, $sys_fb, $version, $imgContent,$nama_document) {
    $conn=db();

    $dokumen_attch = "";
    if($nama_document <> ""){
        $dokumen_attch = ",logo='$imgContent',logo_filename='$nama_document'";
    }


    $sql = "UPDATE `sys_setting` SET 
			sys_name='$sys_name',                   
			sys_tagline='$sys_tagline',                
			sys_owner='$sys_owner',                  
			sys_domain='$sys_domain',                 
			sys_email='$sys_email',                  
			sys_hotline ='$sys_hotline',                
			sys_address ='$sys_address',                
			sys_fb ='$sys_fb',                     
			version ='$version' $dokumen_attch
		 	WHERE sys_id='1' ";

    $result =$conn->query($sql)  or die($conn->error);

    //$conn->close();

    return $result;
}

function companyEdit($id, $sys_id, $name,$short_name,$registration_no,$tel, $email, $website, $address, $authorized_name, $tagline, $slogan, $imgContent_authorized_signatory, $authorized_signatory_fn, $imgContent_company_stamp, $company_stamp_fn, $imgContent_logo, $logo_fn) {
    $conn=db();

    $dokumen_attch = "";

    if($authorized_signatory_fn <> ""){
        $dokumen_attch .= ",authorized_signatory='$imgContent_authorized_signatory',authorized_signatory_filename='$authorized_signatory_fn'";
    }

    if($company_stamp_fn <> ""){
        $dokumen_attch .= ",company_stamp='$imgContent_company_stamp',company_stamp_filename='$company_stamp_fn'";
    }

    if($logo_fn <> ""){
        $dokumen_attch .= ",logo='$imgContent_logo',logo_filename='$logo_fn'";
    }


    $sql = "UPDATE company SET 
			name='$name',                   
			short_name='$short_name',                
			registration_no='$registration_no',                  
			tel='$tel',                 
			website='$website',                  
			address ='$address',                
			authorized_name ='$authorized_name',                
			tagline ='$tagline',                     
			sys_id ='$sys_id',                     
			slogan ='$slogan' $dokumen_attch
		 	WHERE id='$id' ";

    $result =$conn->query($sql) or die($conn->error);

    return $result;
}

// 	function getCompanyDetails($company_id) {
// 		$conn=db();
// 		$sql = "SELECT * FROM company WHERE id='$company_id' ";
// 		$result = $conn->query($sql);
// 		return $result->fetch_assoc();
// 	}

function addRequestQuote($nama_produk,$nama_penuh,$notel,$emel,$nama_syarikat,$bil_pekerja,$alamat) {
    $conn=db();
    $sql = "INSERT INTO request_quote (nama_produk,nama_penuh,notel,emel,nama_syarikat,bil_pekerja,alamat) 
        VALUES('$nama_produk','$nama_penuh','$notel','$emel','$nama_syarikat','$bil_pekerja','$alamat')";
    $result = $conn->query($sql);
    return $result;
}
function janaHujungMinggu($sys_id,$no_staff) {
    $conn=db();
    $ic_number = $conn->query("SELECT noic FROM staff WHERE no_staff = '$no_staff'")->fetch_object()->noic;
    $sql = "INSERT INTO lkp_weekend (id,no_staff,sys_id,`desc`,`status`)
VALUES (CONCAT(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y%m%d%h%i%s'),'$ic_number','1'),'$no_staff','$sys_id','Sunday','0'),
(CONCAT(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y%m%d%h%i%s'),'$ic_number','2'),'$no_staff','$sys_id','Monday','0'),
(CONCAT(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y%m%d%h%i%s'),'$ic_number','3'),'$no_staff','$sys_id','Tuesday','0'),
(CONCAT(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y%m%d%h%i%s'),'$ic_number','4'),'$no_staff','$sys_id','Wednesday','0'),
(CONCAT(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y%m%d%h%i%s'),'$ic_number','5'),'$no_staff','$sys_id','Thursday','0'),
(CONCAT(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y%m%d%h%i%s'),'$ic_number','6'),'$no_staff','$sys_id','Friday','1'),
(CONCAT(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y%m%d%h%i%s'),'$ic_number','7'),'$no_staff','$sys_id','Saturday','1')";
    $result = $conn->query($sql);
    return $result;
}
function getStatusHujungMinggu($hari,$no_staff) {
    $conn=db();
    $sql = "SELECT * FROM lkp_weekend WHERE `desc`='$hari' AND no_staff='$no_staff'";
    $result = $conn->query($sql);
    return $result;
}
function janaTarikh($sys_id,$date,$status,$no_staff) {
    $conn=db();
    $ic_number = $conn->query("SELECT noic FROM staff WHERE no_staff = '$no_staff'")->fetch_object()->noic;
    $sql = "INSERT INTO tarikh_bekerja (id,no_staff,sys_id,tarikh,`status`)
VALUES (CONCAT(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y%m%d%h%i%s'),'$ic_number','$date'),'$no_staff','$sys_id','$date', '$status')";
    $result = $conn->query($sql);
    return $result;
}
function checkTahunAvailbility($tahun,$no_staff) {
    $conn=db();
    $sql = "SELECT COUNT(*) AS tahun FROM tarikh_bekerja
WHERE DATE_FORMAT(tarikh,'%Y')='$tahun' AND no_staff='$no_staff'";
    $result = $conn->query($sql);
    return $result->fetch_object()->tahun;
}

function menuDropdown($tablename,$value,$text,$selected) {
    $conn=db();
    $sql = "SELECT ".$value.",".$text." FROM $tablename ORDER BY $text ASC";
    $result = $conn->query($sql);
    $txt_result="";

    while ($row  = $result -> fetch_array()){
        if ($row[0] != '' || $row[1] != '') {
            $txt_result .= "<option " . ($row[0] == $selected ? 'selected' : '') . " value=\"" . $row[0] . "\">" . $row[1] . "</option>";
        }
    }
    return $txt_result;
}

$conn->close();

?>