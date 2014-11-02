<?php
$html->includeCss('member');
$html->setTitle('Add New Member');
?>


<div class="box_container">
    <div class="box_header">
        <a href="<?php echo WEBROOT ?>members/viewall" class="button">Member List</a>
        <h3>Add New Member</h3>
    </div>
    <div class="box_body">
        <form name="member_add_form" id="member_add_form" method="post" action="<?php echo WEBROOT ?>members/add?attempt=1">
            <table class="add_form">
                <tr>
                    <td>First Name<font color="red">*</font></td>
                    <td><input class="base-input" type="text" name="fname" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['fname'] : ''; ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td>Middle Name</td>
                    <td><input class="base-input"  type="text" name="mname" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['mname'] : ''; ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td>Last Name<font color="red">*</font></td>
                    <td><input class="base-input"  type="text" name="lname" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['lname'] : ''; ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td><?php echo PROJECT ?> ID<font color="red">*</font></td>
                    <td><input class="base-input"  type="text" name="pj_id" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['pj_id'] : ''; ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td><?php echo PROJECT ?> Email</td>
                    <td><input class="base-input"  type="text" name="pj_email" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['pj_email'] : ''; ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td><?php echo PROJECT ?> Role</td>
                    <td><input class="base-input"  type="text" name="pj_role" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['pj_role'] : ''; ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td><?php echo COMPANY ?> Employee Id<font color="red">*</font></td>
                    <td><input class="base-input"  type="text" name="cmp_id" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['cmp_id'] : ''; ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td><?php echo COMPANY ?> Email<font color="red">*</font></td>
                    <td><input class="base-input"  type="text" name="cmp_email" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['cmp_email'] : ''; ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td><?php echo COMPANY ?> Role</td>
                    <td><input class="base-input"  type="text" name="cmp_role" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['cmp_role'] : ''; ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td>Contact 1<font color="red">*</font></td>
                    <td><input class="base-input"  type="text" name="contact_1" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['contact_1'] : ''; ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td>Contact 2</td>
                    <td><input class="base-input"  type="text" name="contact_2" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['contact_2'] : ''; ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td>Location</td>
                    <td><input class="base-input"  type="text"  name="location" /></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td>Location Type</td>
                    <td>
                        <div class="register-switch">
                            <input type="radio" name="location_type" value="Onsite" id="Onsite" class="register-switch-input" checked>
                            <label for="Onsite" class="register-switch-label">Onsite</label>
                            <input type="radio" name="location_type" value="Offshore" id="Offshore" class="register-switch-input">
                            <label for="Offshore" class="register-switch-label">Offshore</label>
                        </div>
                    </td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Submit" class="checkout-btn" style="margin:0px;float:none;"/></td>
                    <td></td>
                </tr>
            </table>
        </form>

    </div>
</div>

<script>
    $(document).ready(function() {
        //  alert(form_status);
        var status = JSON.parse(form_status);
        $('#member_add_form tr td .error_tooltip').css('visibility', 'hidden');
        for (var i = 0; i < status.length; i++) {
            //  alert('#member_add_form font:eq('+status[i]['target_block']+')');

            $('#member_add_form .error_tooltip:eq(' + (status[i]['target_block'] - 1) + ')').html(status[i]['message']);
            $('#member_add_form .error_tooltip:eq(' + (status[i]['target_block'] - 1) + ')').css('visibility', 'visible');
        }
    });
</script>