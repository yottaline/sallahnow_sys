<div class="modal fade" id="techModal" tabindex="-1" role="dialog" aria-labelledby="techModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form id="techForm" method="post" action="/technicians/submit">
                    @csrf
                    <input data-ng-if="updateTechnician !== false" type="hidden" name="_method" value="put">
                    <input type="hidden" name="technician_id" data-ng-value="list[updateTechnician].tech_id">
                    <div class="row">
                        {{-- name --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="fullName">Full Name<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="name" maxlength="120"
                                    data-ng-value="list[updateTechnician].tech_name" required id="fullName">
                            </div>
                        </div>
                        {{-- identification --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="identificationT">Identification</label>
                                <input class="form-control" name="identification" type="text"
                                    data-ng-value="list[updateTechnician].tech_identification" id="IdentificationT">
                            </div>
                        </div>

                        {{-- mobile --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="mobile">Mobile<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="mobile" maxlength="24"
                                    data-ng-value="list[updateTechnician].tech_mobile" required id="mobile" />
                            </div>
                        </div>

                        {{-- email --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" name="email" id="exampleInputEmail1"
                                    data-ng-value="updateTechnician !== false ? list[updateTechnician].tech_email : ''">
                            </div>
                        </div>

                        {{-- phone --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="phoneT">Phone</label>
                                <input type="text" class="form-control" name="tel" maxlength="24"
                                    data-ng-value="list[updateTechnician].tech_tel" id="phoneT" />
                            </div>
                        </div>

                        {{-- birthday --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="BirthdayT">Birthday</label>
                                <input id="inputBirthdate" type="text" class="form-control text-center"
                                    name="birth" maxlength="10" data-ng-value="list[updateTechnician].tech_birth"
                                    id="BirthdayT">
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
                                    <option data-ng-repeat="state in techModal.states" data-ng-value="state.location_id"
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
                                <label for="addressTechnician">Address</label>
                                <input type="text" class="form-control" name="address" id="addressTechnician"
                                    data-ng-value="list[updateTechnician].tech_address" />
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
                    $('#techForm').on('submit', e => e.preventDefault()).validate({
                        rules: {
                            country_id: {
                                notEqual: 'default'
                            },
                            state_id: {
                                notEqual: 'default'
                            },
                            city_id: {
                                notEqual: 'default'
                            },
                            area_id: {
                                notEqual: 'default'
                            },
                            identification: {
                                digits: true
                            },
                            tel: {
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
                                if (response.status) {
                                    toastr.success('Data processed successfully');
                                    $('#techModal').modal('hide');
                                    scope.$apply(() => {
                                        if (scope.updateTechnician === false) {
                                            // scope.list.unshift(response.data);
                                            scope.list = response.data;
                                            clsForm();
                                            // scope.dataLoader(true);
                                        } else {
                                            scope.list[scope.updateTechnician] = response.data;
                                            // scope.dataLoader(true);
                                        }
                                    });
                                } else toastr.error(response.message);
                            }).fail(function(jqXHR, textStatus, errorThrown) {
                                // console.log()
                                toastr.error(jqXHR.responseJSON.message);
                                $('#techModal').modal('hide');
                            }).always(function() {
                                $(form).find('button').prop('disabled', false);
                            });
                        }
                    });

                    $(function() {
                        $("#inputBirthdate").datetimepicker($.extend({}, dtp_opt, {
                            showTodayButton: false,
                            format: "YYYY-MM-DD",
                        }));
                    });

                    function clsForm() {
                        $('#fullName').val('');
                        $('#IdentificationT').val('');
                        $('#mobile').val('');
                        $('#exampleInputEmail1').val('');
                        $('#phoneT').val('');
                        $('#BirthdayT').val('');
                        $('#addressTechnician').val('');
                    }
                </script>
            </div>
        </div>
    </div>
</div>
