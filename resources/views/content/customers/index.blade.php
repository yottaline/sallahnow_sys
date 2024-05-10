@extends('index')
@section('title', 'Customers')
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
                            <label for="roleFilter">Status</label>
                            <select id="filter-status" class="form-select">
                                <option value="">-- SELECT STATUS --</option>
                                <option value="1">Actived</option>
                                <option value="2">Blocked</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Country<b class="text-danger">&ast;</b></label>
                            <select id="filter-country" class="form-select">
                                <option value="0">-- SELECT COUNTRY --</option>
                                <option data-ng-repeat="country in countries" data-ng-value="country.location_id"
                                    data-ng-bind="jsonParse(country.location_name)['en']"></option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>State<b class="text-danger">&ast;</b></label>
                            <select id="filter-state" class="form-select">
                                <option value="0">-- SELECT STATSUS --</option>
                                <option data-ng-repeat="state in filters.states" data-ng-value="state.location_id"
                                    data-ng-bind="jsonParse(state.location_name)['en']"></option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>City<b class="text-danger">&ast;</b></label>
                            <select id="filter-city" class="form-select">
                                <option value="0">-- SELECT CITY --</option>
                                <option data-ng-repeat="city in filters.cities" data-ng-value="city.location_id"
                                    data-ng-bind="jsonParse(city.location_name)['en']"></option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Arae<b class="text-danger">&ast;</b></label>
                            <select id="filter-area" class="form-select" required>
                                <option value="0">-- SELECT AREA --</option>
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
                                    role="status"></span><span>CUSTOMERS</span>
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                    data-ng-click="setCustomer(false)"></button>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>
                        </div>
                        {{-- <h5 data-ng-if="q" class="text-dark">Result of <span class="text-primary" data-ng-bind="q"></span>
                        </h5> --}}
                        <div data-ng-if="list.length" class="table-responsive">
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
                                    <tr data-ng-repeat="customer in list track by $index">
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
                    </div>
                    @include('layouts.loade')
                </div>
            </div>
        </div>

        @include('components.dashbords.modals.modal_customer')
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
            $scope.jsonParse = (str) => JSON.parse(str);
            $scope.activeOb = {
                name: ['', 'Active', 'Bloced'],
                color: ['', 'success', 'danger']
            };
            $scope.q = '';
            $scope.noMore = false;
            $scope.loading = false;
            $scope.last_id = 0;
            $scope.customerUpdate = false;
            $scope.list = [];
            $scope.countries = <?= json_encode($countries) ?>;
            $scope.cousModal = {
                states: [],
                cities: [],
                areas: [],
            };
            $scope.filters = {
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

                var request = {
                    status: $('#filter-status').val(),
                    country: $('#filter-country').val(),
                    state: $('#filter-state').val(),
                    city: $('#filter-city').val(),
                    area: $('#filter-area').val(),
                    q: $scope.q,
                    last_id: $scope.last_id,
                    limit: limit,
                    _token: '{{ csrf_token() }}'
                };

                $.post("/customers/load", request, function(data) {
                    $('.loading-spinner').hide();
                    var ln = data.length;
                    $scope.$apply(() => {
                        $scope.loading = false;
                        if (ln) {
                            $scope.noMore = ln < limit;
                            $scope.list = data;
                            $scope.last_id = data[ln - 1].customer_id;
                        };
                    });
                }, 'json');
            }
            $scope.setCustomer = (indx) => {
                $scope.customerUpdate = indx;
                $('#custModal').modal('show');
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
        // $(function() {

        // });

        // // change active
        // $(function() {

        // });

        $(function() {
            $('#searchForm').on('submit', function(e) {
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
                    scope.cousModal.states = [];
                    scope.cousModal.cities = [];
                    scope.cousModal.areas = [];
                });
                locationsLoad(2, val, function(data) {
                    scope.$apply(() => scope.cousModal.states = data);
                });
            });

            $('#state').on('change', function() {
                var val = $(this).val();
                scope.$apply(function() {
                    scope.cousModal.cities = [];
                    scope.cousModal.areas = [];
                });
                locationsLoad(3, val, function(data) {
                    scope.$apply(() => scope.cousModal.cities = data);
                });
            });

            $('#city').on('change', function() {
                var val = $(this).val();
                scope.$apply(function() {
                    scope.cousModal.areas = [];
                });

                locationsLoad(4, val, function(data) {
                    scope.$apply(() => scope.cousModal.areas = data);
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
