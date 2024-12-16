<?


?>


	<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Maklumat Pekerja </h1>
				<h4><b><font color="blue"><? echo $nama['name'];?></font></b></h4>
				
			</div>
        </div>
<div id='cssmenu'>
	<ul>
		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="update_staff.php?id=<? echo $id;?>&no_staff=<? echo $no_staff;?>">Maklumat Peribadi</a></li>
		<!--li class="<//s? echo ($flagScreen=='tab_6'?'active':'') ?>"><a href="update_staff_record.php?staff_id=<//? echo $staff_id;?>&no_staff=<//? echo $no_staff;?>">Rekod Staff</a></li-->
		<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="update_staff_edu.php?id=<? echo $id;?>&no_staff=<? echo $no_staff;?>">Maklumat Pendidikan</a></li>
		<li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="update_staff_exp.php?id=<? echo $id;?>&no_staff=<? echo $no_staff;?>">Maklumat Pekerjaan Terdahulu</a></li>
		<li class="<? echo ($flagScreen=='tab_4'?'active':'') ?>"><a href="update_staff_skl.php?id=<? echo $id;?>&no_staff=<? echo $no_staff;?>">Maklumat Kemahiran </a></li>
		<li class="<? echo ($flagScreen=='tab_5'?'active':'') ?>"><a href="update_staff_fa.php?id=<? echo $id;?>&no_staff=<? echo $no_staff;?>">Maklumat Keluarga </a></li>
	    <li class="<? echo ($flagScreen=='tab_7'?'active':'') ?>"><a href="staff_add_record.php?id=<? echo $id;?>&no_staff=<? echo $no_staff;?>">Maklumat Rekod Jawatan </a></li>

	</ul>
</div>