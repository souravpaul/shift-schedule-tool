<?php $html->setTitle("Change Password");
?>


<div class="panel" style="width:40%;margin:8% auto; ">
    <h2 class="panel-head">New Password</h2>
    <div class="panel-body">
        <form method="post" action="<?php echo WEBROOT ?>account/reset_password?attempt=1">
            <table style="width:90%;">
                <tr>
                    <td><label><b>New Password:</b></label></td>
                    <td><input type="password" name="password"  class="base-input" style="width:90%;"/></td>
                </tr>
                <tr>
                    <td><label><b>Conf Password:</b></label></td>
                    <td><input type="password" name="conf_password"  class="base-input" style="width:90%;"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><br/><input type="submit" value="Change Password" style="float: none;margin-left:5px;width:70%;" class="button"/></td>
                </tr>
            </table>

        </form>
    </div>
</div>
