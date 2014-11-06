<?php $html->setTitle("Login");
?>


<div class="panel" style="width:40%;margin:8% auto; ">
    <h2 class="panel-head">Login</h2>
    <div class="panel-body">
        <form method="post" action="<?php echo WEBROOT ?>account/login?attempt=1">
            <table style="width:90%;">
                <tr>
                    <td><label><b>Username:</b></label></td>
                    <td><input type="text" name="username" class="base-input" style="width:90%;"/></td>
                </tr>
                <tr>
                    <td><label><b>Password:</b></label></td>
                    <td><input type="password" name="password"  class="base-input" style="width:90%;"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><br/>
                        <input type="submit" value="Login" style="float: none;margin-left:5px;width:50%;" class="button"/>
                        <a href="<?php echo WEBROOT ?>account/forget_password" style="font-size:13px;font-weight:bold;">Forget Password?</a>
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>
