@extends('index')
@section('title')
    Role
@endsection
@section('content')
    <!--  content start -->
    <div class="container-fluid mt-5" data-ng-app="myApp" data-ng-controller="myCtrl">
        @if (session()->has('Add'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('Add') }}</strong>
                <span aria-hidden="true" class="close" data-bs-dismiss="alert" aria-label="Close"> <i
                        class="bi bi-x-circle"></i></span>
            </div>
        @endif
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
                        <div class="mb-3">
                            Add Role
                            <form method="POST" action="{{ route('role_store') }}">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="name" class="form-control">
                                    <button class="input-group-text" id="basic-addon1" type="submit">
                                        <i class="bi bi-plus-circle-fill"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="mb-3">
                            <label for="roleFilter">Roles</label>
                            <ul class="list-group" data-ng-repeat="role in roles track by $index">
                                <div class="input-group mb-2">
                                    <li class="list-group-item" style="width:80%" data-ng-bind="role.user_group_name"
                                        data-ng-value="role.id"></li>
                                    <button class="input-group-text" id="basic-addon1">
                                        <i class="bi-eye" data-ng-click="setPermissions(role)"></i>
                                    </button>
                                    @if (in_array('add-users', explode(',', auth()->user()->role->ugroup_privileges)))
                                        <button class="input-group-text" id="basic-addon1">
                                            <i class="bi-caret-right-fill" data-ng-click="getPermissions(role)"></i>
                                        </button>
                                    @endif
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-8 col-lg-9">
                <div class="card card-box perms">
                    <div class="card-body">
                        <div class="d-flex">
                            <h5 class="card-title fw-semibold pt-1 me-auto mb-3">Permissions
                            </h5>
                        </div>
                        <div>
                            <form action="{{ route('addPermissions') }}" method="post">
                                @csrf @method('PUT')
                                <div class="card mb-3 p-2">
                                    <div class="card-body">
                                        <h5 class="card-title">Users Permissions</h5>
                                        <div class="row">
                                            <input type="text" hidden data-ng-value="roleId" name="role_id">
                                            <div class="card-box">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="add-users" name="name[]">
                                                            <label class="form-check-label">Add
                                                                Users</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="view-users" name="name[]">
                                                            <label class="form-check-label">View
                                                                Users</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="update-users" name="name[]">
                                                            <label class="form-check-label">Update
                                                                Users</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="delete-users" name="name[]">
                                                            <label class="form-check-label">Delete
                                                                Users</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3 p-2">
                                    <div class="card-body">
                                        <h5 class="card-title">Technicians Permissions</h5>
                                        <div class="row">
                                            <input type="text" hidden data-ng-value="roleId" name="role_id">
                                            <div class="card-box">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="add-technician" name="name[]">
                                                            <label class="form-check-label">Add
                                                                Technicians</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="view-technician" name="name[]">
                                                            <label class="form-check-label">View
                                                                Technicians</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="update-technician" name="name[]">
                                                            <label class="form-check-label">Update
                                                                Technicians</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="delete-technician" name="name[]">
                                                            <label class="form-check-label">Delete
                                                                Technicians</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-dark" type="submit"><i
                                        class="bi bi-plus-circle-fill"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card card-box perm">
                    <div class="card-body">
                        <div class="d-flex">
                            <h5 class="card-title fw-semibold pt-1 me-auto mb-3">Permissions
                            </h5>
                        </div>
                        <div>
                            <p>The permsission is Role : <span data-ng-bind="permissions.user_group_privileges"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--  content end -->
@endsection

@section('js')
    <script>
        var scope, app = angular.module('myApp', []);
        app.controller('myCtrl', function($scope) {
            $('.perms').show();
            $('.perm').hide();
            $scope.roleId = 0;
            $scope.roles = [];
            $scope.permissions = [];
            $scope.dataLoader = function() {
                $('.loading-spinner').show();
                $.post("/roles/load/", {
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.roles = data;
                    });
                }, 'json');
            }
            $scope.setPermissions = ($role) => {
                $scope.roleId = $role.id;
            };
            $scope.getPermissions = ($role) => {
                $('.perms').hide();
                $.post("/roles/getPermission/" + $role.id, {
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.perm').show();
                    $scope.$apply(() => {
                        $scope.permissions = data;
                    });
                }, 'json');
            };


            $scope.dataLoader();
            scope = $scope;
        });
    </script>
@endsection
