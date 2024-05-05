@extends('index')
@section('title')
    Technician
@endsection
@section('search')
    <form id="nvSearch" role="search">
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
                            <select id="filter-package" class="form-select">
                                <option value="0"></option>
                                <option value="1">Free</option>
                                <option value="2">Silver | 1 Month</option>
                                <option value="3">Silver | 6 Month</option>
                                <option value="4">Silver | 1 Year</option>
                                <option value="5">Gold | 6 Month</option>
                                <option value="6">Gold | 1 Year</option>
                                <option value="7">Diamond | 1 Year</option>
                            </select>
                        </div>


                        {{-- country --}}
                        <div class="mb-3">
                            <label>Country<b class="text-danger">&ast;</b></label>
                            <select id="filter-country" class="form-select">
                                <option value="0">-- select country --</option>
                                <option data-ng-repeat="country in countries" data-ng-value="country.location_id"
                                    data-ng-bind="jsonParse(country.location_name)['en']"></option>
                            </select>
                        </div>
                        {{-- state --}}
                        <div class="mb-3">
                            <label>State<b class="text-danger">&ast;</b></label>
                            <select id="filter-state" class="form-select">
                                <option value="0">-- select state --</option>
                                <option data-ng-repeat="state in filters.states" data-ng-value="state.location_id"
                                    data-ng-bind="jsonParse(state.location_name)['en']"></option>
                            </select>
                        </div>

                        {{-- city --}}
                        <div class="mb-3">
                            <label>City<b class="text-danger">&ast;</b></label>
                            <select id="filter-city" class="form-select">
                                <option value="0">-- select city --</option>
                                <option data-ng-repeat="city in filters.cities" data-ng-value="city.location_id"
                                    data-ng-bind="jsonParse(city.location_name)['en']"></option>
                            </select>
                        </div>

                        {{-- area --}}
                        <div class="mb-3">
                            <label>Arae<b class="text-danger">&ast;</b></label>
                            <select id="filter-area" class="form-select" required>
                                <option value="0">-- select area --</option>
                                <option data-ng-repeat="area in filters.areas" data-ng-value="area.location_id"
                                    data-ng-bind="jsonParse(area.location_name)['en']"></option>
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
                                    role="status"></span><span>Technicians</span>
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                    data-ng-click="setTechnician(false)"></button>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>
                        </div>

                        {{-- <h5 data-ng-if="q" class="text-dark">Results of <span class="text-primary" data-ng-bind="q"></span>
                        </h5> --}}

                        <div data-ng-if="list.length" class="table-responsive">
                            <table class="table table-hover" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Technician</th>
                                        <th class="text-center">Package</th>
                                        <th class="text-center">Register</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="technician in list track by $index">
                                        <td data-ng-bind="technician.tech_code"
                                            class="text-center small font-monospace text-uppercase"></td>
                                        <td>
                                            <span data-ng-bind="technician.tech_name" class="fw-bold"></span><br>
                                            <small data-ng-if="+technician.tech_mobile"
                                                class="me-1 db-inline-block dir-ltr font-monospace badge bg-primary">
                                                <i class="bi bi-phone me-1"></i>
                                                <span data-ng-bind="technician.tech_mobile" class="fw-normal"></span>
                                            </small>
                                            <small data-ng-if="technician.tech_tel"
                                                class="me-1 db-inline-block dir-ltr font-monospace badge bg-primary">
                                                <i class="bi bi-telephone me-1"></i>
                                                <span data-ng-bind="technician.tech_tel" class="fw-normal"></span>
                                            </small>
                                            <small data-ng-if="technician.tech_email"
                                                class="db-inline-block dir-ltr font-monospace badge bg-primary">
                                                <i class="bi bi-envelope-at me-1"></i>
                                                <span data-ng-bind="technician.tech_email" class="fw-normal"></span>
                                            </small>
                                        </td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <td class="col-fit">
                                            <a class="btn btn-outline-dark btn-circle bi bi-link-45deg"
                                                href="/technicians/profile/<% technician.tech_code %>"
                                                target="_blank"></a>
                                            <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                data-ng-click="setTechnician($index)"></button>
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

        @include('components.dashbords.modals.modal_technician')

    </div>
@endsection

@section('js')
    <script>
        var scope,
            app = angular.module('myApp', [], function($interpolateProvider) {
                $interpolateProvider.startSymbol('<%');
                $interpolateProvider.endSymbol('%>');
            });

        app.controller('myCtrl', function($scope) {
            $('.loading-spinner').hide();
            $scope.noMore = false;
            $scope.loading = false;
            $scope.q = '';
            $scope.updateTechnician = false;
            $scope.list = [];
            $scope.countries = <?= json_encode($countries) ?>;
            $scope.techModal = {
                states: [],
                cities: [],
                areas: [],
            };
            $scope.filters = {
                states: [],
                cities: [],
                areas: [],
            };
            $scope.showTechnician = [];
            $scope.last_id = 0;
            $scope.jsonParse = (str) => JSON.parse(str);
            $scope.dataLoader = function(reload = false) {
                if (reload) {
                    $scope.list = [];
                    $scope.last_id = 0;
                    $scope.noMore = false;
                }

                if ($scope.noMore) return;
                $scope.loading = true;

                $('.loading-spinner').show();
                var request = {
                    package: $('#filter-package').val(),
                    country: $('#filter-country').val(),
                    state: $('#filter-state').val(),
                    city: $('#filter-city').val(),
                    area: $('#filter-area').val(),
                    q: $scope.q,
                    last_id: $scope.last_id,
                    limit: limit,
                    _token: '{{ csrf_token() }}'
                };

                $.post("/technicians/load", request, function(data) {
                    $('.loading-spinner').hide();
                    var ln = data.length;
                    $scope.$apply(() => {
                        $scope.loading = false;
                        if (ln) {
                            $scope.noMore = ln < limit;
                            $scope.list = data;
                            console.log(data)
                            $scope.last_id = data[ln - 1].tech_id;
                        }
                    });
                }, 'json');
            }

            $scope.setTechnician = (indx) => {
                $scope.updateTechnician = indx;
                $('#techModal').modal('show');
            };
            $scope.editActive = (index) => {
                $scope.updateTechnician = index;
                $('#edit_active').modal('show');
            };
            $scope.dataLoader();
            scope = $scope;
        });

        $(function() {
            $('#nvSearch').on('submit', function(e) {
                e.preventDefault();
                scope.$apply(() => scope.q = $(this).find('input').val());
                scope.dataLoader(true);
            });

            $('#filter-country').on('change', function() {
                var val = $(this).val();
                scope.$apply(function() {
                    scope.filters.states = [];
                    scope.filters.cities = [];
                    scope.filters.areas = [];
                });
                locationsLoad(2, val, function(data) {
                    scope.$apply(() => scope.filters.states = data);
                });
            });

            $('#filter-state').on('change', function() {
                var val = $(this).val();
                scope.$apply(function() {
                    scope.filters.cities = [];
                    scope.filters.areas = [];
                });
                locationsLoad(3, val, function(data) {
                    scope.$apply(() => scope.filters.cities = data);
                });
            });

            $('#filter-city').on('change', function() {
                var val = $(this).val();
                scope.$apply(function() {
                    scope.filters.areas = [];
                });

                locationsLoad(4, val, function(data) {
                    scope.$apply(() => scope.filters.areas = data);
                });
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
        };
    </script>
@endsection
