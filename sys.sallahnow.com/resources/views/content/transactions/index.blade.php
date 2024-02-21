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
                        <h5 data-ng-if="q" class="text-dark">Result of <span class="text-primary" data-ng-bind="q"></span>
                        </h5>
                        <div data-ng-if="transactions.length" class="table-responsive">
                            <table class="table table-hover" id="transactions_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Technician Name</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Process type </th>
                                        <th>Method </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="tran in transactions track by $index">
                                        <td data-ng-bind="tran.reference"></td>
                                        <td data-ng-bind="technicianName[$index].name"></td>
                                        <td data-ng-bind="tran.trans_amount"></td>
                                        <td data-ng-bind="tran.created_at"></td>
                                        <td>
                                            <span
                                                class="badge bg-<%procesObj.color[tran.ptrans_rocess]%> rounded-pill font-monospace"><%procesObj.name[tran.ptrans_rocess]%></span>

                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-dark rounded-pill font-monospace"><%methodObj.name[tran.ptrans_rocess]%></span>

                                        </td>

                                        <td>
                                            <div class="col-fit">
                                                <a class="btn btn-outline-dark btn-circle bi bi-link-45deg"
                                                    href="/transactions/profile/<% tran.reference %>" target="_blank"></a>
                                                <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                    data-ng-click="setTransaction($index)"></button>
                                                <button class="btn btn-outline-danger btn-circle bi bi-stopwatch"
                                                    data-ng-click="changePero($index)"></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div data-ng-if="!transactions.length" class="text-center text-secondary py-5">
                            <i class="bi bi-people  display-4"></i>
                            <h5>No records</h5>
                        </div>
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
                            @csrf @method('POST')
                            <input data-ng-if="updateTransactions !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="tran_id"
                                data-ng-value="updateTransactions !== false ? transactions[updateTransactions].id : 0">
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
                                        <input type="search" class="form-control" name="search"
                                            placeholder="Search Technician By code" id="search">
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="mb-3">
                                        <label for="TechnicianName">Technician Name<b class="text-danger">&ast;</b></label>
                                        <select class="form-control" name="technician_name" id="TechnicianName"></select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label>Amount<b class="text-danger">&ast;</b></label>
                                        <input id="amount" type="text" class="form-control" name="amount"
                                            data-ng-value="transactions[updateTransactions].amount" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label>Process<b class="text-danger">&ast;</b></label>
                                        <select name="process" class="form-control" id="method">
                                            <option value="">-- SELECT PROCESS NAME</option>
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
            $scope.updateTransactions = false;
            $scope.technicianName = false;
            $scope.userName = false;
            $scope.transactions = [];
            $scope.page = 1;
            $scope.dataLoader = function(reload = false) {
                $('.loading-spinner').show();
                if (reload) {
                    $scope.page = 1;
                }
                $.post("/transactions/load/", {
                    page: $scope.page,
                    limit: 24,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.transactions = data;
                        $scope.page++;
                    });
                }, 'json');

                $.post("/technicians/load/", {
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.technicians = data;
                    });
                }, 'json');

                $.post("/packages/load/", {
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.packages = data;
                    });
                }, 'json');
            }

            $scope.setTransaction = (indx) => {
                $scope.updateSubscription = indx;
                $('#tranForm').modal('show');
            };

            $scope.changePero = (indx) => {
                $scope.updateSubscription = indx;
                $('#changePerotus').modal('show');
            };

            $scope.getTechnicianName = function() {
                $.post("/transactions/subTranTechnician/", {
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.technicianName = data;
                    });
                }, 'json');
            }

            $scope.dataLoader();
            $scope.getTechnicianName();
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
                        $('#TechnicianName').append('<option id="class" value="' + value.id +
                            '">' + value.name + '</option>');
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
                                scope.transactions.unshift(response.data);
                                $scope.dataLoader();
                            } else {
                                scope.transactions[scope.updateTransactions] = response
                                    .data;
                                $scope.dataLoader();
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
        });

        // change status sub
        $(function() {
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
                                scope.transactions[scope.updateSubscription] = response
                                    .data;
                                $scope.dataLoader();
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
        });
    </script>
@endsection
