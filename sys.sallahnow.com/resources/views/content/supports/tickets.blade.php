@extends('index')
@section('title')
    Tickets
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
                                    role="status"></span><span>SUPPORT TICKETS</span>
                            </h5>
                            <div>
                                {{-- <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                    data-ng-click="setCate(false)"></button> --}}
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>
                        </div>

                        <h5 data-ng-if="q" class="text-dark">Result of <span class="text-primary" data-ng-bind="q"></span>
                        </h5>

                        <div data-ng-if="tickets.length" class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Brand Name</th>
                                        <th class="text-center">Model Name</th>
                                        <th class="text-center">Technician Name</th>
                                        <th class="text-center">Category Name</th>
                                        <th class="text-center">Category Cost</th>
                                        <th class="text-center">Context</th>
                                        <th class="text-center">Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="ticket in tickets track by $index">
                                        <td data-ng-bind="ticket.ticket_code"
                                            class="text-center small font-monospace text-uppercase"></td>
                                        <td class="text-center" data-ng-bind="ticket.brand_name"></td>
                                        <td class="text-center" data-ng-bind="ticket.model_name"></td>
                                        <td class="text-center" data-ng-bind="ticket.tech_name"></td>
                                        <td class="text-center" data-ng-bind="jsonParse(ticket.category_name)['en']"></td>
                                        <td class="text-center" data-ng-bind="ticket.ticket_cost"></td>
                                        <td class="text-center" data-ng-bind="ticket.ticket_context"></td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-<%statusTicket.color[ticket.ticket_status]%> rounded-pill font-monospace p-2"><%statusTicket.name[ticket.ticket_status]%></span>
                                        </td>

                                        <td class="col-fit">
                                            <button class="btn btn-outline-primary btn-circle bi bi-signal"
                                                data-ng-click="replie($index)"></button>
                                            <button class="btn btn-outline-success btn-circle bi bi-check2-circle"
                                                data-ng-click="changeStatus($index)"></button>
                                            <a href="/tickets/get-replie/<% ticket.ticket_id %>"
                                                class="btn btn-outline-dark btn-circle bi bi bi-wechat"></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div data-ng-if="!tickets.length" class="text-center text-secondary py-5">
                            <i class="bi bi-exclamation-circle display-3"></i>
                            <h5 class="">No records</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="centerForm" tabindex="-1" role="dialog" aria-labelledby="centerFormLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="cenForm" method="post" action="/tickets/add-replie/" enctype="multipart/form-data">
                            @csrf
                            <input data-ng-if="ticketUpdate !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="ticket_id" data-ng-value="tickets[ticketUpdate].ticket_id">
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="mb-3">
                                        <label for="replieText">Replie Text<b class="text-danger">&ast;</b></label>
                                        <textarea name="replie" id="replieText" class="form-control" rows="6"></textarea>
                                    </div>
                                </div>

                                <div class="col-12 col-md-12">
                                    <div class="mb-3">
                                        <label for="replieAttachment">Replie Attachmet<b
                                                class="text-danger">&ast;</b></label>
                                        <input type="file" name="attachment" class="form-control"
                                            id="replieAttachment">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex">
                                <button type="button" class="btn btn-outline-secondary me-auto btn-sm"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
                            </div>
                        </form>
                        <script>
                            $('#cenForm').on('submit', e => e.preventDefault()).validate({
                                rules: {
                                    name_en: {
                                        required: true
                                    },
                                    name_ar: {
                                        required: true
                                    }
                                },
                                submitHandler: function(form) {
                                    console.log(form);
                                    var formData = new FormData(form),
                                        action = $(form).attr('action'),
                                        method = $(form).attr('method');

                                    $(form).find('button').prop('disabled', true);
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
                                            $('#centerForm').modal('hide');
                                            scope.$apply(() => {
                                                if (scope.centerUpdate === false) {
                                                    scope.centers.unshift(response.data);
                                                    scope.dataLoader();
                                                } else {
                                                    scope.centers[scope.centerUpdate] = response.data;
                                                    scope.dataLoader();
                                                }
                                            });
                                        } else toastr.error(response.message);
                                    }).fail(function(jqXHR, textStatus, errorThrown) {
                                        toastr.error("error");
                                    }).always(function() {
                                        $(form).find('button').prop('disabled', false);
                                    });
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="changeStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="/tickets/change-status/">
                            @csrf
                            <input data-ng-if="ticketUpdate !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="ticket_id"
                                data-ng-value="tickets !== false ? tickets[ticketUpdate].ticket_id : 0">
                            <div class="mb-3">
                                <label for="status">Ticket Status <b class="text-danger">&ast;</b></label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">-- SELECT STATUS --</option>
                                    <option value="2">Opened</option>
                                    <option value="3">Closed</option>
                                    <option value="4">Solved</option>
                                    <option value="5">Canceled</option>
                                </select>
                            </div>
                            <div class="d-flex">
                                <button type="button" class="btn btn-outline-secondary me-auto"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('js')
        <script>
            var scope, app = angular.module('myApp', [], function($interpolateProvider) {
                $interpolateProvider.startSymbol('<%');
                $interpolateProvider.endSymbol('%>');
            });

            app.controller('myCtrl', function($scope) {
                $scope.statusTicket = {
                    name: ['', 'Unread', 'Opened', 'Closed', 'Solved', 'Canceled'],
                    color: ['', 'dark', 'primary', 'warning', 'success', 'danger']
                }
                $('.loading-spinner').hide();
                $scope.jsonParse = (str) => JSON.parse(str);
                $scope.q = '';
                $scope.ticketUpdate = false;
                $scope.tickets = [];
                $scope.page = 1;
                $scope.dataLoader = function(reload = false) {
                    $('.loading-spinner').show();
                    if (reload) {
                        $scope.page = 1;
                    }
                    $.post("/tickets/load", {
                        page: $scope.page,
                        limit: 24,
                        _token: '{{ csrf_token() }}'
                    }, function(data) {
                        $('.loading-spinner').hide();
                        $scope.$apply(() => {
                            $scope.tickets = data;
                            console.log(data)
                            $scope.page++;
                        });
                    }, 'json');
                }

                $scope.replie = (indx) => {
                    $scope.ticketUpdate = indx;
                    $('#centerForm').modal('show');
                };

                $scope.changeStatus = (index) => {
                    $scope.ticketUpdate = index;
                    $('#changeStatus').modal('show');
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

            $(function() {
                $('#changeStatus form').on('submit', function(e) {
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
                        console.log(data);
                        var response = JSON.parse(data);
                        if (response.status) {
                            toastr.success('Category Update cost successfully');
                            $('#changeStatus').modal('hide');
                            scope.$apply(() => {
                                if (scope.ticketUpdate === false) {
                                    $scope.dataLoader(true);
                                } else {
                                    scope.tickets[scope.ticketUpdate] = response
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
