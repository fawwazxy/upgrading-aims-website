
<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header" style="text-transform: uppercase;">Senarai Ahli</h1>
			</div>
			
        </div>

<div id='cssmenu'>
	<ul>
		<?
			$m=1;
			$status_ahli = getMenuStatusAhli();
			while($row_data_status = $status_ahli->fetch_assoc()) {?>

		<li class="<? echo ($flagScreen=='tab_'.$m?'active':'') ?>"><a href="ahli_senarai_ahli.php?statact=<? echo $row_data_status['kod'];?>&tab=<? echo "tab_".$m;?>"><? echo $row_data_status['keterangan'];?></a></li>

		<?
		$m++;}?>
	</ul>
</div>