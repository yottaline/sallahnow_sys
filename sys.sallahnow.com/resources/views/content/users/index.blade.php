@extends('index')
@section('title')
    Users
@endsection
@section('content')
    <div class="container-fluid mt-5" data-ng-app="myApp" data-ng-controller="myCtrl">
        @if (session()->has('Add'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('Add') }}</strong>
                <span aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close"> <i
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-8 col-lg-9">
                <div class="card card-box">
                    <div class="card-body">
                        <div class="d-flex">
                            <h5 class="card-title fw-semibold pt-1 me-auto mb-3">
                                <span class="loading-spinner spinner-border spinner-border-sm text-warning"
                                    role="status"></span>
                                User Table
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-circle bi bi-person-add"
                                    data-ng-click="setUser(false)"></button>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>
                            @haspermission('add-users')
                            @endhaspermission
                        </div>
                        {{-- <div class="row">
                            <div class="col-7">
                            </div>
                            
                            <div class="col-2">
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#add_role"><i
                                        class="bi bi-person-bounding-box"></i></button>
                            </div>
                        </div> --}}
                        {{-- <hr class="mb-3"> --}}

                        <div data-ng-if="users.length" class="table-responsive">
                            <table class="table table-hover" id="user_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="u in users track by $index">
                                        <td data-ng-bind="u.id"></td>
                                        <td data-ng-bind="u.name"></td>
                                        <td data-ng-bind="u.email"></td>
                                        <td data-ng-bind="u.mobile"></td>
                                        <td>
                                            <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                data-ng-click="setUser($index)"></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div data-ng-if="!users.length" class="text-center py-5">
                            <i class="bi bi-people text-secondary display-4"></i>
                            <h5 class="text-secondary">No records</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- start add new user  Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create New User</h5>
                        <button type="button" class="btn btn-danger close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="bi bi-x-circle"></i></span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" action="{{ route('user_store') }}">
                            @csrf
                            <input data-ng-if="updateUser !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="user_id"
                                data-ng-value="updateUser !== false ? users[updateUser].id : 0">
                            <div class="mb-3">
                                <label for="exampleInputEmail1">Full Name<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="name" maxlength="120" required
                                    data-ng-value="updateUser !== false ? users[updateUser].name : ''">
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Mobile<b class="text-danger">&ast;</b></label>
                                        <input type="text" class="form-control" name="mobile" maxlength="24" required
                                            data-ng-value="updateUser !== false ? users[updateUser].mobile : ''">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="email" class="form-control" name="email"
                                            id="exampleInputEmail1"
                                            data-ng-value="updateUser !== false ? users[updateUser].email : ''">
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
                                        <label for="exampleInputPassword1">Password Confirmation</label>
                                        <input type="password" class="form-control" name="password_co"
                                            id="exampleInputPassword2">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1">Role<b class="text-danger">&ast;</b></label>
                                        <select name="" id="">
                                            <option value=""></option>
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
        @haspermission('update-users')
            <div class="modal fade" id="edit_active" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Change Active</h5>
                            <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="bi bi-x-circle"></i></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('user_update_active') }}">
                                @csrf @method('PUT')
                                <input type="text" hidden id="user_id" name="user_id">
                                <label for="form-control">Active</label>
                                <select name="active" class="form-control">
                                    <option value="">-- select status --</option>
                                    <option value="1">Enabled</option>
                                    <option value="0">Blocked</option>
                                </select>
                                <div class="d-flex mt-3">
                                    <button type="button" class="btn btn-outline-secondary me-auto"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-outline-primary">Update Active</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endhaspermission
        <!-- end edit user active Modal -->

        <!-- start edit user  Modal -->
        <div class="modal fade" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                        <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="bi bi-x-circle"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('user_update') }}">
                            @csrf @method('PUT')
                            <input type="text" id="user_id" name="user_id" hidden>
                            <div class="mb-3">
                                <label for="exampleInputEmail1">User Name</label>
                                <input type="text" class="form-control" name="user_name" id="user_name">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1">Mobile</label>
                                <input type="text" class="form-control" name="user_mobile" id="user_mobile">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" name="user_email" id="user_email"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" name="user_password" id="user_password">
                            </div>

                            <div class="d-flex">
                                <button type="button" class="btn btn-outline-secondary me-auto"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary">Update User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end edit user  Modal -->

        <!-- start add role to user  Modal -->
        <div class="modal fade" id="add_role" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="GET" action="{{ route('user_add_role') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="form-control">Users</label>
                                <select name="user_id" class="form-control">
                                    <option value="">-- select user name --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex">
                                <button type="button" class="btn btn-outline-secondary me-auto"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary">Go</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end add role to user Modal -->

        <!-- start delete user  Modal -->
        <div class="modal fade" id="delete_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                        <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="bi bi-x-circle"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('user_delete') }}">
                            @csrf
                            @method('DELETE')
                            <input type="text" hidden id="user_id" name="user_id">
                            <p class="mb-2">Are you sure you want to delete?</p>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-primary">Delete</button>
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
        var scope, app = angular.module('myApp', []);
        app.controller('myCtrl', function($scope) {
            $('.loading-spinner').hide();
            $scope.updateUser = false;
            $scope.users = [];
            $scope.page = 1;
            $scope.dataLoader = function(reload = false) {
                $('.loading-spinner').show();
                if (reload) {
                    $scope.page = 1;
                }
                $.post("/users/load/", {
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
            }
            $scope.setUser = (indx) => {
                $scope.updateUser = indx;
                $('#exampleModal').modal('show');
            };
            $scope.dataLoader();
            scope = $scope;
        });
    </script>
    <script>
        let delete_user = document.getElementById("delete_user");

        delete_user.addEventListener("shown.bs.modal", function(event) {
            let button = $(event.relatedTarget);
            let user_id = button.data("user_id");
            let modal = $(this);
            modal.find(".modal-body #user_id").val(user_id);
        });
    </script>
    <script>
        let edit_active = document.getElementById("edit_active");

        edit_active.addEventListener("shown.bs.modal", function(event) {
            let button = $(event.relatedTarget);
            let user_id = button.data("user_id");
            let modal = $(this);
            modal.find(".modal-body #user_id").val(user_id);
        });
    </script>
    <script>
        let edit_user = document.getElementById("edit_user");

        edit_user.addEventListener("shown.bs.modal", function(event) {
            let button = $(event.relatedTarget);
            let user_id = button.data("user_id");
            let user_name = button.data("user_name");
            let user_mobile = button.data("user_mobile");
            let user_email = button.data("user_email");
            let user_password = button.data("user_password");
            let user_active = button.data("user_active");
            let modal = $(this);
            modal.find(".modal-body #user_id").val(user_id);
            modal.find(".modal-body #user_name").val(user_name);
            modal.find(".modal-body #user_mobile").val(user_mobile);
            modal.find(".modal-body #user_email").val(user_email);
            modal.find(".modal-body #user_password").val(user_password);
            modal.find(".modal-body #user_active").val(user_active);
        });
    </script>
    <script>
        const myFunction = () => {
            const trs = document.querySelectorAll('#user_table tr:not(.header)')
            const filter = document.querySelector('#search').value
            const regex = new RegExp(filter, 'i')
            const isFoundInTds = td => regex.test(td.innerHTML)
            const isFound = childrenArr => childrenArr.some(isFoundInTds)
            const setTrStyleDisplay = ({
                style,
                children
            }) => {
                style.display = isFound([
                    ...children // <-- All columns
                ]) ? '' : 'none'
            }

            trs.forEach(setTrStyleDisplay)
        };
    </script>
@endsection
