$(document).ready(function () {

    Admin.loadTableData();

    $('.btn').click(function (event) {
        event.preventDefault()
    })
});


const Admin = (() => {
    const thisAdmin = {};

    let user_id = '';
    let toUpdate = false;

    thisAdmin.loadTableData = () => {
        $.ajax({
            type: "GET",
            url: USER_CONTROLLER + '?action=getTableData',
            dataType: "json",
            success: function (response) {
                $('.table').DataTable().destroy();
                
                $('#tbody_users').html(response);

                $('.table').DataTable();
            },
            error: function () {

            }
        });
    }

    thisAdmin.clickSaveButton= () => {
        if(!toUpdate) {
            thisAdmin.save()
        }
        else {
            thisAdmin.update()
        }
    }

    thisAdmin.save = () => {
        const first_name = $('#txt_first_name').val();
        const last_name = $('#txt_last_name').val();
        const username = $('#txt_user_name').val();
        const newpassword = $('#txt_newpassword').val();
        // const password = $('#txt_password').val();
        const confirm_password = $('#txt_confirm_password').val();
        const role = $('#slc_role').val();
        const status = $('#slc_status').val();

        if(first_name == "" 
        || last_name == ""
        || username == ""
        || newpassword == ""
        || confirm_password == ""
        || role == null
        || status == null) {
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Please fillout all fields',
                showConfirmButton: true,
            })
        }
        else if(newpassword != confirm_password) {
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Password Did not match',
                showConfirmButton: true,
            })
        }
        else {
            $.ajax({
                type: "POST",
                url: USER_CONTROLLER + '?action=save',
                dataType: "json",
                data:{
                    first_name: first_name,
                    last_name: last_name,
                    username: username,
                    password: newpassword,
                    role: role,
                    status: status,
                },
                success: function (response) 
                {
                 Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Account created successfully',
                    showConfirmButton: true,
                 })
                    thisAdmin.resetFields();
                    thisAdmin.loadTableData();
                },
                error: function () {
    
                }
            });
        }        
    }

    thisAdmin.clickUpdate= (id) => {
        user_id = id

        $.ajax({
            type: "POST",
            url: USER_CONTROLLER + '?action=getById',
            dataType: "json",
            data:{
                user_id: user_id
            },
            success: function (response) 
            {
                $('#txt_first_name').val(response.first_name);
                $('#txt_last_name').val(response.last_name);
                $('#txt_user_name').val(response.username);
                $('#txt_newpassword').prop( "disabled", true );
                $('#txt_confirm_password').prop( "disabled", true );
                $('#slc_role').val(response.role);
                $('#slc_status').val(response.status);
                
                toUpdate = true;

                $('#btn_save').html("Update Account");
                $('#lbl_title').html("Update Account");
            },
            error: function () {

            }
        });

    }

    thisAdmin.update = () => {
        const first_name = $('#txt_first_name').val();
        const last_name = $('#txt_last_name').val();
        const username = $('#txt_user_name').val();
        const role = $('#slc_role').val();
        const status = $('#slc_status').val();


        $.ajax({
            type: "POST",
            url: USER_CONTROLLER + '?action=update',
            dataType: "json",
            data:{
                user_id: user_id,
                first_name: first_name,
                last_name: last_name,
                username: username,
                role: role,
                status: status,
            },
            success: function (response) 
            {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Account updated successfully',
                    showConfirmButton: true,
                })
                thisAdmin.resetFields();
                thisAdmin.loadTableData();
            },
            error: function () {

            }
        }); 
    }

    // thisAdmin.clickDelete = (id) => {
    //     user_id = id;

    //     Swal.fire({
    //         title: 'Are you sure?',
    //         text: "You won't be able to revert this!",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Yes!',
    //         cancelButtonText: 'No'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             thisAdmin.delete();
    //         }
    //     })
    // }

    // thisAdmin.delete = () => {
    //     $.ajax({
    //         type: "POST",
    //         url: USER_CONTROLLER + '?action=delete',
    //         dataType: "json",
    //         data:{
    //             user_id: user_id
    //         },
    //         success: function (response) 
    //         {
    //             Swal.fire({
    //                 position: 'center',
    //                 icon: 'success',
    //                 title: 'User account was deleted successfully',
    //                 showConfirmButton: false,
    //                 timer: 1500
    //             })
    //             thisAdmin.resetFields();
    //             thisAdmin.loadTableData();
    //         },
    //         error: function () {

    //         }
    //     }); 
    // }

    thisAdmin.clickResetPassword = (id) => {
        user_id = id;

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Update to Default Password!',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                thisAdmin.resetPassword();
            }
        })
    }

    thisAdmin.resetPassword = () => {

        $.ajax({
            type: "POST",
            url: USER_CONTROLLER + '?action=resetPassword',
            dataType: "json",
            data:{
                user_id: user_id
            },
            success: function (response) 
            {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Password Reset Successfully ',
                    showConfirmButton: false,
                    timer: 1500
                })
                thisAdmin.resetFields();
                thisAdmin.loadTableData();
            },
            error: function () {

            }
        }); 
    }


    thisAdmin.resetFields = () => {
        $('#txt_first_name').val("");
        $('#txt_last_name').val("");
        $('#txt_user_name').val("");
        $('#txt_newpassword').val("");
        $('#txt_confirm_password').val("");
        $('#slc_role').val("");
        $('#slc_status').val("");

        $('.form-control').prop("disabled", false);

        $('#btn_save').html("Create Account");
        $('#lbl_title').html("Create Account");
    }

    return thisAdmin;
})();