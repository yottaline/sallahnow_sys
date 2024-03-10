@extends('index')
@section('title')
    Customers
@endsection
@section('search')
    <form id="searchForm" role="search">
        <input type="search" name="q" class="form-control my-3 my-md-0 rounded-pill" placeholder="Search...">
    </form>
@endsection
@section('content')
    <div class="container-fluid" data-ng-app="myApp" data-ng-controller="myCtrl">
        <div class="row">
            <div class="col-12 col-sm-4 col-lg-3">
                <div class="card card-box">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="roleFilter">Package</label>
                            <select name="" id="" class="form-select">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-8 col-lg-9">
                <div class="card card-box">
                    <div class="card-body">
                        <div class="d-flex">
                            <h5 class="card-title fw-semibold pt-1 me-auto mb-3 text-uppercase">
                                <span class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                    role="status"></span><span>CUSTOMERS</span>
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                    data-ng-click="setCustomer(false)"></button>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>
                        </div>

                        <h5 data-ng-if="q" class="text-dark">Result of <span class="text-primary" data-ng-bind="q"></span>
                        </h5>

                        <div data-ng-if="customers.length" class="table-responsive">
                            <table class="table table-hover" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Customre</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Register</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="customer in customers track by $index">
                                        <td data-ng-bind="customer.customer_code"
                                            class="text-center small font-monospace text-uppercase"></td>
                                        <td>
                                            <span data-ng-bind="customer.customer_name" class="fw-bold"></span><br>
                                            <small data-ng-if="customer.customer_mobile"
                                                class="me-1 db-inline-block dir-ltr font-monospace badge bg-primary">
                                                <i class="bi bi-phone me-1"></i>
                                                <span data-ng-bind="customer.customer_mobile" class="fw-normal"></span>
                                            </small>
                                            <small data-ng-if="customer.customer_email"
                                                class="db-inline-block dir-ltr font-monospace badge bg-primary">
                                                <i class="bi bi-envelope-at me-1"></i>
                                                <span data-ng-bind="customer.customer_email" class="fw-normal"></span>
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-<%activeOb.color[customer.customer_active]%> rounded-pill font-monospace p-2"><%activeOb.name[customer.customer_active]%></span>
                                        </td>
                                        <td class="text-center">-</td>
                                        <td class="col-fit">
                                            <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                data-ng-click="setCustomer($index)"></button>
                                            <button class="btn btn-outline-warning btn-circle bi bi-question"
                                                data-ng-click="editActive($index)"></button>
                                            <button class="btn btn-outline-dark btn-circle bi bi-pencil-fill"
                                                data-ng-click="addNote($index)"></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div data-ng-if="!customers.length" class="text-center text-secondary py-5">
                            <i class="bi bi-exclamation-circle display-3"></i>
                            <h5 class="">No records</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="techModal" tabindex="-1" role="dialog" aria-labelledby="techModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="techForm" method="post" action="/customers/submit">
                            @csrf
                            <input data-ng-if="customerUpdate !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="customer_id" data-ng-value="customers[customerUpdate].customer_id">
                            <div class="row">
                                {{-- name --}}
                                <div class="col-12 col-md-12">
                                    <div class="mb-3">
                                        <label for="fullName">Full Name<b class="text-danger">&ast;</b></label>
                                        <input type="text" class="form-control" name="customer_name" maxlength="120"
                                            data-ng-value="customers[customerUpdate].customer_name" required
                                            id="fullName">
                                    </div>
                                </div>

                                {{-- mobile --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="mobile">Mobile<b class="text-danger">&ast;</b></label>
                                        <input type="text" class="form-control" name="customer_mobile" maxlength="24"
                                            data-ng-value="customers[customerUpdate].customer_mobile" required
                                            id="mobile" />
                                    </div>
                                </div>
                                {{-- email --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="email" class="form-control" name="customer_email"
                                            id="exampleInputEmail1"
                                            data-ng-value="customerUpdate !== false ? customers[customerUpdate].customer_email : ''">
                                    </div>
                                </div>

                                {{-- country --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label>Country<b class="text-danger">&ast;</b></label>
                                        <select name="customer_country" class="form-control" required>
                                            <option value="">-- select country --</option>
                                            <option value="1">sudan</option>
                                            <option value="2">Egypt</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- state --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label>State<b class="text-danger">&ast;</b></label>
                                        <select name="customer_state" class="form-control" required>
                                            <option value="">-- select state --</option>
                                            <option value="1">Khartoum</option>
                                            <option value="2">Cairo</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- city --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label>City<b class="text-danger">&ast;</b></label>
                                        <select name="customer_city" class="form-control" required>
                                            <option value="">-- select city --</option>
                                            <option value="1">Khartoum</option>
                                            <option value="2">Cairo</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- area --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label>Arae<b class="text-danger">&ast;</b></label>
                                        <select name="customer_area" class="form-control" required>
                                            <option value="">-- select area --</option>
                                            <option value="1">Khartoum, Omdurman</option>
                                            <option value="2">Cairo, Maadi</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- address --}}
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="addressCustomer">Address</label>
                                        <input type="text" class="form-control" name="customer_address"
                                            id="addressCustomer"
                                            data-ng-value="customerUpdate !== false ? customers[customerUpdate].customer_address : ''" />
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
                                            $('#techModal').modal('hide');
                                            scope.$apply(() => {
                                                if (scope.customerUpdate === false) {
                                                    scope.customers.unshift(response.data);
                                                    scope.dataLoader();
                                                } else {
                                                    scope.customers[scope.customerUpdate] = response.data;
                                                    scope.dataLoader();
                                                }
                                            });
                                        } else toastr.error(response.message);
                                    }).fail(function(jqXHR, textStatus, errorThrown) {
                                        toastr.error("error");
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
                        </script>
                    </div>
                </div>
            </div>
        </div>

        {{-- add - note  --}}
        <div class="modal fade" id="addNoteForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="/customers/update_note/">
                            @csrf
                            <input data-ng-if="customerUpdate !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="customer_id"
                                data-ng-value="customers[customerUpdate].customer_id">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label>Customer Note<b class="text-danger">&ast;</b></label>
                                        <textarea class="form-control" rows="8" cols="30"
                                            data-ng-value="customers[customerUpdate].customer_notes" name="note"></textarea>
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

        {{-- change customer_active --}}
        <div class="modal fade" id="customerActive" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="/customers/update_active/">
                            @csrf
                            <input data-ng-if="customerUpdate !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="customer_id"
                                data-ng-value="customers[customerUpdate].customer_id">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label>Customer Note<b class="text-danger">&ast;</b></label>
                                        <select name="active" id="" class="form-control">
                                            <option value="">-- SELECT CUSTOMER STATSUS --</option>
                                            <option value="1">Active</option>
                                            <option value="0">Bloced</option>
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
    @endsection
    @section('js')
        <script>
            var scope, app = angular.module('myApp', [], function($interpolateProvider) {
                $interpolateProvider.startSymbol('<%');
                $interpolateProvider.endSymbol('%>');
            });

            app.controller('myCtrl', function($scope) {
                $('.loading-spinner').hide();
                $scope.activeOb = {
                    name: ['Bloced', 'Active'],
                    color: ['danger', 'success']
                };
                $scope.q = '';
                $scope.customerUpdate = false;
                $scope.customers = [];
                $scope.page = 1;
                $scope.dataLoader = function(reload = false) {
                    $('.loading-spinner').show();
                    if (reload) {
                        $scope.page = 1;
                    }
                    $.post("/customers/load", {
                        q: $scope.q,
                        page: $scope.page,
                        limit: 24,
                        _token: '{{ csrf_token() }}'
                    }, function(data) {
                        $('.loading-spinner').hide();
                        $scope.$apply(() => {
                            $scope.customers = data;
                            $scope.page++;
                        });
                    }, 'json');
                }
                $scope.setCustomer = (indx) => {
                    $scope.customerUpdate = indx;
                    $('#techModal').modal('show');
                };
                $scope.editActive = (index) => {
                    $scope.customerUpdate = index;
                    $('#customerActive').modal('show');
                };

                $scope.addNote = (index) => {
                    $scope.customerUpdate = index;
                    $('#addNoteForm').modal('show');
                }
                $scope.dataLoader();
                scope = $scope;
            });

            // update note
            $(function() {
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
                                    scope.customers.unshift(response.data);
                                    scope.dataLoader(true);
                                } else {
                                    scope.customers[scope.customerUpdate] = response.data;
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
            });

            // change active
            $(function() {
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
                                    scope.customers.unshift(response.data);
                                    scope.dataLoader(true);
                                } else {
                                    scope.customers[scope.customerUpdate] = response.data;
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
            });

            $(function() {
                $('#searchForm').on('submit', function(e) {
                    e.preventDefault();
                    scope.$apply(() => scope.q = $(this).find('input').val());
                    scope.dataLoader(true);
                });
            });
        </script>
    @endsection
