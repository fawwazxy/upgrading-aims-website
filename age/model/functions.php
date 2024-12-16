<?php

require '../../lib/db/connection.php';

/* USED */

function login($username) {
    $conn=db();
    return $conn->query("SELECT * FROM staff WHERE username='$username' AND status='BEKERJA'");
}

/* END */

$action = $_POST['action'];
if($action == "moduleAdd"){
    $module_code = $_POST['module_code'];
    $module = $_POST['module'];
    $module_id = $_POST['module_id'];
    $conn=db();

    if($module_id > 0 ){
        $sql = "update sec_modules_age set module_code=upper('$module_code'),module=upper('$module') 
			where id='$module_id' ";
        $result = $conn->query($sql) or die($conn->error);
        echo "Data berjaya diproses";
    }else{
        $sqlid = "select count(id) as count from sec_modules_age where module_code = '$module_code' ";
        $count = $conn->query($sqlid)->fetch_object()->count;

        if($count == 0){
            $sql = "insert into sec_modules_age (module_code,module) 
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
    $sql = "SELECT * FROM sec_modules_age ORDER BY susunan ASC";
    $result = $conn->query($sql);
    return $result;
}

function getModuleMenu($module_code) {
    if($module_code != ""){
        $module_code = "AND module_code = '$module_code'";
    }
    $conn=db();
    $sql = "SELECT * FROM sec_module_age WHERE status in (1,0) $module_code ORDER BY menu ASC";
    $result = $conn->query($sql);
    return $result;
}

function getModuleMenuAktif($role_code) {
    $conn=db();
    $sql = "SELECT scm.*,srm.role_code,srm.access_menu,srm.views,srm.edits,srm.adds,srm.deletes FROM sec_module_age scm
		left join sec_role_age srm on scm.id=srm.menu_id  AND srm.access_menu=1 
		AND srm.role_code='$role_code'
		WHERE scm.status=1 ORDER BY scm.module_code,scm.menu ASC";
    $result = $conn->query($sql);
    return $result;
}

function getMaxSusunan() {
    $conn=db();
    $sql = "SELECT max(susunan)+1 as susunan FROM sec_module_age";
    $result = $conn->query($sql) or die($conn->error);
    return $result->fetch_object()->susunan;
}

function menuAddEdit($id,$module_code,$menu,$susunan,$link,$status){
    $conn=db();
    $sql = "INSERT INTO sec_module_age (module_code,menu,susunan,link,status) 
		values ('$module_code','$menu','$susunan','$link','$status')";

    if($id > 0){
        $sql = "UPDATE sec_module_age set module_code='$module_code',menu='$menu',
			susunan='$susunan',link='$link',status='$status' WHERE id='$id' ";
    }

    $result = $conn->query($sql) or die($conn->error);
    return $result;
}

function roleAddEdit($role_code,$menu_id){
    $conn=db();
    $sql = "SELECT id FROM sec_role_age WHERE role_code='$role_code' AND menu_id='$menu_id' limit 1";
    $role_menu_id = $conn->query($sql)->fetch_object()->id;

    $sql_menu = "";
    if($role_menu_id != "" && $role_menu_id > 0){
        $sql_menu = "UPDATE sec_role_age set access_menu='1' WHERE id='$role_menu_id' ";
    }else{
        $sql_menu = "INSERT INTO sec_role_age (role_code,menu_id,access_menu) 
			values ('$role_code','$menu_id','1')";
    }

    //echo $sql_menu."<br>";
    $result = $conn->query($sql_menu) or die($conn->error);
    return $result;
}

function roleAccessInactive($role_code){
    $conn=db();
    $sql = "UPDATE sec_role_age set access_menu='0' WHERE role_code='$role_code'";

    $result = $conn->query($sql) or die($conn->error);
    return $result;
}

function rolePermission($role_code,$menu_id,$columnname){
    $conn=db();
    $sql = "SELECT id FROM sec_role_age WHERE role_code='$role_code' AND menu_id='$menu_id' limit 1";
    $role_menu_id = $conn->query($sql)->fetch_object()->id;

    $sql_menu = "";
    if($role_menu_id != "" && $role_menu_id > 0){
        $sql_menu = "UPDATE sec_role_age set $columnname='1' WHERE id='$role_menu_id' ";
    }else{
        $sql_menu = "INSERT INTO sec_role_age (role_code,menu_id,$columnname) 
			values ('$role_code','$menu_id','1')";
    }

    //echo $sql_menu."<br>";
    $result = $conn->query($sql_menu) or die($conn->error);
    return $result;
}

function rolePermissionInactive($role_code,$columnname){
    $conn=db();
    $sql = "UPDATE sec_role_age set $columnname='0' WHERE role_code='$role_code'";

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

$conn->close();

?>