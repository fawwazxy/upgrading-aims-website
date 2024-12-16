


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


    <? require "../global/header.php"; ?>


<style>

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

.panel-group .panel-heading a:after {
  content: '';
  position: absolute;
  right: 20px;
  top:5px;
}
.panel-group .panel-heading a.collapsed:after {
  content: '';
}
</style>
</head><body>



<div class="header">
  <a href="<? echo $sys['sys_domain']; ?>" class="logo"><? $com = getCompany()->fetch_assoc();
           echo '<img src="data:image/png;base64,'.base64_encode( $com['logo'] ).'" style="width:10%"/>';?></a>

         <h1 style="font-size:40px;font-family:verdana">Frequently Asked Questions</h1>

         
  <div class="header-right">
 
  </div>
</div>


<br><br><br><br>

	<div class="container">

         <div class="panel-group" id="accordion">

         
							  <?           $i=0; 
                            $data = getFAQ();
                            while($row_data = $data->fetch_assoc()) {
							?>
							
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">
                     <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseParent<? echo $i ?>">
					<? echo $row_data['faq_produk']; ?> </a> 
                  </h4> 
               </div><!--/.panel-heading -->
               
                                <div id="collapseParent<? echo $i ?>" class="panel-collapse collapse">
                                <div class="panel-body">
                                <? 
                                $j=0;            
                                $list = getFAQloop($row_data['faq_produk']);
                                while($row_list = $list->fetch_assoc()) {
                                ?>


                               

                                <!-- nested -->

                                <div class="panel-group" id="nested<? echo $i; ?>">

                                <div class="panel panel-default">
                                <div class="panel-heading">
                                <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#nested<? echo $i; ?>" href="#nested-collapse<? echo $i.'_'.$j ?>">
                                <? echo $row_list['faq_title']; ?></a>
                                </h4>
                                </div><!--/.panel-heading -->
                                <div id="nested-collapse<? echo $i.'_'.$j ?>" class="panel-collapse collapse">
                                <div class="panel-body">
                                <? echo $row_list['faq_answer']; ?>




                                </div><!--/.panel-body -->
                                </div><!--/.panel-collapse --> 
                                </div><!-- /.panel --> 



                                </div><!-- /.panel-group -->

 <?
                                $j++;
                                }
                                ?>

                                </div><!--/.panel-body -->
                                </div><!--/.panel-collapse -->

                               
            </div><!-- /.panel -->

                           

           <? $i++;
       }
       ?>
           
         </div><!-- /.panel-group -->

     

</div><!-- /.container --> 

</body></html>