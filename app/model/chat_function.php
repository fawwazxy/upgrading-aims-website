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

	function getLogUser($com_id) {
		$conn=db();
		$sql = "SELECT * FROM staff WHERE company_id='$com_id'";
		$result = $conn->query($sql);
		return $result;
	}
function getCountArkib() {
		$conn=db();
		$sql = "SELECT COUNT(*) AS XCOUNT, c.category_name AS kategori, f.category_id AS kategori_id, f.topik AS topik
		FROM forum f
		LEFT JOIN forum_category c ON f.category_id=c.category_id
		GROUP BY f.category_id";
		
		$result = $conn->query($sql);
		
		//$conn->close();
		return $result;
	}

function getCountTopik() {
		$conn=db();
		$sql = "SELECT COUNT(r.topic_id) AS count, f.topik AS topik, r.topic_id AS id
		FROM forum f
		LEFT JOIN forum_reply r ON f.id=r.topic_id
		GROUP BY f.category_id";
		
		$result = $conn->query($sql);
		
		//$conn->close();
		return $result;
	}
	function getCountCategory($id) {
		$conn=db();
		 $sql = "SELECT DISTINCT(f.category_id), c.category_name, f.category_id AS kategori
		FROM forum f
		LEFT JOIN forum_category c ON f.category_id=c.category_id
		WHERE f.category_id='$id'";
		$result = $conn->query($sql);
		
		//$conn->close();
		return $result;
	}


	function getCategory() {
		$conn=db();
		$sql = "SELECT * FROM forum_category";
		$result = $conn->query($sql);
		return $result;
	}


	function getJenis() {
		$conn=db();
		$sql = "SELECT * FROM forum_jenis";
		$result = $conn->query($sql);
		return $result;
	}

	function getDepartment() {
		$conn=db();
		$sql = "SELECT * FROM department";
		$result = $conn->query($sql);
		return $result;
	}

	function getStaff() {
		$conn=db();
		$sql = "SELECT * FROM staff
		WHERE status='BEKERJA' AND noic IS NOT NULL";
		$result = $conn->query($sql);
		return $result;
	}

	function getStateForum() {
		$conn=db();
		$sql = "SELECT * FROM forum
		ORDER BY count DESC";
		$result = $conn->query($sql);
		return $result;
	}

	function getStatus1(){
		$conn=db();
		$sql ="SELECT f.*, s.username AS user, c.category_name, t.username
		 FROM forum f
		 LEFT JOIN forum_category c ON f.category_id=c.category_id
		LEFT JOIN staff s ON f.username=s.no_staff
		LEFT JOIN staff t ON f.penerima=t.no_staff
		WHERE f.status='1'
		ORDER BY f.forum_date DESC";

			$result = $conn->query($sql);
		return $result;
	}

	function getStatus0(){
		$conn=db();
		$sql = "SELECT f.*, s.username AS user, c.category_name, t.username
		 FROM forum f
		 LEFT JOIN forum_category c ON f.category_id=c.category_id
		LEFT JOIN staff s ON f.username=s.no_staff
		LEFT JOIN staff t ON f.penerima=t.no_staff
		WHERE f.status='0'
		ORDER BY f.forum_date DESC";

			$result = $conn->query($sql);
		return $result;
	}

	function getCategoryForum($category_id) {
		$conn=db();
		$sql = "SELECT *
		FROM forum_category
		WHERE category_id='$category_id'";
		$result = $conn->query($sql);
		return $result;
	}


	function getForumView($id) {
		$conn=db();
		$sql = "SELECT f.*, c.category_name, s.name AS username
		FROM forum f
		LEFT JOIN forum_category c ON f.category_id=c.category_id
		LEFT JOIN staff s ON f.username=s.no_staff
		WHERE f.penerima LIKE '%$id%'
		ORDER BY f.category_id";
		$result = $conn->query($sql);
		return $result;
	}

		function getForumUmum() {
		$conn=db();
		$sql = "SELECT f.*, c.category_name, s.name AS username
		FROM forum f
		LEFT JOIN forum_category c ON f.category_id=c.category_id
		LEFT JOIN staff s ON f.username=s.no_staff
		WHERE f.forum_jenis='UMUM'
		ORDER BY f.category_id";
		$result = $conn->query($sql);
		return $result;
	}

	function getForumView1($no_staff) {
		$conn=db();
		$sql = "SELECT f.*, c.category_name, s.name AS username
		FROM forum f
		LEFT JOIN forum_category c ON f.category_id=c.category_id
		LEFT JOIN staff s ON f.username=s.no_staff
		WHERE f.department_id LIKE CONCAT('%', ( SELECT department_id FROM staff WHERE no_staff='$no_staff'), '%')
		ORDER BY f.forum_date DESC";
		$result = $conn->query($sql);
		return $result;
	}

	function addCounter($id){
		$conn=db();
		$sql ="UPDATE forum SET count=(count + 1)
      	WHERE id='$id'";

		$result = $conn->query($sql);
		return $result;

	}

	function countRespon($id){
		$conn=db();
		$sql ="SELECT COUNT(r.forum_id) AS xcount
		FROM forum f
		LEFT JOIN forum_reply r ON f.id=r.forum_id
		WHERE f.id='$id'";

		$result = $conn->query($sql);
		return $result;

	}


	function getCarian($carian){
		$conn=db();
		$sql ="

		SELECT f.id, f.topik, fc.category_name AS category_name,f.message AS forum_message, r.message AS respon_message
		FROM forum f
		LEFT JOIN forum_reply r ON f.id=r.forum_id
		LEFT JOIN forum_category fc ON f.category_id=fc.category_id
		WHERE r.message LIKE '%$carian%' OR  f.message LIKE '%$carian%' OR f.topik LIKE '%$carian%'  OR  fc.category_name
		 LIKE '%$carian%'";
		$result = $conn->query($sql);
		return $result;

	}

	function getForumView2($id) {
		$conn=db();
		$sql = "SELECT f.*, c.category_name, s.name AS username,  t.phone AS telephone, t.name AS user_name, f.department_id AS department_id
		FROM forum f
		LEFT JOIN forum_category c ON f.category_id=c.category_id
		LEFT JOIN staff s ON f.username=s.no_staff
		LEFT JOIN staff t ON f.penerima=t.no_staff
		WHERE f.username='$id'
		ORDER BY f.forum_date DESC";
		$result = $conn->query($sql);
		return $result;
	}

	function getForumCategory($id) {
		$conn=db();
		$sql = "SELECT f.*, s.username, c.category_name, t.phone AS telephone, t.name AS user_name
		FROM forum f
		LEFT JOIN forum_category c ON f.category_id=c.category_id
		LEFT JOIN staff s ON f.username=s.no_staff
		LEFT JOIN staff t ON f.penerima=t.no_staff
		WHERE f.category_id='$id'
		ORDER BY f.forum_date DESC";
		$result = $conn->query($sql);
		return $result;
	}

	function addForum($id, $forum_jenis, $category, $topik, $message, $penerima, $department){
		$conn=db();
		 $sql = "INSERT INTO forum (username, forum_jenis, category_id, topik, message, penerima, department_id) VALUES ('$id', '$forum_jenis', '$category', '$topik', ?, '$penerima', '$department')";
		$stmt = $conn->prepare($sql) or die($conn->error);
		$stmt->bind_param("s",$message);
		
		$stmt->execute();
		$result = $stmt->insert_id;
		$stmt->close();
		// $result = $conn->query($sql);
		return $result;
	}

	function deleteForum($forum_id){
		$conn=db();
      $sql = "DELETE FROM forum WHERE id='$forum_id'";
      $result = $conn->query($sql);
    return $result;
	}


	function updateForum($forum_id){
		$conn=db();
      $sql = "UPDATE forum SET status='1' WHERE id='$forum_id'";
      $result = $conn->query($sql);
    return $result;
	}

	function updateForumReply($id){
		$conn=db();
      $sql = "UPDATE forum_reply SET status='1' WHERE reply_id='$id'";
      $result = $conn->query($sql);
    return $result;
	}

	function updateForumReply1($id){
		$conn=db();
      $sql = "UPDATE forum_reply_reply SET status='1' WHERE balas_id='$id'";
      $result = $conn->query($sql);
    return $result;
	}

	function addReply($id, $username, $message){
		$conn=db();
		$sql = "INSERT INTO forum_reply (forum_id, no_staff, message) VALUES ('$id' ,'$username', '$message')";
		$result = $conn->query($sql);
		return $result;
	}

	function addReply1($id_reply, $forum_id, $no_staff, $message){
		$conn=db();
		// $sql = "INSERT INTO forum_reply_reply (id_reply, id_topic, username, mesej) VALUES ('$id_reply', '$id' ,'$username', '$message')"
		$sql="INSERT INTO forum_reply (parent_id, forum_id, no_staff, message) VALUES ('$id_reply' ,'$forum_id','$no_staff', ?)";
		$stmt = $conn->prepare($sql) or die($conn->error);
		$stmt->bind_param("s",$message);
		
		$stmt->execute();
		$result = $stmt->insert_id;
		$stmt->close();
		// $result = $conn->query($sql);
		return $result;
	}

	function getReplyView($id) {
		$conn=db();
		$sql = "SELECT f.*, s.name AS name, r.message AS mesej, r.reply_date AS reply_date, r.id AS reply_id, r.status AS status
		FROM forum f
		LEFT JOIN forum_reply r ON f.id=r.forum_id
		LEFT JOIN staff s ON r.no_staff=s.no_staff
		WHERE f.id='$id' AND r.parent_id IS NULL
		ORDER BY r.reply_date DESC";
		$result = $conn->query($sql);
		return $result;
	}

	function getReplyView1($reply_id) {
		$conn=db();
		$sql = "SELECT f.*, s.username AS name, r.message AS mesej, r.reply_date AS reply_date, r.id AS reply_id
		FROM forum f
		LEFT JOIN forum_reply r ON f.id=r.forum_id
		LEFT JOIN staff s ON r.no_staff=s.no_staff
		WHERE r.id='$reply_id'
		ORDER BY r.reply_date DESC";
		$result = $conn->query($sql);
		return $result;
	}

	function getReplyView2($id_reply, $forum_id) {
		$conn=db();
		 $sql = "SELECT fr.*, s.name AS u_name, f.id AS forum_id, fr.id AS reply_id
		FROM forum_reply fr
		LEFT JOIN forum f ON fr.forum_id = f.id
		LEFT JOIN staff s ON fr.no_staff=s.no_staff
		WHERE fr.parent_id='$id_reply' AND fr.forum_id='$forum_id' AND fr.parent_id IS NOT NULL";
		$result = $conn->query($sql);
		return $result;
	}


	function addCategory($category_name){
		$conn=db();
		$sql = "INSERT INTO forum_category (category_name) VALUES ('$category_name')";
		$result = $conn->query($sql);
		return $result;
	}

	function deleteCategory($category_id){
		$conn=db();
      $sql = "DELETE FROM forum_category WHERE category_id='$category_id'";
      $result = $conn->query($sql);
    return $result;
	}

	function editCategory($category_name, $id) {
		 $conn=db();
		  $sql = "UPDATE forum_category SET category_name='$category_name' WHERE category_id='$id'" ;
		 $result = $conn->query($sql);
		 return $result;
	}

	function getCategoryInfo($category_id) {
		$conn=db();
		$sql = "SELECT * FROM forum_category WHERE category_id='$category_id'" ;
		$result = $conn->query($sql);
		return $result;
	}

	function getTopikView($forum_id) {
		$conn=db();
		$sql = "SELECT f.*, c.category_name, s.name
		FROM forum f
		LEFT JOIN forum_category c ON f.category_id=c.category_id
		LEFT JOIN staff s ON f.username=s.no_staff
		WHERE f.id='$forum_id'";
		$result = $conn->query($sql);
		return $result;
	}

	//report analisa
	function getTopic_table(){
		$conn=db();
		$sql = "SELECT COUNT(*) AS xcount, c.category_name AS kategori
		FROM forum f
				LEFT JOIN forum_category c ON f.category_name=c.category_id
				GROUP BY c.category_name";
				
		$result = $conn->query($sql);
		
		//$conn->close();
		return $result;
	}


	function updateNoti($noti_status,$no_pemohon){
       

     	 $conn=db();

          $sql="UPDATE forum SET notifikasi='1'
                WHERE penerima='$no_pemohon'";

          $result = $conn->query($sql);

     	  return $result;
	}

if ($action=="getDropDownForum") {
		$table_ref = $_POST['table_ref'];
		$value_ref = $_POST['value_ref'];
		$text_ref = $_POST['text_ref'];
		
		$conn=db();
		$sql = "SELECT ".$value_ref.",".$text_ref." FROM ".$table_ref;
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($list  = $result -> fetch_array()){
		  $txt_result .= "<option value=\"".$list[0]."\">".$list[1]." </option>";
		  
		}
		echo $txt_result;
		
		//return $txt_result;
	}

		function getDepartment1() {
		$conn=db();
		$sql = "SELECT * FROM department";
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($list  = $result -> fetch_assoc()){
			$txt_result .= "<option value=\"".$list['code_department']."\">".$list['desc']." </option>";
		}
		return $txt_result;
	}


		function getTableRef() {
		$conn=db();
		$sql = "SELECT table_ref FROM forum_jenis  ";
		$result = $conn->query($sql);
		
		  $txt_result="";
		  while ($list  = $result -> fetch_assoc()){
			  $txt_result .= "<option value=\"".$list['table_ref']."\">".$list['table_ref']." </option>";
			}
		
		return  $txt_result;
	}


		function getTable() {
		$conn=db();
		$sql = "SELECT jenis FROM forum_jenis  ";
		$result = $conn->query($sql);

		return $result;
	}
		 function getNoStaff1() {
		$conn=db();
		$sql = "SELECT * FROM staff  ";
		$result = $conn->query($sql);
		
		  $txt_result="";
		  while ($list  = $result -> fetch_assoc()){
			  $txt_result .= "<option value=\"".$list['no_staff']."\">".$list['name']." </option>";
			 
		  }
		
		
		return  $txt_result;
	}

	?>