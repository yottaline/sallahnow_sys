@extends('index')
@section('title', 'Orders')
@section('search')
    <form id="nvSearch" role="search">
        <input type="search" name="q" class="form-control my-3 my-md-0 rounded-pill" placeholder="Search...">
    </form>
@endsection
@section('content')
    <style>
        .table>:not(:first-child) {
            border-top: 1px solid #ccc !important;
        }

        tbody input,
        tfoot input {
            padding: 5px;
            border: 1px dashed #ccc !important;
            outline: none !important;
        }

        #inv-item-input {
            padding-left: 35px
        }

        #items-selector {
            position: absolute;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            background-color: #fff;
            border: 1px solid #ccc;
            border-top: 0;
            box-shadow: 2px 2px 2px #eee;
        }

        #items-selector>.items-list>a {
            border-right: 5px solid transparent;
            text-decoration: none;
            display: block;
            color: #2d2d2d;
            padding: 5px 10px;
        }

        #items-selector>.items-list>a:focus {
            border-right-color: #2d2d2d;
            background-color: #f8f8f8;
        }
    </style>
    <div class="container-fluid" data-ng-app="myApp" data-ng-controller="myCtrl">
        <div class="row">
            <div class="col-12 col-sm-4 col-lg-3">
                <div class="card card-box">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="roleFilter">Customer Name</label>
                            <input type="text" class="form-control" id="filter-name">
                        </div>

                        <div class="mb-3">
                            <label for="roleFilter">Order Date</label>
                            <input type="text" id="filterOrderDate" class="form-control text-center text-monospace"
                                id="filter-date">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-8 col-lg-9">
                <div class="card card-box">
                    <div class="card-body">
                        <div class="d-flex">
                            <h5 class="card-title fw-semibold pt-1 me-auto  text-uppercase">
                                <span class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                    role="status"></span><span>ORDERS</span>
                            </h5>
                            <div>
                                {{-- <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                    data-ng-click="setOrder(false)"></button> --}}
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>
                        </div>
                        <div data-ng-if="list.length" class="table-responsive">
                            <table class="table table-hover" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Customer Name</th>
                                        <th class="text-center">Order Date</th>
                                        <th class="text-center">Discount</th>
                                        <th class="text-center">Total Price</th>
                                        <th class="text-center">Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="order in list">
                                        <td data-ng-bind="order.order_code"
                                            class="text-center small font-monospace text-uppercase">
                                        </td>
                                        <td class="text-center" data-ng-bind="order.customer_name">
                                        </td>
                                        <td data-ng-bind="order.order_create" class="text-center"></td>
                                        <td class="text-center"><% order.order_disc %>%</td>
                                        <td data-ng-bind="order.order_subtotal" class="text-center"></td>
                                        <td class="text-center">
                                            <button ng-if="order.order_status == 1"
                                                class="btn btn-outline-danger btn-circle bi bi-x"
                                                ng-click="opt($index, 2)"></button>
                                            <button ng-if="order.order_status == 1"
                                                class="btn btn-outline-primary btn-circle bi bi-check"
                                                ng-click="opt($index, 3)"></button>
                                            <button ng-if="order.order_status == 3"
                                                class="btn btn-outline-success btn-circle bi bi-check"
                                                ng-click="opt($index, 4)"></button>
                                            <button ng-if="order.order_status == 4"
                                                class="btn btn-outline-success btn-circle bi bi-truck"
                                                ng-click="opt($index, 5)"></button>
                                        </td>
                                        <td class="col-fit">
                                            <button class="btn btn-outline-dark btn-circle bi bi-eye"
                                                data-ng-click="viewDetails(order)"></button>
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

        <div class="modal fade" id="edit_disc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-ng-repeat="details in orderDetails">
                                    <th scope="row"></th>
                                    <td data-ng-bind="details.product_name"></td>
                                    <td data-ng-bind="details.orderItem_qty"></td>
                                    <td data-ng-bind="details.orderItem_subtotal"></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3">
                                        Total amount
                                    </th>
                                    <th data-ng-bind="orDe.order_subtotal"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
            $scope.statusObject = {
                name: ['غير مفعل', 'مفعل'],
                color: ['danger', 'success']
            };
            $scope.noMore = false;
            $scope.loading = false;
            $scope.q = '';
            $scope.updateOrders = false;
            $scope.list = [];
            $scope.orderDetails = [];
            $scope.orDe = [];
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
                    date: $('#filter-date').val(),
                    c_name: $('#filter-name').val(),
                    q: $scope.q,
                    last_id: $scope.last_id,
                    limit: limit,
                    _token: '{{ csrf_token() }}'
                };

                $.post("/markets/orders/load", request, function(data) {
                    $('.loading-spinner').hide();
                    var ln = data.length;
                    $scope.$apply(() => {
                        $scope.loading = false;
                        if (ln) {
                            $scope.noMore = ln < limit;
                            $scope.list.push(...data);
                            $scope.last_id = data[ln - 1].order_id;
                            console.log(data)
                        }
                    });
                }, 'json');
            }

            $scope.viewDetails = (order) => {
                $.get("/markets/orders/view/" + order.order_id, function(data) {
                    $('.perm').show();
                    scope.$apply(() => {

                        scope.orderDetails = data.items;
                        scope.orDe = data.order;
                        console.log(data)
                        $('#edit_disc').modal('show');
                    });
                }, 'json');
            }

            $scope.dataLoader();
            scope = $scope;
        });

        $(function() {
            $('#nvSearch').on('submit', function(e) {
                e.preventDefault();
                scope.$apply(() => scope.q = $(this).find('input').val());
                scope.dataLoader(true);
            });

            $("#filterOrderDate").datetimepicker($.extend({}, dtp_opt, {
                showTodayButton: false,
                format: "YYYY-MM-DD",
            }));
        });
    </script>
@endsection
