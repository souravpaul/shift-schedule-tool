<?php
$html->includeCss('team');
$html->setTitle('Add New Team');
?>
<div style="height:50px;width:99%;">
    <a href="<?php echo WEBROOT; ?>teams/viewall" class="checkout-btn" style="width:150px;float:right;">Team List</a><br/>
</div>
<div class="panel">
    <h2 class="panel-head">Add New Team</h2>
    <div class="panel-body">
        <form method="post" action="<?php echo WEBROOT ?>teams/add?attempt=1">
            <table class="team_form">
                <tr>
                    <td>Team Name</td>
                    <td><input type="text" name="team_name" class="base-input" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['team_name'] : ''; ?>"/></td>
                    <td><span class="error_tooltip">Invalid format.</span></td>
                </tr>
                <tr>
                    <td>Admin Userame</td>
                    <td><input type="text" name="admin_username" class="base-input" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['admin_username'] : ''; ?>"/></td>
                    <td><span class="error_tooltip">Invalid format.</span></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password" class="base-input"  value="" autocomplete="off"/></td>
                    <td><span class="error_tooltip">Invalid format.</span></td>
                </tr>
                <tr>
                    <td>Conf Password</td>
                    <td><input type="password" name="conf_password" class="base-input" autocomplete="off"/></td>
                    <td><span class="error_tooltip">Invalid format.</span></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Add Team" class="checkout-btn" /></td>
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






