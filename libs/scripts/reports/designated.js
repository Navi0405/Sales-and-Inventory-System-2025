$(document).ready(function () {

    Designation.loadExpiredProducts();

    $('.btn').click(function (event) {
        event.preventDefault()
    })    
});    

const Designation = (() => {
    const thisDesignation = {};

    thisDesignation.loadExpiredProducts = () => {
        $.ajax({
            type: "GET",
            url: PRODUCT_CONTROLLER + '?action=getDesignatedExpiredTable',
            dataType: "json",
            success: function (response) {
                $('.table').DataTable().destroy();
                $('#tbl_designations').html(response);

                $('.table').DataTable();
            },
            error: function () {

            }
        });        
    }        
    return thisDesignation; 
})();