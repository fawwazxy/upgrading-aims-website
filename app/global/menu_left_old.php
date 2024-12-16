<li>

	<?php
	    require "../model/menuleft_function.php";
		if ($_SESSION['SESS_ROLE']=='') {
	?>
			<a href="login.php"></a>
	<?
		} elseif ($_SESSION['SESS_ROLE']=='ADMIN') {
	?>
			
			<a href="penawaran_jawatan.php?no_staff=<?echo($_SESSION['SESS_NO_STAFF']);?>&com_id=<?echo($_SESSION['SESS_COM']);?>">Iklan Jawatan</a>
			<a href="pemohon_senarai.php?no_staff=<?echo($_SESSION['SESS_NO_STAFF']);?>&com_id=<?echo($_SESSION['SESS_COM']);?>">Senarai Permohonan Perjawatan</a>
			<a href="kelulusan_pemohon.php">Jadual Temuduga</a>
			
			<a href="staff_new.php">Pelantikan Pekerja</a>
			<a href="staff_info.php?no_staff=<?echo($_SESSION['SESS_NO_STAFF']);?>">Pekerja Syarikat</a>
			<a href="maklumat_cuti.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Borang Mohon Cuti</a>
			<a href="senarai_kelulusan_cuti.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Kelulusan Cuti</a>
			<a href="bulan_tuntutan.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Borang Tuntutan</a>
            <a href="senarai_pengesahan_tuntutan.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Pengesahan Tuntutan
            <?

              $noti=getNotificationPelulusClaimMenuLeft();
        
              if($noti != '0'){
        
        
                echo '<span class="badge red">'.$noti.'</span>';
        
              }
        
            ?>
            </a>
	        <a href="jenis_tuntutan.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Konfigurasi Jenis Tuntutan</a>
	       
			<a href="staff_detail.php?no_staff=<?echo($_SESSION['SESS_NO_STAFF']);?>">Penolakan Gaji</a>
			<a href="elaun.php?no_staff=<?echo($_SESSION['SESS_NO_STAFF']);?>">Konfigurasi Elaun</a>
			
			<a href="senarai_kehadiran.php">Senarai Kehadiran</a>
			<a href="senarai_surat_janaan.php">Janaan Surat</a>
			<a href="niaga_sebut_harga.php">Niaga</a>
			<a href="pengurusan_projek.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Pengurusan Projek

		<?


				$noti=getNotiPengurusanProjek($_SESSION['SESS_NO_STAFF']);

			if($noti != '0'){


				echo '<span class="badge red">'.$noti.'</span>';

			}

		?>
				
			</a>
            <a href="senarai_projek_yang_terlibat.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Pengurusan Projek-Tindakan</a>
			<a href="senarai_perbelanjaan_syarikat.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Rekod Perbelanjaan</a>
			<a href="arkib_dashboard.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Arkib Pengetahuan
				<?
			
			// 	$noti=getNotificationArkib($_SESSION['SESS_NO_STAFF']));

			// if($noti != '0'){


			// 	echo '<span class="badge red">'.$noti.'</span>';

			// }
			?>
			</a>
			<a href="all_meeting.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Tetapan Aktiviti</a>
			<a href="kalendar.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Kalendar Aktiviti</a>
			<a href="list_support_belum_disahkan.php?no_staff=<?echo($_SESSION['SESS_NO_STAFF']);?>">Sokongan
			<a href="developer_support.php?no_staff=<?echo($_SESSION['SESS_NO_STAFF']);?>">Sokongan-Tindakan</a>
			<a href="list_faq.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">FAQ</a>
			<a href="carian_rentas.php">Carian Rentas</a>

			 
	<?
		} elseif ($_SESSION['SESS_ROLE']=='MNG' || $_SESSION['SESS_ROLE']=='SOFTMNG') {
	?>
			<a href="staff_info.php?no_staff=<?echo($_SESSION['SESS_NO_STAFF']);?>">Pekerja Syarikat</a>
			<a href="kelulusan_pemohon.php">Jadual Temuduga</a>
			<a href="maklumat_cuti.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Borang Mohon Cuti</a>
			<a href="senarai_kelulusan_cuti.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Kelulusan Cuti</a>
		    <a href="bulan_tuntutan.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Borang Tuntutan</a>
			<a href="senarai_pengesahan_tuntutan.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Pengesahan Tuntutan
			<?

              $noti=getNotificationPelulusClaimMenuLeft();
        
              if($noti != '0'){
        
        
                echo '<span class="badge red">'.$noti.'</span>';
        
              }
        
            ?>
			</a>
			<a href="pengurusan_projek.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Pengurusan Projek
			<?


				$noti=getNotiPengurusanProjek($_SESSION['SESS_NO_STAFF']);

			if($noti != '0'){


				echo '<span class="badge red">'.$noti.'</span>';

			}

		?>	
				
			</a>
            <a href="senarai_projek_yang_terlibat.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Pengurusan Projek-Tindakan</a>
            <a href="list_support_belum_disahkan.php?no_staff=<?echo($_SESSION['SESS_NO_STAFF']);?>">Sokongan</a>
			<a href="developer_support.php?no_staff=<?echo($_SESSION['SESS_NO_STAFF']);?>">Sokongan-Tindakan</a>
			<a href="arkib_dashboard.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Arkib Pengetahuan
				<?
			
			// 	$noti=getNotificationArkib($_SESSION['SESS_NO_STAFF']));

			// if($noti != '0'){


			// 	echo '<span class="badge red">'.$noti.'</span>';

			// }
			?>
			</a>
            
			<a href="all_meeting.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Tetapan Aktiviti</a>
			<a href="kalendar.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Kalendar Aktiviti</a>
	<?
		} elseif ($_SESSION['SESS_ROLE']=='MD') {
	?>
			<a href="staff_info.php?no_staff=<?echo($_SESSION['SESS_NO_STAFF']);?>">Pekerja Syarikat</a>
			<a href="penawaran_jawatan.php?no_staff=<?echo($_SESSION['SESS_NO_STAFF']);?>&com_id=<?echo($_SESSION['SESS_COM']);?>">Iklan Jawatan</a>
            <a href="pemohon_senarai.php?no_staff=<?echo($_SESSION['SESS_NO_STAFF']);?>&com_id=<?echo($_SESSION['SESS_COM']);?>">Senarai Permohonan Perjawatan</a>
			<a href="kelulusan_pemohon.php">Jadual Temuduga</a>
			
			<a href="staff_new.php">Pelantikan Pekerja</a>
			<a href="maklumat_cuti.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Borang Mohon Cuti</a>
			<a href="senarai_kelulusan_cuti.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Kelulusan Cuti</a>
			<a href="bulan_tuntutan.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Borang Tuntutan</a>
            <a href="senarai_pengesahan_tuntutan.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Pengesahan Tuntutan
            <?

              $noti=getNotificationPelulusClaimMenuLeft();
        
              if($noti != '0'){
        
        
                echo '<span class="badge red">'.$noti.'</span>';
        
              }
        
            ?>
            </a>
	        <a href="jenis_tuntutan.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Konfigurasi Jenis Tuntutan</a>
	       
			<a href="staff_detail.php?no_staff=<?echo($_SESSION['SESS_NO_STAFF']);?>">Penolakan Gaji</a>
			<a href="elaun.php?no_staff=<?echo($_SESSION['SESS_NO_STAFF']);?>">Konfigurasi Elaun</a>
			
			<a href="salary_approve.php?no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>&act=<? echo $act ?>">Permohonan Kelulusan Gaji


	  <?

			$noti=getNotificationPelulusSalMenuLeft($jenis_kelulusan);

			if($noti != '0'){


				echo '<span class="badge red">'.$noti.'</span>';

			}

		?>



			</a>
			<a href="senarai_surat_janaan.php">Janaan Surat</a>
			<a href="niaga_sebut_harga.php">Niaga</a>
			<a href="pengurusan_projek.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Pengurusan Projek
				
				<?


				$noti=getNotiPengurusanProjek($_SESSION['SESS_NO_STAFF']);

			if($noti != '0'){


				echo '<span class="badge red">'.$noti.'</span>';

			}

		?>
				
			</a>
			<a href="senarai_projek_yang_terlibat.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Pengurusan Projek-Tindakan</a>
			<a href="all_meeting.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Tetapan Aktiviti</a>
			<a href="all_kalendar_hls.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Kalendar Aktiviti</a>
			<a href="developer_support.php?no_staff=<?echo($_SESSION['SESS_NO_STAFF']);?>">Sokongan-Tindakan</a>
		    <a href="arkib_dashboard.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Arkib Pengetahuan
				<?
			
			// 	$noti=getNotificationArkib($_SESSION['SESS_NO_STAFF']));

			// if($noti != '0'){


			// 	echo '<span class="badge red">'.$noti.'</span>';

			// }
			?>
			</a>
			<a href="list_faq.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">FAQ</a>
            <a href="carian_rentas.php">Carian Rentas</a>

			
	<?
		} elseif ($_SESSION['SESS_ROLE']=='STAFF') {
	?>
			<a href="bulan_tuntutan.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Borang Tuntutan</a>
			<a href="maklumat_cuti.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Borang Mohon Cuti</a>
			<a href="bulan_salary_staff.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Maklumat Gaji</a>

			
				<a href="kalendar.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Kalendar Aktiviti</a>
				<a href="pengurusan_projek.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Pengurusan Projek
				
				<?


				$noti=getNotiPengurusanProjek($_SESSION['SESS_NO_STAFF']);

			if($noti != '0'){


				echo '<span class="badge red">'.$noti.'</span>';

			}

		?>
			</a>
			<a href="senarai_projek_yang_terlibat.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Pengurusan Projek-Tindakan</a>
			<a href="arkib_dashboard.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Arkib Pengetahuan
				<?
			
			// 	$noti=getNotificationArkib($_SESSION['SESS_NO_STAFF']));

			// if($noti != '0'){


			// 	echo '<span class="badge red">'.$noti.'</span>';

			// }
			?>
			</a>

			
			
	<?
		} elseif ($_SESSION['SESS_ROLE']=='SE') {
	?>
	        <a href="bulan_tuntutan.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Borang Tuntutan</a>
			<a href="maklumat_cuti.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Borang Mohon Cuti</a>
			<a href="bulan_salary_staff.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Maklumat Gaji</a>
			<a href="elaun_add.php?no_staff=<?echo($_SESSION['SESS_NO_STAFF']);?>">Konfigurasi Elaun</a>

			<a href="pengurusan_projek.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Pengurusan Projek
				<?


				$noti=getNotiPengurusanProjek($_SESSION['SESS_NO_STAFF']);

			if($noti != '0'){


				echo '<span class="badge red">'.$noti.'</span>';

			}

		?>
		
			</a>
			<a href="senarai_projek_yang_terlibat.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Pengurusan Projek-Tindakan</a>
			<a href="developer_support.php?no_staff=<?echo($_SESSION['SESS_NO_STAFF']);?>">Sokongan-Tindakan</a>
			<a href="kalendar.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Kalendar Aktiviti</a>
		<a href="arkib_dashboard.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Arkib Pengetahuan
				<?
			
			// 	$noti=getNotificationArkib($_SESSION['SESS_NO_STAFF']));

			// if($noti != '0'){


			// 	echo '<span class="badge red">'.$noti.'</span>';

			// }
			?>
			</a>

	<?
		} elseif ($_SESSION['SESS_ROLE']=='SPR') {

	?>

		<a href="list_support_belum_disahkan.php?no_staff=<?echo($_SESSION['SESS_NO_STAFF']);?>">Sokongan</a>
		<a href="pengurusan_projek.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Pengurusan Projek
				<?


				$noti=getNotiPengurusanProjek($_SESSION['SESS_NO_STAFF']);

			if($noti != '0'){


				echo '<span class="badge red">'.$noti.'</span>';

			}

		?>
		
			</a>
			<a href="senarai_projek_yang_terlibat.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Pengurusan Projek-Tindakan</a>
		    <a href="arkib_dashboard.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Arkib Pengetahuan
				<?
			
			// 	$noti=getNotificationArkib($_SESSION['SESS_NO_STAFF']));

			// if($noti != '0'){


			// 	echo '<span class="badge red">'.$noti.'</span>';

			// }
			?>
			</a>
			<a href="kalendar.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Kalendar Aktiviti</a>
			<a href="bulan_salary_staff.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Maklumat Gaji</a>
			<a href="developer_support.php?no_staff=<?echo($_SESSION['SESS_NO_STAFF']);?>">Sokongan-Tindakan</a>
			<a href="list_faq.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">FAQ</a>



			<?
		} elseif ($_SESSION['SESS_ROLE']=='INTERN_SD') {

	?>

			<a href="pengurusan_projek.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Pengurusan Projek
				<?


				$noti=getNotiPengurusanProjek($_SESSION['SESS_NO_STAFF']);

			if($noti != '0'){


				echo '<span class="badge red">'.$noti.'</span>';

			}

		?>
		
			</a>
			<a href="senarai_projek_yang_terlibat.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Pengurusan Projek-Tindakan</a>
			<a href="developer_support.php?no_staff=<?echo($_SESSION['SESS_NO_STAFF']);?>">Sokongan-Tindakan</a>
			<a href="arkib_dashboard.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Arkib Pengetahuan
		
			</a>
			<a href="kalendar.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">Kalendar Aktiviti</a>
			<a href="list_faq.php?no_staff=<? echo ($_SESSION['SESS_NO_STAFF']); ?>">FAQ</a>







	<?
		} else {
	?>
			<a href="login.php"></a>
	<?
		}
	?>
</li>