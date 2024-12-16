<?

    // require "../model/project_management_function.php";
    require "../model/config_pengguna_functions.php";
    require"../controller/auth.php";


    date_default_timezone_set("Asia/Kuala_Lumpur");
    $sys_id = $_GET['sys_id'];
    $status = $_GET['status'];
    $sys = getSys($sys_id)->fetch_assoc();
    ?>

<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" type="image/x-icon" href="../../resources/images/favicon.ico" />
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
        table, th, td {
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

    </style>
</head>
<body>
    <button id="printPageButton" onClick="window.print();">Cetak</button>


    <center><h3>SENARAI PENGGUNA <? echo strtoupper($status);?> PASANG APLIKASI</h3></center>

   <br><br>

   <?
        $data_jabatan = getJabatanList($status);
        while($list_jabatan = $data_jabatan->fetch_assoc()) {

   ?>

    <table width="100%">
        <tr>
            <th colspan="3">Jab/Unit/Bhgn : <? echo $list_jabatan['description'];?></th>
            <th>Bil : <? echo $list_jabatan['telah_pasang'];?></th>
        </tr>
        <?

        ?>
        <tr>
            <td width="10%">Bil</td>
            <td>Nama</td>
            <td>No. Staf</td>
            <td>NO. Telefon</td>
        </tr>
        <?

        $data_pengguna = getPenggunaList($list_jabatan['code_department'],$status);
        $i=1;
        while($list_pengguna = $data_pengguna->fetch_assoc()) {

        ?>
        <tr>
            <td width="10%"><?echo $i++;?></td>
            <td><? echo $list_pengguna['name'];?></td>
            <td><? echo $list_pengguna['no_staff'];?></td>
            <td><? echo $list_pengguna['phone'];?></td>
        </tr>
        <?}?>
    </table>
    <br><br>
    <?}?>

    
