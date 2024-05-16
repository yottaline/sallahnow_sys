@extends('index')
@section('title', 'Sub Category')
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
                                    role="status"></span><span>SUBCATEGORIES</span>
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                    data-ng-click="setSubCategory(false)"></button>
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
                                        <th class="text-center">Subcategoy Name AR</th>
                                        <th class="text-center">Subcategoy Name EN</th>
                                        <th class="text-center">Catgory Name AR</th>
                                        <th class="text-center">Catgory Name AR</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="subcate in list track by $index">
                                        <td data-ng-bind="subcate.subcategory_id"
                                            class="text-center small font-monospace text-uppercase"></td>
                                        <td class="text-center" data-ng-bind="jsonParse(subcate.subcategory_name).ar"></td>
                                        <td class="text-center" data-ng-bind="jsonParse(subcate.subcategory_name).en"></td>
                                        <td class="text-center" data-ng-bind="jsonParse(subcate.category_name).ar"></td>
                                        <td class="text-center" data-ng-bind="jsonParse(subcate.category_name).en"></td>
                                        <td class="col-fit">
                                            <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                data-ng-click="setSubCategory($index)"></button>
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

        @include('components.dashbords.modals.modal_market_subcategories')

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
            $scope.updateSubCategory = false;
            $scope.list = [];
            $scope.last_id = 0;
            $scope.jsonParse = (str) => JSON.parse(str);
            $scope.categories = <?= json_encode($categories) ?>;
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

                $.post("/markets/subcategories/load", request, function(data) {
                    $('.loading-spinner').hide();
                    var ln = data.length;
                    $scope.$apply(() => {
                        $scope.loading = false;
                        if (ln) {
                            $scope.noMore = ln < limit;
                            $scope.list = data;
                            console.log(data)
                            $scope.last_id = data[ln - 1].subcategory_id;
                        }
                    });
                }, 'json');
            }

            $scope.setSubCategory = (indx) => {
                $scope.updateSubCategory = indx;
                $('#subCategoryForm').modal('show');
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
