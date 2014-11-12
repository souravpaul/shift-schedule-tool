<?php
$html->includeCss('calender');
$html->includeJS('schedule');
$html->setTitle('Create Schedule');
?>

<div id="calendar" class="fc fc-ltr fc-unthemed">
    <div class="fc-toolbar">
        <div class="fc-left">
            <div class="fc-button-group">
                <!-- <button type="button"
                        class="fc-prev-button fc-button fc-state-default fc-corner-left">
                        <span class="fc-icon fc-icon-left-single-arrow"></span>
                </button>
                <button type="button"
                        class="fc-next-button fc-button fc-state-default fc-corner-right">
                        Week</button>
                <button type="button"
                        class="fc-next-button fc-button fc-state-default fc-corner-right">
                        <span class="fc-icon fc-icon-right-single-arrow"></span>
                </button> -->
            </div>
            <a href="<?php echo WEBROOT; ?>schedules/view/<?php echo $_SESSION['TEAM_ID'] ?>"
               class="fc-today-button fc-button fc-state-default fc-corner-left fc-corner-right ">Back</a>
            <a href="<?php echo WEBROOT; ?>schedules/add"
               class="fc-today-button fc-button fc-state-default fc-corner-left fc-corner-right "
               onclick="$('#schedule_create_form').submit();
                       return false;">Save</a>
            <a href="<?php echo WEBROOT; ?>schedules/calender"
               class="fc-today-button fc-button fc-state-default fc-corner-left fc-corner-right ">Cancel</a>
        </div>
        <div class="fc-right">
            <div class="fc-button-group">
                <button type="button"
                        class="fc-month-button fc-button fc-state-default fc-corner-left fc-state-active fc-push-button">On</button>
                <button type="button"
                        class="fc-agendaWeek-button fc-button fc-state-default fc-push-button">Off</button>
            </div>
        </div>
        <div class="fc-center">
            <h2>Create <?php // echo ' '.$current_team_name.' Team'; ?>Schedule</h2>
        </div>
        <div class="fc-clear"></div>
    </div>
    <?php
    $member_list_html = "";
    foreach ($member_list as $member) {
        $member_list_html.= '<li><a href="#" data-member=\'' . json_encode($member) . '\'>' . $member['FIRST_NAME'] . ' ' . $member['FIRST_NAME'] . '</a></li>';
    }
    ?>
    <form method="post" action="<?php echo WEBROOT ?>schedules/add" id="schedule_create_form">
        <div class="fc-view-container" style="">
            <div class="fc-view fc-month-view fc-basic-view">
                <table>
                    <thead>
                        <tr>
                            <td class="fc-widget-header"><div
                                    class="fc-row fc-widget-header">
                                    <table class="sc-names">
                                        <thead>
                                            <tr>
                                                <th class="fc-day-header">Week Days</th>
                                                <?php
                                                $weekday_shift_list = array();
                                                foreach ($shift_list as $shift) {
                                                    if (strtoupper($shift['SHIFT_DAYS']) != 'WEEKEND') {
                                                        array_push($weekday_shift_list, $shift);
                                                        echo '<th class="fc-day-header">'
                                                        . date('g A', ($shift['START_TIME']))
                                                        . '- '
                                                        . date('g A', ($shift['END_TIME']))
                                                        . '</th>';
                                                    }
                                                }
                                                ?>
                                            </tr>
                                        </thead>
                                    </table>
                                </div></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fc-widget-content"><div
                                    class="fc-day-grid-container">
                                    <div class="fc-day-grid">

                                        <?php
                                        foreach ($weekday_dates as $date) {
                                            ?>
                                            <div class="fc-row" style="border-bottom: solid 1px gray;">
                                                <div class="fc-bg">
                                                    <table class="sc-names">
                                                        <tbody>
                                                            <tr>
                                                                <?php
                                                                for ($i = 0; $i <= sizeof($weekday_shift_list); $i++) {
                                                                    echo '<td class="fc-day "></td>';
                                                                }
                                                                ?>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="fc-content-skeleton">

                                                    <table class="sc-names">
                                                        <tbody>
                                                            <tr>
                                                                <td><?php echo date('d', strtotime($date)); ?></td>

                                                                <?php
                                                                $xcount = 0;
                                                                foreach ($weekday_shift_list as $shift) {
                                                                    ?>
                                                                    <td>
                                                                        <div class="container samp<?php echo ($xcount % 2); ?>">
                                                                            <ul>
                                                                                <li class="dropdown ">
                                                                                    <a href="#" data-toggle="dropdown" class="data-select">
                                                                                        <?php
                                                                                        $temp_date=date('d-m-Y', strtotime($date));
                                                                                        echo ((isset($schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][1])) ? $schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][1]['FIRST_NAME'] : '-------------------------------')
                                                                                        . ' '
                                                                                        . ((isset($schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][1])) ? $schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][1]['LAST_NAME'] : '');
                                                                                        
                                                                                        ?>
                                                                                        <i class="icon-arrow"></i>
                                                                                    </a>
                                                                                    <ul class="dropdown-menu">
                                                                                        <?php echo $member_list_html; ?>
                                                                                    </ul>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <input type="hidden" class="shift_input" 
                                                                               name="schedule['<?php echo date('d-m-Y', strtotime($date)); ?>']['<?php echo $shift['STRUCT_ID']; ?>']['1']" 
                                                                               value="<?php echo ((isset($schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][1])) ? $schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][1]['MEMBER_ID'] : '') ?>" />
                                                                    </td>
                                                                    <?php
                                                                    $xcount++;
                                                                }
                                                                ?>
                                                            </tr>
                                                            <tr>
                                                                <td><?php echo date('M, o', strtotime($date)); ?></td>
                                                                <?php
                                                                foreach ($weekday_shift_list as $shift) {
                                                                    ?>
                                                                    <td>
                                                                        <div class="container samp<?php echo ($xcount % 2); ?>">
                                                                            <ul>
                                                                                <li class="dropdown ">
                                                                                    <a href="#" data-toggle="dropdown" class="data-select">
                                                                                        <?php
                                                                                        $temp_date=date('d-m-Y', strtotime($date));
                                                                                        echo ((isset($schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][2])) ? $schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][2]['FIRST_NAME'] : '-------------------------------')
                                                                                        . ' '
                                                                                        . ((isset($schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][2])) ? $schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][2]['LAST_NAME'] : '');
                                                                                        
                                                                                        ?>
                                                                                        <i class="icon-arrow"></i>
                                                                                    </a>
                                                                                    <ul class="dropdown-menu">
                                                                                        <?php echo $member_list_html; ?>
                                                                                    </ul>
                                                                                </li>
                                                                            </ul>
                                                                        </div> 
                                                                        <input type="hidden" class="shift_input" 
                                                                               name="schedule['<?php echo date('d-m-Y', strtotime($date)); ?>']['<?php echo $shift['STRUCT_ID']; ?>']['2']" 
                                                                               value="<?php echo ((isset($schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][2])) ? $schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][2]['MEMBER_ID'] : '') ?>" />
       
                                                                    </td>
                                                                    <?php
                                                                    $xcount++;
                                                                }
                                                                ?>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                    </div>
                                </div></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="fc-view-container" style="">
            <div class="fc-view fc-month-view fc-basic-view">
                <table>
                    <thead>
                        <tr>
                            <td class="fc-widget-header"><div
                                    class="fc-row fc-widget-header">
                                    <table class="sc-names">
                                        <thead>
                                            <tr>
                                                <th class="fc-day-header">Weekend</th>

                                                <?php
                                                $weekend_shift_list = array();
                                                foreach ($shift_list as $shift) {
                                                    if (strtoupper($shift['SHIFT_DAYS']) != 'WEEKDAY') {
                                                        array_push($weekend_shift_list, $shift);
                                                        echo '<th class="fc-day-header">'
                                                        . date('g A', ($shift['START_TIME']))
                                                        . '- '
                                                        . date('g A', ($shift['END_TIME']))
                                                        . '</th>';
                                                    }
                                                }
                                                ?>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>     
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fc-widget-content"><div
                                    class="fc-day-grid-container">
                                    <div class="fc-day-grid">

                                        <?php
                                        foreach ($weekend_dates as $date) {
                                            ?>


                                            <div class="fc-row" style="border-bottom: solid 1px gray;">
                                                <div class="fc-bg">
                                                    <table class="sc-names">
                                                        <tbody>
                                                            <tr>
                                                                <?php
                                                                for ($i = 0; $i <= sizeof($weekend_shift_list); $i++) {
                                                                    echo '<td class="fc-day "></td>';
                                                                }
                                                                ?>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="fc-content-skeleton">

                                                    <table class="sc-names">
                                                        <tbody>
                                                            <tr>
                                                                <td><?php echo date('d', strtotime($date)); ?></td>
                                                                <?php
                                                                $xcount = 1;
                                                                foreach ($weekend_shift_list as $shift) {
                                                                    ?>
                                                                    <td>
                                                                        <div class="container samp<?php echo ($xcount % 2); ?>">
                                                                            <ul>
                                                                                <li class="dropdown ">
                                                                                    <a href="#" data-toggle="dropdown" class="data-select">
                                                                                        <?php
                                                                                        $temp_date=date('d-m-Y', strtotime($date));
                                                                                        echo ((isset($schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][1])) ? $schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][1]['FIRST_NAME'] : '-------------------------------')
                                                                                        . ' '
                                                                                        . ((isset($schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][1])) ? $schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][1]['LAST_NAME'] : '');
                                                                                        
                                                                                        ?>
                                                                                        <i class="icon-arrow"></i>
                                                                                    </a>
                                                                                    <ul class="dropdown-menu">
                                                                                        <?php echo $member_list_html; ?>
                                                                                    </ul>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <input type="hidden" class="shift_input" 
                                                                               name="schedule['<?php echo date('d-m-Y', strtotime($date)); ?>']['<?php echo $shift['STRUCT_ID']; ?>']['1']" 
                                                                               value="<?php echo ((isset($schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][1])) ? $schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][1]['MEMBER_ID'] : '') ?>" />
                                                                    </td>
                                                                    <?php
                                                                    $xcount++;
                                                                }
                                                                ?>
                                                            </tr>
                                                            <tr>
                                                                <td><?php echo date('M, o', strtotime($date)); ?></td>
                                                                <?php
                                                                foreach ($weekend_shift_list as $shift) {
                                                                    ?>
                                                                    <td>
                                                                        <div class="container samp<?php echo ($xcount % 2); ?>">
                                                                            <ul>
                                                                                <li class="dropdown ">
                                                                                    <a href="#" data-toggle="dropdown" class="data-select">
                                                                                        <?php
                                                                                        $temp_date=date('d-m-Y', strtotime($date));
                                                                                        echo ((isset($schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][2])) ? $schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][2]['FIRST_NAME'] : '-------------------------------')
                                                                                        . ' '
                                                                                        . ((isset($schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][2])) ? $schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][2]['LAST_NAME'] : '');
                                                                                        
                                                                                        ?>
                                                                                        <i class="icon-arrow"></i>
                                                                                    </a>
                                                                                    <ul class="dropdown-menu">
                                                                                        <?php echo $member_list_html; ?>
                                                                                    </ul>
                                                                                </li>
                                                                            </ul>
                                                                        </div> 
                                                                        <input type="hidden" class="shift_input" 
                                                                               name="schedule['<?php echo date('d-m-Y', strtotime($date)); ?>']['<?php echo $shift['STRUCT_ID']; ?>']['2']" 
                                                                               value="<?php echo ((isset($schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][2])) ? $schedule_list["'" . $temp_date . "'"][$shift['STRUCT_ID']][2]['MEMBER_ID'] : '') ?>" />
                                                                    </td>
                                                                    <?php
                                                                    $xcount++;
                                                                }
                                                                ?>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>


                                        </td>
                                        </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                                </form>
                                </div>
