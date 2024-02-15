@extends('index')
@section('title')
    Location
@endsection
@section('style')
    <style>
        .list-group {
            height: 240px;
            overflow-y: auto;
        }

        #wrapper .list-group-item.active {
            background-color: #f2f2f2;
            color: #000;
            font-weight: bold;
            border-color: #ccc;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid" data-ng-app="ngApp" data-ng-controller="ngCtrl">
        <div id="locationsSection" class="card card-box">
            <div class="card-body">
                <h5 class="card-title fw-bold text-uppercase">Locations</h5>
                <div class="row">
                    <div id="countriesBox" class="col-12 col-sm-6 col-lg-3">
                        <div class="list-box border p-3">
                            <div class="d-flex">
                                <h6 class="fw-bold me-auto">
                                    <small class="loading-spinner spinner-border spinner-border-sm text-warning"
                                        role="status"></small>
                                    <span>Countries</span>
                                </h6>
                                <a href="" class="link-primary bi bi-plus-circle" data-bs-toggle="modal"
                                    data-bs-target="#locationModal" data-ng-click="locationModal(1, 0)"></a>
                            </div>
                            <ul data-ng-if="countries.length" class="list-group list-group-flush">
                                <li data-ng-repeat="c in countries" class="list-group-item list-group-item-action d-flex"
                                    data-ng-class="activeCountry == $index ? 'active' : ''">
                                    <span data-ng-bind="jsonParse(c.location_name).en" class="me-auto"></span>
                                    <a href="" class="link-primary bi bi-eye me-2"
                                        data-ng-click="toggleVisibility($index)"></a>
                                    <a href="" class="link-primary bi bi-chevron-right"
                                        data-ng-click="setActive('activeCountry', $index, 'states', 'countries')"></a>
                                </li>
                            </ul>
                            <div data-ng-if="!countries.length" class="py-5 text-center">
                                <h1 style="font-size: 90px"><i class="bi bi-info-circle text-secondary"></i></h1>
                                <h6 class="text-secondary">No records</h6>
                            </div>
                        </div>
                    </div>

                    <div id="statesBox" class="col-12 col-sm-6 col-lg-3">
                        <div class="list-box border p-3">
                            <div class="d-flex">
                                <h6 class="fw-bold me-auto">
                                    <small class="loading-spinner spinner-border spinner-border-sm text-warning"
                                        role="status"></small>
                                    <span>States</span>
                                </h6>
                                <a data-ng-if="activeCountry != undefined" href=""
                                    class="link-primary bi bi-plus-circle"
                                    data-ng-click="locationModal(2, countries[activeCountry].location_id)"></a>
                            </div>
                            <ul data-ng-if="states.length" class="list-group list-group-flush">
                                <li data-ng-repeat="c in states" class="list-group-item list-group-item-action d-flex"
                                    data-ng-class="activeState == $index ? 'active' : ''">
                                    <span data-ng-bind="jsonParse(c.location_name).en" class="me-auto"></span>
                                    <a href="" class="link-primary bi bi-eye me-2"
                                        data-ng-click="toggleVisibility($index)"></a>
                                    <a href="" class="link-primary bi bi-chevron-right"
                                        data-ng-click="setActive('activeState', $index, 'cities', 'states')"></a>
                                </li>
                            </ul>
                            <div data-ng-if="!states.length" class="py-5 text-center">
                                <h1 style="font-size: 90px"><i class="bi bi-info-circle text-secondary"></i></h1>
                                <h6 class="text-secondary">No records</h6>
                            </div>
                        </div>
                    </div>

                    <div id="citiesBox" class="col-12 col-sm-6 col-lg-3">
                        <div class="list-box border p-3">
                            <div class="d-flex">
                                <h6 class="fw-bold me-auto">
                                    <small class="loading-spinner spinner-border spinner-border-sm text-warning"
                                        role="status"></small>
                                    <span>Cities</span>
                                </h6>
                                <a data-ng-if="activeState != undefined" href=""
                                    class="link-primary bi bi-plus-circle"
                                    data-ng-click="locationModal(3, states[activeState].location_id)"></a>
                            </div>
                            <ul data-ng-if="cities.length" class="list-group list-group-flush">
                                <li data-ng-repeat="c in cities" class="list-group-item list-group-item-action d-flex"
                                    data-ng-class="activeCity == $index ? 'active' : ''">
                                    <span data-ng-bind="jsonParse(c.location_name).en" class="me-auto"></span>
                                    <a href="" class="link-primary bi bi-eye me-2"
                                        data-ng-click="toggleVisibility($index)"></a>
                                    <a href="" class="link-primary bi bi-chevron-right"
                                        data-ng-click="setActive('activeCity', $index, 'areas', 'cities')"></a>
                                </li>
                            </ul>
                            <div data-ng-if="!cities.length" class="py-5 text-center">
                                <h1 style="font-size: 90px"><i class="bi bi-info-circle text-secondary"></i></h1>
                                <h6 class="text-secondary">No records</h6>
                            </div>
                        </div>
                    </div>

                    <div id="areasBox" class="col-12 col-sm-6 col-lg-3">
                        <div class="list-box border p-3">
                            <div class="d-flex">
                                <h6 class="fw-bold me-auto">
                                    <small class="loading-spinner spinner-border spinner-border-sm text-warning"
                                        role="status"></small>
                                    <span>Area</span>
                                </h6>
                                <a data-ng-if="activeCity != undefined" href=""
                                    class="link-primary bi bi-plus-circle"
                                    data-ng-click="locationModal(4, cities[activeCity].location_id)"></a>
                            </div>
                            <ul data-ng-if="areas.length" class="list-group list-group-flush">
                                <li data-ng-repeat="c in areas" class="list-group-item list-group-item-action d-flex">
                                    <span data-ng-bind="jsonParse(c.location_name).en" class="me-auto"></span>
                                    <a href="" class="link-primary bi bi-eye me-2"
                                        data-ng-click="toggleVisibility($index)"></a>
                                </li>
                            </ul>
                            <div data-ng-if="!areas.length" class="py-5 text-center">
                                <h1 style="font-size: 90px"><i class="bi bi-info-circle text-secondary"></i></h1>
                                <h6 class="text-secondary">No records</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="locationModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <form action="{{ route('location_store') }}" method="post">
                            @csrf
                            <input type="hidden" name="location_type" value="">
                            <input type="hidden" name="location_parent" value="">
                            <div class="mb-3">
                                <label for="locationNameEn">Name EN<b class="text-danger">&ast;</b></label>
                                <input type="text" name="location_name_en" id="locationNameEn" class="form-control"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="locationNameAr">Name AR<b class="text-danger">&ast;</b></label>
                                <input type="text" name="location_name_ar" id="locationNameAr" class="form-control"
                                    required>
                            </div>
                            <div class="d-flex">
                                <button type="button" class="btn btn-outline-secondary btn-sm me-auto"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- brand secton  --}}
        <div class="brand mt-5">
            <div class="row">
                <div class="col-12 col-sm-4 col-lg-3">
                    <div class="card card-box">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="roleFilter">brands Name</label>
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
                                <h5 class="card-title fw-semibold pt-1 me-auto mb-3">
                                    <span class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                        role="status"></span><span>BRANDS</span>
                                </h5>
                                <div>
                                    <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                        data-ng-click="setBrand(false)"></button>
                                    <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                        data-ng-click="loadBrandsData(true)"></button>
                                </div>

                            </div>
                            <div data-ng-if="brands.length" class="table-responsive">
                                <table class="table table-hover" id="brand_table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Logo</th>
                                            <th>User Name</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr data-ng-repeat="brand in brands track by $index">
                                            <td data-ng-bind="brand.id"></td>
                                            <td data-ng-bind="brand.name"></td>
                                            <td>
                                                <img alt="" ng-src="<% brand.logo %>" width="30px">
                                            </td>
                                            <td data-ng-bind="userName[$index].name"></td>
                                            <td>
                                                <div class="col-fit">
                                                    <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                        data-ng-click="setBrand($index)"></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div data-ng-if="!brands.length" class="text-center py-5 text-secondary">
                                <i class="bi bi-people  display-4"></i>
                                <h5>No records</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- start add new brand  Modal -->
            <div class="modal fade" id="brandForm" tabindex="-1" role="dialog" aria-labelledby="brandFormLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form method="POST" action="/brands/submit/" enctype="multipart/form-data">
                                @csrf
                                <input data-ng-if="updateBrand !== false" type="hidden" name="_method" value="put">
                                <input type="hidden" name="brand_id"
                                    data-ng-value="updateBrand !== false ? brands[updateBrand].id : 0">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1">Brand Name<b class="text-danger">&ast;</b></label>
                                    <input type="text" class="form-control" name="name" maxlength="120" required
                                        data-ng-value="updateBrand !== false ? brands[updateBrand].name : ''" />
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1">Logo<b class="text-danger">&ast;</b></label>
                                    <input type="file" class="form-control" name="logo"
                                        accept=".pdf,.jpg, .png, image/jpeg, image/png" data-height="70" required />
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
            <!-- end add new brand  Modal -->
        </div>

        {{-- models section  --}}
        <div class="models mt-5">
            <div class="row">
                <div class="col-12 col-sm-4 col-lg-3">
                    <div class="card card-box">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="roleFilter">brands Name</label>
                                <select name="" id="" class="form-select">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="roleFilter">User Name</label>
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
                                <h5 class="card-title fw-semibold pt-1 me-auto mb-3">
                                    <span class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                        role="status"></span><span>MODELS</span>
                                </h5>
                                <div>
                                    <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                        data-ng-click="setModel(false)"></button>
                                    <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                        data-ng-click="dataLoader(true)"></button>
                                </div>

                            </div>
                            <div data-ng-if="models.length" class="table-responsive">
                                <table class="table table-hover" id="brand_table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Photo</th>
                                            <th>Brand Name</th>
                                            <th>User Name</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr data-ng-repeat="model in models">
                                            <td data-ng-bind="model.id"></td>
                                            <td data-ng-bind="model.name"></td>
                                            <td>
                                                <img alt="" ng-src="<% model.photo %>" width="30px">
                                            </td>
                                            <td data-ng-bind="brandName[$index].name">
                                            </td>
                                            <td data-ng-bind="userName[$index].name"></td>
                                            <td>
                                                <div class="col-fit">
                                                    <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                        data-ng-click="setModel($index)"></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div data-ng-if="!models.length" class="text-center py-5 text-secondary">
                                <i class="bi bi-people  display-4"></i>
                                <h5>No records</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- start add new brand  Modal -->
            <div class="modal fade" id="modelForm" tabindex="-1" role="dialog" aria-labelledby="modelFormLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form method="POST" action="/models/submit/" enctype="multipart/form-data">
                                @csrf
                                <input data-ng-if="updateModel !== false" type="hidden" name="_method" value="put">
                                <input type="hidden" name="model_id"
                                    data-ng-value="updateModel !== false ? models[updateModel].id : 0">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1">Model Name<b class="text-danger">&ast;</b></label>
                                    <input type="text" class="form-control" name="name" maxlength="120" required
                                        data-ng-value="updateModel !== false ? models[updateModel].name : ''" />
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">Logo<b class="text-danger">&ast;</b></label>
                                            <input type="file" class="form-control" name="photo"
                                                accept=".pdf,.jpg, .png, image/jpeg, image/png" required />
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1">URL</label>
                                            <input type="text" class="form-control" name="url"
                                                id="exampleInputEmail1"
                                                data-ng-value="updateModel !== false ? models[updateModel].url : ''">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1">Logo<b class="text-danger">&ast;</b></label>
                                    <select name="brand" class="form-control">
                                        <option value="">-- SELECT BRAND NAME --</option>
                                        <option data-ng-repeat="brand in brands track by $index" data-ng-value="brand.id"
                                            data-ng-bind="brand.name">
                                        </option>

                                    </select>
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
            <!-- end add new brand  Modal -->
        </div>
    </div>
@endsection
@section('js')
    <script>
        var scope, ngApp = angular.module("ngApp", ['ngSanitize'], function($interpolateProvider) {
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
        });
        ngApp.controller("ngCtrl", function($scope) {
            $('.loading-spinner').hide();
            // locations
            $scope.countries = [];
            $scope.states = [];
            $scope.cities = [];
            $scope.areas = [];
            $scope.activeCountry;
            $scope.activeState;
            $scope.activeCity;
            $scope.modalObject = {
                type: 0,
                parent: 0,
            };

            // brands
            $scope.updateBrand = false;
            $scope.userName = false;
            $scope.brands = [];
            $scope.page = 1;

            // models
            $scope.updateModel = false;
            $scope.models = [];
            $scope.brandName = false;
            $scope.userName = false;
            $scope.page = 1;

            $scope.jsonParse = str => JSON.parse(str);
            $scope.locationModal = function(type, parent) {
                $scope.modalObject = {
                    type: +type,
                    parent: +parent,
                };
                $('[name="location_type"]').val(type);
                $('[name="location_parent"]').val(parent);
                $('#locationModal').modal('show');
            };

            $scope.setActive = function(obj, indx, target, list) {
                $scope[obj] = indx;
                switch (obj) {
                    case 'activeCountry':
                        $scope.states = [];
                        $scope.activeState = undefined;
                    case 'activeState':
                        $scope.cities = [];
                        $scope.activeCity = undefined;
                    case 'activeCity':
                        $scope.areas = [];
                }
                $scope.loadData($scope[list][indx], target);
            };

            $scope.loadData = function(parent, target) {
                $(`#${target}Box .loading-spinner`).show();
                $.post('https://sallahnow.yottaline.com/api/settings/locations_load', {
                    type: parent ? (+parent.location_type + 1) : 1,
                    parent: parent ? parent.location_id : 0,
                }, function(data) {
                    $(`#${target}Box .loading-spinner`).hide();
                    $scope.$apply(() => $scope[target] = data)
                }, 'json');
            };

            $scope.loadBrandsData = function(reload = false) {
                $('.loading-spinner').show();
                if (reload) {
                    $scope.page = 1;
                }
                $.post("/brands/load/", {
                    page: $scope.page,
                    limit: 24,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.brands = data;
                        $scope.page++;
                    });
                }, 'json');
            }

            $scope.setBrand = (indx) => {
                $scope.updateBrand = indx;
                $('#brandForm').modal('show');
            };

            $scope.getUserNameModel = function() {
                $.post("/models/getUserName/", {
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.userName = data;
                    });
                }, 'json');
            }

            $scope.setModel = (indx) => {
                $scope.updateModel = indx;
                $('#modelForm').modal('show');
            };

            $scope.lodaModelsData = function(reload = false) {
                $('.loading-spinner').show();
                if (reload) {
                    $scope.page = 1;
                }
                $.post("/models/load/", {
                    page: $scope.page,
                    limit: 24,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.models = data;
                        $scope.page++;
                    });
                }, 'json');
            }


            $scope.getBrandName = function() {
                $.post("/models/getBrandsName/", {
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.brandName = data;
                    });
                }, 'json');
            }

            $scope.loadData(0, 'countries');
            $scope.loadBrandsData();
            $scope.getUserNameModel();
            $scope.lodaModelsData();
            $scope.getBrandName();
            scope = $scope;

            // create new location
            $(function() {
                $('#locationModal form').on('submit', function(e) {
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
                        // if (response.status) {
                        //     toastr.success('Data processed successfully');
                        //     $('#locationModal').modal('hide');
                        //     scope.$apply(() => {
                        //         if (updateTechnician === false) {
                        //             scope.technicians.unshift(response.data);
                        //         } else {
                        //             scope.technicians[updateTechnician] = response.data;
                        //         }
                        //     });
                        // } else toastr.error("Error");
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        // error msg
                    }).always(function() {
                        spinner.hide();
                        controls.prop('disabled', false);
                    });

                })
            });

            // create and update brand
            $(function() {
                $('#brandForm form').on('submit', function(e) {
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
                        console.log(data)
                        if (response.status) {
                            toastr.success('Data processed successfully');
                            $('#brandForm').modal('hide');
                            scope.$apply(() => {
                                if (scope.updateBrand === false) {
                                    scope.brands.unshift(response.data);
                                    $scope.loadBrandsData();
                                } else {
                                    scope.brands[scope.updateBrand] = response.data;
                                    $scope.loadBrandsData();
                                }
                            });
                        } else toastr.error("Error");
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        // error msg
                    }).always(function() {
                        spinner.hide();
                        controls.prop('disabled', false);
                    });
                })
            });

            // create and update model
            $(function() {
                $('#modelForm form').on('submit', function(e) {
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
                        console.log(data)
                        if (response.status) {
                            toastr.success('Data processed successfully');
                            $('#modelForm').modal('hide');
                            scope.$apply(() => {
                                if (scope.updateModel === false) {
                                    scope.models.unshift(response.data);
                                    $scope.lodaModelsData();
                                } else {
                                    scope.models[scope.updateModel] = response.data;
                                    $scope.lodaModelsData();
                                }
                            });
                        } else toastr.error("Error");
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        // error msg
                    }).always(function() {
                        spinner.hide();
                        controls.prop('disabled', false);
                    });

                })
            })

        });
    </script>
@endsection
