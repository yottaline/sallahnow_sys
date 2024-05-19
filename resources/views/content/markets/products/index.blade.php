@extends('index')
@section('title', 'Products')
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
                        {{-- store --}}
                        <div class="mb-3">
                            <label>Stores<b class="text-danger">&ast;</b></label>
                            <select id="filter-store" class="form-select">
                                <option value="0">-- SELECT STORE NAME --</option>
                                <option data-ng-repeat="s in stores" data-ng-value="s.store_id" data-ng-bind="s.store_name">
                                </option>
                            </select>
                        </div>
                        {{-- store --}}
                        <div class="mb-3">
                            <label>Categories<b class="text-danger">&ast;</b></label>
                            <select id="filter-caetgories" class="form-select">
                                <option value="0">-- SELECT CATEEGOY NAME --</option>
                                <option data-ng-repeat="categoy in categories" data-ng-value="categoy.category_id"
                                    data-ng-bind="jsonParse(categoy.category_name)['en']">
                                </option>
                            </select>
                        </div>
                        {{-- store --}}
                        <div class="mb-3">
                            <label>Sub categories<b class="text-danger">&ast;</b></label>
                            <select id="filter-store" class="form-select">
                                <option value="0">-- SELECT SUB CATEGORY NAME --</option>
                                <option data-ng-repeat="sub in subcategories" data-ng-value="sub.subcategory_id"
                                    data-ng-bind="jsonParse(sub.subcategory_name)['en']">
                                </option>
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
                                    role="status"></span><span>PRODUCTS</span>
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                    data-ng-click="setProduct(false)"></button>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>
                        </div>

                        <h5 data-ng-if="q" class="text-dark">Results of <span class="text-primary" data-ng-bind="q"></span>
                        </h5>

                        <div data-ng-if="list.length" class="table-responsive">
                            <table class="table table-hover" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Product Name</th>
                                        <th class="text-center">Store Name</th>
                                        <th class="text-center">Category Name</th>
                                        <th class="text-center">SubCategory Name</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Discount</th>
                                        <th class="text-center">Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="product in list track by $index">
                                        <td data-ng-bind="product.product_code"
                                            class="text-center small font-monospace text-uppercase"></td>
                                        <td class="text-center" data-ng-bind="product.store_name"></td>
                                        <td class="text-center" data-ng-bind="product.store_name"></td>
                                        <td class="text-center" data-ng-bind="product.store_name"></td>
                                        <td class="text-center" data-ng-bind="product.store_name"></td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-<%positionObj.color[product.product_admin]%> rounded-pill font-monospace p-2"><%positionObj.name[product.product_admin]%></span>

                                        </td>
                                        <td class="text-center">
                                            <span data-ng-if="!product.product_approved">Not Approved</span>
                                            <span
                                                data-ng-if="product.product_approved"data-ng-bind="product.product_approved"></span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-<%statusObject.color[product.product_active]%> rounded-pill font-monospace"><%statusObject.name[product.product_active]%></span>

                                        </td>
                                        <td class="col-fit">
                                            <button class="btn btn-outline-success btn-circle bi bi-toggles"
                                                data-ng-click="editActive($index)"></button>
                                            <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                data-ng-click="setProduct($index)"></button>
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

        {{-- @include('components.dashbords.modals.modal_product') --}}

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
            $scope.updateProduct = false;
            $scope.list = [];

            $scope.last_id = 0;
            $scope.jsonParse = (str) => JSON.parse(str);
            $scope.stores = <?= json_encode($stores) ?>;
            $scope.categories = <?= json_encode($categories) ?>;
            $scope.subcategories = <?= json_encode($subcategories) ?>;
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

                $.post("/markets/products/load", request, function(data) {
                    $('.loading-spinner').hide();
                    var ln = data.length;
                    $scope.$apply(() => {
                        $scope.loading = false;
                        if (ln) {
                            $scope.noMore = ln < limit;
                            $scope.list = data;
                            console.log(data)
                            $scope.last_id = data[ln - 1].product_id;
                        }
                    });
                }, 'json');
            }

            $scope.setProduct = (indx) => {
                $scope.updateProduct = indx;
                $('#storeModal').modal('show');
            };
            $scope.editActive = (index) => {
                $scope.updateProduct = index;
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
