$(document).ready(function () {
    Logs.loadData();
});


const Logs = (() => {
    const thisLogs = {};

    thisLogs.loadData = () => {
        $.ajax({
            type: "GET",
            url: ACTIONLOG_CONTROLLER + '?action=getTableData',
            dataType: "json",
            success: function (response) {
                $('.table').DataTable().destroy();
                $('#tbl_data').html(response);

                $('.table').DataTable();
            },
            error: function () {

            }
        });
    }

    return thisLogs;
})();