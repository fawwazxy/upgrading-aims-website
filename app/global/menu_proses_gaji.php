<?


?>
<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Pemprosesan Gaji Kakitangan</h1>
				<!--<h4><b><font color="red"><? echo $nama['name'];?></font></b></h4>-->
				
			</div>
        </div>


<div id='cssmenu'>
	<ul>
		
	
		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="salary_approve.php?no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>&act=<? echo $act ?>">Gaji Bulan Semasa Perlu Diproses
      

  <?

			$noti=getNotificationPelulusSal($no_staff,'SDGDIPROSES');

			if($noti != '0'){


				echo '<span class="badge red">'.$noti.'</span>';

			}

		?>


		</a></li>

		<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="salary_approve_lulus.php?no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>&act=<? echo $act ?>">Senarai Gaji Telah Diluluskan

	
  <?

			$noti=getNotificationPelulusSal($no_staff,'LULUS');

			if($noti != '0'){


				echo '<span class="badge red">'.$noti.'</span>';

			}

		?>
		</a></li>


		<li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="salary_approve_tidak_lulus.php?no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>&act=<? echo $act ?>">Senarai Gaji Yang Tidak Lulus

  <?

			$noti=getNotificationPelulusSal($no_staff,'TDKLULUS');

			if($noti != '0'){


				echo '<span class="badge red">'.$noti.'</span>';

			}

		?>

		</a></li>


	</ul>
</div>