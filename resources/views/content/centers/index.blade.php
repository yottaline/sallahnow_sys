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
            @include('components.dashbords.modals.modal_center')
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
            };
        </script>
    @endsection
