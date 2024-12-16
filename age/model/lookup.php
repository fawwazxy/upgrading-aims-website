<?php

	//require 'util/util_lookup.php';

	function getLookupTable($tablename,$value,$text) {
		$conn=db();
		 $sql = "SELECT ".$value.",".$text." FROM $tablename";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option value=\"".$row[0]."\">".$row[1]." </option>";
		}
		//$conn->close();
		return $txt_result;
	}

	function getLookupActive($tablename,$value,$text) {
		$conn=db();
		  $sql = "SELECT ".$value.",".$text." FROM $tablename where status_id=1";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option value=\"".$row[0]."\">".$row[1]." </option>";
		}
		//$conn->close();
		return $txt_result;
	}

	function getDropDown($tablename,$value,$text,$selected) {
		$conn=db();
		 $sql = "SELECT ".$value.",".$text." FROM $tablename";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
		}
		//$conn->close();
		return $txt_result;
	}

	function getLookupHarga($jenis_kategori,$jenis_transaksi) {
		$conn=db();
		$sql = "select * from harga_semasa where jenis_kategori='$jenis_kategori' and jenis_transaksi='$jenis_transaksi'";
		
		$result = $conn->query($sql);
		return $result->fetch_object()->harga;
	}

	function getLookupUpah() {
		$conn=db();
	 	$sql = "select percentage from margin_upah where id=1";
		
		$result = $conn->query($sql);
		$results =  $result->fetch_object()->percentage;

		return $results;

	}
	
	function getLookupSasaran() {
		$conn=db();
	 	$sql = "select sasaran from sasaran_jualan where id=1";
		
		$result = $conn->query($sql);
		$results =  $result->fetch_object()->sasaran;

		return $results;

	}
	
?>