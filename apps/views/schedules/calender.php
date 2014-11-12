<?php
$html->includeCss('calender');
$html->includeJS('schedule');
$html->includeJS('calender');
$html->setTitle('Daily Calender');
$html->setHeadLink("Calender","schedules/calender");
?>
<div id="calendar" class="fc fc-ltr fc-unthemed sf-calendar"
     style="width: 90%;">
    <div class="fc-toolbar">
        <div class="fc-left">
            <div class="fc-button-group">
                <button type="button"
                        class="fc-prev-button fc-button fc-state-default fc-corner-left"  id="prev_month">
                    <span class="fc-icon fc-icon-left-single-arrow"></span>
                </button>
                <button type="button"
                        class="fc-next-button fc-button fc-state-default fc-corner-right" id="today">Today
                </button>
                <button type="button"
                        class="fc-next-button fc-button fc-state-default fc-corner-right" id="next_month">
                    <span class="fc-icon fc-icon-right-single-arrow"></span>
                </button>
            </div>
        </div>
        <div class="fc-right">
            <div class="fc-button-group">
                <button type="button"
                        class="fc-month-button fc-button fc-state-default fc-corner-left" id="clear-selection">Clear</button>

                <a
                    href="#" onclick="$('#calender_datepick').submit();return false;"
                    class="fc-agendaDay-button fc-button fc-state-default fc-corner-right">Go</a>
            </div>
        </div>
        <div class="fc-center">
            <select style="font-size:18px;margin:0px;padding:4px 13px;margin-right:8px;" id="select-month">
                <option value="1" >January</option>
                <option value="2" >February</option>
                <option value="3" >March</option>
                <option value="4" >April</option>
                <option value="5">May</option>
                <option value="6" >June</option>
                <option value="7" >July</option>
                <option value="8" >August</option>
                <option value="9" >September</option>
                <option value="10" >October</option>
                <option value="11" >November</option>
                <option value="12" >December</option>
            </select>
            <select style="font-size:18px;margin:0px;padding:4px 10px;"  id="select-year">
                <?php
                for ($i = 2010; $i <= 2030; $i++) {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="fc-clear"></div>
    </div>
    <form name="calender_datepick" id="calender_datepick" method="post" action="<?php echo WEBROOT; ?>schedules/view/<?php echo (isset($_SESSION['TEAM_ID']))?$_SESSION['TEAM_ID']:$team_list[0]['TEAM_ID'] ?>">
        <div class="fc-view-container" style="display:none;">
            <div class="fc-view fc-month-view fc-basic-view">
                <table>
                    <thead>
                        <tr>
                            <td class="fc-widget-header"><div
                                    class="fc-row fc-widget-header">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="fc-day-header fc-widget-header">Mon</th>
                                                <th class="fc-day-header fc-widget-header">Tue</th>
                                                <th class="fc-day-header fc-widget-header">Wed</th>
                                                <th class="fc-day-header fc-widget-header">Thu</th>
                                                <th class="fc-day-header fc-widget-header">Fri</th>
                                                <th class="fc-day-header fc-widget-header">Sat</th>
                                                <th class="fc-day-header fc-widget-header">Sun</th>
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
                                    <div class="fc-day-grid" style="background: white;">
                                        <div class="fc-row fc-week fc-widget-content fc-rigid">
                                            <div class="fc-bg">
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                        <div class="fc-row fc-week fc-widget-content fc-rigid">
                                            <div class="fc-bg">
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                        <div class="fc-row fc-week fc-widget-content fc-rigid">
                                            <div class="fc-bg">
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                        <div class="fc-row fc-week fc-widget-content fc-rigid">
                                            <div class="fc-bg">
                                                <table>
                                                    <tbody>

                                                        <tr>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                        <div class="fc-row fc-week fc-widget-content fc-rigid">
                                            <div class="fc-bg">
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                            <td class="fc-day fc-day-number"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>




