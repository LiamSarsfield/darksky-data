$(document).ready(function () {
    $('form').on('submit', function () {
        if (!$(this).validationEngine('validate')) {
            return false;
        }
    });
    $('.datepicker').datepicker({dateFormat: 'dd/M/yy'}).datepicker("setDate", new Date());
});
