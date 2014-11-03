<?php
$html->includeCss('member');
$html->setTitle("Member List");
$html->includeJS('member');
?>


<div class="box_container">
    <div class="box_header">
        <a href="<?php echo WEBROOT ?>members/add" class="button">Add New Member</a>
        <h3>All Team Members</h3>
    </div>
    <div class="box_body">
        <div class="list">
            <input type="text" class="mem_search" placeholder="Find Members"/>
            <ul class="member_list">
                <?php
                foreach ($member_list as $member) {
                    echo "<li data-member=\"" . htmlspecialchars(json_encode($member), ENT_QUOTES) . "\">" . $member['FIRST_NAME'] . ' ' . $member['LAST_NAME'] . '</li>';
                }
                ?>
            </ul>
        </div>

        <div class="member_bio">
            <div class="block_title">
                <img src="<?php echo WEBROOT; ?>public/img/avatar.jpg"/>
                <div style="display:inline-block;vertical-align:top;">
                    <h3 id="vname">Sourav Paul</h3>
                    <b id="vteam">Unknown Team</b><b> Team</b><br/><br/>
                    <b id="vloc"></b>
                    <b style="color:blue;" id="vloc_type"></b>
                </div>
            </div>
            <table class="bio_table" cellspacing='0'>
                <tr>
                    <td><?php echo PROJECT; ?> Id</td>
                    <td id="vpj_id"></td>
                </tr>
                <tr>
                    <td><?php echo PROJECT; ?> Email</td>
                    <td id="vpj_email"></td>
                </tr>
                <tr>
                    <td><?php echo PROJECT; ?> Role</td>
                    <td id="vpj_role"></td>
                </tr>
                <tr>
                    <td>Contact No 1</td>
                    <td id="vcontact_1">9874788063</td>
                </tr>
                <tr>
                    <td>Contact No 2</td>
                    <td id="vcontact_2">123456987</td>
                </tr>
                <tr>
                    <td><?php echo COMPANY; ?> Employee Id</td>
                    <td id="vcmp_id">739947</td>
                </tr>
                <tr>
                    <td><?php echo COMPANY; ?> Email</td>
                    <td id="vcmp_email"></td>
                </tr>
                <tr>
                    <td><?php echo COMPANY; ?> Role</td>
                    <td id="vcmp_role"></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<ul class="team_box">
    <li><a href="<?php echo WEBROOT ?>members/viewall">All</a></li>
    <?php
    foreach ($team_list as $team) {
        echo "<li data-member=" . htmlspecialchars(json_encode($team), ENT_QUOTES) . ">"
                . "<a href='".WEBROOT."members/view/".$team['TEAM_ID']."'>" . $team['NAME'] . '</a>'
                . '</li>';
    }
    ?>
</ul>

