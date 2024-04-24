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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
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

        <!-- start add new suggestion  Modal -->
        <div class="modal fade" id="tranForm" tabindex="-1" role="dialog" aria-labelledby="tranFormLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="/transactions/submit/">
                            @csrf
                            <input data-ng-if="updateTransactions !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="tran_id"
                                data-ng-value="updateTransactions !== false ? list[updateTransactions].trans_id : 0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="method">Method</label>
                                        <select name="method" class="form-control" id="method">
                                            <option value="">-- SELECT METHOD NAME</option>
                                            {{-- <option value="1">Gateway</option> --}}
                                            <option value="2">Cash</option>
                                            <option value="3">Wallet</option>
                                            {{-- <option value="4">Cobon</option> --}}
                                            {{-- <option value="5">Transfer</option> --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="mb-3">
                                        <label>Search Technician By code</label>
                                        <input type="search" class="form-control" name="search" id="search"
                                            data-ng-value="list[updateTransactions].tech_code">
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="mb-3">
                                        <label for="TechnicianName">Technician Name<b class="text-danger">&ast;</b></label>
                                        <p data-ng-if="updateTransactions !== false" class="form-control mb-2"
                                            data-ng-bind="list[updateTransactions].tech_name">
                                        </p>
                                        <select class="form-control" name="technician_id" id="TechnicianName"></select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label>Amount<b class="text-danger">&ast;</b></label>
                                        <input id="amount" type="text" class="form-control" name="amount"
                                            data-ng-value="list[updateTransactions].trans_amount" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label>Process<b class="text-danger">&ast;</b></label>
                                        <select name="process" class="form-control" id="process">
                                            <option value="">-- SELECT PROCESS NAME --</option>
                                            <option value="1">Spend</option>
                                            <option value="2">Earn</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex">
                                    <button type="button" class="btn btn-outline-secondary me-auto"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-outline-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end add new suggestion  Modal -->

        <!-- start change process  Modal -->
        {{-- <div class="modal fade" id="changePerotus" tabindex="-1" role="dialog" aria-labelledby="changePerotusLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="/transactions/change/">
                            @csrf @method('PUT')
                            <input type="hidden" name="tran_id" data-ng-value="transactions[updateSubscription].id">
                            <p>Are you sure the subscription Process has changed?</p>
                            <div class="row">
                                <div class="d-flex">
                                    <button type="button" class="btn btn-outline-secondary me-auto"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-outline-primary">Sure</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- end change process  Modal -->

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

        // add tran
        $(function() {
            $('#tranForm form').on('submit', function(e) {
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
                    var response = JSON.parse(data);
                    if (response.status) {
                        toastr.success('Data processed successfully');
                        $('#tranForm').modal('hide');
                        scope.$apply(() => {
                            if (scope.updateTransactions === false) {
                                clerForm();
                                scope.list.unshift(response.data);
                                scope.dataLoader(true);
                            } else {
                                scope.list[scope.updateTransactions] = response
                                    .data;
                                scope.dataLoader(true);
                            }
                        });
                    } else toastr.error("Error");
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    // error msg
                }).always(function() {
                    spinner.hide();
                    controls.prop('disabled', false);
                });

            })

            // change status sub
            $('#changePerotus form').on('submit', function(e) {
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
                    var response = JSON.parse(data);
                    if (response.status) {
                        toastr.success('Status change successfully');
                        $('#changePerotus').modal('hide');
                        scope.$apply(() => {
                            if (scope.updateSubscription === false) {
                                $scope.dataLoader(true);
                            } else {
                                scope.list[scope.updateSubscription] = response
                                    .data;
                                $scope.dataLoader(true);
                            }
                        });
                    } else toastr.error("Error");
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    // error msg
                }).always(function() {
                    spinner.hide();
                    controls.prop('disabled', false);
                });

            })

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
        });
    </script>
@endsection
