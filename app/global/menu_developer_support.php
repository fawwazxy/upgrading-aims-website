<?

    
?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Sokongan-Tindakan</h1>
		<!--<h4><b><font color="red"><? echo $nama['name'];?></font></b></h4>-->
	</div>
</div>
<div class="panel panel-red">
	<div class="panel-heading">
		<center><b>Analisa Sokongan Peribadi</b></center>
	</div>
	<table width="100%" class="table table-striped table-bordered ">
        <thead>
            <tr>
                <th width="18%" bgcolor="#D6DBDF"><center>Aduan Baharu</center></th>
                <th width="18%" bgcolor="#D6DBDF"><center>Dalam Tindakan</center></th>
                <th width="18%" bgcolor="#D6DBDF"><center>Semakan Terakhir</center></th>
                <th width="28%" bgcolor="#D6DBDF" colspan="4"><center>Selesai</center></th>
                <th width="18%" bgcolor="#D6DBDF"><center>Jumlah Penolakan Aduan</center></th>
            </tr>
        </thead>
        <!--support_analisa_staff.php-->

        <tbody>
            <tr>
            	<td align="center" rowspan="3" style="padding-top: 15px;vertical-align : middle;text-align:center;" bgcolor="#FDFEFE"><strong><font size="7" color="blue"><?echo getCountByStatus($no_staff, 'DP');?> </font></strong></td>
                <td align="center" rowspan="3" style="padding-top: 15px;vertical-align : middle;text-align:center;" bgcolor="#FDFEFE"><strong><font size="7" color="purple"><?echo getCountByStatus($no_staff, 'T');?>  </font></strong></td>
                <td align="center" rowspan="3" style="padding-top: 15px;vertical-align : middle;text-align:center;" bgcolor="#FDFEFE"><strong><font size="7" color="orange"><?echo getCountByStatus($no_staff, 'ST');?>  </font></strong></td>
                <th width="7%" bgcolor="#E8E8E8"><center>Hari Ini</center></th>
                <th width="7%" bgcolor="#E8E8E8"><center>Minggu Semasa</center></th>
                <th width="7%" bgcolor="#E8E8E8"><center>Bulan Semasa</center></th>
                <th width="7%" bgcolor="#E8E8E8"><center>Tahun Semasa</center></th>
                <td onmouseover="this.bgColor='wheat'" onmouseout="this.bgColor='#FDFEFE'" onClick="location.href='list_penolakan_aduan.php?no_staff=<? echo $no_staff;?>&flagScreen=<?echo $flagScreen?>';" align="center" rowspan="3" style="padding-top: 15px;vertical-align : middle;text-align:center;" bgcolor="#FDFEFE"><strong><font size="7" color="red"><?echo getCountRejected($no_staff,'');?>  </font></strong></td>
            </tr>
            <tr>
                <td bgcolor="#FDFEFE" align="center">
                    <strong><font size="6" color="green"><?echo getCountByCurDate($no_staff);?></font></strong>
                </td>
                <td bgcolor="#FDFEFE" align="center">
                    <strong><font size="6" color="green"><?echo getCountByCurWeek($no_staff);?></font></strong>
                </td>
                <td bgcolor="#FDFEFE" align="center">
                    <strong><font size="6" color="green"><?echo getCountByCurMonth($no_staff);?></font></strong>
                </td>
                <td bgcolor="#FDFEFE" align="center">
                    <strong><font size="6" color="green"><?echo getCountByCurYear($no_staff);?></font></strong>
                </td>
            </tr>
            <tr>
                <td onmouseover="this.bgColor='wheat'" onmouseout="this.bgColor='#E8E8E8'" onClick="window.open('support_analisa_staff.php?no_staff=<? echo $no_staff;?>', 'blank')" align="center" style="padding-top: 15px;" bgcolor="#E8E8E8" colspan="4" ><strong><font size="2px" color="green">Paparan Terperinci</font></strong></td>
            </tr>
        </tbody>
    </table>
</div>



<div id='cssmenu'>
	<ul>
		
	

		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="developer_support.php">Aduan Baharu
      



 <?

			$noti=getNotificationStatusDeveloper('DP',$_SESSION['SESS_NO_STAFF']);

			if($noti != '0'){


				echo '<span class="badge red">'.$noti.'</span>';

			}

		?>

      </a></li>
<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="developer_support_belum_selesai.php">Dalam Tindakan

 <?

			$noti=getNotificationStatusDeveloperBS('T',$_SESSION['SESS_NO_STAFF']);

			if($noti != '0'){


				echo '<span class="badge red">'.$noti.'</span>';

			}

		?>
		</a></li>

 <li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="developer_support_semakan_terakhir_list.php">Semakan Terakhir


		</a></li>




       <li class="<? echo ($flagScreen=='tab_4'?'active':'') ?>"><a href="developer_support_tamat.php">Selesai


		</a></li>

       <li class="<? echo ($flagScreen=='tab_5'?'active':'') ?>"><a href="developer_support_list.php">Statistik Sistem


		</a></li>




	</ul>
</div>