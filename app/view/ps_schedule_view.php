<?

require "../model/project_schedule_function.php";
$id_project =$_GET['id_project'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <charset="utf-8" />
<?  $sys = getSys(1)->fetch_assoc();?>


<title><? echo $sys['sys_name']; ?>::<? echo $sys['sys_tagline']; ?></title>
<? require "../global/header.php"; ?>


<link rel="stylesheet" type="text/css" href="../../resources/css/jsgantt.css"/>
<script language="javascript" src="../../js/jsgantt.js"></script>
<!--<script language="javascript" src="../../lib/graphics.js"></script>-->

<style type="text/css">
<!--
.style1 {color: #0000FF}

.roundedCorner{display:block}
.roundedCorner *{
  display:block;
  height:1px;
  overflow:hidden;
  font-size:.01em;
  background:#0061ce}
.roundedCorner1{
  margin-left:3px;
  margin-right:3px;
  padding-left:1px;
  padding-right:1px;
  border-left:1px solid #91bbe9;
  border-right:1px solid #91bbe9;
  background:#3f88da}
.roundedCorner2{
  margin-left:1px;
  margin-right:1px;
  padding-right:1px;
  padding-left:1px;
  border-left:1px solid #e5effa;
  border-right:1px solid #e5effa;
  background:#307fd7}
.roundedCorner3{
  margin-left:1px;
  margin-right:1px;
  border-left:1px solid #307fd7;
  border-right:1px solid #307fd7;}
.roundedCorner4{
  border-left:1px solid #91bbe9;
  border-right:1px solid #91bbe9}
.roundedCorner5{
  border-left:1px solid #3f88da;
  border-right:1px solid #3f88da}
.roundedCornerfg{
  background:#0061ce;}


-->
</style>


</head>

<body>


<h1 align="center" style="color:black">Jadual Kerja - Gantt</h1>
<div class="page-wrapper">
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                       
                        <!-- /.panel-heading -->
                        <div class="panel-body">
 
              <table border="0	">
                        <tbody>

                        <? 
                    $row_log= getProjekById($id_project)->fetch_assoc();
                ?>
                        <tr>
                            <td width="15%"><p><b>Kod Projek</b></td>
                            <td width="2%"><p>:</td>
                            <td width="20%"><p><?php echo $row_log['project_code']; ?> </td>
                            <td width="63%"></td>
                        </tr>
                        <tr>
                            <td><p><b>Nama Projek</b></td>
                            <td><p>:&nbsp;</td>
                            <td><p><?php echo $row_log['project_name']; ?></u></td>
							
                        </tr>
                        <tr>
                            <td><p><b>Pelanggan</b></td>
                            <td><p>:</td>
                            <td><p><?php echo $row_log['client_name']; ?> </td>
                            <td align="center"><font size="4"><?echo $date_year;?></font></td>
                        </tr>
						<tr>
                            <td colspan=3>
                                <button type="button" onclick="return popitup('ps_schedule_add.php?id_project=<? echo $id_project; ?>')" class="btn btn-info">Milestone & Task</button>
                            </td>
                        </tr>
                        
                        
                        </tbody>
                        </table>
						

<div style="position:relative" class="gantt" id="GanttChartDIV"></div>
<script>


  // here's all the html code neccessary to display the chart object

  // Future idea would be to allow XML file name to be passed in and chart tasks built from file.

  var g = new JSGantt.GanttChart('g',document.getElementById('GanttChartDIV'), 'day');


	g.setShowRes(1); // Show/Hide Responsible (0/1)
	g.setShowPriority(1); // Show/Hide Priority (0/1)
	g.setShowDur(1); // Show/Hide Duration (0/1)
	g.setShowComp(1); // Show/Hide % Complete(0/1)
   g.setCaptionType('None');  // Set to Show Caption (None,Caption,Resource,Duration,Complete)
	//g.setFormatArr("hours","minutes")

  //var gr = new Graphics();

  if( g ) {

   
	
	// You can also use the XML file parser JSGantt.parseXML('project.xml',g)
<?
$date = new DateTime();
	$current_date=$date->format('m-d-Y');
   $i= 1;
$row_data=getScheduleMilestone($id_project);
while ($row = $row_data->fetch_assoc()){
	
		 
	?>
	 // Parameters             (pID,pDataID ,pName,                  pStart,      pEnd,        pColor,   pLink,          pMile, pRes,priority,  pComp, pGroup, pParent, pOpen)
	 g.AddTaskItem(new JSGantt.TaskItem(<?echo $i;?>, '<?echo $row['id']?>' , '<?echo $i;?>) <?echo $row['milestone']?>','<?echo $row['start_date']?>','<?echo $row['end_date']?>','ff0000', '',0, '','',0, 1, 0, 1));
	<?
	$j= 1;
	$row_data1=getScheduleTask($row['id']);
	while ($row1 = $row_data1->fetch_assoc()){
		
	 $start_date= $row1['start_date'];
	 $end_date= $row1['end_date'];
	 
	
?>
  
    g.AddTaskItem(new JSGantt.TaskItem(<?echo $i.$j;?>, '<?echo $row1['id']?>' , '<?echo $i.'.'.$j;?>) <?echo $row1['task']?>',  '<?echo $start_date;?>','<?echo $end_date;?>','ff00ff', '',0,'<?echo $row1['owner']?>','<?echo $row1['priority']?>',<?echo $row1['percentage_done']?>, 0,<?echo $i;?>, 1));
   <?

	
	$j++;}
$i++;} 	
?>

    g.Draw();	
    g.DrawDependencies();

  }

  else

  {

    alert("not defined");

  }

</script>
 <center><a href="ps_schedule_add.php?id_project=<?echo $id_project;?>"><button type="button" class="btn btn-primary">Tutup</button></a></center>
</div>
</div>
</div>
</div>
</div>
</body>

</html>