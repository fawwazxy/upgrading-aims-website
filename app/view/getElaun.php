<?php
    require '../../lib/db/connection.php';
    $conn=db();
    
     $sql="SELECT DISTINCT(nama_elaun) FROM elaun ";
    $result = $conn->query($sql);

  $json="";
  if ($result->num_rows >0){
  $json .= "[";
  $cnt=0;
  while($row = $result -> fetch_assoc()) {
   if($cnt>0){
   $json.=",";
   }
   $json .= "{\"name\":\"".$row['nama_elaun']."\"}";
   $cnt++;
  }
   $json .= "]";
}
    //echo json_decode($json);
	
	echo $json;
	$conn->close();
?>