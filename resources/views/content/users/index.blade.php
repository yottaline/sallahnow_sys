@extends('index')
@section('title', 'Users')
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
                            <label for="roleFilter">Role</label>
                            <select class="js-example-basic-single form-control" name="state">
                                <option data-ng-repeat="role in roles" data-ng-value="role.ugroup_id"
                                    data-ng-bind="role.ugroup_name"></option>
                            </select>
                        </div>
                        {{-- It will be worked on soon --}}
                        <div class="mb-3">
                            <label for="roleFilter">Status</label>
                            <select id="filter-status" class="form-select">
                                <option value="">-----</option>
                                <option value="1">Blocd</option>
                                <option value="2">Active</option>
                            </select>
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
                                    role="status"></span><span>USERS</span>
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                    data-ng-click="setUser(false)"></button>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>
                        </div>
                        <div data-ng-if="list.length" class="table-responsive">
                            <table class="table table-hover" id="user_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th class="text-center">Role</th>
                                        <th class="text-center">Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="user in list track by $index">
                                        <td data-ng-bind="user.id" class="small font-monospace text-uppercase">
                                        </td>
                                        <td>
                                            <span data-ng-bind="user.user_name" class="fw-bold"></span><br>
                                            <small data-ng-if="+user.user_mobile"
                                                class="me-1 db-inline-block dir-ltr font-monospace badge bg-primary">
                                                <i class="bi bi-phone me-1"></i>
                                                <span data-ng-bind="user.user_mobile" class="fw-normal"></span>
                                            </small>
                                            <small data-ng-if="user.user_email"
                                                class="db-inline-block dir-ltr font-monospace badge bg-primary">
                                                <i class="bi bi-envelope-at me-1"></i>
                                                <span data-ng-bind="user.user_email" class="fw-normal"></span>
                                            </small>
                                        </td>
                                        <td class="text-center" data-ng-bind="user.ugroup_name"></td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-<%statusObject.color[user.user_active]%> rounded-pill font-monospace"><%statusObject.name[user.user_active]%></span>

                                        </td>
                                        <td class="col-fit">
                                            <div>
                                                <button class="btn btn-outline-success btn-circle bi bi-person-lock"
                                                    data-ng-click="editActive($index)"></button>
                                                <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                    data-ng-click="setUser($index)"></button>
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

        @include('components.dashbords.modals.modal_users')

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
            $scope.statusObject = {
                name: ['blocked', 'active'],
                color: ['danger', 'success']
            };
            $scope.updateUser = false;
            $scope.noMore = false;
            $scope.loading = false;
            $scope.userId = 0;
            $scope.list = [];
            $scope.roles = <?= json_encode($roles) ?>;
            $scope.last_id = 0;
            $scope.q = '';
            $scope.dataLoader = function(reload = false) {

                if (reload) {
                    $scope.list = [];
                    $scope.last_id = 0;
                    $scope.noMore = false;
                }
                if ($scope.noMore) return;
                $scope.loading = true;
                $('.loading-spinner').show();

                $.post("/users/load/", {
                    status: $('#filter-status').val(),
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
                            $scope.last_id = data[ln - 1].id;
                        };
                    });
                }, 'json');
            }
            $scope.setUser = (indx) => {
                $scope.updateUser = indx;
                $('#useForm').modal('show');
            };
            $scope.editActive = (index) => {
                $scope.updateUser = index;
                $('#edit_active').modal('show');
            };
            // $scope.deleletUser = (index) => {
            //     $scope.updateUser = index;
            //     $('#delete_user').modal('show');
            // };
            $scope.dataLoader();
            scope = $scope;
        });

        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });

        $(function() {
            $("#searchForm").on("submit", function(e) {
                e.preventDefault();
                scope.$apply(() => (scope.q = $(this).find("input").val()));
                scope.dataLoader(true);
            });
        });
    </script>
@endsection
