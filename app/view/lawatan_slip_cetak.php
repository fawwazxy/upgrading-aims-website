<?php

    include ('../controller/auth.php');

    require "../model/lawatan_functions.php";

    date_default_timezone_set("Asia/Kuala_Lumpur");
    $date_month = date(m);
    $date_year = date(Y);
    $date_day = date(d);
    $time_hour = date(H);
    $time_min = date(i);
    $time_sec = date(s);

    $sys = getSys(1)->fetch_assoc();

    $id_lawatan = $_GET['id_lawatan'];
    $pelawat_info = getPelawatInfoById($id_lawatan)->fetch_assoc();
?>

<!DOCTYPE html>
<html>
    
    <title>iOffice::Sistem Pengurusan Pejabat Bersepadu</title>
    <head>
    <script src="../../js/jquery/jquery.min.js"></script>
    <script src="../../js/html2canvas/html2canvas.js"></script>

        <style type="text/css">
        i{
            font-family: "Times New Roman";
        }
        body {      
            font-family: Times New Roman;
            font size: 100px;
        }
         
        div.invoice {
        border:0px solid #ccc;
        padding:10px;
        height:740pt;
        width:570pt;
        }
        
        .pagebreak { 
            page-break-before: always; 
        }
        
        div.company-address {
            border:1px solid #ccc;
            float:left;
            width:200pt;
        }
         
        div.invoice-details {
            border:0px solid #ccc;
            float:right;
            width:200pt;
        }
         
        div.customer-address {
            border:1px solid #ccc;
            float:right;
            margin-bottom:50px;
            margin-top:100px;
            width:200pt;
        }
         
        div.clear-fix {
            clear:both;
            float:none;
        }
         
        table {
            width:100%;
        }
         
        th {
            text-align: left;
        }
         
        td {
        }
         
        .text-left {
            text-align:left;
        }
         
        .text-center {
            text-align:center;
        }
         
        .text-right {
            text-align:right;
        }

        .text-top {
            text-align:top;
        }


         
    
    @media print {
        #printPageButton {
        display: none;
    }
    } 

    @media print {
      #html-content-holder {
        display: none;
      }
      #btn-Preview-Image {
        display: none;
      }
    } 
    table { page-break-inside:auto }
    tr { page-break-inside:avoid; page-break-after:auto }

     colorbox{
        float: left;
        width: 50px;
        height: 20px;
        margin: 5px;
        border: 1px solid rgba(0, 0, 0, .2);
    }

    </style>

    </head>
 
    <body>
    
            <br><br><br>
            <center>
            <div class="invoice">
            <div style="text-align:center">

            <center>
            <div class="clear-fix"></div>

            <fieldset class="first" >
            <tr>
                <h3>SLIP PELAWAT</h3>
            <table border='0' cellspacing='0'>
            <tbody>        
            <tr>
            <td colspan="2" class='text-left' height='35px' width="30%"><b>Nama Pelawat</b></td>
            <td colspan="1" class='text-left' height='35px'><b>:</b></td>
            <td colspan="2" class='text-left' height='35px'><?echo $pelawat_info['nama'] ;?></td>
            </tr>
            <tr>
            <td colspan="2" class='text-left' height='35px' width="30%"><b>No. Kad Pengenalan</b></td>
            <td colspan="1" class='text-left' height='35px'><b>:</b></td>
            <td colspan="2" class='text-left' height='35px'><?echo $pelawat_info['nokp'];?></td>
            </tr>
            <tr> 
            <td colspan="2" class='text-left' height='35px' width="30%"><b>No. Telefon</b></td>
            <td colspan="1" class='text-left' height='35px'><b>:</b></td>
            <td colspan="2" class='text-left' height='35px'><?echo $pelawat_info['notel']; ?></td>
            </tr>
            <tr> 
            <td colspan="2" class='text-left' height='35px' width="30%"><b>Nama Syarikat</b></td>
            <td colspan="1" class='text-left' height='35px'><b>:</b></td>
            <td colspan="2" class='text-left' height='35px'><?echo $pelawat_info['nama_company']; ?></td>
            </tr>
            <tr> 
            <td colspan="2" class='text-left' height='35px' width="30%"><b>Jenis Kenderaan</b></td>
            <td colspan="1" class='text-left' height='35px'><b>:</b></td>
            <td colspan="2" class='text-left' height='35px'><?echo $pelawat_info['jenis_kenderaan']; ?></td>
            </tr>
            <tr> 
            <td colspan="2" class='text-left' height='35px' width="30%"><b>No. Kenderaan</b></td>
            <td colspan="1" class='text-left' height='35px'><b>:</b></td>
            <td colspan="2" class='text-left' height='35px'><?echo $pelawat_info['no_kenderaan']; ?></td>
            </tr>
            <tr> 
            <td colspan="2" class='text-left' height='35px' width="30%"><b>Nama Staf</b></td>
            <td colspan="1" class='text-left' height='35px'><b>:</b></td>
            <td colspan="2" class='text-left' height='35px'><?echo $pelawat_info['name']; ?></td>
            </tr>
            <tr> 
            <td colspan="2" class='text-left' height='35px' width="30%"><b>No. Kad Pengenalan</b></td>
            <td colspan="1" class='text-left' height='35px'><b>:</b></td>
            <td colspan="2" class='text-left' height='35px'><?echo $pelawat_info['nokp_staff']; ?></td>
            </tr>
            <tr> 
            <td colspan="2" class='text-left' height='35px' width="30%"><b>Masa Masuk</b></td>
            <td colspan="1" class='text-left' height='35px'><b>:</b></td>
            <td colspan="2" class='text-left' height='35px'><?echo $pelawat_info['tarikh_masa_masuk'];?></td>
            </tr>
            <tr> 
            <td colspan="2" class='text-left' height='35px' width="30%"></td>
            <td colspan="2" class='text-left' height='35px'><b></b></td>
            </tr>
            <tr> 
            <td colspan="2" class='text-left' height='35px' width="30%"></td>
            <td colspan="2" class='text-left' height='35px'><b></b></td>
            </tr>
            <tr> 
            <td colspan="2" class='text-left' height='35px' width="30%"><b>Disahkan oleh</b></td>
            <td colspan="1" class='text-left' height='35px'><b>:</b></td>
            <td colspan="2" class='text-left' height='35px'>-------------------------------------------------------------</td>
            </tr>
            </th>
        </tr>
    </table>
    </fieldset>

    <div style="text-align:center;">
    <br><input id="btn-Preview-Image" type="button" onclick="window.print()" value="Cetak"/>
    <br><br>

    <th>
    
</th>

</tr>
</table>

            
    </body>

    <script>
    $(document).ready(function() {
         //window.onload = function() { window.print(); }
    });

    function pengesahanPelanggan(id){
    $.ajax({
        url: "../model/backoffice_functions.php",
        type: "POST",
        data: {action:"pengesahanPelanggan",id:id},
        success: function (response) {
            // you will get response from your php page (what you echo or print)                 
            //$.alert('test here:'+response);
            //$( "#dataTables-example" ).load( "penternak_senarai.php #dataTables-example" );
            alert('Pengesahan berjaya');
            window.location = window.close();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
}
    </script>
</html>
