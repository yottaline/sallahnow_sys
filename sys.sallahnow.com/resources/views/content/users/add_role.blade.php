@extends('index');
@section('content')
    <!--  content start -->
    <div class="container-fluid mt-5" data-ng-app="myApp" data-ng-controller="myCtrl">
        <div class="row">
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
            <div class="col-12 col-sm-4 col-lg-3">
                <div class="card card-box">
                    <div class="card-body">
                        <div class="mb-3">
                            <form method="POST" action="{{ route('user_add_role_to_user', $user->id) }}">
                                @csrf
                                <div class="row">
                                    <div>
                                        <div class="input-group">
                                            <select name="role" data-ng-repeat="role in roles track by $index"
                                                class="form-control">
                                                <option value="">---choose role---</option>
                                                <option data-ng-value="role.name" data-ng-bind="role.name"></option>
                                            </select>
                                            <button class="input-group-text" id="basic-addon1" type="submit">
                                                <i class="bi bi-plus-circle-fill"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-8 col-lg-9">
                <div class="card card-box">
                    <div class="card-body">
                        <div class="d-flex">
                            <h5 class="card-title fw-semibold pt-1 me-auto mb-3">Roles that a user has
                            </h5>
                        </div>
                        <div class="table-responsive">
                            @if ($user->permissions)
                                @forelse ($user->roles as $role_permission)
                                    <button class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-user_id="{{ $user->id }}" data-role_id="{{ $role_permission->id }}"
                                        data-bs-target="#delete_role">{{ $role_permission->name }}</button>
                                @empty
                                    <div class="text-center py-5">
                                        <i class="bi bi-emoji-grimace text-danger display-4"></i>
                                        <h5 class="text-danger">No Role</h5>
                                    </div>
                                @endforelse
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- start delete role form user Modal -->
        <div class="modal fade" id="delete_role" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    < <div class="modal-body">
                        @if ($user->permissions)
                            <form method="POST" action="{{ route('user_remove_role') }}">
                                @csrf @method('DELETE')
                                <input type="text" hidden id="user_id" name="user_id">
                                <input type="text" hidden id="role_id" name="role_id">
                                <p class="mb-2">Are you sure you want to delete?</p>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-danger">Delete</button>
                            </form>
                        @endif
                </div>
            </div>
        </div>
    </div>
    <!-- end delete role form user  Modal -->

    </div>
    <!--  content start -->
@endsection

@section('js')
    <script>
        var scope, app = angular.module('myApp', []);
        app.controller('myCtrl', function($scope) {
            $('.loading-spinner').hide();
            $scope.roles = [];
            $scope.dataLoader = function(reload = false) {
                $('.loading-spinner').show();
                if (reload) {
                    $scope.page = 1;
                }
                $.post("/roles/load/", {
                    page: $scope.page,
                    limit: 24,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.roles = data;
                    });
                }, 'json');
            }
            $scope.dataLoader();
            scope = $scope;
        });
    </script>
    <script>
        let delete_role = document.getElementById("delete_role");

        delete_role.addEventListener("shown.bs.modal", function(event) {
            let button = $(event.relatedTarget);
            let user_id = button.data("user_id");
            let role_id = button.data("role_id");
            let modal = $(this);
            modal.find(".modal-body #user_id").val(user_id);
            modal.find(".modal-body #role_id").val(role_id);
        });
    </script>
@endsection
