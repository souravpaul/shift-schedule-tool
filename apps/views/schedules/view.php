<?php
$html->includeCss('calender');
$html->includeJS('schedule');
$html->includeJS('calender');
$html->setTitle('Team Schedule');
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
            <a href="<?php echo WEBROOT; ?>schedules/create"
               class="fc-today-button fc-button fc-state-default fc-corner-left fc-corner-right ">Edit</a>
            <a href="<?php echo WEBROOT; ?>schedules/calender"
               class="fc-today-button fc-button fc-state-default fc-corner-left fc-corner-right ">Calender</a>
        </div>
        <div class="fc-right">
            <div class="fc-button-group">
                <?php
                    foreach ($team_list as $team) {
                        echo '<a href="'.WEBROOT."schedules/view/".$team['TEAM_ID'].'" '
                                . 'class="fc-agendaWeek-button fc-push-button fc-button fc-state-default';
                        
                        if($team['TEAM_ID']==$current_team){
                            echo ' fc-state-active ';
                        }
                        
                        echo      '">' . $team['NAME'] . '</a>';
                    }
                ?>
              <!--  <button type="button"
                        class="fc-month-button fc-push-button fc-button fc-state-default fc-corner-left fc-state-active">Team
                    1</button>
                <button type="button"
                        class="fc-agendaWeek-button fc-push-button fc-button fc-state-default">Team
                    1</button>
                <button type="button"
                        class="fc-agendaWeek-button fc-push-button fc-button fc-state-default">Team
                    1</button>
                <button type="button"
                        class="fc-agendaWeek-button fc-push-button fc-button fc-state-default">Team
                    1</button>
                <button type="button"
                        class="fc-agendaWeek-button fc-push-button fc-button fc-state-default">Team
                    1</button>
                <button type="button"
                        class="fc-agendaWeek-button fc-push-button fc-button fc-state-default">Team
                    1</button>
                <button type="button"
                        class="fc-agendaWeek-button fc-button fc-state-default fc-push-button">Team
                    1</button>
                <button type="button"
                        class="fc-agendaWeek-button fc-button fc-state-default fc-push-button">Team
                    1</button>-->
            </div>
        </div>
        <div class="fc-center">
            <h2><?php echo $current_team_name.' '; ?>Team Schedule</h2>
        </div>
        <div class="fc-clear"></div>
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
                                            <th class="fc-day-header">Week Days</th>
                                        <?php
                                            $weekday_shift_list=array();
                                            foreach ($shift_list as $shift) {
                                                if(strtoupper($shift['SHIFT_DAYS'])!='WEEKEND'){
                                                    array_push($weekday_shift_list,$shift);
                                                    echo '<th class="fc-day-header">'
                                                            . date('g A',($shift['START_TIME']))
                                                            . '- '.$shift['SHIFT_DAYS']
                                                            . date('g A',($shift['END_TIME']))
                                                            . '</th>';
                                                }
                                            }
                                        ?>
                                   <!--         <th class="fc-day-header">6 AM - 3 PM</th>
                                            <th class="fc-day-header">10 AM - 7 PM</th>
                                            <th class="fc-day-header">2 PM - 10 PM</th>
                                            <th class="fc-day-header">8 PM - 5 AM</th>
                                            <th class="fc-day-header">10 PM - 7 AM</th>
                                            <th class="fc-day-header">10 PM - 7 AM</th>
                                            <th class="fc-day-header">10 PM - 7 AM</th>-->
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
                                                            for($i=0;$i<=sizeof($weekday_shift_list);$i++){
                                                                echo '<td class="fc-day "></td>';
                                                            }
                                                        ?>
                                                    <!--        <td class="fc-day "></td>
                                                            <td class="fc-day "></td>
                                                            <td class="fc-day "></td>
                                                            <td class="fc-day "></td>
                                                            <td class="fc-day "></td>
                                                            <td class="fc-day "></td>
                                                            <td class="fc-day "></td>-->
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
                                                        $xcount=0;//print_r($schedule_list);
                                                            foreach($weekday_shift_list as $shift){
                                                                $temp_date=date('d-m-Y', strtotime($date));
                                                                echo '<td><a href="#" class="samp'.($xcount%2).'">'
                                                                        .((isset($schedule_list["'".$temp_date."'"][$shift['STRUCT_ID']][1]))?$schedule_list["'".$temp_date."'"][$shift['STRUCT_ID']][1]['FIRST_NAME']:'-')
                                                                        .' '
                                                                        .((isset($schedule_list["'".$temp_date."'"][$shift['STRUCT_ID']][1]))?$schedule_list["'".$temp_date."'"][$shift['STRUCT_ID']][1]['LAST_NAME']:'')
                                                                      .'</a></td>';
                                                                $xcount++;
                                                            }
                                                        ?>
                                         <!--                   <td><a href="#" class="samp1">Sourav Paul</a></td>
                                                            <td><a href="#" class="samp2">Sourav Paul</a></td>
                                                            <td><a href="#" class="samp1">Sourav Paul</a></td>
                                                            <td><a href="#" class="samp2">Sourav Paul</a></td>
                                                            <td><a href="#" class="samp1">Sourav Paul</a></td>
                                                            <td><a href="#" class="samp2">Sourav Paul</a></td>-->
                                                        </tr>
                                                        <tr>
                                                            <td><?php echo date('M, o', strtotime($date)); ?></td>
                                                        <?php
                                                            $xcount=1;
                                                             foreach($weekday_shift_list as $shift){
                                                                $temp_date=date('d-m-Y', strtotime($date));
                                                                echo '<td><a href="#" class="samp'.($xcount%2).'">'
                                                                        .((isset($schedule_list["'".$temp_date."'"][$shift['STRUCT_ID']][2]))?$schedule_list["'".$temp_date."'"][$shift['STRUCT_ID']][2]['FIRST_NAME']:'-')
                                                                        .' '
                                                                        .((isset($schedule_list["'".$temp_date."'"][$shift['STRUCT_ID']][2]))?$schedule_list["'".$temp_date."'"][$shift['STRUCT_ID']][2]['LAST_NAME']:'')
                                                                      .'</a></td>';
                                                                $xcount++;
                                                            }
                                                        ?>
                                         <!--                    <td><a href="#" class="samp2">Neeraj Mishra</a></td>
                                                            <td><a href="#" class="samp1">Neeraj Mishra</a></td>
                                                            <td><a href="#" class="samp2">Neeraj Mishra</a></td>
                                                            <td><a href="#" class="samp1">Neeraj Mishra</a></td>
                                                            <td><a href="#" class="samp2">Neeraj Mishra</a></td>
                                                            <td><a href="#" class="samp1">Neeraj Mishra</a></td>-->
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
                                            $weekend_shift_list=array();
                                            foreach ($shift_list as $shift) {
                                                if(strtoupper($shift['SHIFT_DAYS'])!='WEEKDAY'){
                                                    array_push($weekend_shift_list, $shift);
                                                    echo '<th class="fc-day-header">'
                                                            . date('g A',($shift['START_TIME']))
                                                            . '- '
                                                            . date('g A',($shift['END_TIME']))
                                                            . '</th>';
                                                }
                                            }
                                        ?>
                                     <!--       <th class="fc-day-header">6 AM - 3 PM</th>
                                            <th class="fc-day-header">10 AM - 7 PM</th>-->
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
                                    foreach ($weekend_dates as $date) {
                                        ?>
                                    
                                    
                                    <div class="fc-row" style="border-bottom: solid 1px gray;">
                                        <div class="fc-bg">
                                            <table class="sc-names">
                                                <tbody>
                                                    <tr>
                                                        <?php
                                                            for($i=0;$i<=sizeof($weekend_shift_list);$i++){
                                                                echo '<td class="fc-day "></td>';
                                                            }
                                                        ?>
                                                  <!--      <td class="fc-day "></td>
                                                        <td class="fc-day "></td>-->
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
                                                        $xcount=0;
                                                            foreach($weekend_shift_list as $shift){
                                                                $temp_date=date('d-m-Y', strtotime($date));
                                                                echo '<td><a href="#" class="samp'.($xcount%2).'">'
                                                                        .((isset($schedule_list["'".$temp_date."'"][$shift['STRUCT_ID']][1]))?$schedule_list["'".$temp_date."'"][$shift['STRUCT_ID']][1]['FIRST_NAME']:'-')
                                                                        .' '
                                                                        .((isset($schedule_list["'".$temp_date."'"][$shift['STRUCT_ID']][1]))?$schedule_list["'".$temp_date."'"][$shift['STRUCT_ID']][1]['LAST_NAME']:'')
                                                                      .'</a></td>';
                                                                $xcount++;
                                                            }
                                                        ?>
                                                    <!--    <td><a href="#" class="samp1">Sourav Paul</a></td>
                                                        <td><a href="#" class="samp2">Sourav Paul</a></td>-->
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo date('M, o', strtotime($date)); ?></td>
                                                        <?php
                                                            $xcount=1;
                                                             foreach($weekend_shift_list as $shift){
                                                                $temp_date=date('d-m-Y', strtotime($date));
                                                                echo '<td><a href="#" class="samp'.($xcount%2).'">'
                                                                        .((isset($schedule_list["'".$temp_date."'"][$shift['STRUCT_ID']][2]))?$schedule_list["'".$temp_date."'"][$shift['STRUCT_ID']][2]['FIRST_NAME']:'-')
                                                                        .' '
                                                                        .((isset($schedule_list["'".$temp_date."'"][$shift['STRUCT_ID']][2]))?$schedule_list["'".$temp_date."'"][$shift['STRUCT_ID']][2]['LAST_NAME']:'')
                                                                      .'</a></td>';
                                                                $xcount++;
                                                            }
                                                        ?>
                                                <!--        <td><a href="#" class="samp2">Neeraj Mishra</a></td>
                                                        <td><a href="#" class="samp1">Neeraj Mishra</a></td>-->
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

                            </div>
