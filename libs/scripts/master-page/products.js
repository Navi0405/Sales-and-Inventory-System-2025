$(document).ready(function () {

    Product.loadTableData();
    Product.loadSelectData();


    $('.btn').click(function (event) {
        event.preventDefault()
    })
});


const Product = (() => {
    const thisProduct = {};

    let product_id;

    thisProduct.loadTableData = () => {
        $.ajax({
            type: "GET",
            url: PRODUCT_CONTROLLER + '?action=getProductTable',
            dataType: "json",
            success: function (response) {
                $('.product-table').DataTable().destroy();
                $('#tbody_product_table').html(response);

                $('.product-table').DataTable();
            },
            error: function () {

            }
        });
    }

    thisProduct.loadSelectData = () => {
        $.ajax({
            type: "GET",
            url: CATEGORY_CONTROLLER + '?action=getSelectData',
            dataType: "json",
            success: function (response) {

                $('#slc_product_category').html(response);
            },
            error: function () {

            }
        });
    }

    thisProduct.clickView = (id, product_name) => {
        $.ajax({
            type: "POST",
            url: PRODUCT_CONTROLLER + '?action=getProductDetailsTableModal',
            dataType: "json",
            data:{
                product_id: id
            },
            success: function (response) {
                $('#modal_view_details').modal('show')
                $('#modal_view_details_header').html(product_name)
                $('.table').DataTable().destroy();
                $('#tbody_product_details').html(response);
                
                $('.table').DataTable();
            },
            error: function () {

            }
        });
    }

    thisProduct.clickUpdate = (id, product_name) => {
        product_id = id;

        $.ajax({
            type: "POST",
            url: PRODUCT_CONTROLLER + '?action=getProductForUpdate',
            dataType: "json",
            data:{
                product_id: id
            },
            success: function (response) {
                $('#txt_product_name').val(response.name);
                $('#txt_product_barcode').val(response.barcode);
                $('#slc_product_category').val(response.category_id);
                // $('#txt_lot_number').val(response.lot_num);
                $('#txt_selling_price').val(parseFloat(response.sale_price).toFixed(2));
                $('#slc_status').val(response.status);
                $('#txt_max_stock').val(response.max_stock);
                $('#txt_min_stock').val(response.min_stock);
                $('#slc_type').val(response.type);
                // $('#txt_location').val(response.location);
               
                $('#modal_update_details').modal('show');
                $('#modal_update_details_header').html('Update ' + product_name);
            },
            error: function () {

            }
        });

    }

    thisProduct.update = () => {
        const product_name = $('#txt_product_name').val();
        const product_barcode = $('#txt_product_barcode').val();
        const product_category = $('#slc_product_category').val();
        const selling_price = $('#txt_selling_price').val();
        const status = $('#slc_status').val();
        const max_stock = $('#txt_max_stock').val();
        const min_stock = $('#txt_min_stock').val();
        const type = $('#slc_type').val();
        // const location = $('#txt_location').val();        

        $.ajax({
            type: "POST",
            url: PRODUCT_CONTROLLER + '?action=updateProduct',
            dataType: "json",
            data:{
                product_id: product_id,
                product_name: product_name,
                product_barcode: product_barcode,
                product_category: product_category,
                selling_price: selling_price,
                status: status,
                max_stock: max_stock,
                min_stock: min_stock,
                type: type,
            },
            success: function (response) 
            {
                thisProduct.loadTableData();
                // thisProduct.resetFields();
                $('#modal_update_details').modal('hide');
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Product Successfully updated!',
                    showConfirmButton: true,
                })
            },
            error: function () {

            }
        });

    }

    thisProduct.exportInventory = () => {
        $.ajax({
            type: "POST",
            url: PRODUCT_CONTROLLER + '?action=inventoryExcel',
            dataType: "json",
            success: function (data) {
            
                var currentDate = new Date();
                var formattedDate = currentDate.toLocaleDateString().replaceAll('/', '-'); // Format the date as desired
                var filename = `Inventory Report ${formattedDate}.csv`; // Construct the filename with the current date


                var csvContent = "data:text/csv;charset=utf-8,";
                csvContent += Object.keys(data[0]).join(",") + "\n";
                data.forEach(function (item) {
                    var row = Object.values(item).join(",");
                    csvContent += row + "\n";
                });
                
                var encodedUri = encodeURI(csvContent);
                var link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", filename);
                link.style.display = "none";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            },
            error: function () {

            }
        });
    }

    thisProduct.resetFields = () => {

        $('#txt_product_barcode').val("");
        $('#txt_product_name').val("");
        $('#slc_product_category').val("");
        $('#txt_selling_price').val("");
        $('#slc_status').val("");
        $('#txt_max_stock').val("");
        $('#txt_min_stock').val("");
        $('#txt_location').val("");

        $('#btn_save_product').html('Register Product');
    }

    return thisProduct;
})();