<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Sokongan</h1>
		<!--<h4><b><font color="red"><? echo $nama['name'];?></font></b></h4>-->
	</div>
</div>
<div class="panel panel-red">
	<div class="panel-heading">
		<center><b>Analisa Sokongan Developer</b></center>
	</div>
	<table width="100%" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th width="12%" bgcolor="#D6DBDF" colspan="2"><center>Aduan Tanpa Tindakan</center></th>
                <th width="12%" bgcolor="#D6DBDF"><center>Dalam Penerimaan</center></th>
                <th width="12%" bgcolor="#D6DBDF"><center>Dalam Proses</center></th>
                <th width="12%" bgcolor="#D6DBDF"><center>Semakan Terakhir</center></th>
                <th width="28%" bgcolor="#D6DBDF" colspan="4"><center>Telah Selesai</center></th>
                <th width="12%" bgcolor="#D6DBDF"><center>Telah Dibatalkan</center></th>
                <th width="12%" bgcolor="#D6DBDF"><center>Jumlah Penolakan Aduan</center></th>
            </tr>
        </thead>

        <tbody>
            <tr>
            	<td align="center" rowspan="1" colspan="2" style="padding-top: 15px;" bgcolor="#FDFEFE"><strong><font size="4px" color="blue"><?echo getCountBaharu();?> </font></strong></td>
                <td align="center" rowspan="3" style="padding-top: 15px;vertical-align : middle;text-align:center;" bgcolor="#FDFEFE"><strong><font size="7" color="orange"><?echo getCountByStatus('', 'DP');?>  </font></strong></td>
                <td align="center" rowspan="3" style="padding-top: 15px;vertical-align : middle;text-align:center;" bgcolor="#FDFEFE"><strong><font size="7" color="purple"><?echo getCountByStatus('', 'T');?>  </font></strong></td>
                
                <td align="center" rowspan="3" style="padding-top: 15px;vertical-align : middle;text-align:center;" bgcolor="#FDFEFE"><strong><font size="7" color="orange"><?echo getCountByStatus('', 'ST');?>  </font></strong></td>
                <th width="7%" bgcolor="#E8E8E8"><center>Hari Ini</center></th>
                <th width="7%" bgcolor="#E8E8E8"><center>Minggu Semasa</center></th>
                <th width="7%" bgcolor="#E8E8E8"><center>Bulan Semasa</center></th>
                <th width="7%" bgcolor="#E8E8E8"><center>Tahun Semasa</center></th>
                <td align="center" rowspan="3" style="padding-top: 15px;vertical-align : middle;text-align:center;" bgcolor="#FDFEFE"><strong><font size="7" color="brown"><?echo getCountByStatus('', 'C');?>  </font></strong></td>
                <td onmouseover="this.bgColor='wheat'" onmouseout="this.bgColor='#FDFEFE'" onClick="location.href='list_penolakan.php?flagScreen=<?echo $flagScreen?>';" align="center" rowspan="3" style="padding-top: 15px;vertical-align : middle;text-align:center;" bgcolor="#FDFEFE"><strong><font size="7" color="red"><?echo getCountRejected('','');?>  </font></strong></td>
            </tr>
            <tr>
            	<th bgcolor="#E8E8E8"><center>Baharu</center></th>
                <th bgcolor="#E8E8E8"><center>Tidak Diterima</center></th>
                <td bgcolor="#FDFEFE" align="center">
                    <strong><font size="6" color="green"><?echo getCountByCurDate('');?></font></strong>
                </td>
                <td bgcolor="#FDFEFE" align="center">
                    <strong><font size="6" color="green"><?echo getCountByCurWeek('');?></font></strong>
                </td>
                <td bgcolor="#FDFEFE" align="center">
                    <strong><font size="6" color="green"><?echo getCountByCurMonth('');?></font></strong>
                </td>
                <td bgcolor="#FDFEFE" align="center">
                    <strong><font size="6" color="green"><?echo getCountByCurYear('');?></font></strong>
                </td>
            </tr>
            <tr>
            	 <td align="center" style="padding-top: 15px;" bgcolor="#FDFEFE"><strong><font size="4px" color="brown"><?echo getCountByStatus('', 'BH');?>  </font></strong></td>
            	  <td align="center" style="padding-top: 15px;" bgcolor="#FDFEFE"><strong><font size="4px" color="brown"><?echo getCountByStatus('', 'TT');?>  </font></strong></td>
            	  <td onmouseover="this.bgColor='wheat'" onmouseout="this.bgColor='#E8E8E8'" onClick="window.open('support_analisa_hr.php', 'blank')" align="center" style="padding-top: 15px;" bgcolor="#E8E8E8" colspan="4" ><strong><font size="2px" color="green">Paparan Terperinci</font></strong></td>
            </tr>

        </tbody>
    </table>
</div>

<div id='cssmenu'>
	<ul>
	
		<li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="list_support_belum_disahkan.php">Aduan Baharu

 <?

			$noti=getNotificationStatus('BH');

			if($noti != '0'){


				echo '<span class="badge red">'.$noti.'</span>';

			}

		?>
		</a></li>
		

		<li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="list_support_dalam_penerimaan.php">Dalam Penerimaan


<!--  <?

			$noti=getNotificationStatus('ST');

			if($noti != '0'){


				echo '<span class="badge red">'.$noti.'</span>';

			}

		?> -->
		</a></li>


		<li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="list_support_dalam_proses.php">Dalam Proses


<!--  <?

			$noti=getNotificationStatus('ST');

			if($noti != '0'){


				echo '<span class="badge red">'.$noti.'</span>';

			}

		?> -->
		</a></li>

		<li class="<? echo ($flagScreen=='tab_4'?'active':'') ?>"><a href="list_support_semakan_terakhir.php">Semakan Terakhir


 <?

			$noti=getNotificationStatusST('ST');

			if($noti != '0'){


				echo '<span class="badge red">'.$noti.'</span>';

			}

		?>
		</a></li>

		<li class="<? echo ($flagScreen=='tab_5'?'active':'') ?>"><a href="list_support_selesai.php">Telah Selesai


		</a></li>

		<li class="<? echo ($flagScreen=='tab_6'?'active':'') ?>"><a href="list_support_batal.php">Telah Dibatalkan
<!-- 
 </?

			$noti=getNotificationStatus('C');

			if($noti != '0'){


				echo '<span class="badge red">'.$noti.'</span>';

			}

		?> -->
		</a></li>

		<li class="<? echo ($flagScreen=='tab_8'?'active':'') ?>"><a href="support_list.php">Aduan Mengikut Sistem</a></li>


		
	</ul>
</div>