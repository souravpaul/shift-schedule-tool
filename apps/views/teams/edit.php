<?php
$html->includeCss('team');
$html->setTitle('Update Team');
$html->setHeadLink("Team List","teams/viewall");
$html->setHeadLink("Add New Team","teams/add");
?>
<div class="panel">
    <h2 class="panel-head">Add New Team</h2>
    <div class="panel-body">
       
        <form method="post" action="<?php echo WEBROOT ?>teams/edit?attempt=1">
            <input type="hidden" name="team_id" value="<?php echo (isset($_OLD_STATE['team_id']))?$_OLD_STATE['team_id']:((isset($team['TEAM_ID']))?$team['TEAM_ID']:-1); ?>"/>
            <table class="team_form">
                <tr>
                    <td>Team Full Name</td>
                    <td><input type="text" name="team_full_name" class="base-input" value="<?php echo (isset($_OLD_STATE['team_full_name']))?$_OLD_STATE['team_full_name']:((isset($team['FULL_NAME']))?$team['FULL_NAME']:''); ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td>Team Short Name</td>
                    <td><input type="text" name="team_short_name" class="base-input" value="<?php echo (isset($_OLD_STATE['team_short_name']))?$_OLD_STATE['team_short_name']:((isset($team['SHORT_NAME']))?$team['SHORT_NAME']:-1); ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td>Team/Admin Email</td>
                    <td><input type="text" name="team_email" class="base-input" value="<?php echo (isset($_OLD_STATE['team_email']))?$_OLD_STATE['team_email']:((isset($team['USER_EMAIL']))?$team['USER_EMAIL']:''); ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="Update Team" class="checkout-btn" style="width:40%;display:inline-block;"/>
                        <a href="<?php echo WEBROOT ?>teams/remove/<?php echo (isset($_OLD_STATE['team_id']))?$_OLD_STATE['team_id']:((isset($team['TEAM_ID']))?$team['TEAM_ID']:-1); ?>"
                           onclick="return confirm('After deletion it can\'t be recover.Do you want to proced?');" class="checkout-btn"  style="width:40%;display:inline-block;">Remove</a>
                    </td>
                    <td></td>
                </tr>
            </table>

        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        var status = JSON.parse(form_status);
        $('#team_form tr td .error_tooltip').css('visibility', 'hidden');
        for (var i = 0; i < status.length; i++) {
            $('.team_form .error_tooltip:eq(' + (status[i]['target_block'] - 1) + ')').html(status[i]['message']);
            $('.team_form .error_tooltip:eq(' + (status[i]['target_block'] - 1) + ')').css('visibility', 'visible');
        }
    });
</script>






