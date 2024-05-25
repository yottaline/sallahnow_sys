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
        {{-- start location secton  --}}
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
                                <li data-ng-repeat="c in countries"
                                    class="list-group-item list-group-item-action d-flex bg-muted-8"
                                    data-ng-class="activeCountry == $index ? 'active' : ''">
                                    <span data-ng-bind="jsonParse(c.location_name).en" class="me-auto"></span>
                                    <a href="" class="link-primary bi bi-eye me-2"
                                        data-ng-click="toggleVisibility($index)"></a>
                                    <a href="" class="link-primary bi bi-chevron-right"
                                        data-ng-click="setActive('activeCountry', $index, 'states', 'countries')"></a>
                                </li>
                            </ul>
                            <div data-ng-if="!countries.length" class="py-5 text-center">
                                <h1 style="font-size: 60px"><i class="bi bi-exclamation-circle text-secondary"></i></h1>
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
                                <li data-ng-repeat="c in states"
                                    class="list-group-item list-group-item-action d-flex bg-muted-8"
                                    data-ng-class="activeState == $index ? 'active' : ''">
                                    <span data-ng-bind="jsonParse(c.location_name).en" class="me-auto"></span>
                                    <a href="" class="link-primary bi bi-eye me-2"
                                        data-ng-click="toggleVisibility($index)"></a>
                                    <a href="" class="link-primary bi bi-chevron-right"
                                        data-ng-click="setActive('activeState', $index, 'cities', 'states')"></a>
                                </li>
                            </ul>
                            <div data-ng-if="!states.length" class="py-5 text-center">
                                <h1 style="font-size: 60px"><i class="bi bi-exclamation-circle text-secondary"></i></h1>
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
                                <li data-ng-repeat="c in cities"
                                    class="list-group-item list-group-item-action d-flex bg-muted-8"
                                    data-ng-class="activeCity == $index ? 'active' : ''">
                                    <span data-ng-bind="jsonParse(c.location_name).en" class="me-auto"></span>
                                    <a href="" class="link-primary bi bi-eye me-2"
                                        data-ng-click="toggleVisibility($index)"></a>
                                    <a href="" class="link-primary bi bi-chevron-right"
                                        data-ng-click="setActive('activeCity', $index, 'areas', 'cities')"></a>
                                </li>
                            </ul>
                            <div data-ng-if="!cities.length" class="py-5 text-center">
                                <h1 style="font-size: 60px"><i class="bi bi-exclamation-circle text-secondary"></i></h1>
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
                                <li data-ng-repeat="c in areas"
                                    class="list-group-item list-group-item-action d-flex bg-muted-8">
                                    <span data-ng-bind="jsonParse(c.location_name).en" class="me-auto"></span>
                                    <a href="" class="link-primary bi bi-eye me-2"
                                        data-ng-click="toggleVisibility($index)"></a>
                                </li>
                            </ul>
                            <div data-ng-if="!areas.length" class="py-5 text-center">
                                <h1 style="font-size: 60px"><i class="bi bi-exclamation-circle text-secondary"></i></h1>
                                <h6 class="text-secondary">No records</h6>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            {{-- start location modal --}}
            <div class="modal fade" id="locationModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form action="/settings/location/submit" method="post">
                                @csrf
                                <input type="hidden" name="type" value="">
                                <input type="hidden" name="parent" value="">
                                <div class="mb-3">
                                    <label for="locationNameEn">Name EN<b class="text-danger">&ast;</b></label>
                                    <input type="text" name="name_en" id="locationNameEn" class="form-control"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="locationNameAr">Name AR<b class="text-danger">&ast;</b></label>
                                    <input type="text" name="name_ar" id="locationNameAr"
                                        class="form-control dir-rtl" required>
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
            {{-- end location modal --}}
        </div>
        {{-- end location secton  --}}

        {{-- start brand and model section  --}}
        <div class="card card-box mt-5">
            <div class="card-body">
                <h5 class="card-title fw-bold text-uppercase">BRABDS & MODELS</h5>
                <div class="row">
                    <div id="brandBox" class="col-12 col-sm-6 col-lg-6">
                        <div class="list-box border p-3">
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
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr data-ng-repeat="brand in brands track by $index">
                                            <td data-ng-bind="brand.brand_id"></td>
                                            <td data-ng-bind="brand.brand_name"></td>
                                            <td>
                                                <img alt=""
                                                    ng-src="{{ asset('/Image/Brands/') }}/<% brand.brand_logo %>"
                                                    width="30px">
                                            </td>
                                            <td class="col-fit">
                                                <div>
                                                    <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                        data-ng-click="setBrand($index)"></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div data-ng-if="!brands.length" class="text-center py-5 text-secondary">
                                <i class="bi bi-exclamation-circle  display-4"></i>
                                <h5>No records</h5>
                            </div>
                        </div>
                    </div>

                    <div id="modelBox" class="col-12 col-sm-6 col-lg-6">
                        <div class="list-box border p-3">
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
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr data-ng-repeat="model in models">
                                            <td data-ng-bind="model.model_id"></td>
                                            <td data-ng-bind="model.model_name"></td>
                                            <td>
                                                <img alt=""
                                                    ng-src="{{ asset('/Image/Models/') }}/<% model.model_photo %>"
                                                    width="30px">
                                            </td>
                                            <td data-ng-bind="model.brand_name">
                                            </td>
                                            <td class="col-fit">
                                                <div>
                                                    <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                        data-ng-click="setModel($index)"></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div data-ng-if="!models.length" class="text-center py-5 text-secondary">
                                <i class="bi bi-exclamation-circle  display-4"></i>
                                <h5>No records</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        {{-- end brand and model section  --}}

        {{-- start compa section  --}}
        <div class="card card-box mt-5">
            <div class="card-body">
                <div class="row">
                    <div id="compatbiliyCategorieBox" class="col-6">
                        <div class="list-box border p-3">
                            <div class="d-flex">
                                <h5 class="card-title fw-semibold pt-1 me-auto mb-3">
                                    <span class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                        role="status"></span><span>COMPATIBILITY CATEGORIES</span>
                                </h5>
                                <div>
                                    <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                        data-ng-click="setCompatibilityCategories(false)"></button>
                                    <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                        data-ng-click="lodaCompatibilityCategoriessData(true)"></button>
                                </div>

                            </div>
                            <div data-ng-if="compatibility_categories.length" class="table-responsive">
                                <table class="table table-hover" id="compatibility_categories_table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr data-ng-repeat="cate in compatibility_categories">
                                            <td data-ng-bind="cate.category_id"></td>
                                            <td data-ng-bind="cate.category_name"></td>
                                            <td class="col-fit">
                                                <div>
                                                    <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                        data-ng-click="setCompatibilityCategories($index)"></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div data-ng-if="!compatibility_categories.length" class="text-center py-5 text-secondary">
                                <i class="bi bi-exclamation-circle display-4"></i>
                                <h5>No records</h5>
                            </div>
                        </div>
                    </div>

                    <div id="motherBoard" class="col-6">
                        <div class="list-box border p-3">
                            <div class="d-flex">
                                <h5 class="card-title fw-semibold pt-1 me-auto mb-3">
                                    <span class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                        role="status"></span><span>COMPATIBILITY MOTHER BOARD</span>
                                </h5>
                                <div>
                                    <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                        data-ng-click="setMotherBoard(false)"></button>
                                    <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                        data-ng-click="loadMotherBoard(true)"></button>
                                </div>

                            </div>
                            <div data-ng-if="compatibility_motherBoard.length" class="table-responsive">
                                <table class="table table-hover" id="compatibility_motherBoard_table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr data-ng-repeat="board in compatibility_motherBoard">
                                            <td data-ng-bind="board.board_id"></td>
                                            <td data-ng-bind="board.board_name"></td>
                                            <td class="col-fit">
                                                <div>
                                                    <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                        data-ng-click="setMotherBoard($index)"></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div data-ng-if="!compatibility_motherBoard.length" class="text-center py-5 text-secondary">
                                <i class="bi bi-exclamation-circle display-4"></i>
                                <h5>No records</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        {{-- end compa section  --}}

        {{-- start packages section  --}}
        <div class="card card-box mt-5">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-8 col-lg-12">
                        <div id="packageBox" class="col-12">
                            <div class="list-box border p-3">
                                <div class="d-flex">
                                    <h5 class="card-title fw-semibold pt-1 me-auto mb-3">
                                        <span class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                            role="status"></span><span>PACKAGES</span>
                                    </h5>
                                    <div>
                                        <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                            data-ng-click="setPackage(false)"></button>
                                        <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                            data-ng-click="dataLoader(true)"></button>
                                    </div>

                                </div>
                                <div data-ng-if="packages.length" class="table-responsive">
                                    <table class="table table-hover" id="brand_table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Type</th>
                                                <th>Period</th>
                                                <th>Cost</th>
                                                <th>Points</th>
                                                <th>Ptiv</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr data-ng-repeat="package in packages">
                                                <td data-ng-bind="package.pkg_id"></td>
                                                <td>
                                                    <span
                                                        class="badge bg-dark rounded-pill font-monospace p-2"><%typeObject.name[package.pkg_type]%></span>
                                                </td>
                                                <td data-ng-bind="package.pkg_period"></td>
                                                <td data-ng-bind="package.pkg_cost"></td>
                                                <td data-ng-bind="package.pkg_points"></td>
                                                <td></td>
                                                <td class="col-fit">
                                                    <div>
                                                        <button
                                                            class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                            data-ng-click="setPackage($index)"></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div data-ng-if="!packages.length" class="text-center py-5 text-secondary">
                                    <i class="bi bi-exclamation-circle display-4"></i>
                                    <h5>No records</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        {{-- end packages section  --}}

        @include('components.dashbords.modals.modal_settings')
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

            // compatibility_categories
            $scope.updateCompCate = false;
            $scope.updateMotherBoard = false;
            $scope.compatibility_categories = [];
            $scope.compatibility_motherBoard = [];
            $scope.page = 1;

            // packages
            $scope.updatePackage = false;
            $scope.packages = [];
            $scope.typeObject = {
                name: ['', 'Free', 'Silver', 'Gold', 'Diamond'],
            }

            $scope.jsonParse = str => JSON.parse(str);
            $scope.locationModal = function(type, parent) {
                $scope.modalObject = {
                    type: +type,
                    parent: +parent,
                };
                $('[name=type]').val(type);
                $('[name=parent]').val(parent);
                $('#locationModal').modal('show');
            };

            $scope.setActive = function(obj, indx, target, list) {
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
                $scope[obj] = indx;
                $scope.loadData($scope[list][indx], target);
            };

            $scope.loadData = function(parent, target) {
                $(`#${target}Box .loading-spinner`).show();
                $.post('/settings/location/load', {
                    type: parent ? (+parent.location_type + 1) : 1,
                    parent: parent ? parent.location_id : 0,
                    _token: "{{ csrf_token() }}"
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
                $.post("/brands/load", {
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

            $scope.setModel = (indx) => {
                $scope.updateModel = indx;
                $('#modelForm').modal('show');
            };

            $scope.lodaModelsData = function(reload = false) {
                $('.loading-spinner').show();
                if (reload) {
                    $scope.page = 1;
                }
                $.post("/models/load", {
                    page: $scope.page,
                    limit: 24,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.models = data;
                        console.log(data)
                        $scope.page++;
                    });
                }, 'json');
            }

            $scope.lodaCompatibilityCategoriessData = function(reload = false) {
                $('.loading-spinner').show();
                if (reload) {
                    $scope.page = 1;
                }
                $.post("/CompatibilityCategories/load", {
                    page: $scope.page,
                    limit: 24,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.compatibility_categories = data;
                        $scope.page++;
                    });
                }, 'json');
            }

            $scope.loadMotherBoard = function(reload = false) {
                $('.loading-spinner').show();
                if (reload) {
                    $scope.page = 1;
                }
                $.post("/compatibilityMotherBoard/load", {
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.compatibility_motherBoard = data;
                        // $scope.page++;
                    });
                }, 'json');
            }

            $scope.setCompatibilityCategories = (indx) => {
                $scope.updateCompCate = indx;
                $('#CompatibilityCategoriesForm').modal('show');
            };

            $scope.setMotherBoard = (index) => {
                $scope.updateMotherBoard = index;
                $('#CompatibilityMotherBoardForm').modal('show');
            }

            $scope.loadPackageData = function(reload = false) {
                $('.loading-spinner').show();
                if (reload) {
                    $scope.page = 1;
                }
                $.post("/packages/load", {
                    page: $scope.page,
                    limit: 24,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.packages = data;
                        $scope.page++;
                    });
                }, 'json');
            }

            $scope.setPackage = (indx) => {
                $scope.updatePackage = indx;
                $('#PackageForm').modal('show');
            };

            $scope.loadData(0, 'countries');
            $scope.loadBrandsData();
            $scope.lodaModelsData();
            $scope.loadMotherBoard();
            $scope.lodaCompatibilityCategoriessData()
            $scope.loadPackageData();
            scope = $scope;
        });

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
                    var response = JSON.parse(data);
                    if (response.status) {
                        toastr.success('Data processed successfully');
                        $('#locationModal').modal('hide');
                        scope.$apply(function() {
                            switch (scope.modalObject.type) {
                                case 1:
                                    scope.countries.unshift(response.data);
                                    // clerForm()
                                    break;
                                case 2:
                                    scope.states.unshift(response.data);
                                    break;
                                case 3:
                                    scope.cities.unshift(response.data);
                                    break;
                                case 4:
                                    scope.areas.unshift(response.data);
                            }
                            locationClsForm()
                        });
                    } else toastr.error("Error");
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    // error msg
                }).always(function() {
                    spinner.hide();
                    controls.prop('disabled', false);
                });
            })


            // location cls forms
            function locationClsForm() {
                $('#locationNameEn').val('');
                $('#locationNameAr').val('');
            };
        });
    </script>
@endsection
