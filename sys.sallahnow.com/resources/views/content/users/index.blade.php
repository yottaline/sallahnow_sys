@extends('index')
@section('title')
    Users
@endsection
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
                                <option value="1">Active</option>
                                <option value="0">Blocd</option>
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
                        {{-- <h5 data-ng-if="q" class="text-dark">Result of <span class="text-primary" data-ng-bind="q"></span>
                        </h5> --}}
                        <div data-ng-if="users.length" class="table-responsive">
                            <table class="table table-hover" id="user_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="u in users track by $index">
                                        <td data-ng-bind="u.id"></td>
                                        <td data-ng-bind="u.user_name"></td>
                                        <td data-ng-bind="u.user_email"></td>
                                        <td data-ng-bind="u.user_mobile"></td>
                                        <td data-ng-bind="u.ugroup_name"></td>
                                        <td>
                                            <span
                                                class="badge bg-<%statusObject.color[u.user_active]%> rounded-pill font-monospace"><%statusObject.name[u.user_active]%></span>

                                        </td>
                                        <td class="col-fit">
                                            <div>
                                                <button class="btn btn-outline-success btn-circle bi bi-person-lock"
                                                    data-ng-click="editActive($index)"></button>
                                                <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                    data-ng-click="setUser($index)"></button>
                                                {{-- <button class="btn btn-outline-danger btn-circle bi bi-trash"
                                                    data-ng-click="deleletUser($index)"></button> --}}
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div data-ng-if="!users.length" class="text-center text-secondary py-5">
                            <i class="bi bi-exclamation-circle  display-4"></i>
                            <h5>No records</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- start add new user  Modal -->
        <div class="modal fade" id="useForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="/users/submit/">
                            @csrf
                            <input data-ng-if="updateUser !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="user_id"
                                data-ng-value="updateUser !== false ? users[updateUser].id : 0">
                            <div class="mb-3">
                                <label for="fullName">Full Name<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="name" maxlength="120" id="fullName"
                                    required data-ng-value="updateUser !== false ? users[updateUser].user_name : ''">
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="mobiel">Mobile<b class="text-danger">&ast;</b></label>
                                        <input type="text" class="form-control" name="mobile" maxlength="24"
                                            id="mobiel"
                                            data-ng-value="updateUser !== false ? users[updateUser].user_mobile : ''">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="email" class="form-control" name="email"
                                            id="exampleInputEmail1"
                                            data-ng-value="updateUser !== false ? users[updateUser].user_email : ''">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1">Password</label>
                                        <input type="password" class="form-control" name="password"
                                            id="exampleInputPassword1">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputPassword2">Password Confirmation</label>
                                        <input type="password" class="form-control" name="password_co"
                                            id="exampleInputPassword2">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="role">Roles</label>
                                        <select name="role_id" class="form-control" id="role">
                                            <option
                                                value=""data-ng-value="updateUser !== false ? users[updateUser].ugroup_name : ''"
                                                data-ng-bind="updateUser !== false ? users[updateUser].ugroup_name : ''">
                                            </option>
                                            <option data-ng-repeat="role in roles" data-ng-value="role.ugroup_id"
                                                data-ng-bind="role.ugroup_name"></option>
                                        </select>
                                    </div>
                                </div>
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
        <!-- end add new user  Modal -->

        <!-- start edit user active  Modal -->
        <div class="modal fade modal-sm" id="edit_active" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="/users/update/active/">
                            @csrf @method('PUT')
                            <input hidden data-ng-value="users[userId].id" name="user_id">
                            <input hidden data-ng-value="users[userId].user_active" name="user_active">
                            <p class="mb-2">Are you sure you want to change status the user?</p>
                            <div class="d-flex mt-3">
                                <button type="button" class="btn btn-outline-secondary me-auto"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-success">Change</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- end edit user active Modal -->


        <!-- start delete user  Modal -->
        <div class="modal fade" id="delete_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="{{ route('user_delete') }}">
                            @csrf
                            @method('DELETE')
                            <input type="text" hidden data-ng-value="users[userId].id" name="user_id">
                            <p class="mb-2">Are you sure you want to delete?</p>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end delete user Modal -->

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
            $scope.userId = 0;
            $scope.users = [];
            $scope.roles = [];
            $scope.page = 1;
            $scope.q = ' ';
            $scope.dataLoader = function(reload = false) {
                $('.loading-spinner').show();
                if (reload) {
                    $scope.page = 1;
                }
                $.post("/users/load/", {
                    status: $('#filter-status').val(),
                    q: $scope.q,
                    page: $scope.page,
                    limit: 24,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.users = data;
                        $scope.page++;
                    });
                }, 'json');

                $.post("/roles/load/", {
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.roles = data;
                    });
                }, 'json');
            }
            $scope.setUser = (indx) => {
                $scope.updateUser = indx;
                $('#useForm').modal('show');
            };
            $scope.editActive = (index) => {
                $scope.userId = index;
                $('#edit_active').modal('show');
            };
            $scope.deleletUser = (index) => {
                $scope.userId = index;
                $('#delete_user').modal('show');
            };
            $scope.dataLoader();
            scope = $scope;
        });

        $(function() {
            $('#useForm form').on('submit', function(e) {
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
                        $('#useForm').modal('hide');
                        scope.$apply(() => {
                            if (scope.updateUser === false) {
                                scope.users.unshift(response.data);
                                scope.dataLoader(true);
                            } else {
                                scope.users[scope.updateUser] = response.data;
                                scope.dataLoader(true);
                            }
                        });
                    } else toastr.error(response.message);
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    toastr.error("error");
                    controls.log(jqXHR.responseJSON.message);
                    $('#useForm').modal('hide');
                }).always(function() {
                    spinner.hide();
                    controls.prop('disabled', false);
                });

            })
        });

        $(function() {
            $('#edit_active form').on('submit', function(e) {
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
                        $('#edit_active').modal('hide');
                        scope.$apply(() => {
                            if (scope.updateUser === false) {
                                scope.users.unshift(response.data);
                                scope.dataLoader(true);
                            } else {
                                scope.users[scope.updateUser] = response.data;
                                scope.dataLoader(true);
                            }
                        });
                    } else toastr.error(response.message);
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    toastr.error(response.message);
                    controls.log(jqXHR.responseJSON.message);
                    $('#useForm').modal('hide');
                }).always(function() {
                    spinner.hide();
                    controls.prop('disabled', false);
                });

            })
        })
        $(function() {
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                scope.$apply(() => scope.q = $(this).find('input').val());
                scope.dataLoader(true);
            });
        });
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection
