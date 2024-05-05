@extends('index')
@section('title')
    Subscriptions
@endsection
@section('search')
    <form id="searchForm" role="search">
        <input type="search" name="q" class="form-control my-3 my-md-0 rounded-pill" id="searchInput"
            placeholder="Search...">
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
                                    role="status"></span><span>SUBSCRIPTIONS</span>
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                    data-ng-click="setSubscriotion(false)"></button>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>

                        </div>
                        <h5 class="text-dark" id="data"> </h5>
                        <div data-ng-if="list.length" class="table-responsive">
                            <table class="table table-hover" id="subscriptions_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center">Technician Name</th>
                                        <th class="text-center">Package Points</th>
                                        {{-- <th>User Name</th> --}}
                                        <th class="text-center">Start Date</th>
                                        <th class="text-center">End Date</th>
                                        <th class="text-center">Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="sub in list track by $index">
                                        <td data-ng-bind="sub.sub_id"></td>
                                        <td class="text-center" data-ng-bind="sub.tech_name"></td>
                                        <td class="text-center" data-ng-bind="sub.sub_points"></td>
                                        {{-- <td data-ng-bind="sub.user_name"></td> --}}
                                        <td class="text-center" data-ng-bind="sub.sub_start"></td>
                                        <td class="text-center" data-ng-bind="sub.sub_end"></td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-<%statusObj.color[sub.sub_status]%> rounded-pill font-monospace"><%statusObj.name[sub.sub_status]%></span>

                                        </td>

                                        <td class="col-fit">
                                            <div>
                                                <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                    data-ng-click="setSubscriotion($index)"></button>
                                                <button class="btn btn-outline-danger btn-circle bi bi-stopwatch"
                                                    data-ng-click="changeSta($index)"></button>
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
        @include('components.dashbords.modals.modal_subscription')
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
            $scope.statusObj = {
                name: ['in-active', 'Active'],
                color: ['danger', 'success']
            }
            $scope.q = '';
            $scope.noMore = false;
            $scope.loading = false;
            $scope.updateSubscription = false;
            $scope.technicianName = false;
            $scope.userName = false;
            $scope.list = [];
            $scope.last_id = 0;
            $scope.dataLoader = function(reload = false) {

                if (reload) {
                    $scope.noMore = false;
                    $scope.list = [];
                    $scope.last_id = 0;
                }
                if ($scope.noMore) return;
                $scope.loading = true;
                $('.loading-spinner').show();

                $.post("/subscriptions/load/", {
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
                            $scope.last_id = data[ln - 1].sub_id;
                        };
                    });
                }, 'json');

            }

            $scope.setSubscriotion = (indx) => {
                $scope.updateSubscription = indx;
                $('#subscriotionForm').modal('show');
            };

            $scope.changeSta = (indx) => {
                $scope.updateSubscription = indx;
                $('#changeStatus').modal('show');
            };

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
                        $('#TechnicianName').append('<option id="class" value="' + value
                            .tech_id +
                            '">' + value.tech_name + '</option>');
                    });
                }
            });
        });

        $(function() {
            $("#subStart").datetimepicker($.extend({}, dtp_opt, {
                showTodayButton: false,
                format: "YYYY-MM-DD",
            }));

            $("#subEnd").datetimepicker($.extend({}, dtp_opt, {
                showTodayButton: false,
                format: "YYYY-MM-DD",
            }));
        });
        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            scope.$apply(() => scope.q = $(this).find('input').val());
            scope.dataLoader(true);
        });
    </script>
@endsection
