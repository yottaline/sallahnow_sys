@extends('index')
@section('title')
    Centers
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
                            <label for="roleFilter">Create By</label>
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
                                    role="status"></span><span>CENTERS</span>
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                    data-ng-click="setCenter(false)"></button>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>
                        </div>

                        {{-- <h5 data-ng-if="q" class="text-dark">Result of <span class="text-primary" data-ng-bind="q"></span>
                        </h5> --}}

                        <div data-ng-if="list.length" class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Center Name</th>
                                        <th class="text-center">Owner</th>
                                        <th class="text-center">Logo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="center in list track by $index">
                                        <td data-ng-bind="center.center_id"
                                            class="text-center small font-monospace text-uppercase"></td>
                                        <td>
                                            <span data-ng-bind="center.center_name" class="fw-bold"></span><br>
                                            <small data-ng-if="+center.center_mobile"
                                                class="me-1 db-inline-block dir-ltr font-monospace badge bg-primary">
                                                <i class="bi bi-phone me-1"></i>
                                                <span data-ng-bind="center.center_mobile" class="fw-normal"></span>
                                            </small>
                                            <small data-ng-if="+center.center_tel"
                                                class="me-1 db-inline-block dir-ltr font-monospace badge bg-primary">
                                                <i class="bi bi-telephone me-1"></i>
                                                <span data-ng-bind="center.center_tel" class="fw-normal"></span>
                                            </small>
                                            <small data-ng-if="center.center_email"
                                                class="db-inline-block dir-ltr font-monospace badge bg-primary">
                                                <i class="bi bi-envelope-at me-1"></i>
                                                <span data-ng-bind="center.center_email" class="fw-normal"></span>
                                            </small>
                                        </td>
                                        <td class="text-center" data-ng-bind="center.tech_name"></td>
                                        <td class="text-center">
                                            <img src="{{ asset('/Image/Centers/') }}/<% center.center_logo %>"
                                                alt="" srcset="" width="30px">
                                        </td>
                                        <td class="col-fit">
                                            <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                data-ng-click="setCenter($index)"></button>
                                            {{-- <button class="btn btn-outline-success btn-circle bi bi-person-fill-add"
                                                data-ng-click="addOwnaer($index)"></button> --}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        @include('layouts.loade')

                    </div>
                </div>
            </div>
        </div>

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
                                        <input type="email" class="form-control" name="email"
                                            id="exampleInputEmail1"
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
                                        <input type="file" class="form-control" name="logo" id="Logo"
                                            required />
                                    </div>
                                </div>

                                {{-- country --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label>Country<b class="text-danger">&ast;</b></label>
                                        <select name="country_id" id="country" class="form-select" required>
                                            <option value="default">-- select country --</option>
                                            <option data-ng-repeat="country in countries"
                                                data-ng-value="country.location_id"
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
                                            <option data-ng-repeat="city in techModal.cities"
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
                                            <option data-ng-repeat="area in techModal.areas"
                                                data-ng-value="area.location_id"
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
                                        <input type="search" class="form-control" name="search"
                                            placeholder="Search..." id="search">
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="mb-3">
                                        <label for="TechnicianName">Technician Name<b
                                                class="text-danger">&ast;</b></label>
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
    @endsection
    @section('js')
        <script>
            var scope, app = angular.module('myApp', [], function($interpolateProvider) {
                $interpolateProvider.startSymbol('<%');
                $interpolateProvider.endSymbol('%>');
            });

            app.controller('myCtrl', function($scope) {
                $('.loading-spinner').hide();
                $scope.q = '';
                $scope.noMore = false;
                $scope.loading = false;
                $scope.centerUpdate = false;
                $scope.technicianId = 0;
                $scope.countries = <?= json_encode($countries) ?>;
                $scope.jsonParse = (str) => JSON.parse(str);
                $scope.list = [];
                $scope.last_id = 0;
                $scope.technicianName = false;
                $scope.techModal = {
                    states: [],
                    cities: [],
                    areas: [],
                };
                $scope.dataLoader = function(reload = false) {

                    if (reload) {
                        $scope.list = [];
                        $scope.last_id = 0;
                        $scope.noMore = false;
                    }
                    if ($scope.noMore) return;
                    $scope.loading = true;

                    $('.loading-spinner').show();

                    $.post("/centers/load", {
                        last_id: $scope.last_id,
                        limit: limit,
                        q: $scope.q,
                        _token: '{{ csrf_token() }}'
                    }, function(data) {
                        $('.loading-spinner').hide();
                        var ln = data.length;
                        $scope.$apply(() => {
                            $scope.loading = false;
                            if (ln) {
                                $scope.noMore = ln < limit;
                                $scope.list = data;
                                console.log(data)
                                $scope.last_id = data[ln - 1].center_id;
                            };
                        });
                    }, 'json');
                }

                $scope.setCenter = (indx) => {
                    $scope.centerUpdate = indx;
                    $('#centerForm').modal('show');
                };
                $scope.addOwnaer = (index) => {
                    $scope.centerUpdate = index;
                    $('#add_owner').modal('show');
                }

                $scope.dataLoader();
                scope = $scope;
            });

            $('#search').on('change', function() {
                var idState = this.value;
                console.log(idState);
                $('#TechnicianName').html('');
                $.ajax({
                    url: 'getTechnician/' + idState,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        $.each(res, function(key, value) {
                            $('#TechnicianName').append('<option id="class" value="' + value
                                .tech_id +
                                '">' + value.tech_name + '</option>');
                        });
                    }
                });
            });

            $(function() {
                $('#searchForm').on('submit', function(e) {
                    e.preventDefault();
                    scope.$apply(() => scope.q = $(this).find('input').val());
                    scope.dataLoader(true);
                });
                $('#country').on('change', function() {
                    var val = $(this).val();
                    scope.$apply(function() {
                        scope.techModal.states = [];
                        scope.techModal.cities = [];
                        scope.techModal.areas = [];
                    });
                    locationsLoad(2, val, function(data) {
                        scope.$apply(() => scope.techModal.states = data);
                    });
                });

                $('#state').on('change', function() {
                    var val = $(this).val();
                    scope.$apply(function() {
                        scope.techModal.cities = [];
                        scope.techModal.areas = [];
                    });
                    locationsLoad(3, val, function(data) {
                        scope.$apply(() => scope.techModal.cities = data);
                    });
                });

                $('#city').on('change', function() {
                    var val = $(this).val();
                    scope.$apply(function() {
                        scope.techModal.areas = [];
                    });

                    locationsLoad(4, val, function(data) {
                        scope.$apply(() => scope.techModal.areas = data);
                    });
                });
            });

            function locationsLoad(type, parent, callback) {
                $.post('/locations/load/', {
                    type: type,
                    parent: parent,
                    _token: '{{ csrf_token() }}'
                }, callback, 'json');
            }
        </script>
    @endsection
