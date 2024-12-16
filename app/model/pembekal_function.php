 <?php

require '../../lib/db/connection.php';

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
		$sql = "SELECT * FROM sys_setting";
		if ($sys_id!='') {
			$sql .= " WHERE sys_id='$sys_id'";
		}
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
	 //pembekal
 function addPembekal($nama_syarikat, $short_name, $person_incharge, $supplier_code, $address1,$address2,$district,$city,$state,$country,$contact_no,$fax_no,$official_email,$dept_email,$facebook_id,$bank,$account_no,$zone, $type) {
    $conn=db();
    $sql = "INSERT INTO supplier (company_name, short_name, person_incharge, supplier_code, address1,address2, district,city,state,country,contact_no,fax_no,official_email,dept_email,facebook_id,bank,account_no) VALUES ('$nama_syarikat', '$short_name', '$person_incharge', '$supplier_code', '$address1','$address2','$district','$city','$state','$country','$contact_no','$fax_no','$official_email','$dept_email','$facebook_id','$bank','$account_no')";  
    $result = $conn->query($sql);

    $id =  $conn->insert_id;

    $sql2 ="INSERT INTO supplier_zone (id_supplier, id_zone) 
		VALUES ((SELECT id FROM supplier WHERE id='$id'),'$zone') ";
		$result = $conn->query($sql2);

		 $sql3 ="INSERT INTO supplier_type (id_supplier, id_supplier_type) 
		VALUES ((SELECT id FROM supplier WHERE id='$id'),'$type') ";
		$result = $conn->query($sql3);

    return $conn->insert_id;
  }

  function getPembekalInfo($id) {
		$conn=db();
		$sql = "SELECT s.*, sz.id AS zone_id, st.id AS type_id, z.zone_name AS zone_name, c.category_type AS TYPE
		FROM supplier s 
		LEFT JOIN supplier_zone sz ON sz.id_supplier=s.id
		LEFT JOIN supplier_type st ON st.id_supplier=s.id
		LEFT JOIN lkp_zone z ON sz.id_zone=z.id
		LEFT JOIN lkp_category_type c ON st.id_supplier_type=c.id
		WHERE s.id='$id'" ;
		$result = $conn->query($sql);
		return $result;
	}

	function  editPembekal($nama_syarikat, $short_name, $person_incharge, $supplier_code, $address1,$address2,$district,$city,$state,$country,$contact_no,$fax_no,$official_email,$dept_email,$facebook_id,$bank,$account_no, $zone, $type, $id) {
		 $conn=db();
		 $sql = "UPDATE supplier SET company_name='$nama_syarikat', short_name='$short_name', person_incharge='$person_incharge', supplier_code='$supplier_code', address1='$address1', address2='$address2', district='$district', city='$city', state='$state', country='$country', contact_no='$contact_no', fax_no='$fax_no', official_email='$official_email', dept_email='$dept_email', facebook_id='$facebook_id', bank='$bank', account_no='$account_no'
		  WHERE id='$id'" ;
		 $result = $conn->query($sql);

		 $sql2="UPDATE supplier_zone SET id_zone='$zone' WHERE id_supplier='$id'";
		  $result = $conn->query($sql2);

		  $sql3="UPDATE supplier_type SET id_supplier_type='$type' WHERE id_supplier='$id'";
		  $result = $conn->query($sql3);


		 return $result;
	}
	
function getPembekal() {
    $conn=db();
    $sql = "SELECT * FROM supplier";
    $result = $conn->query($sql);
    return $result;
  }

	function deletePembekal($id) {
		$conn=db();
		$sql = "DELETE FROM supplier WHERE id = '$id'";
		$result = $conn->query($sql);
		return $result;
	}

	function getZone() {
    $conn=db();
    $sql = "SELECT * FROM lkp_zone";
    $result = $conn->query($sql);
    return $result;
  }

  function getCategoryType() {
    $conn=db();
    $sql = "SELECT * FROM lkp_supplier_type";
    $result = $conn->query($sql);
    return $result;
  }

  function getPembekalDetails($id) {
		$conn=db();
		$sql = "SELECT * FROM supplier
		WHERE id = '$id'";

		$result = $conn->query($sql);
		return $result;
	}

	function getZoneDetails($id) {
		$conn=db();
		$sql = "SELECT sz.*, z.zone_name AS zone_name, z.zone_desc
		FROM supplier_zone sz
		LEFT JOIN lkp_zone z ON sz.id_zone=z.id
		WHERE sz.id_supplier = '$id'";

		$result = $conn->query($sql);
		return $result;
	}

	function getTypeDetails($id) {
		$conn=db();
		$sql = "SELECT st.*, c.type AS type
		FROM supplier_type st
		LEFT JOIN lkp_supplier_type c ON st.id_supplier_type=c.id
		WHERE st.id_supplier = '$id'";

		$result = $conn->query($sql);
		return $result;
	}

	?>