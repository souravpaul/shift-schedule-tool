<?php
$html->includeCss('calender');
$html->includeJS('schedule');
$html->includeJS('calender');
$html->setTitle('Team Schedule');
$html->setHeadLink("Calender", "schedules/calender");
$html->setHeadLink("Edit Schedule", "schedules/create");
$html->setHeadLink("Clear Schedule", "schedules/clear");
?>

<div id="calendar" class="fc fc-ltr fc-unthemed">
    <div class="fc-toolbar">
        <div class="fc-left">
            <div class="fc-button-group">
            </div>

        </div>
        <div class="fc-right">
            <div class="fc-button-group">
                <?php
                foreach ($team_list as $team) {
                    echo '<a href="' . WEBROOT . "schedules/view/" . $team['TEAM_ID'] . '" '
                    . 'class="fc-agendaWeek-button fc-push-button fc-button fc-state-default';

                    if ($team['TEAM_ID'] == $current_team) {
                        echo ' fc-state-active ';
                    }

                    echo '" title="' . $team['FULL_NAME'] . '">' . $team['SHORT_NAME'] . '</a>';
                }
                ?>
            </div>
        </div>
        <div class="fc-center">
            <h2><?php echo $current_team_name . ' '; ?>Team Schedule</h2>
        </div>
        <div class="fc-clear"></div>
    </div>
    <div class="fc-view-container" style="">
        <div class="fc-view fc-month-view fc-basic-view">
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
                                        foreach ($schedule_list[$shift_i] as $key => $value) {
                                            ?>
                                            <div class="fc-row" style="border-bottom: solid 1px gray;">
                                                <div class="fc-bg">
                                                    <table class="sc-names">
                                                        <tbody>

                                                            <?php
                                                            for ($mem = 1; $mem <= $value['max_mem']; $mem++) {
                                                                ?>
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
                                                                <?php
                                                            }
                                                            ?>
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
                                                                    $xcount = $mem % 2;
                                                                    $count = 0;
                                                                    foreach ($value['shift'] as $items) {
                                                                        $temp_date = date('d-m-Y', strtotime($key));
                                                                        if ($items['RANK'] == $mem) {
                                                                            $shift_pos = array_search($items['SHIFT_ID'], $shift_id_list);
                                                                            if ($count != $shift_pos) {
                                                                                // echo '<br/>' . $mem . '   ' . $shift_pos . ' >< ' . $count;
                                                                                for ($temp_count = $count; $temp_count < $shift_pos; $temp_count++) {
                                                                                    echo '<td><a href="#" class="samp' . ($xcount % 2) . '"> NA </a></td>';
                                                                                     $count++;
                                                                                    $xcount++;
                                                                                }
                                                                            }
                                                                            echo '<td><a href="#" class="samp' . ($xcount % 2) . '">'
                                                                            . (($items['FIRST_NAME']) ? $items['FIRST_NAME'] : '-')
                                                                            . ' '
                                                                            . (($items['LAST_NAME']) ? $items['LAST_NAME'] : '-')
                                                                            . '</a></td>';
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
    </div>
</div>
