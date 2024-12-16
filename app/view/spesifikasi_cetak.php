<?
    require "../model/spesifikasi_function.php";
    //require"../controller/auth.php";
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $sys_id = $_GET['sys_id'];
    $projek_id = $_GET['projek_id'];
    //$data_id = $_GET['data_id'];
    //$vs_id = $_GET['vs_id'];
    $sys = getSys($sys_id)->fetch_assoc();
    $com = getCompany()->fetch_assoc();
    $id = $_GET['id'];
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" type="image/x-icon" href="../../resources/images/<? echo $sys['logo_filename']; ?>" />
        <title><? echo $sys['sys_name']; ?> :: <? echo $sys['sys_tagline']; ?></title>
        <style>
            #map_wrapper {
                height: 500px;
            }

            #map_canvas {
                width: 100%;
                height: 100%;
            }
        </style>
        <style>
table, th {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
    text-align: left;    
}
table { page-break-inside:auto }
tr { page-break-inside:avoid; page-break-after:auto }
@media print {
tr {
    -webkit-print-color-adjust: exact; 
}}
</style>
    </head>
    <body>
        
        
    <? /* Start Frontpage Cover */ ?>
    <?
    //$data = getAgensi($id) -> fetch_assoc();
    //$vs = getVotingSessionDetails($sys_id,$data_id,$vs_id) -> fetch_assoc();
    $data = getNamaSpesifikasiById($id)->fetch_assoc();
    ?>
<center>
<br><br><br><br><br><br>
<? echo '<img src="data:image/png;base64,'.base64_encode( $com['logo'] ).'"style="width: 150px; height: 170px;"/>';?><br><br><br><br>
<h2>DOKUMEN SPESIFIKASI</h2><br>
<h3>Spesifikasi : <? echo $data['name']; ?></h3><br>
<h5>Tarikh Janaan Dokumen: <? echo date('d/m/Y'); ?></h5><br>
<br><br><br><br><br><br><br><br><br>
<h4>Dokumen Disediakan Oleh
<br><? echo $com['name']; ?></h4><br><br><br><br><br>
<?include '../global/footer_report.php'?>
</center>

<? /* End Frontpage Cover */ ?>
<p style="page-break-after:always;"></p>

<!-- .............................................................................................................................. -->

<? /* Start TOC */ ?>
<div align="right">
    <h6>Dokumen Spesifikasi | <? echo $data['name']; ?></h6>
</div>
<center>
    <h1>Isi Kandungan</h1>
</center>
<div align="left">
<left>
    <br><br>
<h2>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A. Lukisan<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B. Dimensi<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C. Bahan<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;D. Jentera<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E. Contoh Gambar<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;F. Youtube<br>
    <?if($projek_id > 0){?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;G. Pelan Tapak Projek<br>
   <?}?>
    
</h2>
</left>

<? /* End TOC */ ?>
<p style="page-break-after:always;"></p>

<? /* Start TOC */ ?>
<div align="right">
    <h6>Dokumen Spesifikasi | <? echo $data['name']; ?></h6>
</div>
<center>
    <h1>A. Lukisan</h1><br>
</center>
<div align="center">
<center>

                        
                     <table width="100%" style="border: 0px">
                     
                                
                                    
                                    <?               
                                    $i = 1;
                                    $data_drawing = getDrawingList($id);
                                    while($row_data = $data_drawing->fetch_assoc()) {
                                        if($i == 1){
                                    ?>
                                    <tr> 
                                        
                                        <td style="padding-bottom: 50px;"align="center" colspan="2"><center>
                                                <?echo '<img src="data:image/jpeg;base64,'.base64_encode( $row_data['photos'] ).'" style="width: 800px; height: 400px;"/>';?><br>
                                                <?php echo $row_data['name']; ?>
                                            </center>
                                            
                                    </tr>    
                                     <?
                                        }else{
                                            //if($i == 3) echo "</tr>";
                                            if((($i-1)%2) == 1){
                                                //if($i > 3) echo "</tr>";
                                                echo "</tr><tr>";
                                            }
                                    ?>
                                    
                                        <td style="padding-bottom: 50px;" align="center"><center>
                                                <?echo '<img src="data:image/jpeg;base64,'.base64_encode( $row_data['photos'] ).'" style="width: 300px; height: 150px;"/>';?><br>
                                                <?php echo $row_data['name']; ?>
                                            </center>
                                        </td>
                                            
                                    
                                    <?        
                                        }
                                        $i++;
                                     }
                                     ?>
                                    
                            </table>
                     
                     
                    
</center>
</div>
<br><br>

<table id="dataTables-example" width="100%" style="border: 0px">
    <tr>
        <td valign="top">
<left>
    <h1>B. Dimensi</h1>

     <table width="100%" style="border: 0px">
                               

        <?
        $i=1;
        $dimensi_data = getDimensi();
        while($dimensi = $dimensi_data->fetch_assoc()) {

        ?>

        <tr class="odd gradeX">

        <td><?php echo $i; ?></td>
        <td><?php echo $dimensi['details']; ?></td>

        </tr>
        <?php $i++; } ?>
    </table>

</left>
</td><td valign="top"> 
<left>
    <h1>C. Bahan</h1>

     <table id="dataTables-example" width="100%" style="border: 0px">
                                
                        
        <?
        $i=1;
        $listN = getBahanDetails();
        while($list = $listN->fetch_assoc()) {

        ?>

        <tr class="odd gradeX">

        <td><?php echo $i; ?></td>
        <td><?php echo $list['name']; ?></td>


        </tr>
        <?php $i++; } ?>
    </table>

</left>
</td><td valign="top">
<left>
    <h1>D. Jentera</h1>

     <table id="dataTables-example" width="100%" style="border: 0px" >
                                
                        
        <?
        $i=1;
        $log = getMachineryDetail($id);
        while($list = $log->fetch_assoc()) {

        ?>

        <tr class="odd gradeX">

        <td><?php echo $i; ?></td>
        <td><?php echo $list['machinery_name']; ?></td>



        </tr>
        <?php $i++; } ?>  
    </table>

</left>
</td>
</tr>
</table>
<? /* End RUMUSAN */ ?>
<p style="page-break-after:always;"></p>


<? /* Start RUMUSAN */ ?>
<div align="right">
    <h6>Dokumen Spesifikasi | <? echo $data['name']; ?></h6>
</div>
<center>
    <h1>E. Contoh Gambar</h1>

     <table width="100%" style="border: 0px;">
        

        <?               
        $i= 1;
        $data_gambar = getContohGambar($id);
        while($row_data = $data_gambar->fetch_assoc()) {
            if(($i%2) == 1){
                //if($i > 3) echo "</tr>";
                echo "</tr><tr>";
            }
        ?>
        <td style="padding-bottom: 50px;">
            <center>
                <?echo '<img src="data:image/jpeg;base64,'.base64_encode( $row_data['photos'] ).'" style="width: 300px; height: 150px;"/>';?><br><?php echo $row_data['name']; ?></td>
            </center>
        <?php $i++; } ?>

    </table>

</center>

<? /* End RUMUSAN */ ?>
<p style="page-break-after:always;"></p>

<? /* Start RUMUSAN */ ?>
<div align="right">
    <h6>Dokumen Spesifikasi | <? echo $data['name']; ?></h6>
</div>
<center>
    <h1>F. Youtube</h1>

     <table width="100%" style="border: 0px;">
                                
                        
        <?
        $i=1;
        $data_youtube = getVideoDetail($id);
        while($list = $data_youtube->fetch_assoc()) {
            if(($i%2) == 1){
            //if($i > 3) echo "</tr>";
            echo "</tr><tr>";
        }   
        ?>
        <td style="padding-bottom: 50px;"><center>
        <iframe width="300" height="150" src="https://www.youtube.com/embed/<? echo $list['youtube_link'];?>" frameborder="0" gesture="media" allow="encrypted-media"></iframe><br><? echo $list['youtube_name'];?>
        </center>
        </td>
        <?php $i++; } ?>  
    </table>

</center>
<?if($projek_id > 0){?>
<p style="page-break-after:always;"></p>

<? /* Start RUMUSAN */ ?>
<div align="right">
    <h6>Dokumen Spesifikasi | <? echo $data['name']; ?></h6>
</div>
<center>
    <h1>G. Pelan Tapak Projek</h1>
     <?echo '<img src="data:image/jpeg;base64,'.base64_encode( getPelanTapak($projek_id) ).'" style="width: 100%;"/>';?>

</center>
<?}?>
<? /* End RUMUSAN */ ?>
<p style="page-break-after:always;"></p>

        
    </body>
</html>