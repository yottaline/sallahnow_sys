{{-- add customer --}}
<div class="modal fade" id="custModal" tabindex="-1" role="dialog" aria-labelledby="custModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form id="custmForm" method="post" action="/customers/submit">
                    @csrf
                    <input data-ng-if="customerUpdate !== false" type="hidden" name="_method" value="put">
                    <input type="hidden" name="customer_id" data-ng-value="list[customerUpdate].customer_id">
                    <div class="row">
                        {{-- name --}}
                        <div class="col-12 col-md-12">
                            <div class="mb-3">
                                <label for="fullName">Full Name<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="customer_name" maxlength="120"
                                    data-ng-value="list[customerUpdate].customer_name" required id="fullName">
                            </div>
                        </div>

                        {{-- mobile --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="mobile">Mobile<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="customer_mobile" maxlength="24"
                                    data-ng-value="list[customerUpdate].customer_mobile" required id="mobile" />
                            </div>
                        </div>

                        {{-- email --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" name="customer_email" id="exampleInputEmail1"
                                    data-ng-value="list[customerUpdate].customer_email">
                            </div>
                        </div>

                        {{-- country --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label>Country<b class="text-danger">&ast;</b></label>
                                <select name="customer_country" id="country" class="form-select" required>
                                    <option value="">-- SELECT COUNTRY --</option>
                                    <option data-ng-repeat="country in countries" data-ng-value="country.location_id"
                                        data-ng-bind="jsonParse(country.location_name)['ar']"></option>
                                </select>
                            </div>
                        </div>
                        {{-- state --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label>State<b class="text-danger">&ast;</b></label>
                                <select name="customer_state" id="state" class="form-select" required>
                                    <option value="">-- select state --</option>
                                    <option data-ng-repeat="city in cousModal.states" data-ng-value="city.location_id"
                                        data-ng-bind="jsonParse(city.location_name)['en']"></option>
                                </select>
                            </div>
                        </div>

                        {{-- city --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label>City<b class="text-danger">&ast;</b></label>
                                <select name="customer_city" id="city" class="form-select" required>
                                    <option value="">-- select city --</option>
                                    <option data-ng-repeat="city in cousModal.cities" data-ng-value="city.location_id"
                                        data-ng-bind="jsonParse(city.location_name)['en']"></option>
                                </select>
                            </div>
                        </div>
                        {{-- area --}}
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label>Arae<b class="text-danger">&ast;</b></label>
                                <select name="customer_area" id="area" class="form-select" required>
                                    <option value="">-- select area --</option>
                                    <option data-ng-repeat="city in cousModal.areas" data-ng-value="city.location_id"
                                        data-ng-bind="jsonParse(city.location_name)['en']"></option>
                                </select>
                            </div>
                        </div>

                        {{-- address --}}
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="addressCustomer">Address</label>
                                <input type="text" class="form-control" name="customer_address" id="addressCustomer"
                                    data-ng-value="list[customerUpdate].customer_address" />
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
                    $('#custmForm').on('submit', e => e.preventDefault()).validate({
                        rules: {
                            customer_mobile: {
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
                                    $('#custModal').modal('hide');
                                    scope.$apply(() => {
                                        if (scope.customerUpdate === false) {
                                            // scope.list.unshift(response.data);
                                            // scope.dataLoader(true);
                                            scope.list = response.data;
                                        } else {
                                            scope.list[scope.customerUpdate] = response.data;
                                            // scope.dataLoader(true);
                                        }
                                    });
                                } else toastr.error(response.message);
                            }).fail(function(jqXHR, textStatus, errorThrown) {
                                toastr.error("error");
                                $('#custModal').modal('hide');
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
                        $('#mobile').val('');
                        $('#exampleInputEmail1').val('');
                        $('#addressCustomer').val('')
                    }
                </script>
            </div>
        </div>
    </div>
</div>


{{-- add - note  --}}
<div class="modal fade" id="addNoteForm" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form method="POST" action="/customers/update_note/">
                    @csrf
                    <input data-ng-if="customerUpdate !== false" type="hidden" name="_method" value="put">
                    <input type="hidden" name="customer_id" data-ng-value="list[customerUpdate].customer_id">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label>Customer Note<b class="text-danger">&ast;</b></label>
                                <textarea class="form-control" rows="8" cols="30" data-ng-value="list[customerUpdate].customer_notes"
                                    name="note"></textarea>
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
    $('#addNoteForm form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this),
            formData = new FormData(this),
            action = form.attr('action'),
            method = form.attr('method'),
            controls = form.find('button, input'),
            spinner = $('#locationModal .loading-spinner');
        spinner.show();
        controls.prop('disabled', true);
        $.ajax({
            url: action,
            type: method,
            data: formData,
            processData: false,
            contentType: false,
        }).done(function(data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response.status) {
                toastr.success('Note added successfully');
                $('#addNoteForm').modal('hide');
                scope.$apply(() => {
                    if (scope.customerUpdate === false) {
                        scope.list.unshift(response.data);
                        scope.dataLoader(true);
                    } else {
                        scope.list[scope.customerUpdate] = response.data;
                        scope.dataLoader(true);
                    }
                });
            } else toastr.error("Error");
        }).fail(function(jqXHR, textStatus, errorThrown) {
            toastr.error("error");
            controls.log(jqXHR.responseJSON.message);
            $('#useForm').modal('hide');
        }).always(function() {
            spinner.hide();
            controls.prop('disabled', false);
        });

    })
</script>




{{-- change customer_active --}}
<div class="modal fade" id="customerActive" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form method="POST" action="/customers/update_active">
                    @csrf
                    <input data-ng-if="customerUpdate !== false" type="hidden" name="_method" value="put">
                    <input type="hidden" name="customer_id" data-ng-value="list[customerUpdate].customer_id">
                    <input type="hidden" name="customer_active"
                        data-ng-value="list[customerUpdate].customer_active">
                    <div class="row">
                        <div class="col-12">
                            <p class="mb-2">Are you sure you want to change status the customer?</p>
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
    $('#customerActive form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this),
            formData = new FormData(this),
            action = form.attr('action'),
            method = form.attr('method'),
            controls = form.find('button, input'),
            spinner = $('#locationModal .loading-spinner');
        spinner.show();
        controls.prop('disabled', true);
        $.ajax({
            url: action,
            type: method,
            data: formData,
            processData: false,
            contentType: false,
        }).done(function(data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response.status) {
                toastr.success('Actived successfully');
                $('#customerActive').modal('hide');
                scope.$apply(() => {
                    if (scope.customerUpdate === false) {
                        // scope.list.unshift(response.data);
                        scope.list = response.data;
                        // scope.dataLoader(true);
                    } else {
                        scope.list[scope.customerUpdate] = response.data;
                        // scope.dataLoader(true);
                    }
                });
            } else toastr.error("Error");
        }).fail(function(jqXHR, textStatus, errorThrown) {
            toastr.error("error");
            controls.log(jqXHR.responseJSON.message);
            $('#useForm').modal('hide');
        }).always(function() {
            spinner.hide();
            controls.prop('disabled', false);
        });

    })
</script>
