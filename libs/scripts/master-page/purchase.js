$(document).ready(function () {

    Purchase.loadPurchaseData();

    $('.btn').click(function (event) {
        event.preventDefault()
    })    
});

const Purchase = (() => {
    const thisPurchase = {};

    thisPurchase.loadPurchaseData = () => {
        $.ajax({
            type: "GET",
            url: PURCHASE_CONTROLLER + '?action=getPurchaseTable',
            dataType: "json",
            success: function (response) {
                // $('.table').DataTable().destroy();
                
                $('#tbody_purchases').html(response);

                $('.table').DataTable();
            },
            error: function () {

            }
        });        
    }


    let dateInput = document.getElementById('txt_receiving_date'); 
       
      const cur_date = new Date(); 
      const cur_month = cur_date.getMonth() > 9 ? cur_date.getMonth() + 1 : '0' + (cur_date.getMonth() + 1); 
      const cur_day = cur_date.getDate() > 9 ? cur_date.getDate() : '0' + cur_date.getDate();
      const dateStr = cur_date.getFullYear() + '-' + cur_month + '-' + cur_day; 
      dateInput.setAttribute('min', dateStr); 

    thisPurchase.openPurchase = () => {
        $('#modal_add_order').modal('show')
    }

    thisPurchase.createPurchase = () => {
        const orders = $('#txt_order').val();
        const quantity = $('#txt_quantity').val();
        const amount = $('#txt_amount').val();
        const order_date = new Date();
        const receiving_date = $('#txt_receiving_date').val();
        const supplier = $('#txt_supplier').val();

        if(orders == "" 
        || quantity == ""
        || amount == ""
        || receiving_date == ""
        || supplier == "") {
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Please fillup all fields',
                showConfirmButton: true,
            })
        }
        else {
            $.ajax({
                type: "POST",
                url: PURCHASE_CONTROLLER + `?action=save`,
                dataType: "json",
                data:{
                    orders: orders,
                    quantity: quantity,
                    amount: amount,
                    order_date: order_date,
                    receiving_date: receiving_date,
                    supplier: supplier,
                },
                success: function (response) 
                {
                    thisPurchase.loadPurchaseData();
                    thisPurchase.resetFields();
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Order Successfully Added!',
                        showConfirmButton: true,
                    })
                },
                error: function () {
                }
                
            });
        }
    }

    thisPurchase.clickPay = (id) => {
        purchase_id = id;

        $.ajax({
            type: "POST",
            url: PURCHASE_CONTROLLER + '?action=getID',
            dataType: "json",
            data:{
                purchase_id: id,
            },            
            success: function (response) {
                thisPurchase.updatePay();
                // thisPurchase.paidDate();
            },
            error: function () {

            }
        });        
    }

    thisPurchase.clickDeliver = (id) => {
        purchase_id = id;

        $.ajax({
            type: "POST",
            url: PURCHASE_CONTROLLER + '?action=getID',
            dataType: "json",
            data:{
                purchase_id: id,
            },            
            success: function (response) {
                // $('.table').DataTable().destroy();
                thisPurchase.updateDeliver();
            },
            error: function () {

            }
        });        
    }

    thisPurchase.clickReceive = (id) => {
        purchase_id = id;

        $.ajax({
            type: "POST",
            url: PURCHASE_CONTROLLER + '?action=getID',
            dataType: "json",
            data:{
                purchase_id: id,
            },            
            success: function (response) {
                // $('.table').DataTable().destroy();
                thisPurchase.updateReceive();
            },
            error: function () {

            }
        });        
    }

    thisPurchase.clickStock = (id) => {
        purchase_id = id;

        $.ajax({
            type: "POST",
            url: PURCHASE_CONTROLLER + '?action=getID',
            dataType: "json",
            data:{
                purchase_id: id,
            },            
            success: function (response) {
                // $('.table').DataTable().destroy();
                thisPurchase.updateStock();
            },
            error: function () {

            }
        });        
    }

    thisPurchase.clickDamage = (id) => {
        purchase_id = id;

        $.ajax({
            type: "POST",
            url: PURCHASE_CONTROLLER + '?action=getID',
            dataType: "json",
            data:{
                purchase_id: id,
            },            
            success: function (response) {
                // $('.table').DataTable().destroy();
                thisPurchase.updateDamage();
            },
            error: function () {

            }
        });        
    }

    thisPurchase.clickIncomplete = (id) => {
        purchase_id = id;

        $.ajax({
            type: "POST",
            url: PURCHASE_CONTROLLER + '?action=getID',
            dataType: "json",
            data:{
                purchase_id: id,
            },            
            success: function (response) {
                // $('.table').DataTable().destroy();
                thisPurchase.updateIncomplete();
            },
            error: function () {

            }
        });        
    }

    thisPurchase.clickTheft = (id) => {
        purchase_id = id;

        $.ajax({
            type: "POST",
            url: PURCHASE_CONTROLLER + '?action=getID',
            dataType: "json",
            data:{
                purchase_id: id,
            },            
            success: function (response) {
                // $('.table').DataTable().destroy();
                thisPurchase.updateTheft();
            },
            error: function () {

            }
        });        
    }

    thisPurchase.updatePay = () => {
        purchase_id = purchase_id;

        $.ajax({
            type: "POST",
            url: PURCHASE_CONTROLLER + '?action=Pay',
            dataType: "json",
            data:{
                purchase_id: purchase_id,
                status: status,
            },
            success: function (response) 
            {
                $('#pay').html(response);
                thisPurchase.loadPurchaseData();
                thisPurchase.paidDate();
            },
            error: function () {

            }
        });         
    }

    thisPurchase.paidDate = (paid) => {
        purchase_id = purchase_id;

        $.ajax({
            type: "POST",
            url: PURCHASE_CONTROLLER + '?action=paid',
            dataType: "json",
            data:{
                purchase_id: purchase_id,
                paid: paid,
            },
            success: function (response) 
            {
                $('#pay').html(response);
                thisPurchase.loadPurchaseData();
            },
            error: function () {

            }
        });

    }

    thisPurchase.updateDeliver = () => {
        purchase_id = purchase_id;

        $.ajax({
            type: "POST",
            url: PURCHASE_CONTROLLER + '?action=Deliver',
            dataType: "json",
            data:{
                purchase_id: purchase_id,
                status: status,
            },
            success: function (response) 
            {
                $('#deliver').html(response);
                thisPurchase.deliveryDate();
                thisPurchase.loadPurchaseData();
            },
            error: function () {

            }
        });         
    }

    thisPurchase.deliveryDate = (delivery) => {
        purchase_id = purchase_id;        

        $.ajax({
            type: "POST",
            url: PURCHASE_CONTROLLER + '?action=delivery',
            dataType: "json",
            data:{
                purchase_id: purchase_id,
                delivery: delivery,
            },
            success: function (response) 
            {
                $('#deliver').html(response);
                thisPurchase.loadPurchaseData();
            },
            error: function () {

            }
        });        
    }

    thisPurchase.updateReceive = () => {
        purchase_id = purchase_id;

        $.ajax({
            type: "POST",
            url: PURCHASE_CONTROLLER + '?action=Receive',
            dataType: "json",
            data:{
                purchase_id: purchase_id,
                status: status,
            },
            success: function (response) 
            {
                $('#receive').html(response);
                thisPurchase.receivedDate();
                thisPurchase.loadPurchaseData();
            },
            error: function () {

            }
        });         
    }

    thisPurchase.receivedDate = (received) => {
        purchase_id = purchase_id;        

        $.ajax({
            type: "POST",
            url: PURCHASE_CONTROLLER + '?action=received',
            dataType: "json",
            data:{
                purchase_id: purchase_id,
                received: received,
            },
            success: function (response) 
            {
                $('#receive').html(response);
                thisPurchase.loadPurchaseData();
            },
            error: function () {

            }
        });        
    }

    thisPurchase.updateStock = () => {
        purchase_id = purchase_id;

        $.ajax({
            type: "POST",
            url: PURCHASE_CONTROLLER + '?action=Stock',
            dataType: "json",
            data:{
                purchase_id: purchase_id,
                status: status,
            },
            success: function (response) 
            {
                $('#status').html(response);
                thisPurchase.addStock();
                thisPurchase.loadPurchaseData();
            },
            error: function () {

            }
        });         
    }

    thisPurchase.addStock = (stock) => {
        purchase_id = purchase_id;        

        $.ajax({
            type: "POST",
            url: PURCHASE_CONTROLLER + '?action=stock',
            dataType: "json",
            data:{
                purchase_id: purchase_id,
                stock: stock,
            },
            success: function (response) 
            {
                $('#stock').html(response);
                thisPurchase.loadPurchaseData();
            },
            error: function () {

            }
        });        
    }

    thisPurchase.updateDamage = () => {
        purchase_id = purchase_id;

        $.ajax({
            type: "POST",
            url: PURCHASE_CONTROLLER + '?action=Damage',
            dataType: "json",
            data:{
                purchase_id: purchase_id,
                status: status,
            },
            success: function (response) 
            {
                $('#status').html(response);
                thisPurchase.addDamage();
                thisPurchase.loadPurchaseData();
            },
            error: function () {

            }
        });         
    }

    thisPurchase.addDamage = (damaged) => {
        purchase_id = purchase_id;        

        $.ajax({
            type: "POST",
            url: PURCHASE_CONTROLLER + '?action=damaged',
            dataType: "json",
            data:{
                purchase_id: purchase_id,
                damaged: damaged,
            },
            success: function (response) 
            {
                $('#damaged').html(response);
                thisPurchase.loadPurchaseData();
            },
            error: function () {

            }
        });        
    }

    thisPurchase.updateIncomplete = () => {
        purchase_id = purchase_id;

        $.ajax({
            type: "POST",
            url: PURCHASE_CONTROLLER + '?action=Incomplete',
            dataType: "json",
            data:{
                purchase_id: purchase_id,
                status: status,
            },
            success: function (response) 
            {
                $('#status').html(response);
                thisPurchase.addIncomplete();
                thisPurchase.loadPurchaseData();
            },
            error: function () {

            }
        });         
    }

    thisPurchase.addIncomplete = (incomplete) => {
        purchase_id = purchase_id;        

        $.ajax({
            type: "POST",
            url: PURCHASE_CONTROLLER + '?action=incomplete',
            dataType: "json",
            data:{
                purchase_id: purchase_id,
                incomplete: incomplete,
            },
            success: function (response) 
            {
                $('#incomplete').html(response);
                thisPurchase.loadPurchaseData();
            },
            error: function () {

            }
        });        
    }

    thisPurchase.updateTheft = () => {
        purchase_id = purchase_id;

        $.ajax({
            type: "POST",
            url: PURCHASE_CONTROLLER + '?action=Theft',
            dataType: "json",
            data:{
                purchase_id: purchase_id,
                status: status,
            },
            success: function (response) 
            {
                $('#status').html(response);
                thisPurchase.addTheft();
                thisPurchase.loadPurchaseData();
            },
            error: function () {

            }
        });         
    }

    thisPurchase.addTheft = (theft) => {
        purchase_id = purchase_id;        

        $.ajax({
            type: "POST",
            url: PURCHASE_CONTROLLER + '?action=theft',
            dataType: "json",
            data:{
                purchase_id: purchase_id,
                theft: theft,
            },
            success: function (response) 
            {
                $('#theft').html(response);
                thisPurchase.loadPurchaseData();
            },
            error: function () {

            }
        });        
    }

    thisPurchase.resetFields = () => {

        $('#txt_order').val("");
        $('#txt_quantity').val("");
        $('#txt_amount').val("");
        $('#txt_receiving_date').val("");
        $('#txt_supplier').val("");

        $('#modal_add_order').modal('hide');
    }
    return thisPurchase;
})();