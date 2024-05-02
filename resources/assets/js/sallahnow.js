let edit_permission = document.getElementById("edit_permission");

edit_permission.addEventListener("shown.bs.modal", function (event) {
    let button = $(event.relatedTarget);
    let permission_id = button.data("permission_id");
    let modal = $(this);
    modal.find(".modal-body #permission_id").val(permission_id);
});
