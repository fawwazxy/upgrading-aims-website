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
		$sql = "SELECT * FROM sys_setting";
		if ($sys_id!='') {
			$sql .= " WHERE sys_id='$sys_id'";
		}
		$result = $conn->query($sql);
		return $result;
	}
	//start bai
	function addProjectDetails($project_code, $project_name, $client_name, $state, $parliament, $type_of_job, $remark, $created_by, $imgContent, $start_date, $country){
		$conn=db();
		$sql = "INSERT INTO project (project_code,project_name,client_name,state,parliament,type_of_job,remark,project_site_plan,created_by,start_date,country)
				VALUES('$project_code','$project_name','$client_name','$state','$parliament','$type_of_job','$remark','$imgContent','$created_by','$start_date','$country')";
		$result = $conn->query($sql);
		return $conn->insert_id;
	}
	
	function getProjectDetails(){
		$conn=db();
		$sql = "SELECT p.id,p.`project_code`,p.`project_name`,
		p.`client_name`,p.`parliament`,p.`state`,p.`country`,
		p.`type_of_job`,p.`start_date`,p.`remark`,p.`project_site_plan`, p.status,
		p.`created_date`,p.`created_by`
		FROM project p";
		$result = $conn->query($sql);
		return $result;
	}
//end bai
	//start wani

	
	function getProjectInformation($id_project) {
		$conn=db();
		$sql = "SELECT * FROM project WHERE id='$id_project'";
		
		$result = $conn->query($sql);
		return $result;
	}	

	function editProjectDetailsImage($project_code, $project_name, $client_name, $state, $parliament, $type_of_job, $remark, $created_by, $imgContent, $start_date, $country, $id_project){
		$conn=db();

		$sql = "UPDATE project SET project_code='$project_code', project_name='$project_name', client_name='$client_name', state='$state', parliament='$parliament', type_of_job='$type_of_job', remark='$remark', created_by='$created_by', project_site_plan='$imgContent', start_date='$start_date', country='$country' WHERE id='$id_project'";

		$result = $conn->query($sql);
		return $result;
	}

	function editProjectDetailsWithoutImage($project_code, $project_name, $client_name, $state, $parliament, $type_of_job, $remark, $created_by, $start_date, $country, $id_project){
		$conn=db();

		$sql = "UPDATE project SET project_code='$project_code', project_name='$project_name', client_name='$client_name', state='$state', parliament='$parliament', type_of_job='$type_of_job', remark='$remark', created_by='$created_by', start_date='$start_date', country='$country' WHERE id='$id_project'";

		$result = $conn->query($sql);
		return $result;
	}


//end wani
		
//start bielah
	function addMilestone($id, $milestone, $user_name){
    $conn=db();
     $sql = "INSERT INTO project_schedule_milestone (id_project, milestone, created_by) VALUES ('$id', '$milestone','$user_name')";
    $result = $conn->query($sql);
    return $conn->insert_id;
  }

  function addMilestoneTask($milestone_id, $task_name, $task_start, $duration, $task_finish, $user_name, $slack){
    $conn=db();
    $sql = "INSERT INTO project_schedule_task (id_project_schedule_milestone, task, start_date, duration, end_date, created_by, slack) VALUES ('$milestone_id', '$task_name', '$task_start', '$duration', '$task_finish', '$user_name', '$slack')";
    $result = $conn->query($sql);
    return $result;
  }


  function getProject($id) {
    $conn=db();
   $sql = "SELECT * 
  FROM project
  WHERE id='$id'";  
    $result = $conn->query($sql);
    return $result;
  }

  function getTask($id) {
    $conn=db();
   $sql = "SELECT t.*, t.id AS id FROM project_schedule_task t
LEFT JOIN project_schedule_milestone p
ON t.id_project_schedule_milestone=p.id
WHERE t.id_project_schedule_milestone='$id'
ORDER BY t.id_project_schedule_milestone ASC";  
    $result = $conn->query($sql);
    return $result;
  }
function getProjectDetail($id) {
    $conn=db();
   $sql = "SELECT * 
FROM project_schedule_milestone
WHERE id_project='$id'";  
    $result = $conn->query($sql);
    return $result;
  }

  function getMilestone($id) {
    $conn=db();
   $sql = "SELECT * 
  FROM project_schedule_milestone
  WHERE id_project='$id'";  
    $result = $conn->query($sql);
    return $result;
  }
  
   function getDateMin($milestone_id) {
    $conn=db();
    $sql = "SELECT *, MIN(start_date) AS SD,
     MAX(end_date) AS ED
  FROM project_schedule_task
  WHERE id_project_schedule_milestone='$milestone_id'";  
    $result = $conn->query($sql);
    return $result;
  }
  function deleteMilestone($milestone_id){
    $conn=db();
      $sql = "DELETE FROM project_schedule_milestone WHERE id='$milestone_id'";
      $result = $conn->query($sql);
    return $result;
  }
  function deleteTask($task_id){
    $conn=db();
      $sql = "DELETE FROM project_schedule_task WHERE id='$task_id'";
      $result = $conn->query($sql);
    return $result;
  }
  
  //end bielah

  // start lan
  function getScheduleMilestone($id){
       $conn=db();
        $sql= "SELECT psm.*,MIN(pst.start_date) AS start_date, MAX(pst.end_date) AS end_date FROM project_schedule_milestone psm
        LEFT JOIN project_schedule_task pst ON psm.id = pst.id_project_schedule_milestone
        WHERE psm.id_project='$id' GROUP BY psm.milestone ORDER BY psm.id asc";
               $result = $conn->query($sql);
       return $result;

    }
	
	function getScheduleTask($id_project_schedule_milestone){
     	$conn=db();
     	$sql= "SELECT * FROM project_schedule_task WHERE id_project_schedule_milestone='$id_project_schedule_milestone'";
				     	$result = $conn->query($sql);
     	return $result;

    }

 function getProjekById($id){
     	$conn=db();
     	  $sql= "SELECT project_code,project_name, client_name FROM project WHERE id='$id'";
		$result = $conn->query($sql) or die($conn->error);
     	return $result;

    }
// end lan
//start ps member
    $action = $_POST['action'];

    if ($action == "ps_member_material_update"){
	$id_project=($_GET['id_project']);
	$id=($_POST['id']);
	$member_role = ($_POST['roles']);
	$member_code = ($_POST['assign']);
	$amount_value = ($_POST['amount']);

	$result = UpdateMemberTeam($member_role, $member_code, $amount_value, $id);

} 
else if ($action == "ps_member_team_update"){
	$id_project=($_GET['id_project']);
	$id=($_POST['id']);
	$member_role = ($_POST['roles']);
	$member_code = ($_POST['assign']);
	$amount_value = ($_POST['amount']);

	$result = UpdateMemberTeam($member_role, $member_code, $amount_value, $id);
} 
else if ($action == "ps_member_others_update"){
	$id_project=($_GET['id_project']);
	$id=($_POST['id']);
	$member_role = ($_POST['roles']);
	$member_code = ($_POST['assign']);
	$amount_value = ($_POST['amount']);

	$result = UpdateMemberTeam($member_role, $member_code, $amount_value, $id);
}
else if ($action == "ps_member_work_update"){
	$id_project=($_GET['id_project']);
	$id=($_POST['id']);
	$member_role = ($_POST['roles']);
	$member_code = ($_POST['assign']);
	$amount_value = ($_POST['amount']);

	$result = UpdateMemberTeam($member_role, $member_code, $amount_value, $id);
	}

    function getStaffMember(){
    $conn=db();
    $sql = "SELECT * FROM staff WHERE status='BEKERJA' AND noic IS NOT NULL ORDER BY no_staff" ;
    $result = $conn->query($sql);
    return $result;
  }

  function getMember($id, $member_type) {
    $conn=db();
   $sql = "SELECT pm.*, s.name AS name 
	FROM project_members pm
	LEFT JOIN staff s ON pm.member_code=s.no_staff
	WHERE pm.id_project='$id' AND pm.member_type='$member_type'";  
    $result = $conn->query($sql);
    return $result;
  }
  
  function getSMember($id, $member_type) {
    $conn=db();
   $sql = "SELECT pm.*, s.company_name AS name 
	FROM project_members pm
	LEFT JOIN supplier s ON pm.member_code=s.supplier_code 
	WHERE pm.id_project='$id' AND pm.member_type='$member_type'";  
    $result = $conn->query($sql);
    return $result;
  }

  function getSupplierMember(){
    $conn=db();
    $sql = "SELECT * FROM supplier WHERE status=1 ORDER BY company_name" ;
    $result = $conn->query($sql);
    return $result;
  }

  function addMemberTeam($id_project, $member_type, $member_role, $member_code, $amount_value){
  	 $conn=db();
    $sql = "INSERT INTO project_members (id_project, member_type, member_role, member_code, amount_value)
	VALUES ('$id_project','$member_type','$member_role','$member_code','$amount_value')" ;
    $result = $conn->query($sql);
    return $result;
  }

  function deleteMemberTeam($id){
  	 $conn=db();
    $sql = "DELETE FROM project_members WHERE id='$id'" ;
    $result = $conn->query($sql);
    return $result;
  }

   function UpdateMemberTeam( $member_role, $member_code, $amount_value, $id){
  	 $conn=db();
    $sql = $conn=db();
      $sql = "UPDATE project_members SET member_role='$member_role', member_code='$member_code', amount_value='$amount_value'
      WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
  }

  //end ps member
  
  function updatePercentageDone($task_id,$tarikh_mula,$tarikh_tamat,$owner,$priority, $percentage_done){
    $conn=db();
    $sql = "UPDATE project_schedule_task SET start_date='$tarikh_mula',end_date='$tarikh_tamat',owner='$owner',priority='$priority',percentage_done='$percentage_done' WHERE id='$task_id'";

    $result = $conn->query($sql);
    return $result;
  }
	$conn->close();
	
?>