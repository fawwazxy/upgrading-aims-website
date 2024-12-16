<?php

function getStaffName(){
	$conn=db();
	$sql = "SELECT s.name AS nama, f.topik AS topik
	FROM forum f
	LEFT JOIN staff s ON f.username=s.no_staff
	LEFT JOIN forum_reply r ON f.forum_id=r.topic_id
	GROUP BY f.username, f.forum_id
	ORDER BY f.username, forum_id";
	
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


function getCategoryStatus() {
	$conn=db();
	$sql = "SELECT COUNT(DISTINCT r.user_id) AS COUNT, CONCAT(s.username, '-' ,f.topik) AS staff, f.topik AS topik
	FROM forum f
	LEFT JOIN forum_reply r ON f.forum_id=r.topic_id
	LEFT JOIN staff s ON r.user_id=s.no_staff
	GROUP BY r.user_id, r.topic_id";
	
	$result = $conn->query($sql);
	
		//$conn->close();
	return $result;
}

function getCategoryAnalisa(){
	$conn = db();
	$sql="SELECT COUNT(*) AS COUNT,CONCAT(c.category_name) AS kategori FROM forum f
	LEFT JOIN forum_category c ON f.category_id=c.category_id 
	GROUP BY CONCAT (c.category_name)";

	$result = $conn->query($sql);

	return $result;
}

	//test
function getName() {
	$conn=db();
	$sql = "SELECT  f.topik AS topik_name
	FROM forum f
	LEFT JOIN staff s 
	ON f.username=s.no_staff
	LEFT JOIN forum_reply r
	ON f.id= r.forum_id
	GROUP BY f.topik
	ORDER BY f.forum_date";
	
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

function getNameStatus() {
	$conn=db();
	$sql = "
	SELECT DISTINCT(s.username), r.no_staff AS user_id
	FROM forum_reply r
	LEFT JOIN staff s ON r.no_staff=s.no_staff";

	$result = $conn->query($sql);

	return $result;
}

function getCountStatus() {
	$conn=db();
	$sql = "SELECT COUNT(*) AS xcount, s.name AS nama, r.no_staff AS id, f.topik AS topik, r.forum_id AS id_topik
	FROM forum f 
	LEFT JOIN forum_reply r ON f.id=r.forum_id
	LEFT JOIN staff s ON r.no_staff=s.no_staff
	GROUP BY f.topik
	ORDER BY f.forum_date";
		// "SELECT COUNT(*) AS xcount, s.name AS nama, s.no_staff AS id_staff, 
		// f.topik AS topik, r.topic_id AS id_topik
		// FROM forum f 
	 //    LEFT JOIN staff s ON f.username=s.no_staff
	 //    LEFT JOIN forum_reply r ON f.forum_id=r.topic_id
		// GROUP BY CONCAT(f.username, f.forum_id)
		// ORDER BY CONCAT(f.username, f.forum_id)";

	$result = $conn->query($sql);

	return $result;
}

function getCount($id,$id_topik){
	$conn=db();
	$sql = "SELECT COUNT(r.no_staff) AS xcount, s.username AS user_id, r.forum_id  AS id_topik
	FROM forum f
	LEFT JOIN forum_reply r ON f.id = r.forum_id
	LEFT JOIN staff s ON r.no_staff=s.no_staff
	WHERE r.no_staff='$id' AND r.forum_id='$id_topik'";
		// "SELECT COUNT(topic_id) AS xcount 
		// FROM forum f

		// WHERE user_id='$id_staff' AND topic_id='$id_topik'";

	$result = $conn->query($sql);
	
		//$conn->close();
	return $result->fetch_object()->xcount;
}


function getCountPopular() {
	$conn=db();
	$sql = "SELECT COUNT(f.count) AS COUNT
	FROM forum f
	WHERE f.count!='0'";
	
	$result = $conn->query($sql);

	return $result;
}


function getCountTakPopular() {
	$conn=db();
	$sql = "SELECT COUNT(f.count) AS COUNT
	FROM forum f
	WHERE f.count='0'";
	
	$result = $conn->query($sql);

	return $result;
}

function getCountJenis() {
	$conn=db();
	$sql = "SELECT COUNT(*) AS count,f.forum_jenis AS jenis 
	FROM forum f
	GROUP BY f.forum_jenis";
	
	$result = $conn->query($sql);

	return $result;
}

function getCountBalasTajuk() {
	$conn=db();
	$sql = "SELECT COUNT(r.forum_id) AS xcount, f.topik AS tajuk
	FROM forum f
	LEFT JOIN forum_reply r ON f.id=r.forum_id
	GROUP BY r.forum_id";
	
	$result = $conn->query($sql);

	return $result;
}


function getTotalForumJan(){

	$conn=db();
	$sql = "SELECT COUNT(f.id) AS countTotalJan,      
	DATE_FORMAT(f.forum_date,'%M') AS bulan
	FROM forum f 
	WHERE MONTH(forum_date) = 1 AND YEAR(forum_date) = YEAR(CURDATE())";
	$result = $conn->query($sql);
	$results =  $result->fetch_object()->countTotalJan;
	return $results;

}
function getTotalForumFeb(){

	$conn=db();
	$sql = "SELECT COUNT(f.id) AS countTotalFeb,      
	DATE_FORMAT(f.forum_date,'%M') AS bulan
	FROM forum f 
	WHERE MONTH(forum_date) = 2 AND YEAR(forum_date) = YEAR(CURDATE())";
	$result = $conn->query($sql);
	$results =  $result->fetch_object()->countTotalFeb;
	return $results;

}
function getTotalForumMac(){

	$conn=db();
	$sql = "SELECT COUNT(f.id) AS countTotalMac,      
	DATE_FORMAT(f.forum_date,'%M') AS bulan
	FROM forum f 
	WHERE MONTH(forum_date) = 3 AND YEAR(forum_date) = YEAR(CURDATE())";
	$result = $conn->query($sql);
	$results =  $result->fetch_object()->countTotalMac;
	return $results;

}

function getTotalForumApr(){

	$conn=db();
	$sql = "SELECT COUNT(f.id) AS countTotalApr,      
	DATE_FORMAT(f.forum_date,'%M') AS bulan
	FROM forum f 
	WHERE MONTH(forum_date) = 4 AND YEAR(forum_date) = YEAR(CURDATE())";
	$result = $conn->query($sql);
	$results =  $result->fetch_object()->countTotalApr;
	return $results;

}
function getTotalForumMei(){

	$conn=db();
	$sql = "SELECT COUNT(f.id) AS countTotalMei,      
	DATE_FORMAT(f.forum_date,'%M') AS bulan
	FROM forum f 
	WHERE MONTH(forum_date) = 5 AND YEAR(forum_date) = YEAR(CURDATE())";
	$result = $conn->query($sql);
	$results =  $result->fetch_object()->countTotalMei;
	return $results;

}


function getTotalForumJun(){

	$conn=db();
	$sql = "SELECT COUNT(f.id) AS countTotalJun,      
	DATE_FORMAT(f.forum_date,'%M') AS bulan
	FROM forum f 
	WHERE MONTH(forum_date) = 6 AND YEAR(forum_date) = YEAR(CURDATE())";
	$result = $conn->query($sql);
	$results =  $result->fetch_object()->countTotalJun;
	return $results;

}
function getTotalForumJul(){

	$conn=db();
	$sql = "SELECT COUNT(f.id) AS countTotalJul,      
	DATE_FORMAT(f.forum_date,'%M') AS bulan
	FROM forum f 
	WHERE MONTH(forum_date) = 7 AND YEAR(forum_date) = YEAR(CURDATE())";
	$result = $conn->query($sql);
	$results =  $result->fetch_object()->countTotalJul;
	return $results;

}
function getTotalForumOgos(){

	$conn=db();
	$sql = "SELECT COUNT(f.id) AS countTotalOgos,      
	DATE_FORMAT(f.forum_date,'%M') AS bulan
	FROM forum f 
	WHERE MONTH(forum_date) = 8 AND YEAR(forum_date) = YEAR(CURDATE())";
	$result = $conn->query($sql);
	$results =  $result->fetch_object()->countTotalOgos;
	return $results;

}
function getTotalForumSept(){

	$conn=db();
	$sql = "SELECT COUNT(f.id) AS countTotalSept,      
	DATE_FORMAT(f.forum_date,'%M') AS bulan
	FROM forum f 
	WHERE MONTH(forum_date) = 9 AND YEAR(forum_date) = YEAR(CURDATE())";
	$result = $conn->query($sql);
	$results =  $result->fetch_object()->countTotalSept;
	return $results;

}


function getTotalForumOct(){

	$conn=db();
	$sql = "SELECT COUNT(f.id) AS countTotalOct,      
	DATE_FORMAT(f.forum_date,'%M') AS bulan
	FROM forum f 
	WHERE MONTH(forum_date) = 10 AND YEAR(forum_date) = YEAR(CURDATE())";
	$result = $conn->query($sql);
	$results =  $result->fetch_object()->countTotalOct;
	return $results;

}


function getTotalForumNov(){

	$conn=db();
	$sql = "SELECT COUNT(f.id) AS countTotalNov,      
	DATE_FORMAT(f.forum_date,'%M') AS bulan
	FROM forum f 
	WHERE MONTH(forum_date) = 11 AND YEAR(forum_date) = YEAR(CURDATE())";
	$result = $conn->query($sql);
	$results =  $result->fetch_object()->countTotalNov;
	return $results;

}

function getTotalForumDis(){

	$conn=db();
	$sql = "SELECT COUNT(f.id) AS countTotalDis,      
	DATE_FORMAT(f.forum_date,'%M') AS bulan
	FROM forum f 
	WHERE MONTH(forum_date) = 12 AND YEAR(forum_date) = YEAR(CURDATE())";
	$result = $conn->query($sql);
	$results =  $result->fetch_object()->countTotalDis;
	return $results;

}

function getTotalAduanTahun($tahun){

	$conn=db();
	$sql = "SELECT COUNT(f.id) AS countTotalDis  
	FROM forum f
	WHERE  YEAR(forum_date) = '$tahun'";
	$result = $conn->query($sql);
	$results =  $result->fetch_object()->countTotalDis;
	return $results;

}
?>