<?php
$html->includeCss('team');
$html->setTitle('Add New Team');
$html->setHeadLink("View Shift Structure","shifts/view/".$_SESSION['TEAM_ID']);
?>
<div class="panel">
    <h2 class="panel-head">Add Shift</h2>
    <div class="panel-body">
        <form method="post" action="<?php echo WEBROOT ?>shifts/add?attempt=1">
            <table class="team_form">
                <tr>
                    <td>Start Time</td>
                    <td>
                        <select class="base-input" name="start_time">
                            <option value="1">1 AM</option>
                            <option value="2">2 AM</option>
                            <option value="3">3 AM</option>
                            <option value="4">4 AM</option>
                            <option value="5">5 AM</option>
                            <option value="6">6 AM</option>
                            <option value="7">7 AM</option>
                            <option value="8">8 AM</option>
                            <option value="9">9 AM</option>
                            <option value="10">10 AM</option>
                            <option value="11">11 AM</option>
                            <option value="12">12 PM</option>
                            <option value="13">1 PM</option>
                            <option value="14">2 PM</option>
                            <option value="15">3 PM</option>
                            <option value="16">4 PM</option>
                            <option value="17">5 PM</option>
                            <option value="18">6 PM</option>
                            <option value="19">7 PM</option>
                            <option value="20">8 PM</option>
                            <option value="21">9 PM</option>
                            <option value="22">10 PM</option>
                            <option value="23">11 PM</option>
                            <option value="24">12 AM</option>
                        </select>
                    </td>
                    <td><span class="error_tooltip">Invalid format.</span></td>
                </tr>
                <tr>
                    <td>End Time</td>
                    <td>
                        
                        <select class="base-input" name="end_time">
                            <option value="1">1 AM</option>
                            <option value="2">2 AM</option>
                            <option value="3">3 AM</option>
                            <option value="4">4 AM</option>
                            <option value="5">5 AM</option>
                            <option value="6">6 AM</option>
                            <option value="7">7 AM</option>
                            <option value="8">8 AM</option>
                            <option value="9">9 AM</option>
                            <option value="10">10 AM</option>
                            <option value="11">11 AM</option>
                            <option value="12">12 PM</option>
                            <option value="13">1 PM</option>
                            <option value="14">2 PM</option>
                            <option value="15">3 PM</option>
                            <option value="16">4 PM</option>
                            <option value="17">5 PM</option>
                            <option value="18">6 PM</option>
                            <option value="19">7 PM</option>
                            <option value="20">8 PM</option>
                            <option value="21">9 PM</option>
                            <option value="22">10 PM</option>
                            <option value="23">11 PM</option>
                            <option value="24">12 AM</option>
                        </select>
                    </td>
                    <td><span class="error_tooltip">Invalid format.</span></td>
                </tr>
                <tr>
                    <td>Shift Type</td>
                    <td>                       
                        <select class="base-input" name="shift_type">
                            <option value="general">General</option>
                            <option value="oncall">OnCall</option>
                        </select>
                    </td>
                    <td><span class="error_tooltip">Invalid format.</span></td>
                </tr>
                <tr>
                    <td>Day Type</td>                   
                    <td>                       
                        <select class="base-input" name="shift_days">
                            <option value="both">Both</option>
                            <option value="weekday">Weekdays</option>
                            <option value="weekend">Weekend</option>
                        </select>
                    </td>
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






