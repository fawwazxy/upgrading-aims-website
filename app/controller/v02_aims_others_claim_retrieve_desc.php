<?
require "../model/v02_aims_others_claim_function.php";
$id = $_POST['id']; //company_id
$staff_id = $_POST['staff_id'];
$result = v02getDropdownCostCentreByCompany($id,$staff_id);

if ($result->num_rows == 0){ ?>
    <option value="">-- Please choose a company --</option>
    <option style="background-color: #e3e3e3; font-weight: bold" disabled>No Cost Centre</option>
<? }
$i=1;
while($row = $result->fetch_assoc()){
    $bg_color = ($i%2 == 0) ? '': 'background-color: #e3e3e3;';
    echo '<option style="font-weight: bold; '.$bg_color.'" value="'.$row['id'].'">'.$row['description'].'</option>';
    echo ($row['remarks'])? '<option value="" style="color: #393939; font-weight: 500; font-style: italic;' .$bg_color.'" disabled> - '.$row['remarks'].'</option>':'';
    $i++;
} ?>