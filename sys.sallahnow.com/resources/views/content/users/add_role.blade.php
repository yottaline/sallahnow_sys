@extends('index');
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
            <div class="alert alert-success alert-dismissible fade show" role="alert">
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


        <div class="card">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card-body">
                        <h3 class="card-title mb-4">Assing Role To User</h3>
                        <div class="card-body">
                            <form method="POST" action="{{ route('user_add_role_to_user', $user->id) }}">
                                @csrf
                                <div class="mb-2">
                                    <label class="form-label">Rle Name</label>
                                    <select name="role" class="form-control">
                                        <option value="">---choose role---</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-outline-dark  mt-1">Assing</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="card-body">
                        <h3>The Role in User</h3>
                        <div class="template-demo mt-3">
                            @if ($user->permissions)
                                @foreach ($user->roles as $role_permission)
                                    <button class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-user_id="{{ $user->id }}" data-role_id="{{ $role_permission->id }}"
                                        data-bs-target="#delete_role">{{ $role_permission->name }}</button>
                                @endforeach
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
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Role Form User</h5>
                        <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="bi bi-x-circle"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
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
