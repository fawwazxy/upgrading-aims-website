<?
	include "../model/task_function.php";
	
	$id=$_GET['id'];
	$project_code= ($_POST['project_code']);
    $parent_id = ($_POST['parent_id']);
    $task = ($_POST['task_name']);
    $task_duration = ($_POST['task_duration']);
    $task_start = ($_POST['task_start']);
    $task_finish = ($_POST['task_finish']);
    $progress = ($_POST['progress']);
    $status = ($_POST['status']);
	


	echo $result = addTask($project_code,$parent_id,$task,$task_duration,$task_start,$task_finish,$progress, $status);

	// echo $result = addProjectTask($project_code, $shortcode, $template_id);


	if ($result!="" && $result > 0)
	{ 
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/pm_add_task.php?id=$id';
						</script>");
		//header("location: ../view/pm_add_task.php?id=$id");
		exit();
	}else
	{
		die("Query failed");
	}
?>