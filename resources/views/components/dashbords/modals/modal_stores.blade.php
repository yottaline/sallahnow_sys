<div class="modal fade" id="storeModal" tabindex="-1" role="dialog" aria-labelledby="storeModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form id="storeFrom" method="post" action="/markets/stores/submit">
                    @csrf
                    <input data-ng-if="updateStore !== false" type="hidden" name="_method" value="put">
                    <input type="hidden" name="store_id" data-ng-value="list[updateStore].store_id">
                    <div class="row">
                        {{-- name --}}
                        <div class="col-12 col-md-12">
                            <div class="mb-3">
                                <label for="StoreName">Store Name<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="name" maxlength="200"
                                    data-ng-value="list[updateStore].store_name" required id="StoreName" required>
                            </div>
                        </div>
                        {{-- official_name --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="OfficialName">Official Name</label>
                                <input class="form-control" name="official_name" type="text"
                                    data-ng-value="list[updateStore].store_official_name" id="OfficialName" required>
                            </div>
                        </div>

                        {{-- mobile --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="mobile">Mobile<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="mobile" maxlength="24"
                                    data-ng-value="list[updateStore].store_mobile" required id="mobile" />
                            </div>
                        </div>


                        {{-- phone --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="phone">Phone<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="phone" maxlength="24"
                                    data-ng-value="list[updateStore].store_phone" required id="phone" />
                            </div>
                        </div>

                        {{-- Tax Number --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="TaxNumber">Tax Number<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="tax_store" maxlength="70"
                                    data-ng-value="list[updateStore].store_tax" id="TaxNumber" required />
                            </div>
                        </div>

                        {{-- Cr Number --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="CrNumber">Commercial Record Number<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="cr_store" maxlength="70"
                                    data-ng-value="list[updateStore].store_cr" id="CrNumber" required />
                            </div>
                        </div>

                        {{-- Cr photo --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="CrPhoto">Commercial Record Photo</label>
                                <input type="file" class="form-control" name="cr_photo" id="CrPhoto" />
                            </div>
                        </div>

                        {{-- country --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label>Country<b class="text-danger">&ast;</b></label>
                                <select name="country_id" id="country" class="form-select" required>
                                    <option value="default">-- select country --</option>
                                    <option data-ng-repeat="country in countries" data-ng-value="country.location_id"
                                        data-ng-bind="jsonParse(country.location_name)['en']"></option>
                                </select>
                            </div>
                        </div>

                        {{-- state --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label>State<b class="text-danger">&ast;</b></label>
                                <select name="state_id" id="state" class="form-select" required>
                                    <option value="default">-- select state --</option>
                                    <option data-ng-repeat="state in storeModal.states"
                                        data-ng-value="state.location_id"
                                        data-ng-bind="jsonParse(state.location_name)['en']"></option>
                                </select>
                            </div>
                        </div>

                        {{-- city --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label>City<b class="text-danger">&ast;</b></label>
                                <select name="city_id" id="city" class="form-select" required>
                                    <option value="default">-- select city --</option>
                                    <option data-ng-repeat="city in storeModal.cities"
                                        data-ng-value="city.location_id"
                                        data-ng-bind="jsonParse(city.location_name)['en']"></option>
                                </select>
                            </div>
                        </div>
                        {{-- area --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label>Arae<b class="text-danger">&ast;</b></label>
                                <select name="area_id" id="area" class="form-select" required>
                                    <option value="default">-- select area --</option>
                                    <option data-ng-repeat="area in storeModal.areas" data-ng-value="area.location_id"
                                        data-ng-bind="jsonParse(area.location_name)['en']"></option>
                                </select>
                            </div>
                        </div>

                        {{-- address --}}
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="addressS">Address</label>
                                <input type="text" class="form-control" name="address" id="addressS"
                                    data-ng-value="list[updateStore].store_address" />
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
                    $('#storeFrom').on('submit', e => e.preventDefault()).validate({
                        rules: {
                            country_id: {
                                notEqual: 'default',
                                required: true
                            },
                            state_id: {
                                notEqual: 'default',
                                required: true
                            },
                            city_id: {
                                notEqual: 'default',
                                required: true
                            },
                            area_id: {
                                notEqual: 'default',
                                required: true
                            },
                            // official_name: {
                            //     digits: true
                            // },
                            phone: {
                                digits: true
                            },
                            mobile: {
                                digits: true
                            },
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

                                        if (scope.updateStore === false) {
                                            // scope.list.unshift(response.data);
                                            scope.list = response.data;
                                            clsForm();
                                            // scope.dataLoader(true);
                                        } else {
                                            scope.list[scope.updateStore] = response.data;
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
                        $('#StoreName').val('');
                        $('#OfficialName').val('');
                        $('#mobile').val('');
                        $('#CrNumber').val('');
                        $('#TaxNumber').val('');
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
                <form method="POST" action="/markets/stores/change_status">
                    @csrf @method('PUT')
                    <input hidden data-ng-value="list[updateStore].store_id"name="store_id">
                    <input hidden data-ng-value="list[updateStore].store_status" name="status">
                    <p class="mb-2">Are you sure you want to change status?</p>
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
                        if (scope.updateStore === false) {
                            // scope.list.unshift(response.data);
                            // scope.dataLoader(true);
                            scope.list = response.data;
                        } else {
                            scope.list[scope.updateStore] = response.data;
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
