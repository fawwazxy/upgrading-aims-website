
<div id='cssmenu'>
	<ul>
		<li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="forum_diusul.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Topik Diusul</a></li>
		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="forum_diterima.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Individu
			<?
				// $id=($_SESSION['SESS_NO_STAFF']);
				$noti=getNotificationArkib($_SESSION['SESS_NO_STAFF']);

			if($noti != '0'){


				echo '<span class="badge red">'.$noti.'</span>';

			}
			?>
		</a></li>

		<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="forum_diterima_department.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']);?>">Unit/Jabatan</a></li>

		<li class="<? echo ($flagScreen=='tab_4'?'active':'') ?>"><a href="forum_umum.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']);?>">Umum</a></li>
	</ul>
</div>
