<?php
$html->includeCss('team');
$html->setTitle('Team List');
$html->setHeadLink("Add New Team","teams/add");
?>
<table class="team_list" cellspacing="0">
    <tr>
        <th style="width:35%;">Team</th>
        <th style="width:15%;">Short Name</th>
        <th style="width:20%;">Admin Username</th>
        <th style="width:35%;">Team/Admin Email</th>
        <th style="width:10%;">Action</th>
    </tr>
    <?php
    foreach ($team_list as $team) {
        echo '<tr>
                <td>'.$team['FULL_NAME'].'</td>
                <td>'.$team['SHORT_NAME'].'</td>
                <td>'.$team['USERNAME'].'</td>
                <td>'.$team['USER_EMAIL'].'</td>
                <td><a href="'.WEBROOT.'teams/edit/'.$team['TEAM_ID'].'">Edit</a></td>
            </tr>';
    }
    ?>
</table>
