<?
  include "../model/staff_function.php";

 $action = ($_GET['act']);

if ($action == "shift_update"){
  
  $shift_code=($_POST['shift_code']);

  $no_staffs=$_POST['no_staff'];
    //$result =  addCuti($perkara,$tarikh_cuti);

    if(empty($no_staffs)) {
      echo("Sila tanda pada kotak yang disediakan.");
      // $result = roleAccessInactive($role_code);
    }else {
      $N = count($no_staffs);
      //echo("You selected $N door(s): ");

      //inactive existing role
      // roleAccessInactive($role_code);

      foreach($no_staffs as $no_staff){
        //echo $shift."<br>";
         $result =updateShift($shift_code, $no_staff);

         
    
      }
     echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/shift_bekerja.php?tab_shift=$shift_code';
            </script>");
     // header("location: ../view/shift_bekerja.php?tab_shift=$shift_code");
      exit();

}
}


?>