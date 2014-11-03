/*var select_start=0;
 var select_end=0;*/

function checkDate() {
}

var calender = {
    today: null,
    current_date: 0,
    current_month: 0,
    current_year: 0,
    init: function () {
        this.today = new Date();
        /*
         * this.current_month=date.getMonth();
         * this.current_year=date.getFullYear();
         */

        this.generate();
        this.evt();
        //	$('.fc-view-container').css('visibility','visible');
        $('.fc-view-container').slideDown(1000);
    },
    evt: function () {
        var $this = this;
        $('#prev_month').click(function () {
            if ($this.current_month == 0)
                $this.generate(11, ($this.current_year - 1));
            else
                $this.generate(($this.current_month - 1));
        });

        $('#next_month').click(function () {
            if ($this.current_month == 11)
                $this.generate(0, ($this.current_year + 1));
            else
                $this.generate(($this.current_month + 1));
        });

        $('#today').click(function () {
            $this.generate($this.today.getMonth(), $this.today.getFullYear());
        });

        $('.fc-center #select-month').change(
                function () {
                    $this.generate(($(this).val() - 1), $(
                            '.fc-center #select-year').val());
                });

        $('.fc-center #select-year').change(
                function () {
                    $this.generate(($('.fc-center #select-month').val() - 1),
                            $(this).val());
                });
    },
    generate: function (month, year) {
        var date = new Date();
        $this = this;
        if (year == null) {
            if (this.current_year == 0)
                year = date.getFullYear();
            else
                year = this.current_year;
        }
        if (month == null) {
            month = date.getMonth();

        }
        this.current_date = date.getDate();
        this.current_month = month;
        this.current_year = year;

        var current_mon = new Date(year, month, 1);

        var month_end_date = this.getMonthDays(current_mon.getMonth());

        var prev_month = null;
        if (current_mon.getMonth() == 0)
            prev_month = new Date((date.getFullYear() - 1), 12, 1);
        else
            prev_month = new Date(date.getFullYear(), (date.getMonth()), 1);
        var prev_month_end_date = this.getMonthDays(prev_month.getMonth());

        var curent_day = (current_mon.getDay() == 0) ? 7 : current_mon.getDay();

        var prev_month_start_date = (prev_month_end_date - curent_day + 2);
        //alert(curent_day);

        var count = 1;
        $('.fc-center #select-month option').removeAttr('selected');
        $('.fc-center #select-year option').removeAttr('selected');

        $('.fc-center #select-year option[value="' + this.current_year + '"]')
                .attr('selected', 'selected');
        $(
                '.fc-center #select-month option[value="'
                + (this.current_month + 1) + '"]').attr('selected',
                'selected');

        $('.fc-day-grid .fc-day')
                .each(
                        function (i) {
                            $(this).css('background', '#fff');
                            $(this).removeClass('fc-other-month');
                            if (count > month_end_date) {
                                $(this)
                                        .html(
                                                (count%month_end_date)
                                                + ' ');
                                $(this).addClass('fc-other-month');
                                count ++;
                            } else if (i + 1 >= curent_day) {
                                $(this)
                                        .html(
                                                count
                                                + ' <input type="hidden" name="dates[]" value="" />');
                                $(this)
                                        .attr(
                                                'data-date',
                                                (count
                                                        + '-'
                                                        + (current_mon
                                                                .getMonth() + 1)
                                                        + '-'
                                                        + current_mon
                                                        .getFullYear() + ""));
                                var d = new Date();
                                if ($(this).attr('data-date') == d.getDate()
                                        + '-' + (d.getMonth() + 1) + '-'
                                        + d.getFullYear()) {
                                    $(this).css('background', '#80CC80');
                                    $(this).addClass('fc-today');
                                }
                                count++;
                            } else {
                                $(this)
                                        .html(
                                                prev_month_start_date
                                                + ' ');
                                prev_month_start_date++;
                                $(this).addClass('fc-other-month');
                            }
                        });

    },
    getMonthDays: function (month) {
        var month_end_date = 31;
        switch (month) {
            case 1:
                month_end_date = 28;
                break;
            case 3:
            case 5:
            case 7:
            case 10:
                month_end_date = 30;
        }
        return month_end_date;
    },
    getMonthName: function myFunction(month_key) {
        var month = new Array();
        month[0] = "January";
        month[1] = "February";
        month[2] = "March";
        month[3] = "April";
        month[4] = "May";
        month[5] = "June";
        month[6] = "July";
        month[7] = "August";
        month[8] = "September";
        month[9] = "October";
        month[10] = "November";
        month[11] = "December";

        return month[month_key];
    }
};

$(document).ready(
        function () {
            /*
             * $('.date_block').mousedown(function(e){ e.preventDefault();
             * if(e.which==3){ select_start=0; select_end=0; $('.date_block
             * input').prop('checked',false);
             * $('.date_block').removeClass('date_select'); return false; }
             * 
             * var item=$(this).find('input[type="checkbox"]');
             * //alert($(item).val()); if(select_start==0){
             * select_start=parseInt($(item).val()); select_end=0 } else
             * if(parseInt($(item).val())<select_start){ //alert(0);
             * temp=select_start; select_start=parseInt($(item).val());
             * select_end=temp; }else{ select_end=parseInt($(item).val()); }
             * //alert(select_start+" "+select_end); var
             * value=$(item).attr('checked'); if(!value || select_start<select_end){
             * if(select_start<select_end){ $('.date_block
             * input').prop('checked',false);
             * $('.date_block').removeClass('date_select'); } if(select_end>0){
             * for(i=select_start;i<=select_end;i++){
             * $(('#'+i)).prop('checked',true);
             * $(('#'+i)).parent().addClass('date_select'); } }else{
             * $(item).prop('checked',true); $(this).addClass('date_select'); }
             * 
             * }else{ $(item).prop('checked',false);
             * 
             * $(this).removeClass('date_select');
             *  } });
             */

            $('.fc-day').click(
                    function () {
                        if ($(this).find('input').val() == null
                                || $(this).find('input').val() == "") {
                            $(this).find('input')
                                    .val($(this).attr('data-date'));
                            $(this).css('background', '#B4D3F2');
                        } else {
                            $(this).find('input').val('');
                            $(this).css('background', '#fff');
                        }
                        // $(this).css('background','#FFD6AD');
                    });

            calender.init();

            $('#clear-selection').click(
                    function () {
                        $('.fc-day').find('input').val('');
                        $('.fc-day').not('.fc-today').css('background', '#fff');
                    });

        });