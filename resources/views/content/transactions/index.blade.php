@extends('index')
@section('title')
    Transactions
@endsection
@section('search')
    <form id="searchForm" role="search">
        <input type="search" name="q" class="form-control my-3 my-md-0 rounded-pill" placeholder="Search...">
    </form>
@endsection
@section('content')
    <div class="container-fluid" data-ng-app="myApp" data-ng-controller="myCtrl">
        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
        <div class="row">
            <div class="col-12 col-sm-4 col-lg-3">
                <div class="card card-box">
                    <div class="card-body">
                        {{-- <div class="mb-3">
                            <label for="roleFilter">Role</label>
                            <select name="" id="" class="form-select">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="roleFilter">Status</label>
                            <select name="" id="" class="form-select">
                                <option value=""></option>
                            </select>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-8 col-lg-9">
                <div class="card card-box">
                    <div class="card-body">
                        <div class="d-flex">
                            <h5 class="card-title fw-semibold pt-1 me-auto mb-3">
                                <span class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                    role="status"></span><span>TRANSACTIONS</span>
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                    data-ng-click="setTransaction(false)"></button>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>

                        </div>
                        {{-- <h5 data-ng-if="q" class="text-dark">Result of <span class="text-primary" data-ng-bind="q"></span>
                        </h5> --}}
                        <div data-ng-if="list.length" class="table-responsive">
                            <table class="table table-hover" id="transactions_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center">Technician Name</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Process type </th>
                                        <th class="text-center">Method </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="tran in list track by $index">
                                        <td data-ng-bind="tran.trans_ref"></td>
                                        <td class="text-center" data-ng-bind="tran.tech_name"></td>
                                        <td class="text-center" data-ng-bind="tran.trans_amount"></td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-<%procesObj.color[tran.trans_process]%> rounded-pill font-monospace p-2"><%procesObj.name[tran.trans_process]%></span>

                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-dark rounded-pill font-monospace p-2"><%methodObj.name[tran.trans_method]%></span>

                                        </td>

                                        <td class="col-fit">
                                            <div>
                                                <a class="btn btn-outline-dark btn-circle bi bi-link-45deg"
                                                    href="/transactions/profile/<% tran.trans_ref %>" target="_blank"></a>
                                                <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                    data-ng-click="setTransaction($index)"></button>
                                                {{-- <button class="btn btn-outline-danger btn-circle bi bi-stopwatch"
                                                    data-ng-click="changePero($index)"></button> --}}
                                            </div>
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
        @include('components.dashbords.modals.modal_transaction')
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
            $scope.procesObj = {
                name: ['', 'Spend', 'Earn'],
                color: ['', 'danger', 'success']
            };
            $scope.methodObj = {
                name: ['', 'Gateway', 'Cash', 'Wallet', 'Cobon', 'Transfer'],
            }
            $scope.q = '';
            $scope.noMore = false;
            $scope.loading = false;
            $scope.centerUpdate = false;
            $scope.updateTransactions = false;
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

                $.post("/transactions/load/", {
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
                            $scope.last_id = data[ln - 1].trans_id;
                        };
                    });
                }, 'json');
            }

            $scope.setTransaction = (indx) => {
                $scope.updateTransactions = indx;
                $('#tranForm').modal('show');
            };

            // $scope.changePero = (indx) => {
            //     $scope.updateSubscription = indx;
            //     $('#changePerotus').modal('show');
            // };

            $scope.dataLoader();
            scope = $scope;
        });

        $('#search').on('change', function() {
            var idState = this.value;
            console.log(idState);
            $('#TechnicianName').html('');
            $.ajax({
                url: '/centers/getTechnician/' + idState,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    $.each(res, function(key, value) {
                        console.log(value.tech_name);
                        $('#TechnicianName').append('<option id="class" value="' + value
                            .tech_id +
                            '">' + value.tech_name + '</option>');
                    });
                }
            });
        });

        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            scope.$apply(() => scope.q = $(this).find('input').val());
            scope.dataLoader(true);
        });

        function clerForm() {
            var input_method = $('#method').val(' '),
                input_search = $('#search').val(' '),
                input_technician = $('#TechnicianName').val(' '),
                input_amount = $('#amount').val(' '),
                input_process = $('#process').val('-- SELECT PROCESS NAME --');
        };
    </script>
@endsection
