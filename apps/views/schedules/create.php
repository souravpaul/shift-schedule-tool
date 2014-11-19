<?php
$html->includeCss('calender');
$html->includeJS('schedule');
$html->setTitle('Create Schedule');
$html->setHeadLink("Calender", "schedules/calender");
$html->setHeadLink("Check Schedule", "schedules/view/" . $_SESSION['TEAM_ID']);
$html->setHeadLink("Clear Schedule", "schedules/clear");
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
            <h2>Create <?php echo ' ' . ((isset($current_team_name)) ? $current_team_name : '') . ' Team'; ?>Schedule</h2>
        </div>
        <div class="fc-clear"></div>
    </div>
    <?php
    $member_list_html = "";
    foreach ($member_list as $member) {
        $member_list_html.= '<li><a href="#" data-member=\'' . json_encode($member) . '\' data-id="'. $member['MEM_ID'].'">' . $member['FIRST_NAME'] . ' ' . $member['LAST_NAME'] . '</a></li>';
    }
    ?>
    <form method="post" action="<?php echo WEBROOT ?>schedules/add" id="schedule_create_form">
        <div class="fc-view-container" style="">
            <?php
            for ($shift_i = 0; $shift_i < sizeof($formats); $shift_i++) {
                ?>
                <table>
                    <thead>
                        <tr>
                            <td class="fc-widget-header"><div
                                    class="fc-row fc-widget-header">
                                    <table class="sc-names">
                                        <thead>
                                            <tr>
                                                <th class="fc-day-header">Shift</th>
                                                <?php
                                                foreach ($formats[$shift_i] as $struct) {

                                                    echo '<th class="fc-day-header">'
                                                    . $struct['start']
                                                    . '- '
                                                    . $struct['end']
                                                    . '</th>';
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
                                        $date_count=0;
                                        foreach ($schedule_list[$shift_i] as $key => $value) {
                                            $date_count++;
                                            ?>
                                            <div class="fc-row" style="border-bottom: solid 1px gray;">
                                                <div class="fc-bg">
                                                    <table class="sc-names">
                                                        <tbody>
                                                            <tr>
                                                                <?php
                                                                $shift_id_list = array();
                                                                 echo '<td class="fc-day "></td>';
                                                                for ($i = 0; $i < sizeof($formats[$shift_i]); $i++) {
                                                                    echo '<td class="fc-day "></td>';
                                                                    array_push($shift_id_list, $formats[$shift_i][$i]['id']);
                                                                }
                                                                ?>
                                                      <!--      <td cla-->

                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="fc-content-skeleton">
                                                    <table class="sc-names">
                                                        <tbody>
                                                            <?php
                                                            for ($mem = 1; $mem <= $value['max_mem']; $mem++) {
                                                                ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php
                                                                        switch ($mem) {
                                                                            case floor($value['max_mem'] / 2 ): echo date('d', strtotime($key));
                                                                                break;
                                                                            case floor($value['max_mem'] / 2 + 1) : echo date('M', strtotime($key));
                                                                                break;
                                                                            case 1: echo date('d,M', strtotime($key));
                                                                                break;
                                                                            default: echo '';
                                                                        }
                                                                        ?>
                                                                    </td>

                                                                    <?php
                                                                    $xcount = $mem % 2;$count=0;
                                                                    foreach ($value['shift'] as $items) {
                                                                        if ($items['RANK'] == $mem) {
                                                                            $shift_pos = array_search($items['SHIFT_ID'], $shift_id_list);
                                                                            if ($count != $shift_pos) {
                                                                               //  echo '<br/>' . $mem . '   ' . $shift_pos . ' >< ' . $count;
                                                                                for ($temp_count = $count; $temp_count < $shift_pos; $temp_count++) {
                                                                                    echo '<td><a href="#" class="samp' . ($xcount % 2) . '"> NA </a></td>';

                                                                                    $xcount++;
                                                                                     $count++;
                                                                                }
                                                                            }
                                                                            ?>
                                                                            <td>
                                                                                <div class="container samp<?php echo ($xcount % 2); ?>">
                                                                                    <ul>
                                                                                        <li class="dropdown ">
                                                                                            <a href="#" data-toggle="dropdown" class="data-select">
                                                                                                <?php
                                                                                                $temp_date = date('d-m-Y', strtotime($key));
                                                                                                echo (($items['FIRST_NAME']) ? $items['FIRST_NAME'] : '----')
                                                                                                . ' '
                                                                                                . (($items['LAST_NAME']) ? $items['LAST_NAME'] : '-')
                                                                                                ?>
                                                                                                <i class="icon-arrow"></i>
                                                                                            </a>
                                                                                            <ul class="dropdown-menu" data-row="<?php echo ($date_count+1);  ?>" data-id="<?php echo ($mem%($value['max_mem']+1)).$count; ?>">
                    <?php echo $member_list_html; ?>
                                                                                            </ul>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                                <input type="hidden" class="shift_input" 
                                                                                       name="schedule['<?php echo date('d-m-Y', strtotime($key)); ?>']['<?php echo $items['STRUCT_ID']; ?>']['<?php echo $mem; ?>']" 
                                                                                       value="<?php echo (($items['MEM_ID']) ? $items['MEM_ID'] : '0') ?>" />
                                                                            </td>
                                                                            <?php
                                                                            $xcount++;
                                                                            $count++;
                                                                        }
                                                                    }

                                                                    for ($inc = $xcount; $inc < sizeof($formats[$shift_i]) + ($mem % 2); $inc++) {
                                                                        echo '<td><a href="#" class="samp' . ($xcount % 2) . '"> NA </a></td>';
                                                                        $xcount++;
                                                                    }
                                                                    ?>



                                                                </tr>

                                                                <?php
                                                            }
                                                            ?>
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

                </table><br/><br/>
                <?php
            }
            ?>
        </div>
    </form>
</div>
