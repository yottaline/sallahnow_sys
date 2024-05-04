@extends('index')
@section('title')
    Support Category
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
                                    role="status"></span><span>SUPPORT CATEGORY</span>
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                    data-ng-click="setSuppCate(false)"></button>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>
                        </div>

                        <h5 data-ng-if="q" class="text-dark">Result of <span class="text-primary" data-ng-bind="q"></span>
                        </h5>

                        <div data-ng-if="list.length" class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Category Name(en)</th>
                                        <th class="text-center">Category Name(ar)</th>
                                        <th class="text-center">Cost</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="cate in list track by $index">
                                        <td data-ng-bind="cate.category_id"
                                            class="text-center small font-monospace text-uppercase"></td>
                                        <td class="text-center" data-ng-bind="jsonParse(cate.category_name)['en']"></td>
                                        <td class="text-center" data-ng-bind="jsonParse(cate.category_name)['ar']"></td>
                                        <td class="text-center" data-ng-bind="cate.category_cost"></td>

                                        <td class="col-fit">
                                            <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                data-ng-click="setSuppCate($index)"></button>
                                            {{-- <button class="btn btn-outline-success btn-circle bi bi bi-coin"
                                                data-ng-click="addCost($index)"></button> --}}
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

        @include('components.dashbords.modals.modal_support')
    @endsection
    @section('js')
        <script>
            var scope, app = angular.module('myApp', [], function($interpolateProvider) {
                $interpolateProvider.startSymbol('<%');
                $interpolateProvider.endSymbol('%>');
            });

            app.controller('myCtrl', function($scope) {
                $('.loading-spinner').hide();
                $scope.jsonParse = (str) => JSON.parse(str);
                $scope.q = '';
                $scope.noMore = false;
                $scope.loading = false;
                $scope.cateUpdate = false;
                $scope.list = [];
                $scope.last_id = 0;
                $scope.dataLoader = function(reload = false) {

                    if (reload) {
                        $scope.list = [];
                        $scope.last_id = 0;
                        $scope.noMore = false;
                    }
                    if ($scope.noMore) return;
                    $scope.loading = true;

                    $('.loading-spinner').show();

                    $.post("/supports/load", {
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
                                $scope.last_id = data[ln - 1].category_id;
                            };
                        });
                    }, 'json');
                }

                $scope.setSuppCate = (index) => {
                    $scope.cateUpdate = index;
                    $('#centerForm').modal('show');
                };

                $scope.addCost = (index) => {
                    $scope.cateUpdate = index;
                    $('#add_cost').modal('show');
                }
                $scope.dataLoader();
                scope = $scope;
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
