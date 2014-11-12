<?php
$html->includeCss('team');
$html->setTitle('Team List');
?>
<div style="height:50px;width:99%;">
    <a href="<?php echo WEBROOT; ?>teams/add" class="checkout-btn" style="width:150px;float:right;">Add New Team</a><br/>
</div>
<table class="team_list" cellspacing="0">
    <tr>
        <th style="width:40%;">Team</th>
        <th style="width:40%;">Admin Username</th>
        <th style="width:20%;">Remove</th>
    </tr>
    <?php
    foreach ($team_list as $team) {
        echo '<tr>
                <td>'.$team['NAME'].'</td>
                <td>'.$team['USERNAME'].'</td>
                <td><a href="'.WEBROOT.'teams/remove/'.$team['TEAM_ID'].'" onclick="return confirm(\'Are you sure to delete the Team?\');">Remove</a></td>
            </tr>';
    }
    ?>
</table>
