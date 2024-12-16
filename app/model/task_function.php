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
	
	function getPicture() {
		$conn=db();
		$sql = "SELECT * FROM tbl_images ORDER BY id DESC";
		$result = $conn->query($sql);
		return $result;
	}


  
  function getResources(){
    $conn=db();
     $sql = "SELECT pr.id, pr.project_code, pr.project_name
          FROM project pr";

    $result = $conn->query($sql);
    return $result;
  }

  
  function getStaffResources() {
    $conn=db();
    $sql = "SELECT * FROM staff
    WHERE status='BEKERJA' AND noic IS NOT NULL";
    $result = $conn->query($sql);
    return $result;
  }

   function addResources($id, $penerima){
    $conn=db();
    $sql = "INSERT INTO task_resources (task_id, no_staff) VALUES ('$id' ,'$penerima')";
    $result = $conn->query($sql);
    return $result;

  $conn->close();
}


  function getResourcesMilestone($project_code) {
    $conn=db();
     $sql = "SELECT t.*
            FROM task t
            LEFT JOIN project pr ON t.project_code=pr.project_code
            WHERE pr.project_code='$project_code' AND t.task_type_code='MILESTONE'"; // test milestone
    $result = $conn->query($sql);
    return $result;
  }
  
  function getResourcesWbs($milestone_id,$project_code) {
    $conn=db();
    $sql = "SELECT t.*
            FROM task t
            LEFT JOIN project pr ON t.project_code=pr.project_code
            WHERE pr.project_code='$project_code' AND t.ref_id='$milestone_id'";
    $result = $conn->query($sql);
    return $result;
  }
  function getResourcesTask($wbs_id,$project_code) {
    $conn=db();
    $sql = "SELECT t.*
            FROM task t
            LEFT JOIN project pr ON t.project_code=pr.project_code
            WHERE pr.project_code='$project_code' AND t.ref_id='$wbs_id'";
    $result = $conn->query($sql);
    return $result;
  }
  
  function getResourcesSubTask($task_id,$project_code) {
    $conn=db();
    $sql = "SELECT t.*
            FROM task t
            LEFT JOIN project pr ON t.project_code=pr.project_code
            WHERE pr.project_code='$project_code' AND t.ref_id='$task_id'";
    $result = $conn->query($sql);
    return $result;
  }


  function getProject() {
    $conn=db();
    $sql = "SELECT * FROM project 
    ORDER BY created_date DESC";
    $result = $conn->query($sql);
    return $result;
  }

  function addProject($project_name, $shortcode, $project_code, $template_id){
    $conn=db();
    $sql = "INSERT INTO project (project_name, project_code) VALUES ('$project_name',(SELECT CONCAT('$shortcode','/','$project_code','/',YEAR(CURRENT_TIMESTAMP),'/', LPAD(IFNULL(MAX(p.id), 0) + 1, 4, '0')) AS project_code 
      FROM project p))";
    $result = $conn->query($sql);

    $id =  $conn->insert_id;

    $sql2 ="INSERT INTO task (project_code, ref_id, task, task_type_code, task_duration, task_start, task_finish)
    SELECT (SELECT project_code FROM project WHERE id='$id'), ref_id, task, task_type_code, task_duration, task_start, task_finish
    FROM task_template_lib 
    WHERE id_task_template='$template_id'";

    $result = $conn->query($sql2);
    return $result;
  }

  function addProjectTask($project_name, $shortcode, $project_code){
    $conn=db();

    
    $sql = "INSERT INTO project (project_name, project_code) VALUES ('$project_name',(SELECT CONCAT('$shortcode','/','$project_code','/',YEAR(CURRENT_TIMESTAMP),'/', LPAD(IFNULL(MAX(p.id), 0) + 1, 4, '0')) AS project_code 
      FROM project p))";
    $result = $conn->query($sql);

    $id =  $conn->insert_id;

    

    $sql2 ="INSERT INTO task (project_code, task, parent_id, task_duration, task_start, task_finish) 
    VALUES ((SELECT project_code FROM project WHERE id='$id'),(SELECT CONCAT(project_code, '-', project_name) FROM project WHERE id='$id'),'NULL','0','0','0') ";
    $result = $conn->query($sql2);
    return $result;
  }

  function deleteProject($id){
    $conn=db();
      $sql = "DELETE FROM project WHERE id='$id'";
      $result = $conn->query($sql);
    return $result;
  }

  function getProjectInfo($pm_projek_id) {
    $conn=db();
    $sql = "SELECT * FROM project WHERE id='$pm_projek_id'" ;
    $result = $conn->query($sql);
    return $result;
  }

  function editProjectName($project_name, $id) {
     $conn=db();
      $sql = "UPDATE project SET project_name='$project_name' WHERE id='$id'" ;
     $result = $conn->query($sql);
     return $result;
  }

  //next 


  function getNamaProjek($id) {
    $conn=db();
   $sql = "SELECT * 
FROM project
WHERE id='$id'";  
    $result = $conn->query($sql);
    return $result;
  }

function getTask($id) {
    $conn=db();
   $sql = "SELECT t.*, t.id AS id_task 
FROM task t LEFT JOIN project p ON t.project_code=p.project_code
 WHERE p.id='$id' ORDER BY t.parent_id,t.id,t.task ASC
      ";  
    $result = $conn->query($sql);
    return $result;
  }


  function getTaskPrev($id){

    $conn=db();
   $sql="SELECT *,t.id AS task_id FROM task t LEFT JOIN project p ON t.project_code=p.project_code WHERE p.id='$id' ";

 $result=$conn->query($sql);
    return $result;

  }


 

 function addTask($project_code,$parent_id,$task,$task_duration,$task_start,$task_finish,$progress, $status){
    $conn=db();

    $sql = "INSERT INTO task(project_code,parent_id,task,task_duration,task_start,task_finish,progress, status_assign) 
VALUES ('$project_code','$parent_id','$task','$task_duration','$task_start','$task_finish','$progress', '$status')";
    $result = $conn->query($sql);

  
    return $result;
  }


 function getTaskForEdit($id_task){
      $conn=db();
      $sql= "SELECT *, t.id AS id_task FROM task t LEFT JOIN project p ON t.project_code=p.project_code

WHERE t.id='$id_task'";
      $result = $conn->query($sql);
      return $result;

    }


    function editTask($parent_id,$task,$task_duration,$task_start,$task_finish,$progress,$id) {
     $conn=db();
      $sql = "UPDATE task SET parent_id='$parent_id',task='$task',task_duration='$task_duration',task_start='$task_start',task_finish='$task_finish', progress='$progress' 
WHERE id='$id'" ;
     $result = $conn->query($sql);
     return $result;
  }

function updateStatusProjek($id){
    $conn=db();
      $sql = "UPDATE project SET status='0' WHERE id='$id'";
      $result = $conn->query($sql);
    return $result;
  }



	$conn->close();
	
?>