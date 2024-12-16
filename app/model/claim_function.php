<?php

	require '../../lib/db/connection.php';

	 $action=$_POST['action'];
	
	
	//jarak 
	if ($action=="edit_jarak") {
		
		$to_jarak_km=clean($_POST['to_jarak_km']);
		$from_jarak_km=clean($_POST['from_jarak_km']);
		$nilai_jarak=clean($_POST['nilai_jarak']);
		
		 $jarak_id=($_POST['jarak_id']);
		
		if($jarak_id=='0'){
			//need insert new data
		   addJarak($to_jarak_km,$from_jarak_km,$nilai_jarak);
		}else{
			//will update
			editJarak($to_jarak_km,$from_jarak_km,$nilai_jarak,$jarak_id);
		}
	}
	
	if ($action=="del_jarak") {
		 $jarak_id=clean($_POST['jarak_id']);
		if($jarak_id == "0"){
			
		}else{
			delJarak($jarak_id);
		}
	}

	function getTarikhTuntutan(){
	    $conn=db();
	    $sql=" SELECT tarikh_mula_tuntutan, tarikh_akhir_tuntutan, MONTH(tarikh_mula_tuntutan) AS monthbulan
				FROM tarikh_tuntutan
				WHERE status_tuntutan=1
				";
	    $result = $conn->query($sql);
	    return $result;
	}     

	function delJarak($jarak_id) {
		$conn=db();
		$sql = "DELETE FROM jarak WHERE id = '$jarak_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function  addJarak($to_jarak_km,$from_jarak_km,$nilai_jarak) {
		$conn=db();
	     $sql = "INSERT INTO jarak(to_jarak_km,from_jarak_km,nilai_jarak)
					 VALUES('$to_jarak_km', '$from_jarak_km', '$nilai_jarak')";
		$result = $conn->query($sql);
		return $result;
	} 
	
	function editJarak($to_jarak_km,$from_jarak_km,$nilai_jarak,$jarak_id) {
		$conn=db();
	     $sql = "UPDATE jarak SET to_jarak_km='$to_jarak_km' , from_jarak_km='$from_jarak_km', nilai_jarak='$nilai_jarak' 
	    			 WHERE id='$jarak_id'";
		$result = $conn->query($sql);
		return $result;
	} 
	
	//jenis_tuntutan
	if ($action=="edit_jenis") {
		
		$nama_tuntutan=clean($_POST['nama_tuntutan']);
		$code=clean($_POST['code']);
		$flag=clean($_POST['flag']);
		$flag_1=clean($_POST['flag_1']);
		$flag_2=clean($_POST['flag_2']);
	    $flag_3=clean($_POST['flag_3']);
	    $flag_4=clean($_POST['flag_4']);
	    $flag_5=clean($_POST['flag_5']);
		
		 $jenis_id=($_POST['jenis_id']);
		
		if($jenis_id=='0'){
			//need insert new data
		   addJenis($code,$nama_tuntutan,$flag,$flag_1,$flag_2,$flag_3,$flag_4,$flag_5);
		}else{
			//will update
			editJenis($jenis_id,$code,$nama_tuntutan,$flag,$flag_1,$flag_2,$flag_3,$flag_4,$flag_5);
		}
	}
	
	if ($action=="del_jenis") {
		 $jenis_id=clean($_POST['jenis_id']);
		if($jenis_id == "0"){
			
		}else{
			delJenis($jenis_id);
		}
	}

	//funtion to delete jenis tuntutan
	function delJenis($jenis_id) {
		$conn=db();
		$sql = "DELETE FROM jenis_tuntutan WHERE id = '$jenis_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	//funtion to insert new tuntutan
	function  addJenis($code,$nama_tuntutan,$flag,$flag_1,$flag_2,$flag_3,$flag_4,$flag_5) {
		$conn=db();
	     $sql = "INSERT INTO jenis_tuntutan(code,nama_tuntutan,flag,flag_1,flag_2,flag_3,flag_4,flag_5)
				     VALUES('$code', '$nama_tuntutan', '$flag', '$flag_1', '$flag_2', '$flag_3','$flag_4','$flag_5')";
		$result = $conn->query($sql);
		return $result;
	} 
	
	//funtion to edit tuntutan
	function editJenis($jenis_id,$code,$nama_tuntutan,$flag,$flag_1,$flag_2, $flag_3,$flag_4,$flag_5) {
		$conn=db();
	     $sql = "UPDATE jenis_tuntutan SET code='$code' , nama_tuntutan='$nama_tuntutan', flag='$flag', flag_1='$flag_1',     
	                 flag_2='$flag_2', flag_3='$flag_3' ,flag_4='$flag_4',flag_5='$flag_5' 
	                 WHERE id='$jenis_id'";
		$result = $conn->query($sql);
		return $result;
	} 

	if ($action=="get_nilai") {
		
		$jumlah_jarak=clean($_POST['jumlah_jarak']);
	
		//need insert new data
		$conn=db();
	    $sql="SELECT CONCAT(nilai_jarak,'|',id) AS nilai
		 	  FROM jarak
		 	  WHERE '$jumlah_jarak' BETWEEN from_jarak_km AND to_jarak_km ";
		$result = $conn->query($sql);

		echo $result->fetch_object()->nilai;
	}


	function getJarakid($jumlah_jarak){
		$conn=db();
		$sql="SELECT nilai_jarak,id
		 	  FROM jarak
		      WHERE '$jumlah_jarak' BETWEEN from_jarak_km AND to_jarak_km ";
		$result = $conn->query($sql);
		return $result;
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

		function getJarak() {
		$conn=db();
		$sql = "SELECT * FROM jarak ";
		$result = $conn->query($sql);
		return $result;
	}
		function getJenisTuntutan() {
		$conn=db();
		$sql = "SELECT * FROM jenis_tuntutan WHERE code NOT IN('TRNSPRT')";
		$result = $conn->query($sql);
		return $result;
	}

		function getJenisTuntutanTRNSPRT() {
		$conn=db();
		$sql = "SELECT * FROM jenis_tuntutan WHERE code ='TRNSPRT'";
		$result = $conn->query($sql);
		return $result;
	}

	function getNamaTuntutan() {
		$conn=db();
		$sql = "SELECT * FROM jenis_tuntutan";
		$result = $conn->query($sql);
		return $result;
	}
	function getJenisTuntutanLulus() {
		$conn=db();
		$sql = "SELECT id,code,nama_tuntutan,flag_1 FROM jenis_tuntutan";
		$result = $conn->query($sql);
		return $result;
	}
	function getSenaraiTuntutanPerjalanan($no_staff){

		$conn=db();
		$sql = " SELECT ca.*,s.name AS nama_pekerja,pt.jumlah_jarak,pt.tempat_from,pt.tempat_to,pt.tarikh_journey,pt.tarikh_pohon,
			     pt.jumlah_tuntutan,pt.document,pt.catatan AS catatan_perjalanan,jck.jenis_lulus AS status_jarak
			     FROM claim_approve ca
			     LEFT JOIN perjalanan_tuntutan pt
			     ON pt.jenis_tuntutan=ca.jenis_tuntutan
			     LEFT JOIN staff s
			     ON s.no_staff=pt.no_staff
			     LEFT JOIN perjalanan_tuntutan ptt
			     ON ptt.pelulus=ca.approve_by
			     LEFT JOIN jenis_kelulusan_claim jck
			     ON jck.code=ca.approve_status
			     WHERE ca.approve_status<>'BD' 
			     AND ca.jenis_tuntutan='TRNSPRT'
			     AND ca.approve_by='$no_staff'
			     ORDER BY ca.id ASC";

		$result = $conn->query($sql);
		return $result;

	}

	//get maklumat tuntutan perjalanan untuk kemaskini
	function getTuntutanPerjalananPemohon($id){
		$conn=db();
	    $sql = "SELECT ca.*, jt.nama_tuntutan AS nama_tuntut,
				pt.tempat_from, pt.tempat_to, pt.tarikh_journey, pt.jumlah_jarak,
				ca.jumlah_tuntut AS jumlah_tuntutan, pt.catatan AS catatan_perjalanan
				FROM claim_approve ca
				LEFT JOIN jenis_tuntutan jt
				ON jt.code=ca.jenis_tuntutan
				LEFT JOIN perjalanan_tuntutan pt
				ON ca.value=pt.id
				WHERE ca.jenis_tuntutan='TRNSPRT'
				AND ca.id='$id'";

			$result = $conn->query($sql);
			return $result;


	}

	//get image for bukti tuntutan perjalanan untuk page kemaskini dan page kelulusan
	function getTuntutanPerjalananImg($no_pemohon,$jenis_tuntutan,$id){
		$conn=db();
		$sql="SELECT ca.*,jt.nama_tuntutan,pt.document
			  FROM claim_approve ca
			  LEFT JOIN jenis_tuntutan jt
			  ON jt.code=ca.jenis_tuntutan
			  LEFT JOIN perjalanan_tuntutan pt
			  ON pt.id=ca.value
			  WHERE pt.no_staff='$no_pemohon'
			  AND ca.jenis_tuntutan='TRNSPRT'
			  AND ca.id='$id'";

		$result = $conn->query($sql);
		$default= $result-> fetch_assoc();
		echo '<img src="data:image/jpeg;base64,'.base64_encode( $default['document'] ).'"style="width: 450px; height: 500px;"/>';


	}

	//get maklumat tuntutan default untuk page kemaskini
	function getTuntutanDefault($no_pemohon,$jenis_tuntutan,$id){
		$conn=db();
		$sql="	SELECT ca.*,jt.nama_tuntutan,dt.catatan,dt.document
				FROM claim_approve ca
				LEFT JOIN jenis_tuntutan jt
				ON jt.code=ca.jenis_tuntutan
				LEFT JOIN default_tuntutan dt
				ON dt.id=ca.value
				WHERE dt.no_staff='$no_pemohon'
				AND ca.jenis_tuntutan='$jenis_tuntutan'
				AND ca.id='$id' ";

		$result = $conn->query($sql);
	    return $result;

	}

	//get image for default tuntutan
	function getTuntutanDefaultImg($no_pemohon,$jenis_tuntutan,$id){
		$conn=db();
		$sql="	SELECT ca.*,jt.nama_tuntutan,dt.catatan,dt.document
				FROM claim_approve ca
				LEFT JOIN jenis_tuntutan jt
				ON jt.code=ca.jenis_tuntutan
				LEFT JOIN default_tuntutan dt
				ON dt.id=ca.value
				WHERE dt.no_staff='$no_pemohon'
				AND ca.jenis_tuntutan='$jenis_tuntutan'
				AND ca.id='$id'";

		$result = $conn->query($sql);
		$default= $result-> fetch_assoc();
		echo '<img src="data:image/jpeg;base64,'.base64_encode( $default['document'] ).'" style="width: 450px; height: 500px;"/>';

	}



function getBuktiTuntutan($id){
	$conn=db();
	 $sql="SELECT ca.*,dt.document,dt.nama_document,pt.document AS bukti_perjalanan,pt.nama_document AS nama_bukti_perjalanan
			FROM claim_approve ca
			LEFT JOIN default_tuntutan dt
			ON ca.value=dt.id
			LEFT JOIN perjalanan_tuntutan pt
			ON ca.value=pt.id
			WHERE ca.id='$id'";

	$result = $conn->query($sql);
	$default= $result-> fetch_assoc();

	if($default['jenis_tuntutan']=='TRNSPRT'){
		echo '<img src="data:image/jpeg;base64,'.base64_encode( $default['bukti_perjalanan'] ).'"  style="width: 450px; height: 500px;"/>';

	} else {
		echo '<img src="data:image/jpeg;base64,'.base64_encode( $default['document'] ).'"  style="width: 450px; height: 500px;"/>';
	}
	// echo '<img src="data:image/jpeg;base64,'.base64_encode( $default['document'] ).'"  style="width: 450px; height: 500px;"/>';
	// echo '<img src="data:image/jpeg;base64,'.base64_encode( $default['bukti_perjalanan'] ).'"  style="width: 450px; height: 500px;"/>';

}

function getBuktiTuntutanPerjalanan($id){
	$conn=db();
	 $sql="SELECT ca.*,jt.nama_tuntutan,dt.catatan,dt.document, s.name AS nama_penuntut
			FROM claim_approve ca
			LEFT JOIN jenis_tuntutan jt
			ON jt.code=ca.jenis_tuntutan
			LEFT JOIN default_tuntutan dt
			ON dt.id=ca.value
			left join staff s
			on s.no_staff= ca.no_pemohon
			WHERE ca.id='$id'";

	$result = $conn->query($sql);
	$default= $result-> fetch_assoc();

	//echo '<img src="data:image/jpeg;base64,'.base64_encode( $row_data_staff['document'] ).'" style="width: 100px; height: 110px;"/>';
	echo '<img src="data:image/jpeg;base64,'.base64_encode( $default['document'] ).'"  style="width: 450px; height: 500px;"/>';

}
//UPDATE TUNTUTAN JARAK 
function UpdateTuntutanJarak($perjalanan_tuntutan_id,$tempat_from,$tempat_to,$tarikh_journey,$jumlah_jarak,$jumlah_tuntutan,$pelulus,$catatan,$jarak_id,$jenis_tuntutan,$document,$nama_document){
     
     $conn=db();
     //UPDATE TABLE PERJALANAN_TUNTUTAN
    $sql="UPDATE perjalanan_tuntutan SET tarikh_journey=STR_TO_DATE('$tarikh_journey','%d/%m/%Y'), 
               jumlah_tuntutan='$jumlah_tuntutan',jumlah_jarak='$jumlah_jarak',
               jarak_id='$jarak_id' , tempat_from='$tempat_from' ,tempat_to='$tempat_to' , 
               pelulus='$pelulus' , catatan='$catatan' ";

                if($nama_document!=""){
                	$sql.=" ,document='$document',nama_document='$nama_document' "; 
                }

     	       $sql.=" WHERE id='$perjalanan_tuntutan_id'";


     $result = $conn->query($sql);

      $sql1="UPDATE claim_approve SET jumlah_tuntut='$jumlah_tuntutan',approve_by='$pelulus'
	           WHERE value='$perjalanan_tuntutan_id' AND jenis_tuntutan='$jenis_tuntutan'";

     
     $result1 = $conn->query($sql1);

     return $result;


     }

 function UpdateTuntutanDefault($default_id,$jumlah_tuntutan,$pelulus,$catatan,$jenis_tuntutan,$document,$nama_document){
 	  $conn=db();
 	   $sql="UPDATE default_tuntutan SET jumlah_tuntutan='$jumlah_tuntutan', pelulus='$pelulus', catatan='$catatan' ";
 	           if($nama_document!=""){
 	           		$sql.=" ,document='$document',nama_document='$nama_document' "; 
 	           }
 	           
 	           $sql.=" WHERE id='$default_id' ";

 	  $result = $conn->query($sql);

     $sql1="UPDATE claim_approve SET jumlah_tuntut='$jumlah_tuntutan',approve_by='$pelulus'
	                 WHERE value='$default_id' AND jenis_tuntutan='$jenis_tuntutan'";
    $result1 = $conn->query($sql1);
	return $result;

 }

  function getStaff() {
   $conn=db();
  $sql = "SELECT s.*,d.description AS department_name,r.role AS role_name 
    FROM staff s
    LEFT JOIN department d
    ON d.code_department=s.department_id
    LEFT JOIN role r
    ON s.role_id=r.code";
    $result = $conn->query($sql);
    return $result;
  }

  function checkCheckbox($no_staff){
       $conn=db();
      $sql = "SELECT * FROM pelulus_tuntutan WHERE approve_person='$no_staff'";

    $result = $conn->query($sql);
    $row=$result->num_rows;

    if($row>0){



      return "checked";

    }
    else{


      return " ";
    }
     }


     

  function addPelulus($approve_person){

	   $conn=db();
	    $sql="INSERT INTO pelulus_tuntutan(approve_person) VALUES ('$approve_person')";
       $result = $conn->query($sql);
       return $result;


}

function getTuntutanPelulus(){
    $conn=db();
    $sql=" SELECT pt.*,s.name AS nama_pelulus
			FROM pelulus_tuntutan pt
			LEFT JOIN staff s
			ON s.no_staff=pt.approve_person";
    $result = $conn->query($sql);
    return $result;



}

function getNamePerjalananTuntutan(){
	$conn=db();
	$sql="SELECT code,nama_tuntutan FROM jenis_tuntutan WHERE nama_tuntutan='PERJALANAN'";
	$result = $conn->query($sql);
    return $result;

}




  function addTuntutanJarak($no_staff,$jenis_tuntutan,$tarikh_pohon,$tempat_from,$tempat_to,$tarikh_journey,$jumlah_jarak,$jumlah_tuntutan,$document,$nama_document,$pelulus,$catatan,$status,$jarak_id){
    $conn=db();
    $sql="INSERT INTO perjalanan_tuntutan(no_staff,jenis_tuntutan,tarikh_pohon,tempat_from,tempat_to,tarikh_journey,jumlah_jarak,jumlah_tuntutan,document,nama_document,pelulus,catatan,status,jarak_id)VALUES('$no_staff','$jenis_tuntutan',STR_TO_DATE('$tarikh_pohon','%d/%m/%Y'),'$tempat_from','$tempat_to',STR_TO_DATE('$tarikh_journey','%d/%m/%Y'),'$jumlah_jarak','$jumlah_tuntutan','$document','$nama_document','$pelulus','$catatan','BD','$jarak_id')";
    $result = $conn->query($sql) or die($conn->error);



     $value= $conn->insert_id;
      //query insert data ke table claim_approve
     $sql1 ="INSERT INTO claim_approve
             (value,table_ref,column_ref,jenis_tuntutan,approve_status,approve_by,no_pemohon,jumlah_tuntut,tarikh_dipohon,noti_status)
             VALUES('$value','perjalanan_tuntutan','id','TRNSPRT','BD','$pelulus','$no_staff', '$jumlah_tuntutan', STR_TO_DATE('$tarikh_pohon','%d/%m/%Y'),'0')";
      

      $result1 = $conn->query($sql1);

    return $result;


}

//insert data ke default table
 function addDefaultTuntutan($no_staff,$jenis_tuntutan,$jumlah_tuntutan,$document,$nama_document,$pelulus,$catatan,$status,$tarikh_pohon){
    $conn=db();

    $document=
   $sql="INSERT INTO default_tuntutan(no_staff,jenis_tuntutan,jumlah_tuntutan,document,nama_document,pelulus,catatan,status,tarikh_pohon)VALUES('$no_staff','$jenis_tuntutan','$jumlah_tuntutan','$document','$nama_document','$pelulus','$catatan','SD',STR_TO_DATE('$tarikh_pohon','%d/%m/%Y'))";
    $result = $conn->query($sql);



     $value= $conn->insert_id;
      //query insert data ke table claim_approve
     $sql1 ="INSERT INTO claim_approve
             (value,table_ref,column_ref,jenis_tuntutan,approve_status,approve_by,no_pemohon,jumlah_tuntut,tarikh_dipohon)
             VALUES('$value','default_tuntutan','id','$jenis_tuntutan','BD','$pelulus','$no_staff','$jumlah_tuntutan', STR_TO_DATE('$tarikh_pohon','%d/%m/%Y'))";
      

      $result1 = $conn->query($sql1);

    return $result;

}
//DROPDOWN STATUS kelulusan claim
function statusKelulusanClaim(){
  $conn=db();
  $sql="SELECT * FROM jenis_kelulusan_claim WHERE code IN ('L','TL')";

  $result=$conn->query($sql);
 return $result; 
}


  function deletePelulus(){
     	  $conn=db();
     	  $sql= "DELETE FROM pelulus_tuntutan";
     	   $result = $conn->query($sql);
     	   return $result;

     }
     //get maklumat utk proses pengesahan bagi tuntutan jarak
     function getMaklumatTuntutanPekerja($tuntut_jarak_id){
            $conn=db();
            $sql="SELECT ca.*,s.name AS nama_pekerja,d.description AS nama_bahagian,s.phone,pt.tarikh_pohon,pt.tarikh_journey,
					jt.nama_tuntutan AS nama_tuntutan, pt.tempat_from, pt.tempat_to, pt.catatan AS catatan_pemohon,
					pt.jumlah_tuntutan
					FROM claim_approve ca
					LEFT JOIN perjalanan_tuntutan pt
					ON pt.id=ca.value
					LEFT JOIN staff s
					ON s.no_staff=pt.no_staff
					LEFT JOIN department d
					ON d.code_department=s.department_id
					LEFT JOIN jenis_tuntutan jt
					ON jt.code=ca.jenis_tuntutan
					WHERE ca.jenis_tuntutan='TRNSPRT' AND pt.id='$tuntut_jarak_id'";

            $result = $conn->query($sql);
     	   return $result;




     }

    function getTuntutanPerjalananInfo($id){
    	$conn=db();
    	$sql="SELECT ca.*, s.name AS nama_pekerja, d.description AS nama_bahagian,
				pt.tarikh_pohon,pt.tarikh_journey,pt.tempat_from,pt.tempat_to,pt.jumlah_tuntutan,pt.id AS claim_id,pt.catatan AS catatan_pemohon,jt.nama_tuntutan
				FROM claim_approve ca
				LEFT JOIN staff s
				ON s.no_staff=ca.no_pemohon
				LEFT JOIN department d
				ON d.code_department=s.department_id
				LEFT JOIN perjalanan_tuntutan pt
				ON pt.id=ca.value
				LEFT JOIN jenis_tuntutan jt
				ON jt.code=ca.jenis_tuntutan
				WHERE ca.jenis_tuntutan='jenis_tuntutan' AND pt.id='$id'";

		$result = $conn->query($sql);
		return $result;
    }



     function getMaklumatTuntutanPekerjaDefault($default_id){
     	 $conn=db();
       $sql="  SELECT ca.*,s.name AS nama_pekerja,d.description AS nama_bahagian,s.phone,dt.tarikh_pohon,
			     jt.nama_tuntutan AS nama_tuntutan,dt.catatan AS catatan_pemohon,dt.document
			     FROM claim_approve ca
			     LEFT JOIN default_tuntutan dt
			     ON dt.id=ca.value
			     LEFT JOIN staff s
			     ON s.no_staff=dt.no_staff
			     LEFT JOIN department d
			     ON d.code_department=s.department_id
			     LEFT JOIN jenis_tuntutan jt
			     ON jt.code=ca.jenis_tuntutan
			     WHERE ca.table_ref='default_tuntutan' AND dt.id='$default_id'";

		  $result = $conn->query($sql);
     	   return $result;

     }


     //PROSES BUTTON HANTAR DI SENARAI BELUM DI HANTAR 
     function UpdateStatusHantar($value,$table_ref){

     	 $conn=db();


     	 $sql="UPDATE claim_approve SET approve_status='SD'
     	       WHERE value='$value' AND table_ref='$table_ref'";

     	 $result = $conn->query($sql);


        if($table_ref=='perjalanan_tuntutan'){

     	 $sql1="UPDATE perjalanan_tuntutan SET status='SD'
     	        WHERE id='$value'";

     	 $result1 = $conn->query($sql1);

     	}

        if($table_ref=='default_tuntutan'){

        $sql2="UPDATE default_tuntutan SET status='SD'
     	       WHERE id='$value'";

     	 $result2 = $conn->query($sql2);

     }

      return $result;
 }
  //PROSES BUTTON HANTAR DI SENARAI BELUM DI HANTAR 
     function getMaklumat($value,$table_ref){

     	 $conn=db();


     	 $sql="UPDATE claim_approve SET approve_status='SD'
     	       WHERE value='$value' AND table_ref='$table_ref'";

     	 $result = $conn->query($sql);


        if($table_ref=='perjalanan_tuntutan'){

     	 $sql1="UPDATE perjalanan_tuntutan SET status='SD'
     	        WHERE id='$value'";

     	 $result1 = $conn->query($sql1);

     	}

        if($table_ref=='default_tuntutan'){

        $sql2="UPDATE default_tuntutan SET status='SD'
     	       WHERE id='$value'";

     	 $result2 = $conn->query($sql2);

     }

      return $result;
 }
     //update status table perjalanan_tuntutan  semasa superior/hr melakukan pengesahan
     function UpdateStatusTuntutJarak($approve_status,$catatan,$tuntut_jarak_id,$tarikh_approvement,$jenis_tuntutan){

     $conn=db();
     $sql= "UPDATE claim_approve SET approve_status='$approve_status', catatan='$catatan', 
            tarikh_approvement=STR_TO_DATE('$tarikh_approvement','%d/%m/%Y')
     	    WHERE value='$tuntut_jarak_id'  AND jenis_tuntutan='$jenis_tuntutan'";


     $result = $conn->query($sql);


     $sql1="UPDATE perjalanan_tuntutan SET status='$approve_status'
            WHERE  id='$tuntut_jarak_id'";

     $result1=$conn->query($sql1);



      return $result;
     

     }

      //update status table default_table  semasa superior/hr melakukan pengesahan

       function UpdateStatusTuntutDefault($approve_status,$catatan,$default_id,$tarikh_approvement,$jenis_tuntutan){

       	  $conn=db();

       	    $sql= "UPDATE claim_approve SET approve_status='$approve_status', catatan='$catatan', 
	            tarikh_approvement=STR_TO_DATE('$tarikh_approvement','%d/%m/%Y')
	     	    WHERE value='$default_id' AND jenis_tuntutan='$jenis_tuntutan'";

     	     $result = $conn->query($sql);


            $sql1="UPDATE default_tuntutan SET status='$approve_status'
                   WHERE  id='$default_id'";

             $result1=$conn->query($sql1);
        

          return $result;

       }




      function getSenaraiTuntutan($no_staff){

     	 $conn=db();
     	 $sql="  SELECT ca.*, s.name AS nama, jt.nama_tuntutan, jkc.jenis_lulus AS status_tuntut ,st.name AS nama_pelulus,pt.tempat_from, pt.tempat_to
				FROM claim_approve ca
				LEFT JOIN staff s
				ON s.no_staff=ca.no_pemohon
				LEFT JOIN staff st
				ON st.no_staff=ca.approve_by
				LEFT JOIN jenis_tuntutan jt
				ON jt.code = ca.jenis_tuntutan
				LEFT JOIN jenis_kelulusan_claim jkc
				ON jkc.code=ca.approve_status
				LEFT JOIN perjalanan_tuntutan pt
				ON ca.value=pt.id
				WHERE ca.approve_status IN ('SD','BD')
				AND ca.no_pemohon='$no_staff'
				ORDER BY ca.id DESC";

     	 $result = $conn->query($sql);

     	 return $result;

     }
      function getSenaraiTuntutanLulus($no_staff){

     	 $conn=db();
     	 $sql="  SELECT ca.*, s.name AS nama, jt.nama_tuntutan, jkc.jenis_lulus AS status_tuntut ,st.name AS nama_pelulus,
     	 		 pt.tempat_from,pt.tempat_to
			     FROM claim_approve ca
			     LEFT JOIN staff s
			     ON s.no_staff=ca.no_pemohon
			     LEFT JOIN staff st
			     ON st.no_staff=ca.approve_by
			     LEFT JOIN jenis_tuntutan jt
			     ON jt.code = ca.jenis_tuntutan
			     LEFT JOIN jenis_kelulusan_claim jkc
			     ON jkc.code=ca.approve_status
			     LEFT JOIN perjalanan_tuntutan pt
			     ON pt.id=ca.value
			     WHERE ca.approve_status='L'
			     AND ca.no_pemohon='$no_staff'";

     	 $result = $conn->query($sql);

     	 return $result;

     }
        function getSenaraiTuntutanTidakLulus($no_staff){

     	 $conn=db();
         $sql="  SELECT ca.*, s.name AS nama, jt.nama_tuntutan, jkc.jenis_lulus AS status_tuntut ,st.name AS nama_pelulus, pt.tempat_from,pt.tempat_to
			     FROM claim_approve ca
			     LEFT JOIN staff s
			     ON s.no_staff=ca.no_pemohon
			     LEFT JOIN staff st
			     ON st.no_staff=ca.approve_by
			     LEFT JOIN jenis_tuntutan jt
			     ON jt.code = ca.jenis_tuntutan
			     LEFT JOIN jenis_kelulusan_claim jkc
			     ON jkc.code=ca.approve_status
			     LEFT JOIN perjalanan_tuntutan pt
			     ON pt.id=ca.value
			     WHERE ca.approve_status='TL'
			     AND ca.no_pemohon='$no_staff'";

     	 $result = $conn->query($sql);

     	 return $result;

     }

     function getSenaraiTuntutanPekerja($no_staff){

     	 $conn=db();
     	 $sql="  SELECT ca.*, s.name AS nama, jt.nama_tuntutan, jkc.jenis_lulus AS status_tuntut , ca.id AS claim_id,pt.tempat_from,pt.tempat_to
				FROM claim_approve ca
				LEFT JOIN staff s
				ON s.no_staff=ca.no_pemohon
				LEFT JOIN jenis_tuntutan jt
				ON jt.code = ca.jenis_tuntutan
				LEFT JOIN  staff st
				ON st.no_staff=ca.approve_by
				LEFT JOIN jenis_kelulusan_claim jkc
				ON jkc.code=ca.approve_status
				LEFT JOIN perjalanan_tuntutan pt
				ON pt.id=ca.value
				WHERE ca.approve_status='SD' AND ca.approve_by='$no_staff'
				ORDER BY ca.id DESC";

     	 $result = $conn->query($sql);

     	 return $result;
     }

//to get senarai tuntutan yang tidak diluluskan (untuk di view oleh pelulus)

 	function getSenaraiTuntutanPekerjaTidakLulus($no_staff){

     	 $conn=db();
     	 $sql="  SELECT ca.*, s.name AS nama, jt.nama_tuntutan, jkc.jenis_lulus AS status_tuntut 
			     FROM claim_approve ca
			     LEFT JOIN staff s
			     ON s.no_staff=ca.no_pemohon
			     LEFT JOIN jenis_tuntutan jt
			     ON jt.code = ca.jenis_tuntutan
			     LEFT JOIN staff st
			     ON st.no_staff=ca.approve_by
			     LEFT JOIN jenis_kelulusan_claim jkc
			     ON jkc.code=ca.approve_status
			     WHERE ca.approve_status='TL' AND ca.approve_by='$no_staff'";

     	 $result = $conn->query($sql);

     	 return $result;
     }

//to get senarai tuntutan yang telah diluluskan (untuk di view oleh pelulus)
     function getSenaraiTuntutanPekerjaLulus($no_staff){

     	 $conn=db();
     	 $sql=" SELECT ca.*, s.name AS nama, jt.nama_tuntutan, jkc.jenis_lulus AS status_tuntut 
				FROM claim_approve ca
				LEFT JOIN staff s
				ON s.no_staff=ca.no_pemohon
				LEFT JOIN jenis_tuntutan jt
				ON jt.code = ca.jenis_tuntutan
				LEFT JOIN staff st
				ON st.no_staff=ca.approve_by
				LEFT JOIN jenis_kelulusan_claim jkc
				ON jkc.code=ca.approve_status
				WHERE ca.approve_status='L' AND ca.approve_by='$no_staff'";

     	 $result = $conn->query($sql);

     	 return $result;
     }

     function getMaklumatTuntutanYangDituntut($no_staff,$tahun,$bulan){
     		 $conn=db();
     		 $sql="SELECT ca.*, s.name AS nama, jt.nama_tuntutan, jkc.jenis_lulus AS status_tuntut ,st.name AS nama_pelulus, pt.tempat_from,pt.tempat_to
			      FROM claim_approve ca
			     LEFT JOIN staff s
			     ON s.no_staff=ca.no_pemohon
			     LEFT JOIN staff st
			     ON st.no_staff=ca.approve_by
			     LEFT JOIN jenis_tuntutan jt
			     ON jt.code = ca.jenis_tuntutan
			     LEFT JOIN jenis_kelulusan_claim jkc
			     ON jkc.code=ca.approve_status
			     LEFT JOIN perjalanan_tuntutan pt
			     ON pt.id=ca.value
			     WHERE ca.approve_status<>'BD'
			     AND YEAR(tarikh_dipohon)='$tahun'
			     AND MONTH(tarikh_dipohon)='$bulan'
			     AND ca.no_pemohon='$no_staff'";

			      $result = $conn->query($sql);

     	          return $result;


     }

     function getTuntutanLulusByBulan($no_staff,$tahun,$bulan){
     		 $conn=db();
     		 $sql="SELECT ca.*, s.name AS nama_penuntut, jt.nama_tuntutan, jkc.jenis_lulus AS status_tuntut ,st.name AS nama_pelulus
			      FROM claim_approve ca
			     LEFT JOIN staff s
			     ON s.no_staff=ca.no_pemohon
			     LEFT JOIN staff st
			     ON st.no_staff=ca.approve_by
			     LEFT JOIN jenis_tuntutan jt
			     ON jt.code = ca.jenis_tuntutan
			     LEFT JOIN jenis_kelulusan_claim jkc
			     ON jkc.code=ca.approve_status
			     WHERE ca.approve_status='L'
			     AND YEAR(tarikh_dipohon)='$tahun'
			     AND MONTH(tarikh_dipohon)='$bulan'
			     AND ca.approve_by='$no_staff'";

			      $result = $conn->query($sql);

     	          return $result;


     }

     function getTuntutanTidakLulusByBulan($no_staff,$tahun,$bulan){
     		 $conn=db();
     		 $sql="SELECT ca.*, s.name AS nama_penuntut, jt.nama_tuntutan, jkc.jenis_lulus AS status_tuntut ,st.name AS nama_pelulus
			      FROM claim_approve ca
			     LEFT JOIN staff s
			     ON s.no_staff=ca.no_pemohon
			     LEFT JOIN staff st
			     ON st.no_staff=ca.approve_by
			     LEFT JOIN jenis_tuntutan jt
			     ON jt.code = ca.jenis_tuntutan
			     LEFT JOIN jenis_kelulusan_claim jkc
			     ON jkc.code=ca.approve_status
			     WHERE ca.approve_status='TL'
			     AND YEAR(tarikh_dipohon)='$tahun'
			     AND MONTH(tarikh_dipohon)='$bulan'
			     AND ca.approve_by='$no_staff'";

			      $result = $conn->query($sql);

     	          return $result;


     }


           

      //count notification number page individual
     function getNotification($no_staff,$approve_status){

     	 $conn=db();

     
            $sql="SELECT COUNT(noti_status) AS noti FROM claim_approve 
					WHERE noti_status='0'
					AND approve_status='$approve_status'
					AND no_pemohon='$no_staff'";



     	 $n_status= $conn->query($sql)->fetch_object()->noti;



       return $n_status;


     }

       //count notification number page superior or HR
     function getNotificationPelulus($no_staff,$approve_status){

     	 $conn=db();

     
           $sql="SELECT COUNT(noti_status_pelulus) AS noti FROM claim_approve 
					WHERE noti_status_pelulus='0'
					AND approve_status='$approve_status'
					AND approve_by='$no_staff'";



     	 $n_status_1= $conn->query($sql)->fetch_object()->noti;



       return $n_status_1;


     }

     //update notification staff individu after click on the menu top

	function updateNoti($noti_status,$no_pemohon,$approve_status){
       

     	 $conn=db();

          $sql="UPDATE claim_approve SET noti_status='1'
                WHERE no_pemohon='$no_pemohon'
                AND approve_status='$approve_status'";

          $result = $conn->query($sql);

     	  return $result;
	}
	   //update notification Pelulus after click on the menu top

	function updateNotiPelulus($noti_status,$no_staff,$approve_status){
       

     	 $conn=db();

        $sql="UPDATE claim_approve SET noti_status_pelulus='1'
                WHERE approve_by='$no_staff'
                AND approve_status='$approve_status'";

          $result = $conn->query($sql);

     	  return $result;
	}


	function getNotiMenuLeft($no_staff){

		 $conn=db();
		 $sql="SELECT COUNT(noti_status) AS noti FROM claim_approve 
				WHERE noti_status='0'
				AND approve_status IN ('TL','L')
				AND no_pemohon='$no_staff'";



		 $n_status= $conn->query($sql)->fetch_object()->noti;

     	  return $n_status;

	}

	// function getCheckbox(){
       

 //     	 $conn=db();
 //     	 if(isset($_POST['checkbox'])){$checkbox = $_POST['checkbox'];
 //     	 if(isset($_POST['activate'])?$activate = $_POST["activate"]:$deactivate = $_POST["deactivate"])
 //     	 	$id="('" . implode( "','", $checkbox ) . "');" ;
 //     	 $sql="UPDATE claim_approve SET approve_status = '".(isset($activate)?'L':'TL')."' WHERE id IN $id" ;

 //     	 $result = $conn->query($sql);
 //     	}
 //     	 return $result;
 //     }

	function getCheckboxUpdateClaim($id,$no_staff){
 $conn=db();
if(isset($_POST['checkbox'])){$checkbox = $_POST['checkbox'];
if(isset($_POST['activate'])?$activate = $_POST["activate"]:$deactivate = $_POST["deactivate"])
$id = "('" . implode( "','", $checkbox ) . "');" ;
$sql="UPDATE claim_approve SET approve_by='$no_staff',catatan='-',tarikh_approvement=SysDate(),noti_status_pelulus='1', approve_status = '".(isset($activate)?'L':'TL')."' WHERE id IN $id" ;
$result=$conn->query($sql);
  return $result;
}


}
	function addTuntutan($nama_tuntutan,$code) {
  		$conn=db();
  		$sql = "INSERT INTO jenis_tuntutan (nama_tuntutan,code) VALUES ('$nama_tuntutan','$code')";
  		$result =$conn->query($sql);
  		return $result;
  	}

  	function deleteTuntutan($id) {
    	$conn=db();
    	$sql = "DELETE FROM jenis_tuntutan WHERE id='$id' ";
        $result = $conn->query($sql);
		return $result;
	}
	
	function addTarikhTuntutan($tarikh_mula_tuntutan,$tarikh_akhir_tuntutan){
    
    $conn=db();

   $sql4 = "SELECT *
FROM tarikh_tuntutan
 WHERE MONTH(tarikh_mula_tuntutan)=MONTH('$tarikh_mula_tuntutan') AND YEAR(tarikh_mula_tuntutan)=YEAR('$tarikh_akhir_tuntutan')";
    $query = $conn->query($sql4);



    if($query->num_rows > 0){
         echo ("<script LANGUAGE='JavaScript'>
    window.alert('Data pada bulan ini sudah ada');
    window.location.href='../view/tarikh_tuntutan.php';
    </script>");
    } else {
     $sql3="SELECT MAX(id) AS id FROM tarikh_tuntutan";
		$checkId=$conn->query($sql3)->fetch_object()->id;
		$sql2="UPDATE tarikh_tuntutan SET status_tuntutan='0' WHERE id='$checkId'";
		$result = $conn->query($sql2);
		 $sql="INSERT INTO tarikh_tuntutan (tarikh_mula_tuntutan,tarikh_akhir_tuntutan,perubahan_tarikh,status_tuntutan) VALUES ('$tarikh_mula_tuntutan', '$tarikh_akhir_tuntutan',MONTH(CURRENT_TIME),'1')";
       $result = $conn->query($sql);
       return $result;
    } 
    return 0;
	}
    
    function getCheckingTarikhTuntutan(){
	$conn=db();
	$sql="SELECT MONTH(tarikh_mula_tuntutan) AS bulan,YEAR(tarikh_mula_tuntutan) AS tahun FROM tarikh_tuntutan";
	$result = $conn->query($sql);
	return $result;
	}
	
	function getTarikhTuntutanById(){
	$conn=db();
	$sql="SELECT * FROM tarikh_tuntutan WHERE id='$id'";
	$result = $conn->query($sql);
	return $result;
	}
    
    function updateStatusTarikhTuntutan($id){
	$conn=db();
	$sql1="UPDATE tarikh_tuntutan SET status_tuntutan ='0' WHERE id NOT IN ('$id')
";
	$result = $conn->query($sql1);
	$sql="UPDATE tarikh_tuntutan SET status_tuntutan='1' WHERE id='$id'";
	$result = $conn->query($sql);

	return $result;
	}
	
	function getTarikhTuntutanPrevious(){
	$conn=db();
	$sql="SELECT * FROM tarikh_tuntutan ORDER BY id DESC";
	$result = $conn->query($sql);
	return $result;
	}
    

	$conn->close();


?>