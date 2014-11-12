<?php
$html->includeCss('team');
$html->setTitle('Add New Team');
$html->setHeadLink("Team List","teams/viewall");
?>
<div class="panel">
    <h2 class="panel-head">Add New Team</h2>
    <div class="panel-body">
        <form method="post" action="<?php echo WEBROOT ?>teams/add?attempt=1">
            <table class="team_form">
                <tr>
                    <td>Team Full Name</td>
                    <td><input type="text" name="team_full_name" class="base-input" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['team_full_name'] : ''; ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td>Team Short Name</td>
                    <td><input type="text" name="team_short_name" class="base-input" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['team_short_name'] : ''; ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td>Team/Admin Email</td>
                    <td><input type="text" name="team_email" class="base-input" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['team_email'] : ''; ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Add Team" class="checkout-btn"/></td>
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






