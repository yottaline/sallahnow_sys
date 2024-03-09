@extends('index')
@section('title')
    Role
@endsection
@section('content')
    <!--  content start -->
    <div class="container-fluid" data-ng-app="myApp" data-ng-controller="myCtrl">
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
                                    <li class="list-group-item" style="width:80%" data-ng-bind="role.ugroup_name"
                                        data-ng-value="role.ugroup_id"></li>
                                    <button class="input-group-text" id="basic-addon1">
                                        <i class="bi-eye" data-ng-click="setPermissions($index)"></i>
                                    </button>
                                    @if (in_array('add-technician ', explode(',', auth()->user()->role->ugroup_privileges)))
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
                        <div>
                            <form id="permissionForm" action="/roles/addPermissions/" method="post">
                                @csrf @method('PUT')
                                <input type="text" hidden ng-value="roles[roleId].ugroup_id" name="ugroup_id">
                                <div class="card card-box">
                                    <div class="card-body">
                                        <div id="users">
                                            <div class="list-box border p-3">
                                                <div class="d-flex">
                                                    <h5 class="card-title fw-semibold pt-1 me-auto mb-3">
                                                        <span class="spinner-border-sm text-warning me-2"
                                                            role="status"></span><span>USER PERMISSIONS</span>
                                                    </h5>
                                                    <div>
                                                        <input type="checkbox" readonly
                                                            class="btn btn-outline-dark form-check-input btn-circle bi-check-circle-fill">
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row p-3">
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
                                <div class="card card-box">
                                    <div class="card-body">
                                        <div id="users">
                                            <div class="list-box border p-3">
                                                <div class="d-flex">
                                                    <h5 class="card-title fw-semibold pt-1 me-auto mb-3">
                                                        <span class="spinner-border-sm text-warning me-2"
                                                            role="status"></span><span>TECHNICIAN PERMISSIONS</span>
                                                    </h5>
                                                    <div>
                                                        <input type="checkbox" readonly
                                                            class="btn btn-outline-dark form-check-input btn-circle bi-check-circle-fill">
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row p-3">
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
                                <div class="text-end">
                                    <button class="btn btn-dark" type="submit"><i
                                            class="bi bi-plus-circle-fill"></i></button>
                                </div>
                            </form>

                            <script>
                                $('#permissionForm').on('submit', e => e.preventDefault()).validate({
                                    rules: {
                                        ugroup_id: {
                                            required: true,
                                            notEqual: 0
                                        },
                                        name: {
                                            required: true
                                        }
                                    },
                                    submitHandler: function(form) {
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
                                                scope.$apply(() => {
                                                    if (scope.roleId === false) {
                                                        scope.roles.unshift(response.data);
                                                        scope.dataLoader();
                                                    } else {
                                                        scope.roles[scope.roleId] = response.data;
                                                        scope.dataLoader();
                                                    }
                                                });
                                            } else toastr.error(response.message);
                                        }).fail(function(jqXHR, textStatus, errorThrown) {
                                            // console.log()
                                            toastr.error(jqXHR.responseJSON.message);
                                            // $('#techModal').modal('hide');
                                        }).always(function() {
                                            $(form).find('button').prop('disabled', false);
                                        });
                                    }
                                });

                                $(function() {
                                    $("#inputBirthdate").datetimepicker($.extend({}, dtp_opt, {
                                        showTodayButton: false,
                                        format: "YYYY-MM-DD",
                                    }));
                                });
                            </script>

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
                            <p>The permsission is Role : <span data-ng-bind="permissions.ugroup_privileges"></span></p>
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
            $scope.setPermissions = (index) => {
                $scope.roleId = index;
                console.log(index)
            };
            $scope.getPermissions = ($role) => {
                $('.perms').hide();
                $scope.roleId = $;
                $.post("/roles/getPermission/" + $role.ugroup_id, {
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
