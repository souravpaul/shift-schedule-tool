<?php $html->setTitle("Recover Password");
?>


<div class="panel" style="width:40%;margin:8% auto; ">
    <h2 class="panel-head">Recover Password</h2>
    <div class="panel-body">
        <form method="post" action="<?php echo WEBROOT ?>account/forget_password?attempt=1">
            <table style="width:90%;">
                <tr>
                    <td><label><b>Username:</b></label></td>
                    <td><input type="text" name="username"  class="base-input" style="width:90%;"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><br/><input type="submit" value="Recover Password" style="float: none;margin-left:5px;width:80%;" class="button"/></td>
                </tr>
            </table>

        </form>
    </div>
</div>
