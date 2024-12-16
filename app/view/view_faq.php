
<?
require "../model/support_function.php";
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">





    <style>
        * {box-sizing: border-box;}

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .header {
            overflow: hidden;
            background-color: #f1f1f1;
            padding: 1px 10px;
        }

        .header a {
            float: left;
            color: black;
            text-align: center;
            padding: 12px;
            text-decoration: none;
            font-size: 18px;
            line-height: 25px;
            border-radius: 4px;
        }

        .header a.logo {
            font-size: 25px;
            font-weight: bold;
        }

        .header a:hover {
            background-color: #ddd;
            color: black;
        }

        .header a.active {
            background-color: dodgerblue;
            color: white;
        }

        .header-right {
            float: right;
        }

        @media screen and (max-width: 500px) {
            .header a {
                float: none;
                display: block;
                text-align: left;
            }
            .header-right {
                float: none;
            }
        }

        .accordion {
            background-color: #eee;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 50%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;

        }

        .accordiones {
            background-color: #f49b5d;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 50%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 18px;
            transition: 0.4s;

        }


        .active, .accordion:hover {
            background-color: #ccc;
        }

        .panel{
            padding: 0 18px;
            display: none;
            background-color: white;
            overflow: hidden;
        }

        .col-sm-8{
            margin-left: 200px;
            margin-right: 200px;
        }

        * {
            box-sizing: border-box;
        }

        form.example input[type=text] {
            padding: 10px;
            font-size: 17px;
            border: 1px solid grey;
            float: left;
            width: 80%;
            background: #f1f1f1;
        }

        form.example button {
            float: left;
            width: 20%;
            padding: 10px;
            background: #2196F3;
            color: white;
            font-size: 17px;
            border: 1px solid grey;
            border-left: none;
            cursor: pointer;
        }

        form.example button:hover {
            background: #0b7dda;
        }

        form.example::after {
            content: "";
            clear: both;
            display: table;
        }


    </style>

</head>

<? $sys = getSys(1) -> fetch_assoc(); ?>





<body>

<div class="header">
    <a href="<? echo $sys['sys_domain']; ?>" class="logo"><? $com = getCompany()->fetch_assoc();
        echo '<img src="data:image/png;base64,'.base64_encode( $com['logo'] ).'" style="width:10%"/>';?></a>

    <h1 style="font-size:40px;font-family:verdana">Frequently Asked Question</h1>


    <div class="header-right">

    </div>
</div>



<div style="padding-right:30px">


    <div class="form-group" align="center">



        <!-- <label style="font-family:verdana;font-size:50px;">FAQ</label>  --><br><br><br><br><br>

        <div>
            <?
            $data = getFAQ();
            while($row_data = $data->fetch_assoc()) {


                ?>

                <button class="accordiones"  ><? echo $row_data['faq_produk']; ?></button>
                <div class="panel">


                    <button class="accordion" style="margin-left:200px;" ><? echo $row_data['faq_title']; ?></button>
                </div>

                <div class="panel">
                    <p>Jawapan:<? echo $row_data['faq_answer']; ?></p> <br>
                </div>   <?}?>
        </div>








        <? include ('../global/footer.php'); ?>
    </div>
    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            });
        }
    </script>
    <script>
        var acc = document.getElementsByClassName("accordiones");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            });
        }
    </script>

    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


</body>
</html>
