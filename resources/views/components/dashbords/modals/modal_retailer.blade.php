<div class="modal fade" id="storeModal" tabindex="-1" role="dialog" aria-labelledby="storeModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form id="retailerFrom" method="post" action="/markets/retailers/submit">
                    @csrf
                    <input data-ng-if="updateRetailer !== false" type="hidden" name="_method" value="put">
                    <input type="hidden" name="retailer_id" data-ng-value="list[updateRetailer].retailer_id">
                    <div class="row">
                        {{-- name --}}
                        <div class="col-12 col-md-12">
                            <div class="mb-3">
                                <label for="RetailerName">Name<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="name" maxlength="200"
                                    data-ng-value="list[updateRetailer].retailer_name" required id="RetailerName"
                                    required>
                            </div>
                        </div>

                        {{-- phone --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="phone">Phone<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="phone" maxlength="24"
                                    data-ng-value="list[updateRetailer].retailer_phone" required id="phone" />
                            </div>
                        </div>


                        {{-- stores --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label>Store<b class="text-danger">&ast;</b></label>
                                <select name="store" id="store" class="form-select" required>
                                    <option value="default">-- select store --</option>
                                    <option data-ng-repeat="store in stores" data-ng-value="store.store_id"
                                        data-ng-bind="store.store_name"></option>
                                </select>
                            </div>
                        </div>



                        {{-- Email --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="retailerEmail">Email<b class="text-danger">&ast;</b></label>
                                <input type="email" class="form-control" name="email"
                                    data-ng-value="list[updateRetailer].retailer_email" id="retailerEmail" required />
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="retailerPass">Password<b class="text-danger">&ast;</b></label>
                                <input type="password" class="form-control" name="password"
                                    data-ng-value="list[updateRetailer].retaile_password" id="retailerPass" />
                            </div>
                        </div>


                        <div class="col-6 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" name="admin"
                                    value="1" ng-checked="+list[updateRetailer].retailer_admin" id="retailerAdmin">
                                <label class="form-check-label" for="retailerAdmin">Is Admin</label>
                            </div>
                        </div>

                        <div class="col-6 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" name="active"
                                    value="1" ng-checked="+list[updateRetailer].retailer_active"
                                    id="retailerActive">
                                <label class="form-check-label" for="retailerActive">Account status</label>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex">
                        <button type="button" class="btn btn-outline-secondary me-auto btn-sm"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
                    </div>
                </form>
                <script>
                    $('#retailerFrom').on('submit', e => e.preventDefault()).validate({
                        rules: {
                            store: {
                                notEqual: 'default',
                                required: true
                            },
                            name: {
                                required: true
                            },
                            email: {
                                required: true
                            },
                            // password: {
                            //     required: true
                            // },
                            phone: {
                                digits: true,
                                required: true
                            }
                        },
                        submitHandler: function(form) {
                            var formData = new FormData(form),
                                action = $(form).attr('action'),
                                method = $(form).attr('method');

                            $(form).find('button').prop('disabled', true);
                            $.ajax({
                                url: action,
                                type: method,
                                data: formData,
                                processData: false,
                                contentType: false,
                            }).done(function(data, textStatus, jqXHR) {
                                var response = JSON.parse(data);
                                console.log(response);
                                if (response.status) {
                                    toastr.success('Data processed successfully');
                                    $('#storeModal').modal('hide');
                                    scope.$apply(() => {

                                        if (scope.updateRetailer === false) {
                                            scope.list.unshift(response.data);
                                            // scope.list = response.data;
                                            clsForm();
                                            scope.dataLoader();
                                        } else {
                                            scope.list[scope.updateRetailer] = response.data;
                                            // scope.dataLoader(true);
                                        }
                                    });
                                } else toastr.error(response.message);
                            }).fail(function(jqXHR, textStatus, errorThrown) {
                                // console.log()
                                toastr.error(jqXHR.responseJSON.message);
                                $('#storeModal').modal('hide');
                            }).always(function() {
                                $(form).find('button').prop('disabled', false);
                            });
                        }
                    });

                    function clsForm() {
                        $('#RetailerName').val('');
                        $('#OfficialName').val('');
                        $('#mobile').val('');
                        $('#retailerPass').val('');
                        $('#retailerEmail').val('');
                        $('#phone').val('');
                        $('#addressS').val('');
                    }
                </script>
            </div>
        </div>
    </div>
</div>


{{-- edit status --}}
<div class="modal fade modal-sm" id="edit_active" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form method="POST" action="/markets/retailers/change">
                    @csrf @method('PUT')
                    <input hidden data-ng-value="list[updateRetailer].retailer_id" name="id">
                    <p class="mb-2">Are you sure you want to Approved retailer account ?</p>
                    <div class="d-flex mt-3">
                        <button type="button" class="btn btn-outline-secondary me-auto"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success">Sure</button>
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
                        if (scope.updateRetailer === false) {
                            // scope.list.unshift(response.data);
                            // scope.dataLoader(true);
                            scope.list = response.data;
                        } else {
                            scope.list[scope.updateRetailer] = response.data;
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
