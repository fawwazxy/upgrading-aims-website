
<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Senarai Maklumat Tuntutan</h1>
				<!--<h4><b><font color="red"><? echo $nama['name'];?></font></b></h4>-->
				
			</div>
        </div>

 
<div id='cssmenu' >
	<ul>
		<!--<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>">
		<a href="<? echo ($act=='update'?'pemohon_update.php?pemohon_id='.$pemohon_id.'&act='.$act:'permohonan_baru.php?pemohon_id='.$pemohon_id.'&act='.$act) ?>">Tuntutan Jarak / Kenderaan</a></li>-->

	
		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="bulan_tuntutan.php?no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>&act=<? echo $act ?>">Senarai Tuntutan</a></li>

		<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="senarai_tuntutan_belum_diluluskan.php?no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>&act=<? echo $act ?>">Senarai Tuntutan Yang Belum Diluluskan</a></li>
		
		
		<li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="senarai_tuntutan_lulus.php?no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>&act=<? echo $act ?>">Senarai Tuntutan Yang Lulus
       <?

		$noti=getNotification($no_staff,'L');

		if($noti != '0'){


		


		echo '<span class="badge red">'.$noti.'</span>';

		}

		?>

		</a></li>
		
		<li class="<? echo ($flagScreen=='tab_4'?'active':'') ?>"><a href="senarai_tuntutan_tidak_lulus.php?no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>&act=<? echo $act ?>">Senarai Tuntutan Yang Tidak Lulus
    
		<?

		$noti=getNotification($no_staff,'TL');

		if($noti != '0'){


		


		echo '<span class="badge red">'.$noti.'</span>';

		}

		?>
</a></li>

	</ul>
</div>

