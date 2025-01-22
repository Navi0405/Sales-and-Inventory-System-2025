$(document).ready(() => {
    checkSalesToday();
    checkCart();
});

const pos_sales_today = document.querySelector('.pos__head__amount');
const inpCustomerError = document.querySelector('.pos__body__customer__error');
const inpPaymentError = document.querySelector('.pos__insufficient__error');
const inpCustomer = document.querySelector('.pos__body__customer__input');
const inpCustomerNumber = document.querySelector('.pos__body__customer__number');
const posCustomer = document.querySelector('.pos__body__customer');
const posCustomerNumber = document.querySelector('.pos__body__customer_number');
const posForm = document.querySelector('.pos__form');
const inpBarcode = document.querySelector('.pos__form__barcode');
const inpProduct = document.querySelector('.pos__form__product');
const inpDiscount = document.querySelector('.pos__body__discount__input');
const btnConfirm = document.querySelector('.pos__confirm');
const btnCart = document.querySelector('.pos__form__submit');
const btnCheckout = document.querySelector('.pos__form__checkout');
const btnClose = document.querySelector('pos__close');
const posTable = document.querySelector('pos__table');
const posQuantity = document.querySelector('.pos__form__quantity');
const btnConfirmPassword = document.querySelector('.admin__password__button');
const inpAdminPassword = document.querySelector('.admin__password__input');

let barcode;
let productCart = [];
let grandTotal = 0;
let container = 0;
let transaction = 0;

const printReceipt = (invoiceId) => {
    // window.location.href = ('http://localhost/pos/views/pos/receipt.php?invoice_id=${invoiceId}');
    window.open(`${HOST_2}/views/pos/receipt.php?invoice_id=${invoiceId}`);
}

const checkSalesToday = () => {
    $.ajax({
        type:'get',
        url: INVOICE_CONTROLLER + `?action=getTotalSalesToday`,
        dataType:'json',
        cache: false,
        success: (data) => {
            if(data.total_sales == null){
                data.total_sales = 0;
            }
            pos_sales_today.innerHTML = '₱'+ parseFloat(data.total_sales).toFixed(2);
        }
    });
}

// const getBarcode =  () => {

//     let actionURL;

//     if(select.value == 0){
//         if(inpSearchDaily.value == ''){
//             inpSearchDaily.classList.add('error');
//         }
//         else{
//             inpSearchDaily.classList.remove('error');
//             actionURL = `?action=searchDaily&date=${inpSearchDaily.value}`;
//         }

//     }
// }

// const openModal = (id) => {
//     $('#myModal').modal('show');
//     $.ajax({
//         type:'get',
//         url: INVOICE_CONTROLLER + `?action=voidCart=${id}`,
//         dataType: 'json',
//         cache:false,
//         success: (data) =>{
//             console.log(data);
//             let tbody = '';

//             data.forEach(item => {
//                 tbody += `<tr>
//                 <td>
//                     <button class="invoice__modal__void" onclick="confirmVoidCart(${product.barcode}">Void</button>
//                 </td>
//             </tr>`;
//             });

//             $('#sales__table').DataTable().destroy();
//             $('#sales__table tbody').html(tbody);
//             $('#sales__table').DataTable();
//         }
//     })
// }

const checkCart = () => {
    if(container == 0){
        btnCheckout.style.backgroundColor="#808080";
        btnCheckout.disabled=true;
    }
    else{
        btnCheckout.style.backgroundColor="#99FFCC";
        btnCheckout.disabled=false;
    }
    $('#pos__table').DataTable().destroy();

    $('#pos__table').DataTable({
        language: {
            emptyTable: "No item(s) added on cart"
        }
    });
}

const removeItem = (barcode) => {

    productCart = productCart.filter((item)=>{
        if(item.barcode != barcode) return item; 
    });

    const rowClass = `.row${barcode}`;
    const table = $('#pos__table').DataTable();
    const rows = table
        .rows( rowClass )
        .remove()
        .draw()
        container --
        transaction --
        checkCart();
}

const validateAdminPassword = () => {
 var barcode = $('#modal_confirmpassword').data('barcode');
    $.ajax({
        type: 'POST',
        url: USER_CONTROLLER + `?action=validateAdminPassword`,
        data:{
            password:inpAdminPassword.value
        },
        dataType: 'json',
        cache: false,
        success: (result) => {
            if(result == true) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Voided successfully',
                    showConfirmButton: true,
                })
                removeItem(barcode)
                $('#modal_confirmpassword').modal('hide');
            }
            else {
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'Incorrect Password',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        }
    });
    inpAdminPassword.value = "";
}

const confirmVoidCart = (barcode) => {
    barcode = barcode;
    if(SessionRole.value == 3) {
        $('#modal_confirmpassword').data('barcode', barcode);
        $('#modal_confirmpassword').modal('show');
    } 
    else {
        removeItem(barcode)
    }
}

const voidCart = (barcode) => {
        $.ajax({
            type: 'GET',
            url: INVOICE_CONTROLLER + `?action=voidCart`,
            // type: 'DELETE',
            data:{
                barcode:barcode,
            },
            dataType: 'json',
            cache: false,
            success: (data) => {
                console.log(data);
            }
        });
}


const closeModal = (modal) =>{
    $(`#${modal}`).modal('hide');
}


const calculateDiscount = (amount, discountType) => {
                let discount = 0;
                if(discountType == 'branded'){
                    discount = 0.08;
                }
                else if(discountType == 'generic'){
                    discount = 0.2;
                }
                else{
                    // not discounted
                }
                return amount - (amount * discount);
};

const checkDiscount = () => {
    const rows = document.querySelectorAll('tbody tr.rowClass');
    if(rows.length > 0){
        rows.forEach((row)=>{
            const price = row.querySelector('.p-price');
            const quantity = row.querySelector('.p-quantity');
            const amount = row.querySelector('.p-amount');
            const type = row.querySelector('.p-type');
            let amountValue = (+price.innerHTML * +quantity.innerHTML).toFixed(2);
            
            posCustomer.classList.remove('show');
            posCustomerNumber.classList.remove('show');
            if(inpDiscount.checked){
                console.log('wew');
                posCustomer.classList.add('show');
                posCustomerNumber.classList.add('show');
                amountValue = calculateDiscount(amountValue, type.innerHTML);
            }
            amount.innerHTML = amountValue;
        })
    }
    else{
        posCustomer.classList.toggle('show');
        posCustomerNumber.classList.toggle('show');
    }
}

inpDiscount.addEventListener('change', checkDiscount);
posQuantity.addEventListener('click', ()=>{
    posQuantity.classList.remove('error');
});
inpBarcode.addEventListener('click', ()=>{
    inpBarcode.classList.remove('error');
});
inpBarcode.addEventListener('blur', (e)=>{
    // console.log(e.currentTarget);
    $.ajax({
        type:'GET',
        url: PRODUCT_CONTROLLER + `?action=getAvailableProductByBarcode&barcode=${inpBarcode.value}`,
        dataType: 'json',
        cache:false,
        success: (data) => {
            
            if(data.length > 0){
                inpProduct.value = data[0].product_name;
            }
            else{
                inpBarcode.classList.add('error');
                inpProduct.value = '';
                Swal.fire({
                    icon: 'error',
                    title: 'Product Not Found',
                    text: 'It seems like the product that you\'re looking for does not exist or out of stock',
                    // footer: `<a class="kaboom" href="${HOST}views/master-page/products.php">You might check the list of available products here</a>`
                })
            }
        }
    })
});

btnCheckout.addEventListener('click', (e)=>{
    e.preventDefault();
    grandTotal = 0;
    console.log(productCart);
    let list = productCart.map(item =>{
        let totalItemPrice = parseInt(item.quantity) * parseFloat(item.price).toFixed(2);

        if(inpDiscount.checked){
            totalItemPrice =  calculateDiscount(totalItemPrice, item.type);
        }
        grandTotal += totalItemPrice;
        
        
        return `<li class="pos__list__item">
            <div class="pos__list__item__details">
            <span class="pos__list__item__quantity">${item.quantity}</span>
            <p class="pos__list__item__name"> ${item.name}</p>
            </div>
            <span class="pos__list__item__price">₱ ${totalItemPrice.toFixed(2)}</span>
        </li>`;
    }).join('');
    list+=`<li class="pos__list__item total">
        <div class="pos__list__item__details">
        <span class="pos__list__item__quantity"></span>
        <p class="pos__list__item__name dark">Grand Total</p>
        </div>
        <span class="pos__list__item__price" step="0.01">₱ ${grandTotal.toFixed(2)}</span>
    </li>`

    list+=`<li class="pos__list__item payment">
        <div class="pos__list__item__details">
        <span class="pos__list__item__quantity"></span>
        <p class="pos__list__item__name">Payment</p>
        </div>
        <input class="pos__body__payment" min="1" oninput="calculateChange() || validity.valid || (value='')" 
        type="number" step="0.01" max="100000"></input>
    </li>`

    list+=`<li class="pos__list__item total">
        <div class="pos__list__item__details">
        <span class="pos__list__item__quantity"></span>
        <p class="pos__list__item__name dark">Change</p>
        </div>
        <span class="pos__list__item__change">₱ 0.00</span>
    </li>`

    $('.pos__list').html(list);

    $('#myModal').modal('show');
});

btnCart.addEventListener('click', (e) => {
    e.preventDefault();
    let requiredQuantity = parseInt(posQuantity.value) || 1;
    $.ajax({
        type: 'GET',
        url: PRODUCT_CONTROLLER + `?action=getAvailableProductByBarcode&barcode=${inpBarcode.value}`,
        dataType: 'json',
        cache: false,
        success: data => {

            let totalAvailableQuantity = data.reduce((accumulator, product) => {
                return accumulator + parseInt(product.quantity);
            }, 0);


            if (data.length > 0 && totalAvailableQuantity >= requiredQuantity) {
                const exist = productCart.some(el => el.barcode === data[0].barcode);
                if(exist){
                    Swal.fire(
                                `${data[0].barcode}`,
                                'Item is already on the list',
                                'question'
                            )
                            data = [];
                }
                else{
                    const item = {
                        barcode: data[0].barcode,
                        name: data[0].product_name,
                        price: data[0].sale_price,
                        quantity: requiredQuantity,
                        type:data[0].type
                    }
                    productCart.push(item);
                }

                
                

                let row = '';
                for (const product of data) {
                    totalAvailableQuantity += product.quantity;
                    if (requiredQuantity > 0) {
                        let availableQuantity = 0;

                        if (requiredQuantity >= product.quantity) {
                            requiredQuantity = requiredQuantity - product.quantity;
                            availableQuantity = product.quantity
                        } else {
                            availableQuantity = requiredQuantity;
                            requiredQuantity = 0;
                        }
                        
                        
                        const amount = product.sale_price * availableQuantity;
                        const rowClass = `rowClass row${product.barcode}`;
                        row += `<tr class="${rowClass}">
                        <td>
                            <button class="btn-remove" onclick="confirmVoidCart(${product.barcode})">&#10008;</button>
                        </td>
                        <td>${product.product_name}</td>
                        <td>${product.category_name}</td>
                        <td class="p-type">${product.type}</td>
                        <td>${product.expiration_date}</td>
                        <td class="p-price">${product.sale_price}</td>
                        <td class="p-quantity">${availableQuantity}</td>
                        <td class="p-amount">${amount.toFixed(2)}</td>
                       
                        </tr>`;
                    } else {
                        break;
                    }
                }

                $('#pos__table').DataTable().destroy();
                $('#tbody_pos').append(row);
                $('#pos__table').DataTable({
                    language: {
                        emptyTable: "No item(s) added on cart"
                    }
                });
                container ++
                checkCart()
                transaction ++
                checkDiscount()
                posForm.reset();

            } else if (data.length > 0 && totalAvailableQuantity < requiredQuantity) {
                posQuantity.classList.add('error');
                Swal.fire(
                    `${data[0].product_name}`,
                    `We only have ${totalAvailableQuantity} items left for this product`,
                    'info'
                )
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Out of Stock',
                    text: 'It seems like the product that you\'re looking for is out of stock',
                    // footer: '<a class="kaboom" href="http://localhost/pos/views/master-page/products.php">You might check the list of available products here</a>'
                })
            }
        }
    })

});

inpCustomer.addEventListener('click',()=>{
    inpCustomerError.classList.remove('show');
});

inpCustomerNumber.addEventListener('click',()=>{
    inpCustomerError.classList.remove('show');
});

btnConfirm.addEventListener('click',()=>{
    
    let discount = ''
    let customerName = '';
    let customerNumber = '';
    let cashPayment = $('.pos__body__payment').val();
    let process = 1;
    if(inpDiscount.checked){
        discount = 'discounted';
        customerName = inpCustomer.value;
        customerNumber = inpCustomerNumber.value;

        if(customerName == '' || customerNumber == ''){
            process = 0;
        }
    }

    if(cashPayment < grandTotal) {
        process = 2;
    }
    
    if(process == 1){
        $.ajax({
            type: "POST",
            url: INVOICE_CONTROLLER + `?action=confirmedCheckout`,
            dataType: "json",
            data:{
                osca_number: customerNumber, 
                customerName: customerName, 
                cashPayment: cashPayment, 
                data: productCart,
                discounted: discount
            },
            success: function (last_invoice_id) 
            {
                console.log('success');
                printReceipt(last_invoice_id);
                window.location.href = HOST_2 + '/views/pos/index.php';
            },
            error: function () {
                console.log('error');
            }
        });
    }
    else if(process == 2){
        inpPaymentError.classList.add('show');
    }
    else{
        $('#myModal').modal('hide');
        inpCustomerError.classList.add('show');
    }

});


function calculateChange () {
    let payment = $('.pos__body__payment').val();
    const posPayment = document.querySelector('.pos__body__payment');
    
    let change = payment - grandTotal;

    if(payment >= grandTotal) {
        inpPaymentError.classList.remove('show');
        console.log(payment,grandTotal);
        posPayment.classList.remove('error');
        
    }
    else{
        inpPaymentError.classList.add('show');
        if(posPayment.classList.contains('error') == false){
            posPayment.classList.add('error');
        }
    }

    if(payment == ""){
        change = 0;
    }
    change = parseFloat(change).toFixed(2);
    $('.pos__list__item__change').html(`₱ ${change}`);
}


btnConfirmPassword.addEventListener('click', validateAdminPassword);

var formChanged = false;
// Form warning before leaving
$(document).ready(function() {
    $('form').on('change', function() {
        formChanged = true;
    });

    $('a').on('click', function(e) {
        console.log("test")
        if (transaction == 1) {
            e.preventDefault(); 
            Swal.fire({
                title: 'Transaction is in progress',
                text: 'Are you sure you want to leave?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, leave anyway',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = this.href;
                }
            });
        }
    });
    
    $('.cancelButton').on('click', function(e) {
        if (formChanged) {
            e.preventDefault();
            Swal.fire({
                title: 'Transaction is in progress',
                text: 'Are you sure you want to leave?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../master-page/home.php";
                }
            });
        } else {
            window.location.href = "../master-page/home.php";
        }
    });
});
window.onload = function(){
    document.getElementById("bCode").focus();
}