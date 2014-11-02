<?php
if (!isset($loggedin)) {
    ?>
    <div id="container" >
        <div id="linkList">
            <h1><?php echo PROJECT; ?></h1>
            <p class="small-logo">Shift Schedule</p>
            <br />
            <p class="login_name">
                <b>WELCOME</b>
            </p>
            <div id="linkList2">
                <div id="lselect">
                    <ul>
                        <li><a href="<?php echo WEBROOT ?>account/login">Login</a></li>
                        <li><a href="<?php echo WEBROOT ?>members/viewall">Members</a></li>
                        <li><a href="<?php echo WEBROOT ?>shifts/view/">Shift Structure</a></li>
                        <li><a href="<?php echo WEBROOT ?>teams/viewall">Teams</a></li>
                        <li><a href="<?php echo WEBROOT ?>schedules/calender">Schedule</a></li>
                        <li><a href="<?php echo WEBROOT ?>teams/viewall">Teams</a></li>
                    </ul>
                </div>

            </div>
        </div>
        <?php
    } else {
        ?>
        <div id="container">
            <div id="linkList">
                <h1><?php echo PROJECT; ?></h1>
                <p class="small-logo">Shift Schedule</p>
                <br />
                <p class="login_name">
                    Hi, <b><?php echo $_SESSION['USER_NAME']; ?></b>
                </p>
                <div id="linkList2">
                    <div id="lselect">
                        <ul>
                            <li><a href="<?php echo WEBROOT ?>account/home">Home</a></li>
                            <li><a href="<?php echo WEBROOT ?>members/viewall">Members</a></li>
                            <li><a href="<?php echo WEBROOT ?>shifts/view/<?php echo $_SESSION['TEAM_ID']; ?>">Shift Structure</a></li>
                        <li><a href="<?php echo WEBROOT ?>teams/viewall">Teams</a></li>
                            <li><a href="<?php echo WEBROOT ?>schedules/calender">Schedule</a></li>
                            <li><a href="<?php echo WEBROOT ?>account/logout">Logout</a></li>
                        </ul>
                    </div>

                </div>
            </div>
            <?php
        }
        ?>
        <div class='topbar' >
        </div>

        <div class="body-hold">
            <?php
            if (isset($_STATUS) && !empty($_STATUS)) {
                ?>

                <div class="alert-message <?php echo $_STATUS['CLASS']; ?> "> 
                    <div class="box-icon"></div> 
                    <p><?php echo $_STATUS['MESSAGE']; ?><a href="" class="close">&times;</a> 
                </div>
                <?php
                if (isset($_STATUS['DATA']) && !empty($_STATUS['DATA'])) {

                    for ($i = 0; $i < sizeof($_STATUS['DATA']); $i++) {
                        $_STATUS['DATA'][$i]['message'] = str_replace("'", "&#8216;", $_STATUS['DATA'][$i]['message']);
                    }
                    echo"<script>var form_status='" . json_encode($_STATUS['DATA']) . "';</script>";
                }
            }
            ?>



