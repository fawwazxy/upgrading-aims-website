                      
<?
require "../model/kawalan_produk_functions.php";
$id=$_GET['id'];
$kod_produk=$_GET['kod_produk'];
$list=getMaklumatPenggunaBYid($id)->fetch_assoc();

?>




                      <form method="post" action="../controller/kawalan_produk_exec.php" enctype="multipart/form-data">
                          <div>
                              <input type="hidden" name="action" value="PenggunaAddEdit" />
                              <input type="hidden" id="id" name="id" value="<?echo $id?>" />
                               <input type="hidden" id="kod_produk" name="kod_produk" value="<?echo $kod_produk?>" />
                          </div>

                          <div class="form-group" align="left">
                            <label>Kod Pengguna<font color="red"> **</font>&nbsp;</label>
                            <input type="text" required class="form-control" style="text-transform:uppercase" name="user_code" id="user_code" value="<?echo $list['user_code'];?>">
                          </div>
                          <div class="form-group" align="left">
                            <label>nama Pengguna<font color="red"> **</font>&nbsp;</label>
                            <input type="text" required class="form-control" name="user_name" id="user_name" value="<?echo $list['user_name'];?>">
                          </div>
                          <div class="form-group" align="left">
                            <label>Had Penggunaan (Device)<font color="red"> **</font>&nbsp;</label>
                            <input type="number" class="form-control" step="0" required name="limit" id="limit" value="<?echo $list['limit'];?>">
                          </div>

                          <div class="form-group" align="right">
                              <button type="submit" class="btn btn-primary">Simpan</button>
                          </div>

                    </form>