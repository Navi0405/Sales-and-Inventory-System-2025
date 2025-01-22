$(document).ready(function () {
    Category.loadTableData();
    Category.loadSelectData();


    $('.btn').click(function (event){
        event.preventDefault()
    })
});


const Category = (() => {
    const thisCategory = {};

    let category_id = '';

    let toUpdate = false;

    thisCategory.loadTableData = () => {
        $.ajax({
            type: "GET",
            url: CATEGORY_CONTROLLER + '?action=getTableData',
            dataType: "json",
            success: function (response) {
                $('.table').DataTable().destroy();
                $('#tbody_category').html(response);

                $('.table').DataTable();
            },
            error: function () {

            }
        });
    }

    thisCategory.loadSelectData = () => {
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

    thisCategory.clickSaveButton= () => {
        if(!toUpdate) {
            thisCategory.save()
        }
        else {
            thisCategory.update()
        }
    }

    thisCategory.save = () => {
        const category_name = $('#txt_category_name').val();
        let existingCategories = ['MILK & DIAPERS', 'SUPPLEMENTS', 'BRANDED TABLETS', 'GENERIC TABLETS',
        'OINTMENTS', 'GALLENICALS', 'BRANDED SYRUP', 'GENERIC SYRUP','milk & diapers', 'supplements', 'branded tablets', 'generic tablets',
        'ointments', 'gallenicals', 'branded syrup', 'generic syrup', 'Milk & Diapers', 'Supplements', 'Branded Tablets', 'Generic Tablets',
        'Ointments', 'Gallenicals', 'Branded Syrup', 'Generic Syrup'];

        if(category_name == "") {
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Please input Category Name',
                showConfirmButton: true,
            })
        }
        else if (existingCategories.includes(category_name)) {
            Swal.fire({
              position: 'center',
              icon: 'warning',
              title: 'Category name already exists',
              showConfirmButton: true,
            })
          } 
        else if (/\d/.test(category_name)) {
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Category name cannot contain numbers',
                showConfirmButton: true,
            });
        }
        else {
            $.ajax({
                type: "POST",
                url: CATEGORY_CONTROLLER + '?action=save',
                dataType: "json",
                data:{
                    category_name: category_name
                },
                success: function (response) 
                {
                    $('#txt_category_name').val("")
                    thisCategory.loadTableData();
                    thisCategory.loadSelectData();
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Category Registered Successfully',
                        showConfirmButton: true,
                    })
                },
                error: function () {
    
                }
            });
        }        
    }

    thisCategory.clickUpdate = (id) => {
        category_id = id;

        $.ajax({
            type: "POST",
            url: CATEGORY_CONTROLLER + '?action=getById',
            dataType: "json",
            data:{
                category_id: category_id
            },
            success: function (response) 
            {
                $('#txt_category_name').val(response.name);
                toUpdate = true;

                $('#btn_save_category').html('Update Category');
                $('#txt_category').html('Update Category');
            },
            error: function () {

            }
        });
    }

    thisCategory.update = () => {
        const category_name = $('#txt_category_name').val();

        if(category_name == "") {
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Category field should have value',
                showConfirmButton: true,
            })
        }
        else{
            $.ajax({
                type: "POST",
                url: CATEGORY_CONTROLLER + '?action=update',
                dataType: "json",
                data:{
                    category_id: category_id,
                    category_name: category_name
                },
                success: function (response) 
                {
                    $('#txt_category_name').val("")
                    thisCategory.loadTableData();
                    thisCategory.loadSelectData();
                    $('#btn_save_category').html('Register Category');
                    toUpdate = false;
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Category updated successfully',
                        showConfirmButton: true,
                    })
                },
                error: function () {
    
                }
            });

        }
 
    }

    thisCategory.clickCancel = () => {
        $('#txt_category_name').val("")
        toUpdate = false;
        $('#btn_save_category').html('Register Category');
    }

    thisCategory.clickCancel = () => {
        $('#txt_category_name').val("")
        toUpdate = false;
        $('#btn_save_category').html('Register Category');
    }

    // thisCategory.clickDelete = (id) => {
    //     category_id = id

    //     Swal.fire({
    //         title: 'Are you sure?',
    //         text: "You will not be able to revert this action",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Yes!',
    //         cancelButtonText: 'No'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             thisCategory.delete();
    //         }
    //     })
    // }

    // thisCategory.delete = () => {
    //     $.ajax({
    //         type: "POST",
    //         url: CATEGORY_CONTROLLER + '?action=delete',
    //         dataType: "json",
    //         data:{
    //             category_id: category_id
    //         },
    //         success: function (response) 
    //         {
    //             Swal.fire({
    //                 position: 'center',
    //                 icon: 'success',
    //                 title: 'Category Deleted Successfully ',
    //                 showConfirmButton: false,
    //                 timer: 1500
    //             })
    //             thisCategory.loadTableData();
    //             thisCategory.loadSelectData();
    //         },
    //         error: function () {

    //         }
    //     });
    // }

    return thisCategory;
})()