<?php
$html->includeCss('team');
$html->setTitle('Shift List');
$html->setHeadLink("Add New Structure","shifts/add");
?>

<table class="team_list" cellspacing="0">
    <tr>
        <th style="width:20%;">Start Time</th>
        <th style="width:2s0%;">End Time</th>
        <th style="width:20%;">Type</th>
        <th style="width:20%;">Weekdays/Weekends</th>
        <th style="width:20%;">Action</th>
    </tr>
    <?php
    foreach ($shift_list as $shift) {
        echo '<tr>
                <td>'.date('g A',  strtotime($shift['START_TIME'])).'</td>
                <td>'.date('g A',  strtotime($shift['END_TIME'])).'</td>
                <td>'.ucwords($shift['SHIFT_TYPE']).'</td>
                <td>'.ucwords($shift['SHIFT_DAYS']).'</td>
                <td><a href="'.WEBROOT.'shifts/remove/'.$shift['STRUCT_ID'].'" onclick="return confirm(\'Are you sure to delete the Team?\');">Deactivate</a></td>
            </tr>';
    }
    ?>
</table>