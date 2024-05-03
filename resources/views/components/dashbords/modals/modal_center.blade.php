<div class="modal fade" id="centerForm" tabindex="-1" role="dialog" aria-labelledby="centerFormLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form id="cenForm" method="post" action="/centers/submit" enctype="multipart/form-data">
                    @csrf
                    <input data-ng-if="centerUpdate !== false" type="hidden" name="_method" value="put">
                    <input type="hidden" name="center_id" data-ng-value="list[centerUpdate].center_id">
                    <div class="row">
                        {{-- name --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="fullName">Center Name<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="name" maxlength="120"
                                    data-ng-value="list[centerUpdate].center_name" id="fullName" required />
                            </div>
                        </div>

                        {{-- mobile --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="mobile">Mobile<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="mobile" maxlength="24"
                                    data-ng-value="list[centerUpdate].center_mobile" id="mobile" required />
                            </div>
                        </div>
                        {{-- Whatsapp --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="Whatsapp">Whatsapp</label>
                                <input class="form-control" name="center_whatsapp" type="text"
                                    data-ng-value="list[centerUpdate].center_whatsapp" id="Whatsapp" required />
                            </div>
                        </div>
                        {{-- email --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" name="email" id="exampleInputEmail1"
                                    data-ng-value="centerUpdate !== false ? list[centerUpdate].center_email : ''"
                                    required />
                            </div>
                        </div>

                        {{-- phone --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="phoneT">Phone</label>
                                <input type="text" class="form-control" name="tel" maxlength="24"
                                    data-ng-value="list[centerUpdate].center_tel" id="phoneT" required />
                            </div>
                        </div>

                        {{-- Tax Number --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="TaxNumber">Tax Number</label>
                                <input type="text" class="form-control" name="center_tax" maxlength="24"
                                    data-ng-value="list[centerUpdate].center_tax" id="TaxNumber" required />
                            </div>
                        </div>

                        {{-- Cr Number --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="CrNumber">Cr Number</label>
                                <input type="text" class="form-control" name="center_cr" maxlength="24"
                                    data-ng-value="list[centerUpdate].center_cr" id="CrNumber" required />
                            </div>
                        </div>

                        {{-- logo --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="Logo">Logo</label>
                                <input type="file" class="form-control" name="logo" id="Logo" required />
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
                                    <option data-ng-repeat="state in techModal.states"
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
                                    <option data-ng-repeat="city in techModal.cities" data-ng-value="city.location_id"
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
                                    <option data-ng-repeat="area in techModal.areas" data-ng-value="area.location_id"
                                        data-ng-bind="jsonParse(area.location_name)['en']"></option>
                                </select>
                            </div>
                        </div>
                        {{-- address --}}
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="addressCenter">Address</label>
                                <input type="text" class="form-control" name="address" id="addressCenter"
                                    data-ng-value="centerUpdate !== false ? list[centerUpdate].center_address : ''"
                                    required />
                            </div>
                        </div>

                        <div class="col-12 col-md-12">
                            <div class="mb-3">
                                <input type="search" class="form-control" name="search" placeholder="Search..."
                                    id="search">
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="mb-3">
                                <label for="TechnicianName">Technician Name<b class="text-danger">&ast;</b></label>
                                <select class="form-control" name="technician_name" id="TechnicianName"
                                    required></select>
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
                    $('#cenForm').on('submit', e => e.preventDefault()).validate({
                        rules: {
                            whatsapp: {
                                digits: true
                            },
                            tel: {
                                digits: true
                            },
                            mobile: {
                                digits: true
                            },
                            cr_number: {
                                digits: true
                            },
                            tax_number: {
                                digits: true
                            }
                        },
                        submitHandler: function(form) {
                            console.log(form);
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
                                if (response.status) {
                                    toastr.success('Data processed successfully');
                                    $('#centerForm').modal('hide');
                                    scope.$apply(() => {
                                        if (scope.centerUpdate === false) {
                                            scope.list.unshift(response.data);
                                            scope.dataLoader(true);
                                        } else {
                                            scope.list[scope.centerUpdate] = response.data;
                                            scope.dataLoader(true);
                                        }
                                    });
                                } else toastr.error(response.message);
                            }).fail(function(jqXHR, textStatus, errorThrown) {
                                toastr.error("error");
                            }).always(function() {
                                $(form).find('button').prop('disabled', false);
                            });
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>


{{-- <div class="modal fade" id="add_owner" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="cenOwnerForm" method="post" action="/centers/addOwner/">
                            @csrf
                            <input type="hidden" name="_method" value="put">
                            <input type="hidden" name="center_id" data-ng-value="centers[centerUpdate].id">
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="mb-3">
                                        <input type="search" class="form-control" name="search"
                                            placeholder="Search..." id="search">
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="mb-3">
                                        <label for="TechnicianName">Technician Name<b
                                                class="text-danger">&ast;</b></label>
                                        <select class="form-control" name="technician_name" id="TechnicianName"></select>
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
                            $('#cenOwnerForm').on('submit', e => e.preventDefault()).validate({
                                rules: {
                                    technician_name: {
                                        required: true
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
                                        if (response.status) {
                                            toastr.success('Data processed successfully');
                                            $('#add_owner').modal('hide');
                                            scope.$apply(() => {
                                                if (scope.centerUpdate === false) {
                                                    scope.centers.unshift(response.data);
                                                    scope.dataLoader();
                                                } else {
                                                    scope.centers[scope.centerUpdate] = response.data;
                                                    scope.dataLoader();
                                                }
                                            });
                                        } else toastr.error(response.message);
                                    }).fail(function(jqXHR, textStatus, errorThrown) {
                                        toastr.error("error");
                                    }).always(function() {
                                        $(form).find('button').prop('disabled', false);
                                    });
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div> --}}
