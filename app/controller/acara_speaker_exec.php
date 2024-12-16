<?php

include "../model/acara_functions.php";
	
	$action=clean($_POST['action']);
	if($action == "addSpeaker"){
		$id_sesi=clean($_POST['id_sesi']);
		$id_aturcara=clean($_POST['id_aturcara']);
		$ids=$_POST['speaker_ids'];
		
			foreach($ids as $id){
				
				$result = addAcaraSpeaker($id_aturcara,$id);
			}
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/acara_speaker.php?id_aturcara=$id_aturcara&id_sesi=$id_sesi';
						</script>");
			//header("location: ../view/acara_speaker.php?id_aturcara=$id_aturcara&id_sesi=$id_sesi");
			exit();
		}else {
			die("Query failed");
		}

	}

		
	
	
	
?>