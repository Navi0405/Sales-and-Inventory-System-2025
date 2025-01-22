$(document).ready(function () {
    Alerts.loadTableDataExpiredStatus();
    Alerts.loadTableDataStockStatus();
    Alerts.designationValidation();

    // Set up the onclick events when the document is ready
    $('#exchange').click(function () {
        let designation = 'exchange';  // Replace with actual designation
        let expired_status = 1;    // Replace with actual expired_status
        Alerts.Exchange(designation, expired_status);
    });

    $('#return').click(function () {
        let designation = 'return';  // Replace with actual designation
        let expired_status = 2;    // Replace with actual expired_status
        Alerts.Return(designation, expired_status);
    });

    $('#decompose').click(function () {
        let designation = 'decompose';  // Replace with actual designation
        let expired_status = 3;    // Replace with actual expired_status
        Alerts.Decompose(designation, expired_status);
    });
    $('#designate').click(function () {
        chosen = false;
    });
});

let chosen = false;

const Alerts = (() => {
    const thisAlerts = {};

    thisAlerts.loadTableDataExpiredStatus = () => {
        $.ajax({
            type: "GET",
            url: ALERT_CONTROLLER + '?action=getTableDataExpirationStatus',
            dataType: "json",
            success: function (response) {
                // Check if the DataTable instance exists, then clear or destroy
                if ($.fn.DataTable.isDataTable('#table-expiration')) {
                    $('#table-expiration').DataTable().clear().destroy();
                }
    
                // Populate the table body with the new data
                $('#tbody_expiration_status').html(response);
    
                // Initialize DataTable with custom empty table message
                $('#table-expiration').DataTable({
                    language: {
                        emptyTable: "No issue on certain products"  // Custom message for empty data
                    }
                });
            },
            error: function () {

            }
        });
    }

    thisAlerts.loadTableDataStockStatus = () => {
        $.ajax({
            type: "GET",
            url: ALERT_CONTROLLER + '?action=getTableDataStockStatus',
            dataType: "json",
            success: function (response) {
                // Check if the DataTable instance exists, then clear or destroy
                if ($.fn.DataTable.isDataTable('#table-stocks')) {
                    $('#table-stocks').DataTable().clear().destroy();
                }
    
                // Populate the table body with the new data
                $('#tbody_stock_status').html(response);
    
                // Initialize DataTable with custom empty table message
                $('#table-stocks').DataTable({
                    language: {
                        emptyTable: "No issue on Stocks"  // Custom message for empty data
                    }
                });
            },
            error: function () {
                console.error("Error loading stock status data.");
            }
        });
    };
    

    thisAlerts.getExpiredId = (id) => {
        chosen = false;
        product_details_id = id;
        $.ajax({
            type: "POST",
            url: ALERT_CONTROLLER + '?action=getById',
            dataType: "json",
            data:{
                product_details_id: id,
            },            
            success: function (response) {
                thisAlerts.Exchange();
                thisAlerts.Return();
                thisAlerts.Decompose();
            },
            error: function () {
                
            },
        });        
    }

    thisAlerts.designationValidation = () => {
        if (chosen) {
            $('#submit_designation').fadeIn(); // Hide the button with animation
        }
        else {
            $('#submit_designation').fadeOut(); // Hide the button with animation
        }
    }

    thisAlerts.Exchange = (designation, expired_status) => {
        chosen = true;
        product_details_id = product_details_id;
        $('#submit_designation').fadeIn(); // Show the button with animation
        // Attach a one-time click event to the button
        if (valid) {
            $.ajax({
                type: "POST",
                url: ALERT_CONTROLLER + '?action=exchange',
                dataType: "json",
                data:{
                    product_details_id: product_details_id,
                    designation: designation,
                    expired_status: expired_status,
                },
                success: function (response) 
                {
                    $('#exchange').html(response);
                },
                error: function () {

                }
            });
        }
        else {

        }
    };

    thisAlerts.Return = (designation, expired_status) => {
        chosen = true;
        product_details_id = product_details_id;
        $('#submit_designation').fadeIn(); // Show the button with animation
        // Attach a one-time click event to the button
        if (valid) {
            $.ajax({
                type: "POST",
                url: ALERT_CONTROLLER + '?action=return',
                dataType: "json",
                data:{
                    product_details_id: product_details_id,
                    designation: designation,
                    expired_status: expired_status,
                },
                success: function (response) 
                {
                    $('#return').html(response);
                },
                error: function () {

                }
            });
        }
        else {

        }
    };

    thisAlerts.Decompose = (designation, expired_status) => {
        chosen = true;
        product_details_id = product_details_id;
        $('#submit_designation').fadeIn(); // Show the button with animation
        if (valid) {
            $.ajax({
                type: "POST",
                url: ALERT_CONTROLLER + '?action=decompose',
                dataType: "json",
                data:{
                    product_details_id: product_details_id,
                    designation: designation,
                    expired_status: expired_status,
                },
                success: function (response) 
                {
                    $('#decompose').html(response);
                },
                error: function () {

                }
            });
        }
        else {

        }

    };


    return thisAlerts;
})();