<?
require "../model/v02_aims_others_claim_function.php";
$id = $_POST['id'];
$res = v02OthersClaimById($id)->fetch_assoc();
?>
<div class="table-responsive">
    <table class="table table-bordered table-hover" id="table_database" style="width: 100%">
        <tbody>
        <tr>
            <th>Company Claim</th>
            <td colspan="2"><? echo v02CompanyNameFromClaimId($res['id']); ?></td>
        </tr>
        <tr>
            <th style="width: 15%">Month Claim</th>
            <td colspan="2"><? echo $res['month_claim']; ?></td>
        </tr>
        <tr>
            <th>Job No</th>
            <td colspan="2"><? echo ($res['job_no']) ? : '<i class="text-muted" style="font-size: 12px">-- No Data --</i>';?></td>
        </tr>
        <tr>
            <th>Description</th>
            <td colspan="2"><? echo nl2br($res['description']);?></td>
        </tr>
        <tr>
            <th rowspan="3">Date Time</th>
        </tr>
        <tr>
            <td colspan="2"><b>Departure: </b><? echo $res['datetime_departure']<>'0000-00-00 00:00:00' ? $res['datetime_departure'] : '<i class="text-muted" style="font-size: 12px">-- No Data --</i>';?></td>
        </tr>
        <tr>
            <td colspan="2"><b>Arrival: </b><? echo $res['datetime_arrival']<>'0000-00-00 00:00:00' ? $res['datetime_arrival'] : '<i class="text-muted" style="font-size: 12px">-- No Data --</i>';?></td>
        </tr>
        <tr>
            <th>Type Claim</th>
            <td>
                <ul style="list-style: square">
                    <?
                    $type_claim = v02getTypeClaimByClaimId($id);
                        while ($type = $type_claim->fetch_assoc()){
                        $desc = getTypeClaimDescription($type['company_cc_id'])->fetch_assoc();
                        ?>
                        <li><? echo '<b>'.$desc['cost_centre'].'</b>: '.$desc['description'].' - RM '.$type['total']?>
                        </li>
                    <? }?>
                </ul>
            </td>
            <td class="text-center" style="vertical-align: middle; font-size: 16pt"><b>RM <? echo $res['total_claim']?></b></td>
        </tr>
        </tbody>
    </table>
</div>
