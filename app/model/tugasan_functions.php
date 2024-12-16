<?php
require '../../lib/db/connection.php';
session_start();

$action = ($_POST['action']);
if ($action == "addMainProject"){
  $pName=strtoupper($_POST['pName']);
  $rowid=strtoupper($_POST['rowid']);

  $result = saveMainProject($pName);

  echo "Data dikemaskini";
}

  // Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
  $conn=db();
  $str = @trim($str);
  if(get_magic_quotes_gpc()) {
    $str = stripslashes($str);
  }
  return mysqli_real_escape_string($conn,$str);
}

function getSys($sys_id) {
  $conn=db();
  $sql = "SELECT s.*,c.short_name FROM sys_setting s LEFT JOIN company c ON c.sys_id=s.sys_id WHERE s.sys_id='$sys_id'";
  $result = $conn->query($sql);
  return $result;
}

/**carta gantt logic**/
//example json to follow
// [
//   {
//     "pID": 1,
//     "pName": "Define Chart API",
//     "pStart": "",
//     "pEnd": "",
//     "pPlanStart": "",
//     "pPlanEnd": "",
//     "pClass": "ggroupblack",
//     "pLink": "",
//     "pMile": 0,
//     "pRes": "Mario",
//     "pComp": 0,
//     "pGroup": 1,
//     "pParent": 0,
//     "pOpen": 1,
//     "pDepend": "",
//     "pCaption": "",
//     "pNotes": "Some Notes text",
//     "category": "Planning",
//     "sector": "CMO"
//   }
// ]
function getJsonGanttData() {
  $conn=db();
  $sql = "SELECT *, pDepend as predecessor from staff_tugasan ORDER BY pID ASC";
  $result = $conn->query($sql);
  //$data = $result->fetch_all( MYSQLI_ASSOC );
  //echo json_encode( $data );
  //json_encode( $phpArray, JSON_HEX_APOS|JSON_HEX_QUOT ));
  $myArray = array();
  while($row = $result->fetch_array()) {
            $myArray[] = $row;
    }
    //echo json_encode($myArray);
  return json_encode($myArray);
}

function getJsonGanttDataById($id_projek) {
  $conn=db();
  $sql = "SELECT *, pDepend as predecessor from staff_tugasan WHERE id_projek='$id_projek' ORDER BY pID ASC";
  $result = $conn->query($sql);
  //$data = $result->fetch_all( MYSQLI_ASSOC );
  //echo json_encode( $data );
  //json_encode( $phpArray, JSON_HEX_APOS|JSON_HEX_QUOT ));
  //return json_encode($data);
  //return json_encode( $data, JSON_HEX_APOS|JSON_HEX_QUOT );
  $myArray = array();
  while($row = $result->fetch_array()) {
            $myArray[] = $row;
    }
    //echo json_encode($myArray);
  return json_encode($myArray);
}

function getAllStaff() {
  $conn=db();
  $sql = "SELECT concat(no_staff,' - ',name) as id,concat(no_staff,' - ',name) as name from staff where noic is not null and status='BEKERJA'";
  $result = $conn->query($sql);
  $myArray = array();
  while($row = $result->fetch_array()) {
            $myArray[] = $row;
    }
    //echo json_encode($myArray);
  return json_encode($myArray);
}

function getAllTask() {
  $conn=db();
  $sql = "select a.pID as id,concat((select b.pName from staff_tugasan b where b.pID = a.pParent),' : ',a.pName) as name from staff_tugasan a where a.pEnd is not null order by a.pID asc";
  $result = $conn->query($sql);
  $myArray = array();
  while($row = $result->fetch_array()) {
            $myArray[] = $row;
    }
    //echo json_encode($myArray);
  return json_encode($myArray);
}

function saveTugasan($pName, $id_projek, $pStart, $pEnd, $pDuration, $pPlanStart, $pPlanEnd, $pClass, $pLink, $pMile, $pRes, 
  $pParent, $pOpen, $pDepend, $pCaption, $pNotes, $pCost) {
  $conn=db();

  $created_by = $_SESSION['SESS_NO_STAFF'];
  //$pComp = $_SESSION['SESS_COM'];
  $pComp = 0;

  //get last numbering
  $sql = "select IFNULL(max(pID),0) as pID from staff_tugasan where pParent= $pParent ";
  $lastnum = $conn->query($sql)->fetch_object()->pID;
  $nparent = str_replace("'", "", $pParent);
  if($lastnum == 0){
    $lastnum = $nparent.'.1'; 
  }else{
    $runn_no = explode('.',$lastnum);
    //echo count($runn_no);
    //echo $value = end($runn_no); 
    $last = array_pop($runn_no);
    //reset($runn_no);
    $parts = array(implode('.', $runn_no), $last);
    $lastnum = $parts[0].'.'.($last+1);
  }

  $pGroup = setValue($lastnum);
  //set null if not parent level
  if($pClass != "'ggroupblack'"){
    $pGroup = setValue('NULL');
  }else{
    $pStart = setValue('NULL');
    $pEnd = setValue('NULL');
    $duration = setValue('NULL');
    $pPlanStart = setValue('NULL');
    $pPlanEnd = setValue('NULL');
    $pRes = setValue('NULL');
    $pDepend = setValue('NULL');
  }

  $sql = "insert into staff_tugasan (id_projek, pID, pName, pStart, pEnd,pDuration, pPlanStart, pPlanEnd, pClass, pLink, pMile, pRes, pComp, pGroup, pParent, pOpen, pDepend, pCaption, pNotes, pCost,created_by)
  values('$id_projek','$lastnum', $pName, $pStart, $pEnd,$pDuration, $pPlanStart, $pPlanEnd, $pClass, 
  $pLink, $pMile,$pRes, $pComp, $pGroup, $pParent, $pOpen, $pDepend, 
  $pCaption, $pNotes, $pCost, '$created_by')";
  $result = $conn->query($sql) or die($conn->error);
  //$newid=$conn->insert_id;
  return $result;
}

function updateTugasan($pID, $pName, $pStart, $pEnd, $pDuration, $pPlanStart, $pPlanEnd, $pClass, 
  $pLink, $pMile, $pRes, $pComp, $pParent, $pOpen, $pDepend, $pCaption, $pNotes, $pCost) {
  $conn=db();

  $pGroup = setValue($pID);
  if($pClass != "'ggroupblack'"){
    $pGroup = setValue('NULL');
  }else{
    $pStart = setValue('NULL');
    $pEnd = setValue('NULL');
    $duration = setValue('NULL');
    $pPlanStart = setValue('NULL');
    $pPlanEnd = setValue('NULL');
    $pRes = setValue('NULL');
    $pDepend = setValue('NULL');
  }

  $sql = "update staff_tugasan set pName = $pName, pStart = DATE_FORMAT($pStart,'%Y-%m-%d %H:%i:%s'), 
  pEnd = $pEnd,pDuration = $pDuration, 
  pPlanStart = $pPlanStart, pPlanEnd = $pPlanEnd, pClass = $pClass, pLink = $pLink, pMile = $pMile, 
  pRes = $pRes, pComp = $pComp, pGroup = $pGroup, pParent = $pParent, pOpen = $pOpen, pDepend = $pDepend, 
  pCaption = $pCaption, pNotes = $pNotes
  where pID = $pID ";
  
  $result = $conn->query($sql);
  return $result;
}

function setValue($value){
  if(isset($value) && !empty($value)){
    if($value == "NULL"){
      $value = "NULL";
    }else{
      $value = "'$value'";
    }
  }else if($value == "0"){
    $value = "'$value'";
  }else if($value == "NULL"){
    $value = "NULL";
  }else{
    $value = "NULL";
  }

  return $value;
}
/**end carta gantt logic**/

/**tugasan flow logic**/
function getMainProjectList() {
  $conn=db();
  $sql = "SELECT * FROM staff_tugasan WHERE pParent = '0' ";
  $result = $conn->query($sql);
  return $result;
}

function saveMainProject($pName) {
  $conn=db();
  $created_by = $_SESSION['SESS_NO_STAFF'];

  //get last numbering
  $sql = "select IFNULL(max(pID),0) as pID from staff_tugasan where id_projek is not null ";
  $lastnum = $conn->query($sql)->fetch_object()->pID;
  if($lastnum == 0) $lastnum = 1; else $lastnum = $lastnum + 1;

  $sql = "insert into staff_tugasan (id_projek,pID, pName,pClass,pGroup,pParent,created_by) 
  values('$lastnum','$lastnum','$pName','ggroupblack','$lastnum','0','$created_by')";
  $result = $conn->query($sql);
  return $result;
}

/**tugasan flow logic**/

?>