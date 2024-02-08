@extends('index')
@section('title')
    Location
@endsection
@section('content')
    <div class="container-fluid mt-5">
        <div class="card card-box">
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
    </div>
    <!-- Modal -->
    <div class="modal fade" id="locationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="{{ route('location_store') }}" method="post">
                        @csrf
                        <input type="hidden" name="location_type" data-ng-value="modalObject.type">
                        <input type="hidden" name="location_parent" data-ng-value="modalObject.parent">
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
@endsection
@section('js')
    <script>
        var scope, ngApp = angular.module("ngApp", ['ngSanitize']);
        ngApp.controller("ngCtrl", function($scope) {
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

            $scope.jsonParse = str => JSON.parse(str);
            $scope.locationModal = function(type, parent) {
                $scope.modalObject = {
                    type: +type,
                    parent: +parent,
                };
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

            $scope.loadData(0, 'countries');
            scope = $scope;
        });

        $(function() {
            $('.loading-spinner').hide();
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
                    // add to list
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    // error msg
                }).always(function() {
                    spinner.hide();
                    controls.prop('disabled', false);
                });

            })
        });
    </script>
@endsection
