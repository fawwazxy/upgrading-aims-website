
<?

include ('../controller/auth.php');

require "../model/acara_functions.php";

$id_kumpulan = $_POST['id_kumpulan'];
$id_sesi = $_POST['id_sesi'];

?>



				<form method="post" action="../controller/upload_peserta_excel_exec.php" enctype="multipart/form-data">
					   <input id="action" name="action" type="hidden" value="upload"/>
					   <input id="action" name="id_kumpulan" type="hidden" value="<? echo $id_kumpulan;?>"/>
					   <input id="id_sesi" name="id_sesi" type="hidden" value="<? echo $id_sesi;?>"/>
					   <input id="created_by" name="created_by" type="hidden" value="<? echo $_SESSION['SESS_NAME'];?>"/>
						<div class="form-group"> 
							<label class="control-label">Fail<font color="red"> **</font>&nbsp;(Fail Excel Sahaja) <font color="red">Format Susunan Data: NoKP,Nama,NoTelefon</font></label>
							<input required  accept=".xlsx" type="file" name="csv_file" id="csv_file" class="btn btn-link">
						</div>
						
					<div class="modal-footer">
					<button type="submit" class="btn btn-success">Simpan</button>
					<button type="reset" class="btn btn-warning">Tetapan Semula</button>
					</div>
                        
                    
                         
                </form>