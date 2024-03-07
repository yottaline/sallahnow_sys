@extends('index')
@section('title')
    Points
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
                        <div class="input-group mt-3 mb-3">
                            {{-- <label for="MobileFilter"></label> --}}
                            <input type="search" name="tech_mobile" placeholder="Search Technician Mobile"
                                id="MobileFilter" class="form-control">
                            <div class="input-group-text" style="cursor: pointer"><i class="bi bi-search"
                                    data-ng-click="getPermissions(role)"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-8 col-lg-9">
                <div class="card card-box">
                    <div class="card-body">
                        <div class="d-flex">
                            <h5 class="card-title fw-semibold pt-1 me-auto mb-3">
                                <span class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                    role="status"></span><span>POINTS</span>
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>

                        </div>
                        <h5 data-ng-if="q" class="text-dark">Result of <span class="text-primary" data-ng-bind="q"></span>
                        </h5>
                        <div data-ng-if="points.length" class="table-responsive">
                            <table class="table table-hover" id="points_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Technician Name</th>
                                        <th>Points Count</th>
                                        <th>Process type</th>
                                        <th>Point source</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="test">

                                    <tr data-ng-repeat="point in points track by $index" id="tBoody">
                                        <td data-ng-bind="point.points_id"></td>
                                        <td data-ng-bind="point.tech_name"></td>
                                        <td data-ng-bind="point.points_count"></td>
                                        <td>
                                            <span
                                                class="badge bg-<%procesObj.color[point.points_process]%> rounded-pill font-monospace"><%procesObj.name[point.points_process]%></span>

                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-dark rounded-pill font-monospace"><%scrObj.name[point.points_src]%></span>

                                        </td>
                                        <td data-ng-bind="point.points_register"></td>
                                        <td>
                                            <div class="col-fit">
                                                {{-- <a class="btn btn-outline-dark btn-circle bi bi-link-45deg"
                                                    href="/points/profile/<% point.technician_id %>" target="_blank"></a>
                                                <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                    data-ng-click="setPoint($index)"></button>
                                                <button class="btn btn-outline-danger btn-circle bi bi-stopwatch"
                                                    data-ng-click="changePero($index)"></button> --}}
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div data-ng-if="!points.length" class="text-center text-secondary py-5">
                            <i class="bi bi-exclamation-circle display-4"></i>
                            <h5>No records</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- start add new suggestion  Modal -->
        <div class="modal fade" id="pointForm" tabindex="-1" role="dialog" aria-labelledby="pointFormLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="/points/submit/">
                            @csrf @method('POST')
                            <input data-ng-if="updatePoint !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="point_id"
                                data-ng-value="updatePoint !== false ? points[updatePoint].id : 0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="PointSource">Point source</label>
                                        <select name="point_source" class="form-control" id="PointSource">
                                            <option value="">-- SELECT SOURCE NAME</option>
                                            <option value="1">Pkg</option>
                                            <option value="2">Credit</option>
                                            <option value="3">Cobon</option>
                                            <option value="4">Academy</option>
                                            <option value="5">Ticket</option>
                                            <option value="6">Transfer</option>
                                            <option value="7">Sugg</option>
                                            <option value="7">Ads</option>
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
                                        <label>Count<b class="text-danger">&ast;</b></label>
                                        <input id="Count" type="text" class="form-control" name="Count"
                                            data-ng-value="updatePoint !== false ? points[updatePoint].count : ''" />
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
            $scope.scrObj = {
                name: ['', 'Pkg', 'Credit', 'Cobon', 'Academy', 'Ticket', 'Transfer', 'Sugg', 'Ads',
                    'Articles'
                ],
            }
            $scope.updatePoint = false;
            $scope.points = [];
            $scope.page = 1;
            $scope.dataLoader = function(reload = false) {
                $('.loading-spinner').show();
                if (reload) {
                    $scope.page = 1;
                }
                $.post("/points/load/", {
                    page: $scope.page,
                    limit: 24,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.points = data;
                        $scope.page++;
                    });
                }, 'json');
            }

            $scope.setPoint = (indx) => {
                $scope.updatePoint = indx;
                $('#pointForm').modal('show');
            };

            $scope.changePero = (indx) => {
                $scope.updatePoint = indx;
                $('#changePerotus').modal('show');
            };

            $scope.dataLoader();
            scope = $scope;
        });

        $('#MobileFilter').on('change', function() {
            var idState = this.value;
            $('#techName').html('');
            $.ajax({
                url: 'get-technician/' + idState,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    // console.log(res)
                    if (res.length > 0) {
                        document.getElementById('tBoody').style.display = "none"
                        $.each(res, function(key, value) {
                            $('#test').append('<tr><td>' + value.points_id + '</td> <td>' +
                                value
                                .tech_name + '</td><td>' + value
                                .points_count + '</td><td>' + ' ' + '</td><td>' + ' ' +
                                '</td><td>' +
                                value
                                .points_register + '</td> </tr>');
                        });
                    } else {
                        document.getElementById('tBoody').style.display = "none"
                        $('#test').append(
                            '<tr><td></td><td></td> <td class="text-center">No Ponit to that Technician </td><td></td><td></td></tr>'
                        )
                    }

                }
            });
        });

        // add tran
        $(function() {
            $('#pointForm form').on('submit', function(e) {
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
                        $('#pointForm').modal('hide');
                        scope.$apply(() => {
                            if (scope.updatePoint === false) {
                                scope.points.unshift(response.data);
                                scope.dataLoader();
                            } else {
                                scope.points[scope.updatePoint] = response
                                    .data;
                                scope.dataLoader();
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
