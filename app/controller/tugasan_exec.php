<?
	include "../model/tugasan_functions.php";
	date_default_timezone_set("Asia/Kuala_Lumpur");
	
	$action=$_POST['action'];

	if($action == 'adding'){
		$id_projek=$_POST['id_projek'];
		$tugasan=setValue($_POST['tugasan']);
		$pParent=setValue($_POST['parent']);
		$pClass=setValue($_POST['tasktype']);
		$pRes=setValue($_POST['resource']);
		$duration=setValue($_POST['duration']);
		$startdate=setValue($_POST['startdate'].' 00:00:00');
		$enddate=setValue($_POST['enddate'].' 00:00:00');
		$_pDepend=$_POST['pdepend'].$_POST['pdependext'];

		$pPlanStart = $startdate;
		$pPlanEnd = $enddate;
		$pLink = setValue('NULL');
		$pMile = setValue('NULL');
		$pOpen = '1';
		$pDepend = setValue($_pDepend);
		$pCaption = setValue('NULL');
		$pNotes = setValue('NULL');
		$pCost = setValue('NULL');


		$result = saveTugasan($tugasan, $id_projek, $startdate, $enddate,$duration, $pPlanStart, $pPlanEnd,$pClass, $pLink, $pMile, 
			$pRes, $pParent, $pOpen, $pDepend, $pCaption, $pNotes, $pCost);

		// // echo $result = addProjectTask($project_code, $shortcode, $template_id);


		if ($result!="" && $result > 0)
		{ 
			echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../view/tugasan_staff.php?id_projek=$id_projek';
                    </script>");
			//header("location: ../view/tugasan_staff.php?id_projek=$id_projek");
			exit();
		}else
		{
			die("Query failed");
		}
	}else if($action == 'updating'){
		$id_projek=$_POST['id_projek'];
		$pID=setValue($_POST['pID']);
		$pName=setValue($_POST['tugasan']);
		$pParent=setValue($_POST['parent']);
		$pClass=setValue($_POST['tasktype']);
		$pRes=setValue($_POST['resource']);
		$pComp=setValue($_POST['pComp']);
		$duration=setValue($_POST['duration']);
		$pStart=setValue($_POST['startdate'].' 00:00:00');
		$pEnd=setValue($_POST['enddate'].' 00:00:00');
		$_pDepend=$_POST['pdepend'].$_POST['pdependext'];

		$pPlanStart = $pStart;
		$pPlanEnd = $pEnd;
		$pLink = setValue('NULL');
		$pMile = setValue('NULL');
		$pOpen = '1';
		$pDepend = setValue($_pDepend);
		$pCaption = setValue('NULL');
		$pNotes = setValue('NULL');
		$pCost = setValue('NULL');

		$result = updateTugasan($pID, $pName, $pStart, $pEnd, $duration, $pPlanStart, 
			$pPlanEnd, $pClass, $pLink, $pMile, $pRes, $pComp, $pParent, $pOpen, $pDepend, 
			$pCaption, $pNotes, $pCost);

		if ($result!="" && $result > 0)
		{ 
			echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../view/tugasan_staff.php?id_projek=$id_projek';
                    </script>");
			//header("location: ../view/tugasan_staff.php?id_projek=$id_projek");
			exit();
		}else
		{
			die("Query failed");
		}
	}
?>