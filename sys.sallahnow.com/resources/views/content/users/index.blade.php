@extends('index')
@section('title')
    Users
@endsection
@section('content')
    <div class="container-fluid mt-5">
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
        <div class="card">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-7">
                        <h5 class="card-title fw-semibold pt-1"> <i class="bi bi-people text-success"></i> User Table
                        </h5>
                    </div>
                    <div class="col-3">
                        <input type="text" id="search" class="form-control input-lg" onkeyup="myFunction()"
                            placeholder="Search for names.." title="Type in a name" autocomplete="off">
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                            data-target="#exampleModal"><i class="bi bi-person-add"></i></button>
                        <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#add_role"><i
                                class="bi bi-person-bounding-box"></i></button>
                    </div>
                </div>
                <hr class="mb-3">

                <div class="table-responsive">
                    <table class="table table-hover" id="user_table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Mobile</th>
                                <th scope="col">Active</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mobile }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2" style="cursor:pointer"
                                            data-bs-toggle="modal" data-bs-target="#edit_active"
                                            data-user_id="{{ $user->id }}">
                                            @if ($user->active == 1)
                                                <span class="badge bg-success p-2 rounded-3 fw-semibold">
                                                    Enabled
                                                </span>
                                            @else
                                                <span class="badge bg-danger p-2 rounded-3 fw-semibold">
                                                    Blocked
                                                </span>
                                            @endif

                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropright d-flex align-items-center gap-2">
                                            <span type="button"
                                                class=" dropdown-toggle badge bg-dark p-2 rounded-3 fw-semibold"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </span>
                                            <div class="dropdown-menu">
                                                {{-- <a class="dropdown-item" href="{{ route('user.add_role', $user->id) }}">
                                                    <i class="bi bi-person-bounding-box "></i> Add Role</a> --}}
                                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit_user"
                                                    data-user_id="{{ $user->id }}" data-user_name="{{ $user->name }}"
                                                    data-user_mobile="{{ $user->mobile }}"
                                                    data-user_email="{{ $user->email }}"
                                                    data-user_password="{{ $user->password }}"
                                                    data-user_active="{{ $user->active }}">
                                                    <i class="bi bi-pencil-square"></i> Edit</a>
                                                <a class="dropdown-item text-danger" data-bs-toggle="modal"
                                                    data-bs-target="#delete_user" data-user_id="{{ $user->id }}">
                                                    <i class="bi bi-trash"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- start add new user  Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
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
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">User Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Mobile</label>
                                <input type="text" class="form-control" name="mobile">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="exampleInputPassword1">
                            </div>
                            <div class="d-flex">
                                <button type="button" class="btn btn-outline-secondary me-auto"
                                    data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary">Add User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end add new user  Modal -->

        <!-- start edit user active  Modal -->
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
                            <label for="form-control" class="form-label">Active</label>
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
                                <label for="exampleInputEmail1" class="form-label">User Name</label>
                                <input type="text" class="form-control" name="user_name" id="user_name">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Mobile</label>
                                <input type="text" class="form-control" name="user_mobile" id="user_mobile">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email</label>
                                <input type="email" class="form-control" name="user_email" id="user_email"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Password</label>
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
                                <label for="form-control" class="form-label">Users</label>
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
