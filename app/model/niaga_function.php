
<?php

	require '../../lib/db/connection.php';
	
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
	
		
	// function getLogUser($com_id) {
		// $conn=db();
		// $sql = "SELECT s.*,r.role,ss.desc FROM staff s
                // LEFT JOIN role r ON s.role_id=r.id
				// LEFT JOIN status_staff ss ON s.status=ss.id
                // ";
		// $result = $conn->query($sql);
		// return $result;
	// }
	
	function getLogUser($com_id) {
		$conn=db();
		$sql = "SELECT * FROM staff WHERE company_id='$com_id'";
		$result = $conn->query($sql);
		return $result;
	}


function getSebutharga(){
    $conn=db();
		$sql = "SELECT i.*, SUM(jumlah_harga_item) AS total,p.code,p.produk,st.no_staff as nostaff_pegawai_dalaman,st.name as pegawai_dalaman    
		        FROM sebut_harga i
                LEFT JOIN item_sebut_harga s ON i.id_sebut_harga=s.id_sebut_harga 
                LEFT JOIN produk p ON i.id_produk=p.id 
                LEFT JOIN staff st ON i.pegawai_dalaman=st.no_staff 
                GROUP BY i.id_sebut_harga
                ORDER BY i.id_sebut_harga DESC";
		$result = $conn->query($sql);
		return $result;
}

function getBiltunai(){
    $conn=db();
		$sql = "SELECT bt.*, SUM(jumlah_harga_item) AS total,p.code,p.produk,st.no_staff as nostaff_pegawai_dalaman,st.name as pegawai_dalaman    
		        FROM bil_tunai bt
                LEFT JOIN bil_tunai_item bti ON bt.id_bil_tunai=bti.id_bil_tunai 
                LEFT JOIN produk p ON bt.id_produk=p.id 
                LEFT JOIN staff st ON bt.pegawai_dalaman=st.no_staff 
                GROUP BY bt.id_bil_tunai 
                ORDER BY bt.id_bil_tunai DESC";
		$result = $conn->query($sql);
		return $result;
}

function getReqSebutharga(){
    $conn=db();
		$sql = "SELECT rq.*,l.lead_telno as status_data_prospect FROM request_quote rq 
		        LEFT JOIN lead l ON rq.notel=l.lead_telno 
                ORDER BY rq.id DESC
                 ";
		$result = $conn->query($sql);
		return $result;
}

function getPesananBelianList(){
    $conn=db();
		$sql = "SELECT pb.*, sh.*,s.name AS nama_ketua_projek,sp.penerangan AS status_projek
                FROM pesanan_belian pb
                LEFT JOIN sebut_harga sh
                ON pb.id_sebut_harga = sh.id_sebut_harga
                LEFT JOIN staff s
                ON pb.ketua_projek = s.no_staff
                LEFT JOIN status_projek sp
                ON pb.status_penerimaan_tugas = sp.kod ORDER BY pb.id_pesanan_belian DESC";
		$result = $conn->query($sql);
		return $result;
}



function getSebuthargaIfo($id){
    $conn=db();
		$sql = "SELECT * FROM sebut_harga where id_sebut_harga='$id' ";
		$result = $conn->query($sql);
		return $result;
}

function getBiltunaiIfo($id){
    $conn=db();
		$sql = "SELECT * FROM bil_tunai where id_bil_tunai='$id' ";
		$result = $conn->query($sql);
		return $result;
}



function getCompany() {
		$conn=db();
		$sql = "SELECT * FROM company";
		$result = $conn->query($sql);
		return $result;
	}

function getCompanySC() {
		$conn=db();
		 $sql = "SELECT short_name AS shortcode FROM company";
		$result = $conn->query($sql);
		return $result;
	}


function getItem($id){
    $conn=db();
		$sql = "SELECT * FROM item_sebut_harga where id_sebut_harga='$id' ";
		$result = $conn->query($sql);
		return $result;
}

function getItemBilt($id){
    $conn=db();
		$sql = "SELECT * FROM bil_tunai_item where id_bil_tunai='$id'";
		$result = $conn->query($sql);
		return $result;
}

function getInbois(){
    $conn=db();
		$sql = "SELECT *,(SELECT SUM(rb.jumlah_bayaran) FROM resit_bayaran rb WHERE rb.id_inbois=i.id_inbois) AS jumlah_bayaran FROM inbois i LEFT JOIN sebut_harga sh ON i.id_sebut_harga=sh.id_sebut_harga 
		ORDER BY i.id_inbois DESC";
		$result = $conn->query($sql);
		return $result;
}
function getInboisInfo($id){
    $conn=db();
		$sql = "SELECT * FROM inbois i LEFT JOIN sebut_harga sh ON i.id_sebut_harga=sh.id_sebut_harga
                where i.id_inbois='$id'";
		$result = $conn->query($sql);
		return $result;
}







//update status penerimaan sebutharga
	function updateStatusPenerimaanSebutHarga($id,$status_jawapan,$tarikh_jawapan){
		 $conn=db();
		  $sql = "UPDATE sebut_harga SET status_penerimaan_sebut_harga='$status_jawapan' , tarikh_penerimaan_sebut_harga='$tarikh_jawapan' WHERE id_sebut_harga='$id'" ;
		 $result = $conn->query($sql);
		 return $result;
	}
	//update status penerimaan Inbois
	function updateStatusPenerimaanInbois($id,$status_jawapan,$tarikh_jawapan){
		 $conn=db();
		  $sql = "UPDATE inbois SET status_penerimaan_inbois='$status_jawapan' , tarikh_terima_inbois='$tarikh_jawapan' WHERE id_inbois='$id'" ;
		 $result = $conn->query($sql);
		 return $result;
	}
	
	//update status penerimaan biltunai
	function updateStatusPenerimaanBiltunai($id,$status_jawapan,$tarikh_jawapan){
		 $conn=db();
		  $sql = "UPDATE bil_tunai SET status_penerimaan_bil_tunai='$status_jawapan',tarikh_penerimaan_bil_tunai='$tarikh_jawapan' WHERE id_bil_tunai='$id'" ;
		 $result = $conn->query($sql);
		 return $result;
	}
	
	
	function getLead() {
    $conn=db();
    $sql = "SELECT l.*,ln.name as negeri,ls.name as segmen,s.no_staff as created_by,s.name as created_name  
            FROM lead l
            LEFT JOIN lkp_negeri ln ON l.id_negeri=ln.id 
            LEFT JOIN lead_segmen ls ON l.id_lead_segmen=ls.id 
            LEFT JOIN staff s ON l.created_by=s.no_staff 
            ORDER BY ls.name ASC,l.lead_name ASC";
    $result = $conn->query($sql);
    return $result;
  }
  
  function getLeadDetails($leadid) {
    $conn=db();
    $sql = "SELECT l.*,ln.name as negeri,ls.name as segmen FROM lead l
            LEFT JOIN lkp_negeri ln ON l.id_negeri=ln.id 
            LEFT JOIN lead_segmen ls ON l.id_lead_segmen=ls.id 
            WHERE l.id='$leadid'";
    $result = $conn->query($sql);
    return $result;
  }

  function getPegawai() {
    $conn=db();
    $sql = "SELECT s.*, d.description AS nama_bahagian
			FROM staff s
			LEFT JOIN department d
			ON s.department_id = d.code_department
			WHERE s.status='BEKERJA' AND s.noic IS NOT NULL 
			ORDER BY s.no_staff ASC";
    $result = $conn->query($sql);
    return $result;
  }
  
  function getProduct() {
    $conn=db();
    $sql = "SELECT p.id,p.produk,p.code   
            FROM produk p 
            WHERE p.status=1";
    $result = $conn->query($sql);
    return $result;
  }



function getLeadInformation($id) {
		$conn=db();
		$sql = "SELECT l.*,ln.name as negeri,ls.name as segmen,s.no_staff as created_by,s.name as created_name  
		        FROM lead l
                LEFT JOIN lkp_negeri ln ON l.id_negeri=ln.id 
                LEFT JOIN lead_segmen ls ON l.id_lead_segmen=ls.id 
                LEFT JOIN staff s ON l.created_by=s.no_staff 
                WHERE l.id='$id'";
		$result = $conn->query($sql)->fetch_assoc();
		return $result;
	}


function addItemSebutHarga($keterangan_item,$kuantiti_item,$harga_item,$jumlah_harga_item,$id_sebut_harga){
    
     $conn=db();
     $sql = "INSERT INTO item_sebut_harga(keterangan_item,kuantiti_item,harga_item,jumlah_harga_item,id_sebut_harga) VALUES('$keterangan_item','$kuantiti_item','$harga_item','$jumlah_harga_item','$id_sebut_harga')";
    $result = $conn->query($sql);
    return $result;
}

function addItemBiltunai($keterangan_item,$kuantiti_item,$harga_item,$jumlah_harga_item,$id_bil_tunai){
    
     $conn=db();
     $sql = "INSERT INTO bil_tunai_item (keterangan_item,kuantiti_item,harga_item,jumlah_harga_item,id_bil_tunai) VALUES('$keterangan_item','$kuantiti_item','$harga_item','$jumlah_harga_item','$id_bil_tunai')";
    $result = $conn->query($sql);
    return $result;
}



function addSebutHarga($agensi_rujukan,$tajuk_sebut_harga,$jumlah_sebut_harga,$terma_sebut_harga,$tempoh_sah_sebut_harga,$id_lead,$nama_rujukan,$alamat_rujukan,$notel_rujukan,$shortcode,$id_produk,$pegawai_dalaman){
    
     $conn=db();
    //$norujukan_sebut_harga=getRunning_No("norujukan_sebut_harga");
    
    
     $sql = "INSERT INTO sebut_harga(pegawai_dalaman,id_produk,agensi_rujukan,tajuk_sebut_harga,jumlah_sebut_harga, terma_sebut_harga,tempoh_sah_sebut_harga,id_lead,nama_rujukan,alamat_rujukan,notel_rujukan,status_sebut_harga,norujukan_sebut_harga)  
    VALUES('$pegawai_dalaman','$id_produk','$agensi_rujukan','$tajuk_sebut_harga','$jumlah_sebut_harga','$terma_sebut_harga','$tempoh_sah_sebut_harga','$id_lead','$nama_rujukan','$alamat_rujukan','$notel_rujukan','AKTIF',(SELECT CONCAT('$shortcode','/','SHG','/',YEAR(CURRENT_TIMESTAMP),'/',
LPAD(IFNULL(MAX(a.id_sebut_harga), 0) + 1, 4, '0')) AS norujukan_sebut_harga 
    FROM sebut_harga a )) ";
    
    
    $result = $conn->query($sql);
    return $result;
}

function addBiltunai($agensi_rujukan,$tajuk_bil_tunai,$jumlah_bil_tunai,$id_lead,$nama_rujukan,$alamat_rujukan,$notel_rujukan,$shortcode,$id_produk,$pegawai_dalaman){
    
     $conn=db();
    //$norujukan_sebut_harga=getRunning_No("norujukan_sebut_harga");
    
    
    $sql = "INSERT INTO bil_tunai (pegawai_dalaman,id_produk,agensi_rujukan,tajuk_bil_tunai,jumlah_bil_tunai,id_lead,nama_rujukan,alamat_rujukan,notel_rujukan,status_bil_tunai,norujukan_bil_tunai)  
            VALUES('$pegawai_dalaman','$id_produk','$agensi_rujukan','$tajuk_bil_tunai','$jumlah_bil_tunai','$id_lead','$nama_rujukan','$alamat_rujukan','$notel_rujukan','1',(SELECT CONCAT('$shortcode','/','TUNAI','/',YEAR(CURRENT_TIMESTAMP),'/',
            LPAD(IFNULL(MAX(a.id_bil_tunai), 0) + 1, 4, '0')) AS norujukan_bil_tunai FROM bil_tunai a ))";
    
    
    $result = $conn->query($sql);
    return $result;
}

function addSebutHarga2($agensi_rujukan,$tajuk_sebut_harga,$jumlah_sebut_harga,$terma_sebut_harga,$tempoh_sah_sebut_harga,$id_lead,$nama_rujukan,$alamat_rujukan,$notel_rujukan,$shortcode){
    
     $conn=db();
    //$norujukan_sebut_harga=getRunning_No("norujukan_sebut_harga");
    
    
     $sql = "INSERT INTO sebut_harga(agensi_rujukan,tajuk_sebut_harga,jumlah_sebut_harga, terma_sebut_harga,tempoh_sah_sebut_harga,id_lead,nama_rujukan,alamat_rujukan,notel_rujukan,status_sebut_harga,norujukan_sebut_harga)  
    VALUES('$agensi_rujukan','$tajuk_sebut_harga','$jumlah_sebut_harga','$terma_sebut_harga','$tempoh_sah_sebut_harga','$id_lead','$nama_rujukan','$alamat_rujukan','$notel_rujukan','AKTIF',(SELECT CONCAT('$shortcode','/','SHG','/',YEAR(CURRENT_TIMESTAMP),'/',
LPAD(IFNULL(MAX(a.id_sebut_harga), 0) + 1, 4, '0')) AS norujukan_sebut_harga 
    FROM sebut_harga a )) ";
    
    
    $result = $conn->query($sql);
    return $result;
}

function updateSebutHarga($nama_rujukan,$agensi_rujukan,$alamat_rujukan,$notel_rujukan,$tajuk_sebut_harga,$terma_sebut_harga,$tempoh_sah_sebut_harga,$id_sebut_harga,$id_produk,$pegawai_dalaman)
  {
		$conn=db();
		 $sql = "UPDATE sebut_harga 
		        SET nama_rujukan='$nama_rujukan', 
		        agensi_rujukan='$agensi_rujukan', 
		        alamat_rujukan='$alamat_rujukan', 
		        notel_rujukan='$notel_rujukan', 
		        tajuk_sebut_harga='$tajuk_sebut_harga', 
		        terma_sebut_harga='$terma_sebut_harga', 
		        tempoh_sah_sebut_harga='$tempoh_sah_sebut_harga',
		        id_produk='$id_produk',
		        pegawai_dalaman='$pegawai_dalaman' 
		        WHERE id_sebut_harga='$id_sebut_harga'"; 
 	  
				 
 	    $result = $conn->query($sql);
		return $result;
	}

function updateBiltunai($nama_rujukan,$agensi_rujukan,$alamat_rujukan,$notel_rujukan,$tajuk_bil_tunai,$id_bil_tunai,$id_produk,$pegawai_dalaman)
  {
		$conn=db();
		 $sql = "UPDATE bil_tunai 
		        SET nama_rujukan='$nama_rujukan', 
		        agensi_rujukan='$agensi_rujukan', 
		        alamat_rujukan='$alamat_rujukan', 
		        notel_rujukan='$notel_rujukan', 
		        tajuk_bil_tunai='$tajuk_bil_tunai', 
		        id_produk='$id_produk',
		        pegawai_dalaman='$pegawai_dalaman' 
		        WHERE id_bil_tunai='$id_bil_tunai'"; 
 	  
				 
 	    $result = $conn->query($sql);
		return $result;
	}

function updateItemSebutHarga($keterangan_item,$kuantiti_item,$harga_item,$jumlah_harga_item,$id,$id_sebut_harga)
  {
		$conn=db();
		 $sql = "UPDATE item_sebut_harga SET keterangan_item='$keterangan_item', kuantiti_item='$kuantiti_item', harga_item='$harga_item', jumlah_harga_item='$jumlah_harga_item' WHERE id='$id' AND id_sebut_harga='$id_sebut_harga'"; 
  
 	    $result = $conn->query($sql);
		return $result;
	}

function updateItemBiltunai($keterangan_item,$kuantiti_item,$harga_item,$jumlah_harga_item,$id,$id_bil_tunai)
  {
		$conn=db();
		 $sql = "UPDATE bil_tunai_item SET keterangan_item='$keterangan_item', 
		            kuantiti_item='$kuantiti_item', harga_item='$harga_item', 
		            jumlah_harga_item='$jumlah_harga_item' 
		            WHERE id='$id' AND id_bil_tunai='$id_bil_tunai'"; 
  
 	    $result = $conn->query($sql);
		return $result;
	}

	function getRunning_No($reference) {
		$conn=db();
		$new_running_no='';
		if ($reference=='norujukan_sebut_harga'){
		$new_running_no='INDEEP';
		}else if($reference=='norujukan_inbois'){
		$new_running_no='INDEEP';
		}
		
		 $sql= " SELECT LPAD(running_no, 4, '0') AS running_no FROM running_no WHERE reference='$reference'";
        $run_no = $conn->query($sql)->fetch_object()->running_no ;
		$niaga_number =$new_running_no.$run_no;
	
	//update running no
	
	$sql8 = "UPDATE running_no SET running_no=running_no+1 WHERE reference='$reference'";
	$result = $conn->query($sql8);
	
	return $niaga_number;
	
	
		}
		
function getSebutHargaID($id_sebut_harga){
    
    $conn=db();
		$sql = "SELECT id_sebut_harga 
		        FROM sebut_harga  
		        WHERE id_sebut_harga='$id_sebut_harga'";
		$result = $conn->query($sql);
		return $result;
}

function getBiltunaiID($id_bil_tunai){
    
    $conn=db();
		$sql = "SELECT id_bil_tunai 
		        FROM bil_tunai  
		        WHERE id_bil_tunai='$id_bil_tunai'";
		$result = $conn->query($sql);
		return $result;
}


function getItemSebutharga($id_sebut_harga)
{
     $conn=db();
     $sql = " SELECT *,SUM(jumlah_harga_item) AS total FROM item_sebut_harga WHERE id_sebut_harga='$id_sebut_harga' GROUP BY id";
		$result = $conn->query($sql);
		return $result;
}

function getItemBiltunai($id_bil_tunai)
{
     $conn=db();
     $sql = " SELECT *,SUM(jumlah_harga_item) AS total FROM bil_tunai_item WHERE id_bil_tunai='$id_bil_tunai' GROUP BY id";
		$result = $conn->query($sql);
		return $result;
}

function getPelangganEdit($id_sebut_harga)
{
  $conn=db();
     $sql = " SELECT * FROM sebut_harga WHERE id_sebut_harga='$id_sebut_harga'";
		$result = $conn->query($sql);
		return $result;
}

function getPelangganBiltunaiEdit($id_bil_tunai)
{
  $conn=db();
     $sql = " SELECT * FROM bil_tunai WHERE id_bil_tunai='$id_bil_tunai'";
		$result = $conn->query($sql);
		return $result;
}




function getRunning_No_Bayaran($reference,$shortcode) {
    $conn=db();
    $new_running_no='';
    if ($reference=='norujukan_bayaran '){
    $new_running_no=$shortcode;
    }else if($reference=='no_slip'){
    $new_running_no='SG';
    }
    
     $sql= " SELECT LPAD(running_no, 4, '0') AS running_no FROM running_no WHERE reference='$reference'";
        $run_no = $conn->query($sql)->fetch_object()->running_no ;
    $norujukan_bayaran =$new_running_no.$run_no;
  
  //update running no
  
  $sql8 = "UPDATE running_no SET running_no=running_no+1 WHERE reference='$reference'";
  $result = $conn->query($sql8);
  
  return $norujukan_bayaran;
  
  
    }

// get invoice status == 'AKTIF'
 function getInboisStatus($id_inbois) {
     $conn=db();
     $sql = "SELECT * FROM inbois WHERE status_inbois='AKTIF' ";
     $result = $conn->query($sql);
    
     return $result;
   }


function deleteSebutHarga($id) {
    $conn=db();
    $sql = "DELETE FROM item_sebut_harga WHERE id='$id' ";
        $result = $conn->query($sql);
return $result;
}

function deleteBiltunai($id) {
    $conn=db();
    $sql = "DELETE FROM bil_tunai_item WHERE id='$id' ";
        $result = $conn->query($sql);
return $result;
}




function updateTotalSebutHarga($jumlah_sebut_harga,$id_sebut_harga){
		$conn=db();
	    $sql = "UPDATE sebut_harga SET jumlah_sebut_harga='$jumlah_sebut_harga' WHERE id_sebut_harga='$id_sebut_harga'"; 
 	  
				 
 	    $result = $conn->query($sql);
		return $result;
	}
	
function updateTotalBiltunai($jumlah_bil_tunai,$id_bil_tunai){
		$conn=db();
	    $sql = "UPDATE bil_tunai SET jumlah_bil_tunai='$jumlah_bil_tunai' WHERE id_bil_tunai='$id_bil_tunai'"; 
 	  
				 
 	    $result = $conn->query($sql);
		return $result;
	}	

function getSebutHargaPelanggan($id_sebut_harga){
    
    $conn=db();
    $sql = "SELECT sh.*,p.code,p.produk,s.no_staff as nostaff_pegawai_dalaman,s.name as namastaff_pegawai_dalaman 
            FROM sebut_harga sh  
            LEFT JOIN produk p ON sh.id_produk=p.id 
            LEFT JOIN staff s ON sh.pegawai_dalaman=s.no_staff 
            WHERE sh.id_sebut_harga='$id_sebut_harga' ";
    $result = $conn->query($sql);
    return $result;
}

function getBiltunaiPelanggan($id_bil_tunai){
    
    $conn=db();
    $sql = "SELECT bt.*,p.code,p.produk,s.no_staff as nostaff_pegawai_dalaman,s.name as namastaff_pegawai_dalaman 
            FROM bil_tunai bt   
            LEFT JOIN produk p ON bt.id_produk=p.id 
            LEFT JOIN staff s ON bt.pegawai_dalaman=s.no_staff 
            WHERE bt.id_bil_tunai='$id_bil_tunai' ";
    $result = $conn->query($sql);
    return $result;
}

function getJanaInbois($id_sebut_harga,$shortcode){
    
         $conn=db();
    $sql = "INSERT INTO inbois(id_sebut_harga,norujukan_inbois,status_inbois) VALUES ('$id_sebut_harga',(SELECT CONCAT('$shortcode','/','INB','/',YEAR(CURRENT_TIMESTAMP),'/',
    LPAD(IFNULL(MAX(a.id_inbois), 0) + 1, 4, '0')) AS norujukan_inbois 
    FROM inbois a ), 'AKTIF') ";
    $result = $conn->query($sql);
    $sql2 = "UPDATE sebut_harga SET status_sebut_harga = '1' WHERE id_sebut_harga='$id_sebut_harga'";
    $result = $conn->query($sql2);
    
    return $result;

    
}

// to get payment details
	function getBayaran(){
	    $conn=db();
			$sql = "SELECT * FROM resit_bayaran rb  LEFT JOIN inbois i ON i.id_inbois=rb.id_inbois 
            LEFT JOIN sebut_harga sh ON i.id_sebut_harga=sh.id_sebut_harga ORDER BY rb.id_bayaran DESC";
			$result = $conn->query($sql);
			return $result;
	}

	// to get payment details to view by id
	function getBayaranDetails($id_bayaran){
	    $conn=db();
			$sql = "SELECT * FROM resit_bayaran rb 
			LEFT JOIN sebut_harga sh 
			ON rb.id_inbois=sh.id_sebut_harga 
			LEFT JOIN inbois i
			 ON i.id_inbois=rb.id_inbois
			 WHERE id_bayaran='$id_bayaran'";
			$result = $conn->query($sql);
			return $result;
	}

function addBayaran($id_inbois,$jumlah_bayaran,$tarikh_bayaran,$kaedah_bayaran,$no_cek_bayaran,$nama_bank_bayaran,$shortcode) {
		 $conn=db();

		

		 $sql = "INSERT INTO resit_bayaran(id_inbois,jumlah_bayaran,tarikh_bayaran,kaedah_bayaran,no_cek_bayaran,nama_bank_bayaran,status_bayaran,norujukan_bayaran)
					VALUES ('$id_inbois','$jumlah_bayaran','$tarikh_bayaran','$kaedah_bayaran','$no_cek_bayaran','$nama_bank_bayaran','1',(
					SELECT CONCAT('$shortcode','/','BYR','/',YEAR(CURRENT_TIMESTAMP),'/',
					LPAD(IFNULL(MAX(a.id_bayaran), 0) + 1, 4, '0')) AS norujukan_bayaran 
					FROM resit_bayaran a ))";


		$result = $conn->query($sql);

		return $result;
	}

	function getBayaranInfo($id){
	    $conn=db();
			$sql = "SELECT *,sum(jumlah_bayaran) as jumlah_dah_bayar FROM resit_bayaran rb LEFT JOIN inbois i ON rb.id_inbois = i.id_inbois
            LEFT JOIN sebut_harga sh ON i.id_sebut_harga=sh.id_sebut_harga
            WHERE i.id_inbois='$id'";
			$result = $conn->query($sql);
			return $result;
	}

	function getBayaranInfoResit($id){
	    $conn=db();
			$sql = "SELECT * FROM resit_bayaran rb LEFT JOIN inbois i ON rb.id_inbois = i.id_inbois
            LEFT JOIN sebut_harga sh ON i.id_sebut_harga=sh.id_sebut_harga
            WHERE rb.id_bayaran='$id'";
			$result = $conn->query($sql);
			return $result;
	}

		function getItemInfo($id_sebut_harga,$id){
	    $conn=db();
			$sql = " SELECT * FROM item_sebut_harga WHERE id_sebut_harga='$id_sebut_harga' AND id='$id'";
			$result = $conn->query($sql);
			return $result;
	}
	
	function getItemBiltunaiInfo($id_bil_tunai,$id){
	    $conn=db();
			$sql = " SELECT * FROM bil_tunai_item WHERE id_bil_tunai='$id_bil_tunai' AND id='$id'";
			$result = $conn->query($sql);
			return $result;
	}

//update status penerimaan bayaran
  function updateStatusPenerimaanBayaran($id,$status_jawapan,$tarikh_jawapan){
     $conn=db();
      $sql = "UPDATE resit_bayaran SET status_penerimaan_bayaran='$status_jawapan' , tarikh_penerimaan_bayaran='$tarikh_jawapan' WHERE id_bayaran='$id'" ;
     $result = $conn->query($sql);
     return $result;
  }
function getInboiDetails($id_inbois){
      $conn=db();
      $sql = "SELECT * 
,(SELECT SUM(rb.jumlah_bayaran) FROM resit_bayaran rb WHERE rb.id_inbois=i.id_inbois) AS jumlah_bayaran 
 FROM inbois i LEFT JOIN sebut_harga sh ON i.id_sebut_harga=sh.id_sebut_harga 
          WHERE i.id_inbois='$id_inbois'";
      $result = $conn->query($sql);
      return $result;
  }

function getBaki(){
          $conn=db();

   $sql=" 
SELECT (s.jumlah_sebut_harga-r.jumlah_bayaran) AS baki,r.id_bayaran FROM sebut_harga s LEFT JOIN resit_bayaran r 
ON s.id_sebut_harga=r.id_inbois GROUP BY s.id_sebut_harga"; 
$result = $conn->query($sql);
      return $result;
}



function getBayaranTerdahulu($id_inbois,$id_bayaran){
          $conn=db();

   $sql=" 
  SELECT SUM(jumlah_bayaran) AS bayaran_terdahulu FROM resit_bayaran WHERE id_inbois='$id_inbois' AND id_bayaran NOT IN ('$id_bayaran') AND id_bayaran<'$id_bayaran'"; 
$result = $conn->query($sql);
      return $result->fetch_object()->bayaran_terdahulu;
}


//to diplay button for add or view Purchase Order
function getPesananBelian($id_sebut_harga){
	$conn=db();
	$sql = "SELECT * FROM pesanan_belian WHERE id_sebut_harga='$id_sebut_harga'";
	$result = $conn->query($sql);
	return $result;
}

function getSebutHargaDetail($id_sebut_harga){

	$conn=db();
	$sql="SELECT * FROM sebut_harga WHERE id_sebut_harga='$id_sebut_harga'";
	$result = $conn->query($sql);
	return $result;
}

function getMaklumatPO($id_sebut_harga){
	$conn=db();
	$sql="SELECT pb.*,sh.nama_rujukan,sh.agensi_rujukan,sh.tajuk_sebut_harga,sh.norujukan_sebut_harga, s.name AS nama_pegawai_pelaksana, d.description AS nama_bahagian, ss.name AS pegawai_rujukan_dalaman,sp.penerangan
		FROM  pesanan_belian pb
		LEFT JOIN sebut_harga sh
		ON pb.id_sebut_harga=sh.id_sebut_harga
		LEFT JOIN staff s
		ON pb.ketua_projek = s.no_staff
		LEFT JOIN staff ss
		ON pb.pegawai_dalaman = ss.no_staff
		LEFT JOIN department d
		ON d.code_department= s.department_id
		LEFT JOIN status_projek sp
		ON pb.status_penerimaan_tugas = sp.kod
		WHERE pb.id_sebut_harga='$id_sebut_harga'";
	$result = $conn->query($sql);
	return $result;

	$default= $result-> fetch_assoc();
	
}

function getPurchaseOrderInfo($id_sebut_harga){
	$conn=db();
	$sql="SELECT pb.*,sh.nama_rujukan,sh.agensi_rujukan,sh.tajuk_sebut_harga,sh.norujukan_sebut_harga,s.name, d.description AS nama_bahagian
			FROM  pesanan_belian pb
			LEFT JOIN sebut_harga sh
			ON pb.id_sebut_harga=sh.id_sebut_harga
			LEFT JOIN staff s
			ON pb.ketua_projek = s.no_staff
			LEFT JOIN department d
			ON d.code_department= s.department_id
			WHERE pb.id_sebut_harga='$id_sebut_harga'";
	$result = $conn->query($sql);
	return $result;

	$default= $result-> fetch_assoc();
	
}

function getPOImg($id_sebut_harga){
	$conn=db();
	 $sql="	SELECT * FROM pesanan_belian WHERE id_sebut_harga='$id_sebut_harga'";

	$result = $conn->query($sql);
	$default= $result-> fetch_assoc();
	echo '<img src="data:image/jpeg;base64,'.base64_encode( $default['document'] ).'" style="width: 350px; height: 350px;"/>';

}


function getPODoc($id_sebut_harga){
	$conn=db();
	 $sql="	SELECT * FROM pesanan_belian WHERE id_sebut_harga='$id_sebut_harga'";

	$result = $conn->query($sql);
	$default= $result-> fetch_assoc();
	echo '<img src="data:image/jpeg;base64,'.base64_encode( $default['document_rujukan'] ).'" style="width: 350px; height: 350px;"/>';

}

function addPesananBelian($id_sebut_harga,$tarikh_pesanan_belian,$jumlah_harga,$document,$nama_document,$ketua_projek,$document_rujukan,$nama_document_rujukan,$pegawai_dalaman){

	$conn=db();
	$sql="INSERT INTO pesanan_belian(id_sebut_harga,tarikh_pesanan_belian,jumlah_harga,document,nama_document,ketua_projek,document_rujukan,nama_document_rujukan,pegawai_dalaman)
		  VALUES('$id_sebut_harga','$tarikh_pesanan_belian','$jumlah_harga','$document','$nama_document','$ketua_projek','$document_rujukan','$nama_document_rujukan','$pegawai_dalaman')";
	$result = $conn->query($sql);
	return $result;
}

function updatePesananBelian($id_sebut_harga,$tarikh_pesanan_belian,$jumlah_harga,$document,$nama_document,$ketua_projek,$document_rujukan,$nama_document_rujukan,$pegawai_dalaman){
  	$conn=db();
  	  $sql = "UPDATE pesanan_belian SET tarikh_pesanan_belian='$tarikh_pesanan_belian', jumlah_harga='$jumlah_harga', ketua_projek='$ketua_projek', pegawai_dalaman='$pegawai_dalaman'";
  	if($nama_document!="" && $nama_document_rujukan!=""){
 	           		$sql.=" ,document='$document',nama_document='$nama_document',document_rujukan='$document_rujukan', nama_document_rujukan='$nama_document_rujukan' "; 
 	           }
 	           $sql.=" WHERE id_sebut_harga='$id_sebut_harga'";

  	$result = $conn->query($sql);
  	return $result;
  }


 function updateKetuaProjek($id_sebut_harga,$ketua_projek){
 	$conn=db();
 	$sql="UPDATE pesanan_belian SET ketua_projek='$ketua_projek', status_penerimaan_tugas='DP' 
WHERE id_sebut_harga='$id_sebut_harga'";
 	$result = $conn->query($sql);
 	return $result;
 }

function getJumlahBayaran(){
    $conn=db();
		$sql = "SELECT SUM(sh.jumlah_sebut_harga) AS jumlahbayaran
                FROM inbois i  
                LEFT JOIN sebut_harga sh ON i.id_sebut_harga=sh.id_sebut_harga";
		$result = $conn->query($sql);
		return $result;
}

function getJumlahBayaranTunai(){
    $conn=db();
		$sql = "SELECT SUM(bt.jumlah_bil_tunai) AS jumlahbayarantunai
                FROM bil_tunai bt";
		$result = $conn->query($sql);
		return $result;
}

function getJumlahBayaranTerima(){
    $conn=db();
		$sql = "SELECT SUM(rb.jumlah_bayaran) AS jumlahbayaranterima
                FROM resit_bayaran rb";
		$result = $conn->query($sql);
		return $result;
}

function addPelanggan($name,$shrtname,$address,$telno,$email,$pic_name,$pic_position,$lokasi,$daerah,$negeri,$segmen,$status,$created_by){

	$conn=db();
	$sql="INSERT INTO lead (lead_name,lead_shrtname,lead_address,lead_telno,lead_email,pic_name,pic_position,lokasi,daerah,id_negeri,id_lead_segmen,status,created_by)
		  VALUES('$name','$shrtname','$address','$telno','$email','$pic_name','$pic_position','$lokasi','$daerah','$negeri','$segmen','$status','$created_by')";
	$result = $conn->query($sql);
	return $result;
}

function getCreated() {
    $conn=db();
    $sql = "SELECT no_staff as created_by,name as created_name  
			FROM staff  
			WHERE status='BEKERJA' AND noic IS NOT NULL
			ORDER BY no_staff";
    $result = $conn->query($sql);
    return $result;
  }

function getNegeri() {
    $conn=db();
    $sql = "SELECT * 
			FROM lkp_negeri 
			WHERE status=1 
			ORDER BY id";
    $result = $conn->query($sql);
    return $result;
  }

function getSegmen() {
    $conn=db();
    $sql = "SELECT * 
			FROM lead_segmen 
			WHERE status=1 
			ORDER BY id";
    $result = $conn->query($sql);
    return $result;
  }

function updatePelanggan($id,$name,$shrtname,$address,$telno,$email,$pic_name,$pic_position,$lokasi,$negeri,$daerah,$segmen,$status,$created_by){
     $conn=db();
     $sql = "UPDATE lead 
                SET 
                lead_name='$name',lead_shrtname='$shrtname',lead_address='$address',lead_telno='$telno',
                lead_email='$email',pic_name='$pic_name',pic_position='$pic_position',lokasi='$lokasi',
                daerah='$daerah',id_negeri='$negeri',id_lead_segmen='$segmen',status='$status',created_by='$created_by' 
                WHERE id='$id'" ;
                
     $result = $conn->query($sql);
     return $result;
  }  


?>