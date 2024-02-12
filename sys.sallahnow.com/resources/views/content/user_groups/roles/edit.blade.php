@extends('index')
@section('title')
    Role | Edit
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
                            Edit Role
                            <form method="POST" action="{{ route('role_update', $role->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="input-group">
                                    <input type="text" name="name" value="{{ $role->name }}" class="form-control">
                                    <button class="input-group-text" id="basic-addon1" type="submit">
                                        <i class="bi bi-cloud-upload-fill"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="mb-3">
                            <label for="roleFilter">Permissions that a <span class="text-success">{{ $role->name }}</span>
                                Role has</label>
                            <ul class="list-group">
                                @if ($role->permissions)
                                    @foreach ($role->permissions as $permission_role)
                                        {{-- <button class="btn btn-outline-success" data-bs-toggle="modal"
                                            data-role_id="{{ $role->id }}"
                                            data-permission_role_id="{{ $permission_role->id }}"
                                            data-bs-target="#delete_permission"></button> --}}
                                        <div class="input-group mb-2">
                                            <li class="list-group-item" style="width:90%">{{ $permission_role->name }}
                                            </li>
                                            <button class="input-group-text" id="basic-addon1">
                                                <i class="bi-trash text-danger" data-ng-click="setPermissions(role)"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-8 col-lg-9">
                <div class="card card-box">
                    <div class="card-body">
                        <div class="d-flex">
                            <h5 class="card-title fw-semibold pt-1 me-auto mb-3">Permissions
                            </h5>
                        </div>
                        <div>
                            <form action="{{ route('role_give_permission', $role->id) }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" value="add-users" name="name" type="checkbox"
                                                id="flexSwitchCheckChecked">
                                            <label class="form-check-label" for="flexSwitchCheckChecked">Add Users</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" value="view-users" name="name"
                                                type="checkbox" id="flexSwitchCheckChecked">
                                            <label class="form-check-label" for="flexSwitchCheckChecked">View
                                                Users</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" value="update-users" name="name"
                                                type="checkbox" id="flexSwitchCheckChecked">
                                            <label class="form-check-label" for="flexSwitchCheckChecked">Update
                                                Users</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" value="delete-users" name="name"
                                                type="checkbox" id="flexSwitchCheckChecked">
                                            <label class="form-check-label" for="flexSwitchCheckChecked">Delete
                                                Users</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" value="delete-users" name="name"
                                                type="checkbox" id="checked">
                                            <label class="form-check-label" for="flexSwitchCheckChecked">Delete
                                                Users</label>
                                        </div>
                                    </div>
                                </div>

                                <button class="input-group-text mt-3" id="basic-addon1" type="submit">
                                    <i class="bi bi-plus-circle-fill"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- start edit role  Modal -->
        <div class="modal fade" id="edit_role" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {{-- <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Role</h5>
                        <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="bi bi-x-circle"></i></span>
                        </button>
                    </div> --}}
                    <div class="modal-body">
                        <form method="GET" action="{{ route('role_edit') }}">
                            @csrf
                            <input type="text" hidden data-ng-value="roleId" name="role_id">
                            <p class="mb-2">You will be Transfer to the edit file, and you can also add ?</p>

                            <div class="d-flex">
                                <button type="button" class="btn btn-outline-secondary me-auto"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary">Transfer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end edit role Modal -->

    </div>

    <!--  content start -->
@endsection

@section('js')
    <script>
        let delete_permission = document.getElementById("delete_permission");

        delete_permission.addEventListener("shown.bs.modal", function(event) {
            let button = $(event.relatedTarget);
            let role_id = button.data("role_id");
            let permission_role_id = button.data("permission_role_id");
            let modal = $(this);
            modal.find(".modal-body #role_id").val(role_id);
            modal.find(".modal-body #permission_role_id").val(permission_role_id);
        });
    </script>
    <script>
        let checked = document.getElementById('checked');
        checked.addEventListener('click', function() {
            var selectedPerms = $('.form-check-input:checked').map((e, i) => $(i).val()).get().join();
            console.log(selectedPerms);
        })
    </script>
@endsection
