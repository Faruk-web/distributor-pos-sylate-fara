$(document).ready(function() {
    //alert('hello');
    
});

//Begin:: Check Permission
function checkPermission(group_name, permission_id, permission_name) {
    var unSelectedPermission = document.getElementById("unSelectedPermission_"+permission_id);
    var roleID = $('#role_ID').val();
    $.ajax({
        url: '/admin/set-permission-to-admin-helper-role',
        method:"GET",
        data:{ 
            permission_id:permission_id,
            roleID: roleID,
        },
        success: function (response) {
            
            if(response['status'] == 'yes') {
                unSelectedPermission.classList.add("d-none");
                Toastify({
                    text: response['reason'],
                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                    className: "success",
                }).showToast();
                $("#provided_permission_group_"+group_name).append('<div class="form-check form-check-inline ml-4" id="provided_permission_'+permission_id+'"><input class="form-check-input" id="checked_'+permission_name+'" checked onclick="delete_permission('+permission_id+')" type="checkbox"  value=""><label class="form-check-label" for="checked_'+permission_name+'">'+permission_name+'</label></div><br / id="provided_br_'+permission_id+'">');
            }
            else {
                Toastify({
                    text: response['reason'],
                    backgroundColor: "linear-gradient(to right, #F50057, #2F2E41)",
                    className: "error",
                }).showToast();
            }
            
        }
    });

}
//End:: Check Permission

//Begin:: Delete Permission
function delete_permission(permission_id) {
    var unSelectedPermission = document.getElementById("unSelectedPermission_"+permission_id);
    var roleID = $('#role_ID').val();
    $.ajax({
        url: '/admin/delete-permission-from-role',
        method:"GET",
        data:{ 
            permission_id:permission_id,
            roleID: roleID,
        },
        success: function (response) {
            if(response['status'] == 'yes') {
                unSelectedPermission.classList.remove("d-none");
                Toastify({
                    text: response['reason'],
                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                    className: "success",
                }).showToast();
                $("#provided_permission_"+permission_id).remove();
                $("#provided_br_"+permission_id).remove();
                $("#permissionCheckbox"+permission_id).prop("checked", false);
            }
            else {
                Toastify({
                    text: response['reason'],
                    backgroundColor: "linear-gradient(to right, #F50057, #2F2E41)",
                    className: "error",
                }).showToast();
            }
            
        }
    });

}
//End:: Delete Permission

//Begin:: Sidebar Mini
function SidebarColpase() {
    var element = document.getElementById("page-container");
     element.classList.add("sidebar-mini");
}
//End:: Sidebar Mini









