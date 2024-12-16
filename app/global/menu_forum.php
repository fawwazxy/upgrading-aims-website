<?

?>
<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Arkib Pengetahuan</h1>
			</div>
        </div>

<div id='cssmenu'>
	<?
	if ($_SESSION['SESS_ROLE']=='ADMIN') { ?>
	<ul>
		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="arkib_dashboard.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Dashboard</a></li>
		<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="forum_diusul.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Senarai Topik</a></li>
		<li class="<? echo ($flagScreen=='tab_4'?'active':'') ?>"><a href="category_view.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Kategori</a></li>
		<li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="forum_analisa.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Analisa</a></li>
		<li class="<? echo ($flagScreen=='tab_5'?'active':'') ?>"><a href="search.php">Carian</a></li>
	</ul>
<? } 

else if ($_SESSION['SESS_ROLE']=='SOFTWARE') {?>
	<ul>
		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="arkib_dashboard.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Dashboard</a></li>
		<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="forum_diusul.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']);?>">Senarai Topik</a></li>
		<!--li class="<//s? echo ($flagScreen=='tab_6'?'active':'') ?>"><a href="update_staff_record.php?staff_id=<//? echo $staff_id;?>&no_staff=<//? echo $no_staff;?>">Rekod Staff</a></li-->
		<!-- <li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="forum_view.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Topik Keseluruhan</a></li> -->
		<li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="forum_analisa.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Analisa</a></li>
		<li class="<? echo ($flagScreen=='tab_5'?'active':'') ?>"><a href="search.php">Carian</a></li>
	</ul>

	<?}

	else if ($_SESSION['SESS_ROLE']=='MANAGER') {?>
	<ul>
		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="arkib_dashboard.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Dashboard</a></li>
		<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="forum_diusul.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Senarai Topik</a></li>
		<!--li class="<//s? echo ($flagScreen=='tab_6'?'active':'') ?>"><a href="update_staff_record.php?staff_id=<//? echo $staff_id;?>&no_staff=<//? echo $no_staff;?>">Rekod Staff</a></li-->
		<!-- <li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="forum_view.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Topik Keseluruhan</a></li> -->
		<li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="forum_analisa.php">Analisa</a></li>
		<li class="<? echo ($flagScreen=='tab_5'?'active':'') ?>"><a href="search.php">Carian</a></li>
	</ul>

	<?}

	else if ($_SESSION['SESS_ROLE']=='FOUNDER') {?>
	<ul>
		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="arkib_dashboard.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Dashboard</a></li>
		<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="forum_diusul.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Senarai Topik</a></li>
		<!--li class="<//s? echo ($flagScreen=='tab_6'?'active':'') ?>"><a href="update_staff_record.php?staff_id=<//? echo $staff_id;?>&no_staff=<//? echo $no_staff;?>">Rekod Staff</a></li-->
		<!-- <li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="forum_view.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Topik Keseluruhan</a></li> -->
		<li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="forum_analisa.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Analisa</a></li>
		<li class="<? echo ($flagScreen=='tab_5'?'active':'') ?>"><a href="search.php">Carian</a></li>
	</ul>

<?} else if ($_SESSION['SESS_ROLE']=='INTERN') {?>
	<ul>
		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="arkib_dashboard.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Dashboard</a></li>
		<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="forum_diusul.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']);?>">Senarai Topik
		<?
				// $id=($_SESSION['SESS_NO_STAFF']);
				$noti=getNotificationArkib($_SESSION['SESS_NO_STAFF']);

			if($noti != '0'){


				echo '<span class="badge red">'.$noti.'</span>';

			}
			?></a></li>
		
		<li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="forum_analisa.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Analisa</a></li>
		<li class="<? echo ($flagScreen=='tab_4'?'active':'') ?>"><a href="category_view.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Kategori</a></li>
		<li class="<? echo ($flagScreen=='tab_5'?'active':'') ?>"><a href="search.php">Carian</a></li>
	</ul>

	<?}
	?>



</div>