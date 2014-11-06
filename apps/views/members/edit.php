<?php
$html->includeCss('member');
$html->setTitle('Update Member Profile');
$html->setHeadLink("Member List","members/viewall");
?>


<div class="box_container">
    <div class="box_header">
        <h3>Add New Member</h3>
    </div>
    <div class="box_body">
        <form name="member_add_form" id="member_add_form" method="post" action="<?php echo WEBROOT ?>members/edit?attempt=1">
            <input type="hidden" name="member_id" value="<?php echo (isset($_OLD_STATE['member_id']))?$_OLD_STATE['member_id']:((isset($member['MEM_ID']))?$member['MEM_ID']:-1); ?>"/>
            <table class="add_form">
                <tr>
                    <td>First Name<font color="red">*</font></td>
                    <td><input class="base-input" type="text" name="fname" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['fname'] : ((isset($member['FIRST_NAME']))?$member['FIRST_NAME']:''); ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td>Middle Name</td>
                    <td><input class="base-input"  type="text" name="mname" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['mname'] : ((isset($member['MIDDLE_NAME']))?$member['MIDDLE_NAME']:''); ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td>Last Name<font color="red">*</font></td>
                    <td><input class="base-input"  type="text" name="lname" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['lname'] : ((isset($member['LAST_NAME']))?$member['LAST_NAME']:''); ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td><?php echo PROJECT ?> ID<font color="red">*</font></td>
                    <td><input class="base-input"  type="text" name="pj_id" readonly="readonly" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['pj_id'] : ((isset($member['PJ_ID']))?$member['PJ_ID']:''); ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td><?php echo PROJECT ?> Email</td>
                    <td><input class="base-input"  type="text" name="pj_email" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['pj_email'] : ((isset($member['PJ_EMAIL']))?$member['PJ_EMAIL']:''); ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td><?php echo PROJECT ?> Role</td>
                    <td><input class="base-input"  type="text" name="pj_role" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['pj_role'] : ((isset($member['PJ_ROLE']))?$member['PJ_ROLE']:''); ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td><?php echo COMPANY ?> Employee Id<font color="red">*</font></td>
                    <td><input class="base-input"  type="text" name="cmp_id"  readonly="readonly"  value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['cmp_id'] : ((isset($member['CMP_ID']))?$member['CMP_ID']:''); ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td><?php echo COMPANY ?> Email<font color="red">*</font></td>
                    <td><input class="base-input"  type="text" name="cmp_email" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['cmp_email'] : ((isset($member['CMP_EMAIL']))?$member['CMP_EMAIL']:''); ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td><?php echo COMPANY ?> Role</td>
                    <td><input class="base-input"  type="text" name="cmp_role" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['cmp_role'] : ((isset($member['CMP_ROLE']))?$member['CMP_ROLE']:''); ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td>Contact 1<font color="red">*</font></td>
                    <td><input class="base-input"  type="text" name="contact_1" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['contact_1'] : ((isset($member['CONTACT_1']))?$member['CONTACT_1']:''); ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td>Contact 2</td>
                    <td><input class="base-input"  type="text" name="contact_2" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['contact_2'] : ((isset($member['CONTACT_2']))?$member['CONTACT_2']:''); ?>"/></td>
                    <td><span class="error_tooltip"></span></td>
                </tr>
                <tr>
                    <td>Location</td>
                    <td><input class="base-input"  type="text"  name="location" value="<?php echo (isset($_OLD_STATE)) ? $_OLD_STATE['location'] : ((isset($member['LOCATION']))?$member['LOCATION']:''); ?>"/></td>
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
                    <td><input type="submit" value="Update" class="checkout-btn" style="margin:0px;float:none;"/></td>
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