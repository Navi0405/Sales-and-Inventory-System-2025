const select = document.querySelector('.invoice__filters__select');
const filterGroups = document.querySelectorAll('.invoice__filters__group');

const btnSearchDaily = document.querySelector('.invoice__filters__daily__button');
const btnSearchMonthly = document.querySelector('.invoice__filters__monthly__button');
const btnSearchRange = document.querySelector('.invoice__filters__range__button');
const btnConfirmPassword = document.querySelector('.admin__password__button');

const inpSearchDaily = document.querySelector('.invoice__filters__daily__input');
const inpSearchMonthly = document.querySelector('.invoice__filters__monthly__input');
const inpSearchRangeStart = document.querySelector('.invoice__filters__monthly__input__start');
const inpSearchRangeEnd = document.querySelector('.invoice__filters__monthly__input__end');
const inpAdminPassword = document.querySelector('.admin__password__input');

const SessionRole = document.querySelector('#SessionRole');

let invoice_id;
let product_id;



$(document).ready(() => {
    let currentDate = new Date().toJSON().slice(0, 10);
    inpSearchDaily.value = currentDate;

    getInvoices();
})

const invoiceTable = document.querySelector('.invoice__table');

select.addEventListener('change',()=>{
    console.log(select.value);
    filterGroups.forEach(group =>{
        group.classList.contains('hidden')? '': group.classList.add('hidden');
    });
    filterGroups[select.value].classList.remove('hidden');

    $('.table').DataTable().destroy();
    $('.invoice__table tbody').html('');
    $('.table').DataTable();
});

const getInvoices =  () => {

    let actionURL;

    if(select.value == 0){
        if(inpSearchDaily.value == ''){
            inpSearchDaily.classList.add('error');
        }
        else{
            inpSearchDaily.classList.remove('error');
            actionURL = `?action=searchDaily&date=${inpSearchDaily.value}`;
        }

    }
    else if(select.value == 1){
        if(inpSearchMonthly.value == ''){
            inpSearchMonthly.classList.add('error');
        }
        else{
            inpSearchMonthly.classList.remove('error');
            actionURL = `?action=searchMonthly&yearmonth=${inpSearchMonthly.value}`;
        }

    }
    else if(select.value == 2){
        if(inpSearchRangeStart.value == '' || inpSearchRangeEnd.value == ''){
            inpSearchRangeStart.classList.add('error');
            inpSearchRangeEnd.classList.add('error');
        }
        else{
            inpSearchRangeStart.classList.remove('error');
            inpSearchRangeEnd.classList.remove('error');
            actionURL = `?action=searchRange&startDate=${inpSearchRangeStart.value}&endDate=${inpSearchRangeEnd.value}`;
        }

    }
    else{

    }

    $.ajax({
        type:'GET',
        url: INVOICE_CONTROLLER + actionURL,
        dataType:'json',
        cache:false,
        success: (data) => {
            console.log(data);
            let tbody = '';
            let count = 1;
            data.forEach(invoice =>{
                tbody+=`<tr>
                <td>${count++}</td>
                <td>${invoice.users_name}</td>             
                <td>${invoice.date_transact}</td>
                <td>${invoice.total_items}</td>
                <td>${invoice.total_purchase}</td>
                <td>
                    <button onclick="openModal('${invoice.id}')">View</button>
                </td>
            </tr>`;
            });

            $('.table').DataTable().destroy();
            $('.invoice__table tbody').html(tbody);
            $('.table').DataTable();
        }
    });


};


const openModal = (id) => {
    $('#myModal').modal('show');
    $.ajax({
        type:'get',
        url: INVOICE_CONTROLLER + `?action=getInvoiceSales&invoice_id=${id}`,
        dataType: 'json',
        cache:false,
        success: (data) =>{
            console.log(data);
            let tbody = '';

            data.forEach(item => {
                if(item.void == null){
                tbody += `<tr>
                <td>${item.qty}</td>
                <td>${item.name}</td>
                <th>${item.price}</th>
                <td>
                    <button class="invoice__modal__void" onclick="confirmVoidItem(${item.invoice_id}, ${item.product_id})">Void</button>
                </td>
            </tr>`;
                }
                else{
                    tbody += `<tr>
                    <td>${item.qty}</td>
                    <td>${item.name}</td>
                    <th>${item.price}</th>
                    <td>
                        <button class="invoice__modal__void" disabled style="color:red">Voided</button>
                    </td>
                </tr>`;
                }
            });

            $('#sales__table').DataTable().destroy();
            $('#sales__table tbody').html(tbody);
            $('#sales__table').DataTable();
        }
    })
}

const validateAdminPassword = () => {
 
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
                voidItem(invoice_id, product_id)
                $('#modal_confirmpassword').modal('hide');
            }
            else {
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: 'Invalid Password',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        }
    });
    inpAdminPassword.value = "";
}

const confirmVoidItem = (invoice, product) => {
    invoice_id = invoice;
    product_id = product
    if(SessionRole.value == 3) {
        $('#modal_confirmpassword').modal('show');
    } 
    else {
        voidItem(invoice, product)
    }
}

const voidItem = (invoice, product) => {
        $.ajax({
            type: 'POST',
            url: INVOICE_CONTROLLER + `?action=voidItem`,
            data:{
                invoice:invoice,
                product:product
            },
            dataType: 'json',
            cache: false,
            success: (data) => {
                // console.log(data);
                getInvoices();
                openModal(invoice);
            }
        });
}

btnSearchDaily.addEventListener('click', getInvoices);
btnSearchMonthly.addEventListener('click', getInvoices);
btnSearchRange.addEventListener('click', getInvoices);
btnConfirmPassword.addEventListener('click', validateAdminPassword);




