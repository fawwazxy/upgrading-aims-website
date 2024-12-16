<?

        $id=$_GET['id_project'];


?>

<div class="row">
			<div class="col-lg-12">
				<!-- <h1 class="page-header">Konfigurasi</h1> -->
			</div>
        </div>
<div id='cssmenu'>
	<ul>
		<li class="<? echo ($flagScreen=='TEAM'?'active':'') ?>"><a href="ps_member.php?id_project=<? echo $id;?>&flagScreen=TEAM">TEAM</a></li>
		<li class="<? echo ($flagScreen=='WORK'?'active':'') ?>"><a href="ps_member_work.php?id_project=<? echo $id;?>&flagScreen=WORK">WORK</a></li>
		<li class="<? echo ($flagScreen=='MATERIAL'?'active':'') ?>"><a href="ps_member_material.php?id_project=<? echo $id;?>&flagScreen=MATERIAL">MATERIAL</a></li>
		<li class="<? echo ($flagScreen=='OTHERS'?'active':'') ?>"><a href="ps_member_others.php?id_project=<? echo $id;?>&flagScreen=OTHERS">OTHERS</a></li>
	</ul>
</div>
