@extends('index')
@section('title')
    Permissions
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
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-7">
                        <h5 class="card-title fw-semibold pt-1"> <i class="bi bi-ui-checks text-success"></i> Permissions
                            Table
                        </h5>
                    </div>
                    <div class="col-3">
                        <input type="text" id="search" class="form-control input-lg" onkeyup="myFunction()"
                            placeholder="Search for names.." title="Type in a name" autocomplete="off">
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                            data-target="#add_permission"><i class="bi bi-ui-checks"></i></button>
                    </div>
                </div>
                <hr class="mb-3">

                <div class="table-responsive">
                    <table class="table table-hover" id="permission_table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($permissions as $permission)
                                <tr>
                                    <th scope="row">{{ $permission->id }}</th>
                                    <td>{{ $permission->name }}</td>
                                    <td>
                                        <div class="dropright d-flex align-items-center gap-2">
                                            <span type="button"
                                                class=" dropdown-toggle badge bg-dark p-2 rounded-3 fw-semibold"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </span>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#edit_permission"
                                                    data-permission_id={{ $permission->id }}>
                                                    <i class="bi bi-pencil-square"></i> Edit</a>
                                                <a class="dropdown-item text-danger" data-bs-toggle="modal"
                                                    data-bs-target="#delete_permission"
                                                    data-permission_id={{ $permission->id }}>
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


        <!-- start add new permission  Modal -->
        <div class="modal fade" id="add_permission" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create New Permission</h5>
                        <button type="button" class="btn btn-danger close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="bi bi-x-circle"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('permission_store') }}">
                            @csrf
                            <div class="mb-2">
                                <label for="example_input_permission_name" class="form-label">Permission Name</label>
                                <input type="text" class="form-control lg" name="permission_name"
                                    id="example_input_permission_name">
                            </div>
                            <div class="d-flex">
                                <button type="button" class="btn btn-outline-secondary me-auto"
                                    data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary">Add permission</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end add new permission  Modal -->

        <!-- start edit permission  Modal -->
        <div class="modal fade" id="edit_permission" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Permission</h5>
                        <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="bi bi-x-circle"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="GET" action="{{ route('permission_edit') }}">
                            @csrf
                            <input type="text" hidden id="permission_id" name="permission_id">
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
        <!-- end edit permission  Modal -->

        <!-- start delete permission  Modal -->
        <div class="modal fade" id="delete_permission" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Permission</h5>
                        <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="bi bi-x-circle"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('permission_delete') }}">
                            @csrf
                            @method('DELETE')
                            <input type="text" hidden id="permission_id" name="permission_id">
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
        <!-- end delete permission Modal -->

    </div>
@endsection
@section('js')
    <script>
        let delete_permission = document.getElementById("delete_permission");

        delete_permission.addEventListener("shown.bs.modal", function(event) {
            let button = $(event.relatedTarget);
            let permission_id = button.data("permission_id");
            let modal = $(this);
            modal.find(".modal-body #permission_id").val(permission_id);
        });
    </script>
    <script>
        const myFunction = () => {
            const trs = document.querySelectorAll('#permission_table tr:not(.header)')
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
