@extends('index')
@section('title', 'Retailers')
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
                        {{-- country --}}
                        {{-- <div class="mb-3">
                            <label>Country<b class="text-danger">&ast;</b></label>
                            <select id="filter-country" class="form-select">
                                <option value="0">-- select country --</option>
                                <option data-ng-repeat="country in countries" data-ng-value="country.location_id"
                                    data-ng-bind="jsonParse(country.location_name)['en']"></option>
                            </select>
                        </div> --}}
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-8 col-lg-9">
                <div class="card card-box">
                    <div class="card-body">
                        <div class="d-flex">
                            <h5 class="card-title fw-semibold pt-1 me-auto mb-3 text-uppercase">
                                <span class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                    role="status"></span><span>RETAILERS</span>
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                    data-ng-click="setReyailer(false)"></button>
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
                                        <th>Retailer Name</th>
                                        <th class="text-center">Store Name</th>
                                        <th class="text-center">Position</th>
                                        <th class="text-center">Approved Date</th>
                                        <th class="text-center">Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="retailer in list track by $index">
                                        <td data-ng-bind="retailer.retailer_id"
                                            class="text-center small font-monospace text-uppercase"></td>
                                        <td>
                                            <span data-ng-bind="retailer.retailer_name" class="fw-bold"></span><br>
                                            <small data-ng-if="retailer.retailer_phone"
                                                class="me-1 db-inline-block dir-ltr font-monospace badge bg-primary">
                                                <i class="bi bi-phone me-1"></i>
                                                <span data-ng-bind="retailer.retailer_phone" class="fw-normal"></span>
                                            </small>
                                            <small data-ng-if="retailer.retailer_email"
                                                class="db-inline-block dir-ltr font-monospace badge bg-primary">
                                                <i class="bi bi-envelope-at me-1"></i>
                                                <span data-ng-bind="retailer.retailer_email" class="fw-normal"></span>
                                            </small>
                                        </td>
                                        <td class="text-center" data-ng-bind="retailer.store_name"></td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-<%positionObj.color[retailer.retailer_admin]%> rounded-pill font-monospace p-2"><%positionObj.name[retailer.retailer_admin]%></span>

                                        </td>
                                        <td class="text-center">
                                            <span data-ng-if="!retailer.retailer_approved">Not Approved</span>
                                            <span
                                                data-ng-if="retailer.retailer_approved"data-ng-bind="retailer.retailer_approved"></span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-<%statusObject.color[retailer.retailer_active]%> rounded-pill font-monospace"><%statusObject.name[retailer.retailer_active]%></span>

                                        </td>
                                        <td class="col-fit">
                                            <button class="btn btn-outline-success btn-circle bi bi-toggles"
                                                data-ng-click="editActive($index)"></button>
                                            <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                data-ng-click="setReyailer($index)"></button>
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

        @include('components.dashbords.modals.modal_retailer')

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
            $scope.statusObject = {
                name: ['blocked', 'active'],
                color: ['danger', 'success']
            };
            $scope.positionObj = {
                name: ['Not Admin', 'Admin'],
                color: ['danger', 'success']
            };
            $('.loading-spinner').hide();
            $scope.noMore = false;
            $scope.loading = false;
            $scope.q = '';
            $scope.updateRetailer = false;
            $scope.list = [];

            $scope.last_id = 0;
            $scope.jsonParse = (str) => JSON.parse(str);
            $scope.stores = <?= json_encode($stores) ?>;
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
                    q: $scope.q,
                    last_id: $scope.last_id,
                    limit: limit,
                    _token: '{{ csrf_token() }}'
                };

                $.post("/markets/retailers/load", request, function(data) {
                    $('.loading-spinner').hide();
                    var ln = data.length;
                    $scope.$apply(() => {
                        $scope.loading = false;
                        if (ln) {
                            $scope.noMore = ln < limit;
                            $scope.list = data;
                            console.log(data)
                            $scope.last_id = data[ln - 1].retailer_id;
                        }
                    });
                }, 'json');
            }

            $scope.setReyailer = (indx) => {
                $scope.updateRetailer = indx;
                $('#storeModal').modal('show');
            };
            $scope.editActive = (index) => {
                $scope.updateRetailer = index;
                $('#edit_active').modal('show');
            };
            $scope.dataLoader();
            scope = $scope;
        });

        $('#nvSearch').on('submit', function(e) {
            e.preventDefault();
            scope.$apply(() => scope.q = $(this).find('input').val());
            scope.dataLoader(true);
        });
    </script>
@endsection
