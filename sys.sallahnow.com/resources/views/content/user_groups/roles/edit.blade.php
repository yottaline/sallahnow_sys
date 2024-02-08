@extends('index')
@section('title')
    Role | Edit
@endsection
@section('content')
    <!--  content start -->
    <div class="container-fluid mt-5">

        @if (session()->has('Add'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('Add') }}</strong>
                <span aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close"> <i
                        class="bi bi-x-circle"></i></span>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('error') }}</strong>
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

        <div class="card mb-3">
            <div class="card-body">
                <h3 class="card-title">Edit Role</h3>
                <div class="card-body">
                    <form action="{{ route('role_update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" class="form-control"
                                        value="{{ $role->name }}" name="role_name" />
                                    <button class="input-group-text" id="basic-addon1" type="submit">
                                        <i class="bi bi-cloud-upload-fill"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        {{-- role section --}}
        <div class="card">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card-body">
                        <h3 class="card-title">Give Permission </h3>
                        <div class="card-body">
                            <form method="POST" action="{{ route('role_give_permission', $role->id) }}">
                                @csrf

                                <div class="row">
                                    <div>
                                        <div class="input-group">
                                            <select name="permission" class="form-control">
                                                <option value="">---choose permission---</option>
                                                @foreach ($permissions as $permission)
                                                    <option value="{{ $permission->name }}">{{ $permission->name }}
                                                    </option>
                                                @endforeach
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
                <div class="col-sm-8">
                    <div class="">
                        <div class="card-body">
                            <h3>The Permission in Role</h3>
                            <div class="template-demo mt-3">
                                @if ($role->permissions)
                                    @foreach ($role->permissions as $permission_role)
                                        <button class="btn btn-outline-success" data-bs-toggle="modal"
                                            data-role_id="{{ $role->id }}"
                                            data-permission_role_id="{{ $permission_role->id }}"
                                            data-bs-target="#delete_permission">{{ $permission_role->name }}</button>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- start delete permission Modal -->
        <div class="modal fade" id="delete_permission" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Permission</h5>
                        <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="bi bi-x-circle"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('role_revoke_permission') }}">
                            @csrf @method('DELETE')
                            <input type="text" hidden id="role_id" name="role_id">
                            <input type="text" hidden id="permission_role_id" name="permission_role_id">
                            <p class="mb-2">Are you sure you want to delete?</p>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end delete permission  Modal -->

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
@endsection
