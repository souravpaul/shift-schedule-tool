<?php
$html->includeCss('team');
$html->includeCss('home');
$html->setTitle('Home');
$html->setHeadLink("Schedule Today","schedules/view/1?ref=today");
$html->setHeadLink("Calender","schedules/calender");
?>
<div style="display:block;text-align: center;">
<?php
    foreach ($live_track as $team){
        if(strtolower($team['TEAM_NAME'])=='admin'){
            continue;
        }
?>
<div class="panel short_team_box">
    <h2 class="panel-head"><?php echo ucwords(strtolower($team['TEAM_NAME'])); ?> Team</h2>
    <div class="panel-body">
    <?php
    for ($i=0;$i<$max_mem;$i++){
        echo '<div class="team_sub_box">
            '.((isset($team['MEMBER'][$i]) && strlen($team['MEMBER'][$i])>2)?$team['MEMBER'][$i]:'-').'
        </div>';
    }
    ?>
        <div class="team_sub_box" style="background: none repeat scroll 0% 0% #11A8AB;color:white;">
            <a href="<?php echo WEBROOT; ?>members/view/<?php echo $team['TEAM_ID']; ?>" style="margin-right: 13px">View Member</a>|
            <a href="<?php echo WEBROOT; ?>schedules/view/<?php echo $team['TEAM_ID']; ?>?ref=today" style="margin-left: 13px">View Schedule</a>
        </div>
    </div>
</div>

<?php
    }
?>
</div>






