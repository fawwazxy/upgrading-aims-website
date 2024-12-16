<?
include "../model/chat_function.php";

if($_REQUEST['submit']){
$carian = $_POST['name'];

 $result = getCarian($carian);

    if($result!="" && $result > 0)
    {
    	echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/search.php?carian=$carian';
            </script>");
        //header("location: ../view/search.php?carian=$carian");
        exit();
    }else
    {
        die("Query failed");
    }
}
?>