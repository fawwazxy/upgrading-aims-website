<?
	include "../model/project_schedule_function.php";

 $action = ($_GET['act']);

if ($action == "ps_milestone_add"){
	 $id=($_GET['id_projek']);
	 $milestone = ($_POST['milestone']);
	 $user_name = ($_GET['user_name']);

	$result = addMilestone($id, $milestone, $user_name);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/ps_schedule_add.php?id_project=$id';
            </script>");
		//header("location: ../view/ps_schedule_add.php?id_project=$id");
		exit();
	}else {
		die("Query failed");
	}


}else if ($action == "ps_task_add"){
	$id=($_GET['id_project']);
	 $milestone_id=($_GET['milestone_id']);
	 $task_name = ($_POST['task_name']);
	 $task_start = ($_POST['task_start']); 
	 $duration = ($_POST['task_duration']);
	 $task_finish = ($_POST['task_finish']);
	 $user_name = ($_GET['username']);
	 $slack = ($_POST['slack']);

	$result = addMilestoneTask($milestone_id, $task_name, $task_start,$duration, $task_finish, $user_name, $slack);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/ps_schedule_add.php?id_project=$id';
            </script>");
		//header("location: ../view/ps_schedule_add.php?id_project=$id");
		exit();
	}else {
		die("Query failed");
	}


}else if ($action == "ps_milestone_delete"){
	$id=($_GET['id']);
	$milestone_id=($_GET['milestone_id']);
	

	$result =   deleteMilestone($milestone_id);


	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/ps_schedule_add.php?id_project=$id';
            </script>");
		//header("location: ../view/ps_schedule_add.php?id_project=$id");
		exit();
	}else {
		die("Query failed");
	}
}else if ($action == "ps_task_delete"){
	$id=($_GET['id']);
	$task_id=($_GET['task_id']);
	

	$result =  deleteTask($task_id);


	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/ps_schedule_add.php?id_project=$id';
            </script>");
		//header("location: ../view/ps_schedule_add.php?id_project=$id");
		exit();
	}else {
		die("Query failed");
	}
}
//----------------------PS_MEMBER---------------------------------//

//_________________TEAM___________________________//

else if ($action == "ps_member_team_add"){
	$id_project=($_GET['id_project']);
	$member_type = ($_GET['member_type']);
	$member_role = ($_POST['roles']);
	$member_code = ($_POST['assign']);
	$amount_value = ($_POST['amount']);
	
	$result = addMemberTeam($id_project, $member_type, $member_role, $member_code, $amount_value);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/ps_member.php?id_project=$id_project&flagScreen=$member_type';
            </script>");
		//header("location: ../view/ps_member.php?id_project=$id_project&flagScreen=$member_type");
		exit();
	}else {
		die("Query failed");
	}
}
else if ($action == "ps_member_material_add"){
	$id_project=($_GET['id_project']);
	$member_type = ($_GET['member_type']);
	$member_role = ($_POST['roles']);
	$member_code = ($_POST['assign']);
	$amount_value = ($_POST['amount']);
	
	$result = addMemberTeam($id_project, $member_type, $member_role, $member_code, $amount_value);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/ps_member_material.php?id_project=$id_project&flagScreen=$member_type';
            </script>");
		//header("location: ../view/ps_member_material.php?id_project=$id_project&flagScreen=$member_type");
		exit();
	}else {
		die("Query failed");
	}
}
else if ($action == "ps_member_others_add"){
	$id_project=($_GET['id_project']);
	$member_type = ($_GET['member_type']);
	$member_role = ($_POST['roles']);
	$member_code = ($_POST['assign']);
	$amount_value = ($_POST['amount']);
	
	$result = addMemberTeam($id_project, $member_type, $member_role, $member_code, $amount_value);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/ps_member_others.php?id_project=$id_project&flagScreen=$member_type';
            </script>");
		//header("location: ../view/ps_member_others.php?id_project=$id_project&flagScreen=$member_type");
		exit();
	}else {
		die("Query failed");
	}
}
else if ($action == "ps_member_work_add"){
	$id_project=($_GET['id_project']);
	$member_type = ($_GET['member_type']);
	$member_role = ($_POST['roles']);
	$member_code = ($_POST['assign']);
	$amount_value = ($_POST['amount']);
	
	$result = addMemberTeam($id_project, $member_type, $member_role, $member_code, $amount_value);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/ps_member_work.php?id_project=$id_project&flagScreen=$member_type';
            </script>");
		//header("location: ../view/ps_member_work.php?id_project=$id_project&flagScreen=$member_type");
		exit();
	}else {
		die("Query failed");
	}
}

else if($action == "ps_member_team_delete"){
	$id=($_GET['id']);
	$member_type = ($_GET['member_type']);
	$id_project=($_GET['id_project']);
	$result =  deleteMemberTeam($id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/ps_member.php?id_project=$id_project&flagScreen=$member_type';
            </script>");
		//header("location: ../view/ps_member.php?id_project=$id_project&flagScreen=$member_type");
		exit();
	}else {
		die("Query failed");
	}
}
else if($action == "ps_member_work_delete"){
	$id=($_GET['id']);
	$member_type = ($_GET['member_type']);
	$id_project=($_GET['id_project']);
	$result =  deleteMemberTeam($id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/ps_member_work.php?id_project=$id_project&flagScreen=$member_type';
            </script>");
		//header("location: ../view/ps_member_work.php?id_project=$id_project&flagScreen=$member_type");
		exit();
	}else {
		die("Query failed");
	}
}


else if($action == "ps_member_material_delete"){
	$id=($_GET['id']);
	$member_type = ($_GET['member_type']);
	$id_project=($_GET['id_project']);
	$result =  deleteMemberTeam($id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/ps_member_material.php?id_project=$id_project&flagScreen=$member_type';
            </script>");
		//header("location: ../view/ps_member_material.php?id_project=$id_project&flagScreen=$member_type");
		exit();
	}else {
		die("Query failed");
	}
}

else if($action == "ps_member_others_delete"){
	$id=($_GET['id']);
	$member_type = ($_GET['member_type']);
	$id_project=($_GET['id_project']);
	$result =  deleteMemberTeam($id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/ps_member_others.php?id_project=$id_project&flagScreen=$member_type';
            </script>");
		//header("location: ../view/ps_member_others.php?id_project=$id_project&flagScreen=$member_type");
		exit();
	}else {
		die("Query failed");
	}
}

else if ($action == "ps_member_team_update"){
	$id_project=($_GET['id_project']);
	$id=($_POST['id']);
	$member_type = ($_POST['member_type']);
	$member_role = ($_POST['role']);
	$member_code = ($_POST['assign']);
	$amount_value = ($_POST['amount']);

	$result = UpdateMemberTeam($member_type, $member_role, $member_code, $amount_value, $id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/ps_member.php?id_project=$id_project';
            </script>");
		//header("location: ../view/ps_member.php?id_project=$id_project");
		exit();
	}else {
		die("Query failed");
	}
}
else if ($action == "ps_member_material_update"){
	$id_project=($_GET['id_project']);
	$id=($_POST['id']);
	$member_type = ($_POST['member_type']);
	$member_role = ($_POST['role']);
	$member_code = ($_POST['assign']);
	$amount_value = ($_POST['amount']);

	$result = UpdateMemberTeam($member_type, $member_role, $member_code, $amount_value, $id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/ps_member_material.php?id_project=$id_project';
            </script>");
		//header("location: ../view/ps_member_material.php?id_project=$id_project");
		exit();
	}else {
		die("Query failed");
	}
}
else if ($action == "ps_member_others_update"){
	$id_project=($_GET['id_project']);
	$id=($_POST['id']);
	$member_type = ($_POST['member_type']);
	$member_role = ($_POST['role']);
	$member_code = ($_POST['assign']);
	$amount_value = ($_POST['amount']);

	$result = UpdateMemberTeam($member_type, $member_role, $member_code, $amount_value, $id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/ps_member_others.php?id_project=$id_project';
            </script>");
		//header("location: ../view/ps_member_others.php?id_project=$id_project");
		exit();
	}else {
		die("Query failed");
	}
}
else if ($action == "ps_member_work_update"){
	$id_project=($_GET['id_project']);
	$id=($_POST['id']);
	$member_type = ($_POST['member_type']);
	$member_role = ($_POST['role']);
	$member_code = ($_POST['assign']);
	$amount_value = ($_POST['amount']);

	$result = UpdateMemberTeam($member_type, $member_role, $member_code, $amount_value, $id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/ps_member_work.php?id_project=$id_project';
            </script>");
		//header("location: ../view/ps_member_work.php?id_project=$id_project");
		exit();
	}else {
		die("Query failed");
	}
}
//start Lan
else if ($action == "jsgantt"){
  
  $task_id=($_GET['task_id']);
  //$id_project=($_GET['id_project']);
  
  $tarikh_mula = ($_POST['tarikh_mula']);
  $tarikh_tamat = ($_POST['tarikh_tamat']);
  $owner = ($_POST['owner']);
  $priority = ($_POST['priority']);
  $percentage_done = ($_POST['percentage_done']);
  

  $result = updatePercentageDone($task_id,$tarikh_mula,$tarikh_tamat,$owner,$priority, $percentage_done);

  //Check whether the query was successful or not
  if($result) {
    
    ?>
  <!-- refresh parent window-->
  <script>  
  window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
  </script>
    <?
    
    
    //auto close popup window
    if(isset($_POST['btnSub']))
    echo "<script>window.close();</script>";
    //header("location: ../view/ps_schedule_view.php?id_project=$id_project");
    
    exit();
  }else {
    die("Query failed");
  }
}
?>