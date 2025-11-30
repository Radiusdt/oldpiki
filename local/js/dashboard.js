let inputStartDate = moment()
let inputEndDate = moment()

$(function() {
    let input = $('.custom_time');
    let options = {
        startDate: inputStartDate,
        endDate: inputEndDate,
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear',
            format: 'YYYY-MM-DD'
        },
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }

    input.daterangepicker(options);

    $(input).on('click', function() {
        return false;
    });

    $(input).on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        document.location.href = '/dashboard/index/?type=custom&dates=' + $(this).val();
    });

    $(input).on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        document.location.href = '/dashboard/index/?type=custom&dates=' + $(this).val();
    });


    let chartInput = $('.chart-custom');

    chartInput.daterangepicker(options);

    $(chartInput).on('click', function() {
        return false;
    });

    $(chartInput).on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        document.location.href = '/dashboard/index/?chart-type=custom&dates=' + $(this).val();
    });

    $(chartInput).on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        document.location.href = '/dashboard/index/?chart-type=custom&dates=' + $(this).val();
    });
});