<?php

include "../model/config_supplier_functions.php";
	
	$action=clean($_POST['action']);
	if($action == "config_supplier"){
		$supplier=clean($_POST['supplier']);
		$category=clean($_POST['category']);
		$items=$_POST['items'];
		//$result =  addCuti($perkara,$tarikh_cuti);

		if(empty($items)) {
			//echo("Sila tanda pada kotak yang disediakan.");
			$result = subCategoryItemInactive($supplier,$category);
		}else {
			$N = count($items);
			//echo("You selected $N door(s): ");

			//inactive existing role
			subCategoryItemInactive($supplier,$category);

			foreach($items as $item){
				//echo $item."<br>";
				$result = addSubCategoryItem($supplier,$item);
			}


		}
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/config_supplier.php?supplier=$supplier&category=$category';
						</script>");
		//header("location: ../view/config_supplier.php?supplier=$supplier&category=$category");
		exit();
		
	}else if($action == "config_stage"){
		$stage=clean($_POST['stage']);
		$category=clean($_POST['category']);
		$items=$_POST['items'];
		//$result =  addCuti($perkara,$tarikh_cuti);

		if(empty($items)) {
			//echo("Sila tanda pada kotak yang disediakan.");
			$result = subCategoryStageInactive($stage,$category);
		}else {
			$N = count($items);
			//echo("You selected $N door(s): ");

			//inactive existing role
			subCategoryStageInactive($stage,$category);

			foreach($items as $item){
				//echo $item."<br>";
				$result = addSubCategoryStage($stage,$item);
			}


		}
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/config_stage.php?stage=$stage&category=$category';
						</script>");
		//header("location: ../view/config_stage.php?stage=$stage&category=$category");
		exit();
		
	}
	
?>