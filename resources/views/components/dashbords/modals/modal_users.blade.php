<!-- start add new user  Modal -->
<div class="modal fade" id="useForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form method="POST" action="/users/submit/">
                    @csrf
                    <input data-ng-if="updateUser !== false" type="hidden" name="_method" value="put">
                    <input type="hidden" name="user_id" data-ng-value="updateUser !== false ? list[updateUser].id : 0">
                    <div class="mb-3">
                        <label for="fullName">Full Name<b class="text-danger">&ast;</b></label>
                        <input type="text" class="form-control" name="name" maxlength="120" id="fullName"
                            required data-ng-value="updateUser !== false ? list[updateUser].user_name : ''">
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="mobiel">Mobile<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="mobile" maxlength="24" id="mobiel"
                                    data-ng-value="updateUser !== false ? list[updateUser].user_mobile : ''">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" name="email" id="exampleInputEmail1"
                                    data-ng-value="updateUser !== false ? list[updateUser].user_email : ''">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" name="password" id="exampleInputPassword1">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="exampleInputPassword2">Password Confirmation</label>
                                <input type="password" class="form-control" name="password_co"
                                    id="exampleInputPassword2">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="role">Roles</label>
                                <select name="role_id" class="form-control" id="role">
                                    <option
                                        value=""data-ng-value="updateUser !== false ? list[updateUser].ugroup_name : ''"
                                        data-ng-bind="updateUser !== false ? list[updateUser].ugroup_name : ''">
                                    </option>
                                    <option data-ng-repeat="role in roles" data-ng-value="role.ugroup_id"
                                        data-ng-bind="role.ugroup_name"></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex">
                        <button type="button" class="btn btn-outline-secondary me-auto"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $("#useForm form").on("submit", function(e) {
        e.preventDefault();
        var form = $(this),
            formData = new FormData(this),
            action = form.attr("action"),
            method = form.attr("method"),
            controls = form.find("button, input"),
            spinner = $("#locationModal .loading-spinner");
        spinner.show();
        controls.prop("disabled", true);
        $.ajax({
                url: action,
                type: method,
                data: formData,
                processData: false,
                contentType: false,
            })
            .done(function(data, textStatus, jqXHR) {
                var response = JSON.parse(data);
                if (response.status) {
                    toastr.success("Data processed successfully");
                    $("#useForm").modal("hide");
                    scope.$apply(() => {
                        if (scope.updateUser === false) {
                            scope.list.unshift(response.data);
                            scope.dataLoader(true);
                        } else {
                            scope.list[scope.updateUser] = response.data;
                            scope.dataLoader(true);
                        }
                    });
                } else toastr.error(response.message);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                toastr.error("error");
                controls.log(jqXHR.responseJSON.message);
                $("#useForm").modal("hide");
            })
            .always(function() {
                spinner.hide();
                controls.prop("disabled", false);
            });
    });
</script>
<!-- end add new user  Modal -->


<!-- start edit user active  Modal -->
<div class="modal fade modal-sm" id="edit_active" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form method="POST" action="/users/update/active/">
                    @csrf @method('PUT')
                    <input hidden data-ng-value="list[updateUser].id" name="user_id">
                    <input hidden data-ng-value="list[updateUser].user_active" name="active">
                    <p class="mb-2">Are you sure you want to change status the user?</p>
                    <div class="d-flex mt-3">
                        <button type="button" class="btn btn-outline-secondary me-auto"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success">Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $("#edit_active form").on("submit", function(e) {
        e.preventDefault();
        var form = $(this),
            formData = new FormData(this),
            action = form.attr("action"),
            method = form.attr("method"),
            controls = form.find("button, input"),
            spinner = $("#locationModal .loading-spinner");
        spinner.show();
        controls.prop("disabled", true);
        $.ajax({
                url: action,
                type: method,
                data: formData,
                processData: false,
                contentType: false,
            })
            .done(function(data, textStatus, jqXHR) {
                var response = JSON.parse(data);
                if (response.status) {
                    toastr.success("Data processed successfully");
                    $("#edit_active").modal("hide");
                    scope.$apply(() => {
                        if (scope.updateUser === false) {
                            scope.list.unshift(response.data);
                            // scope.dataLoader(true);
                        } else {
                            scope.list[scope.updateUser] = response.data;
                            // scope.dataLoader(true);
                        }
                    });
                } else toastr.error(response.message);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                toastr.error(response.message);
                controls.log(jqXHR.responseJSON.message);
                $("#useForm").modal("hide");
            })
            .always(function() {
                spinner.hide();
                controls.prop("disabled", false);
            });
    });
</script>
<!-- end edit user active Modal -->

<!-- start delete user  Modal -->
{{-- <div class="modal fade" id="delete_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form method="POST" action="{{ route('user_delete') }}">
                    @csrf
                    @method('DELETE')
                    <input type="text" hidden data-ng-value="users[userId].id" name="user_id">
                    <p class="mb-2">Are you sure you want to delete?</p>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div> --}}
<!-- end delete user Modal -->
