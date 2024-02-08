@extends('index')
@section('title')
    Role
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

        <!-- table start -->
        <div class="card">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-7">
                        <h5 class="card-title fw-semibold pt-1"> <i class="bi bi-person-bounding-box text-success"></i>
                            Roles
                            Table
                        </h5>
                    </div>
                    <div class="col-3">
                        <input type="text" id="search" class="form-control input-lg" onkeyup="myFunction()"
                            placeholder="Search for names.." title="Type in a name" autocomplete="off">
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                            data-target="#add_role"><i class="bi bi-person-bounding-box"></i></button>
                    </div>
                </div>
                <hr class="mb-3">

                <div class="table-responsive">
                    <table class="table table-hover" id="role_table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $role)
                                <tr>
                                    <th scope="row">{{ $role->id }}</th>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        <div class="dropright d-flex align-items-center gap-2">
                                            <span type="button"
                                                class=" dropdown-toggle badge bg-dark p-2 rounded-3 fw-semibold"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </span>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item text-secondary" data-bs-toggle="modal"
                                                    data-bs-target="#edit_role" data-role_id={{ $role->id }}>
                                                    <i class="bi bi-pencil-square"></i> Edit</a>
                                                <a class="dropdown-item text-danger" data-bs-toggle="modal"
                                                    data-bs-target="#delete_role" data-role_id={{ $role->id }}>
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
        <!-- table end -->


        <!-- start add new permission  Modal -->
        <div class="modal fade" id="add_role" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create New Role</h5>
                        <button type="button" class="btn btn-danger close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="bi bi-x-circle"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('role_store') }}">
                            @csrf
                            <div class="mb-2">
                                <label for="exampleInputEmail1" class="form-label">Role Name</label>
                                <input type="text" class="form-control lg" name="role_name" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="d-flex">
                                <button type="button" class="btn btn-outline-secondary me-auto"
                                    data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary">Add Role</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end add new permission  Modal -->

        <!-- start edit role  Modal -->
        <div class="modal fade" id="edit_role" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Role</h5>
                        <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="bi bi-x-circle"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="GET" action="{{ route('role_edit') }}">
                            @csrf
                            <input type="text" hidden id="role_id" name="role_id">
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

        <!-- start delete role  Modal -->
        <div class="modal fade" id="delete_role" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Role</h5>
                        <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="bi bi-x-circle"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('role_delete') }}">
                            @csrf
                            @method('DELETE')
                            <input type="text" hidden id="role_id" name="role_id">
                            <p class="mb-2">Are you sure you want to delete?</p>
                            <div class="d-flex">
                                <button type="button" class="btn btn-outline-secondary me-auto"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end delete role Modal -->

    </div>
    <!--  content end -->
@endsection

@section('js')
    <script>
        let edit_role = document.getElementById("edit_role");

        edit_role.addEventListener("shown.bs.modal", function(event) {
            let button = $(event.relatedTarget);
            let role_id = button.data("role_id");
            let modal = $(this);
            modal.find(".modal-body #role_id").val(role_id);
        });
    </script>
    <script>
        let delete_role = document.getElementById("delete_role");

        delete_role.addEventListener("shown.bs.modal", function(event) {
            let button = $(event.relatedTarget);
            let role_id = button.data("role_id");
            let modal = $(this);
            modal.find(".modal-body #role_id").val(role_id);
        });
    </script>
    <script>
        const myFunction = () => {
            const trs = document.querySelectorAll('#role_table tr:not(.header)')
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
