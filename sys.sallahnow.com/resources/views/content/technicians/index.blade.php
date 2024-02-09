@extends('index')
@section('title')
    Technician
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
                        <h5 class="card-title fw-semibold pt-1"> <i class="bi bi-tools text-success"></i> Technicians Table
                        </h5>
                    </div>
                    <div class="col-3">
                        <input type="text" id="search" class="form-control input-lg" onkeyup="myFunction()"
                            placeholder="Search for names.." title="Type in a name" autocomplete="off">
                    </div>
                    <div class="col-2">
                        @haspermission('add-technician')
                            <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                data-target="#exampleModal"><i class="bi bi-tools"></i></button>
                        @endhaspermission
                    </div>
                </div>
                <hr class="mb-3">

                <div class="table-responsive">
                    <table class="table table-hover" id="technician_table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Tel</th>
                                <th scope="col">Mobile</th>
                                <th scope="col">Birth Day</th>
                                <th scope="col">Status</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @haspermission('view-technician')
                                @forelse ($technicians as $technician)
                                    <tr>
                                        <th scope="row">{{ $technician->id }}</th>
                                        <td>{{ $technician->name }}</td>
                                        <td>
                                        @empty($technician->email)
                                            <span class="text-warning">No Email</span>
                                        @endempty
                                        {{ $technician->email }}
                                    </td>
                                    <td>
                                    @empty($technician->tel)
                                        <span class="text-warning">No Tel</span>
                                    @endempty
                                    {{ $technician->tel }}
                                </td>
                                <td>{{ $technician->mobile }}</td>
                                <td>{{ $technician->birth }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2" style="cursor:pointer"
                                        data-bs-toggle="modal" data-bs-target="#technician_update_active"
                                        data-technician_id="{{ $technician->id }}">
                                        @if ($technician->active == 1)
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
                                            @haspermission('update-technician')
                                                <a class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#edit_technician"
                                                    data-technician_id="{{ $technician->id }}"
                                                    data-technician_name="{{ $technician->name }}"
                                                    data-technician_mobile="{{ $technician->mobile }}"
                                                    data-technician_email="{{ $technician->email }}"
                                                    data-technician_address="{{ $technician->address }}"
                                                    data-technician_tel="{{ $technician->tel }}"
                                                    data-technician_identification="{{ $technician->identification }}"
                                                    data-technician_bio="{{ $technician->bio }}">
                                                    <i class="bi bi-pencil-square"></i> Edit</a>
                                            @endhaspermission
                                            @haspermission('delete-technician')
                                                <a class="dropdown-item text-danger" data-bs-toggle="modal"
                                                    data-bs-target="#delete_technician"
                                                    data-technician_id="{{ $technician->id }}">
                                                    <i class="bi bi-trash"></i> Delete</a>
                                            @endhaspermission
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <td>
                                no data
                            </td>
                        @endforelse
                    @endhaspermission
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- start add new technician  Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New Technician</h5>
                <button type="button" class="btn btn-danger close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="bi bi-x-circle"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('technician_store') }}">
                    @csrf
                    <input type="text" class="form-control" name="code" hidden>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Technician Name</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div>
                                <label for="exampleInputEmail1" class="form-label">Tel</label>
                                <input type="number" class="form-control" name="tel" />
                            </div>
                        </div>
                        <div class="col-6">
                            <div>
                                <label for="exampleInputEmail1" class="form-label">Mobile</label>
                                <input type="number" class="form-control" name="mobile">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email"
                                    id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password"
                                    id="exampleInputPassword1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Birth Day</label>
                                <input type="date" class="form-control" name="birth">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Country</label>
                                <select name="country_id" class="form-control">
                                    <option value="">-- select country --</option>
                                    <option value="1">sudan</option>
                                    <option value="2">Egypt</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">State</label>
                                <select name="state_id" class="form-control">
                                    <option value="">-- select state --</option>
                                    <option value="1">Khartoum</option>
                                    <option value="2">Cairo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">City</label>
                                <select name="city_id" class="form-control">
                                    <option value="">-- select city --</option>
                                    <option value="1">Khartoum</option>
                                    <option value="2">Cairo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Arae</label>
                                <select name="area_id" class="form-control">
                                    <option value="">-- select area --</option>
                                    <option value="1">Khartoum, Omdurman</option>
                                    <option value="2">Cairo, Maadi</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" />
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Identification</label>
                        <textarea class="form-control" name="identification" cols="30" rows="5"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Bio</label>
                        <textarea class="form-control" name="bio" cols="30" rows="5"></textarea>
                    </div>
                    <div class="d-flex modal-footer">
                        <button type="button" class="btn btn-outline-secondary me-auto"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary">Add Technician</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end add new technician  Modal -->

<!-- start edit technician  Modal -->
<div class="modal fade" id="edit_technician" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Technician</h5>
                <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="bi bi-x-circle"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('technician_update') }}">
                    @csrf @method('PUT')
                    <input type="text" class="form-control" name="id" id="technician_id" hidden>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Technician Name</label>
                        <input type="text" class="form-control" id="technician_name" name="name">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div>
                                <label for="exampleInputEmail1" class="form-label">Tel</label>
                                <input type="number" class="form-control" name="tel" id="technician_tel" />
                            </div>
                        </div>
                        <div class="col-6">
                            <div>
                                <label for="exampleInputEmail1" class="form-label">Mobile</label>
                                <input type="number" class="form-control" id="technician_mobile"
                                    name="mobile">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="technician_email">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password"
                                    id="exampleInputPassword1" placeholder="15314*****">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Birth Day</label>
                                <input type="date" class="form-control" name="birth">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Country</label>
                                <select name="country_id" class="form-control">
                                    <option value="">-- select country --</option>
                                    <option value="1">sudan</option>
                                    <option value="2">Egypt</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">State</label>
                                <select name="state_id" class="form-control">
                                    <option value="">-- select state --</option>
                                    <option value="1">Khartoum</option>
                                    <option value="2">Cairo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">City</label>
                                <select name="city_id" class="form-control">
                                    <option value="">-- select city --</option>
                                    <option value="1">Khartoum</option>
                                    <option value="2">Cairo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Arae</label>
                                <select name="area_id" class="form-control">
                                    <option value="">-- select area --</option>
                                    <option value="1">Khartoum, Omdurman</option>
                                    <option value="2">Cairo, Maadi</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Address</label>
                        <input type="text" class="form-control" id="technician_address" name="address" />
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Identification</label>
                        <textarea class="form-control" name="identification" id="technician_identification" cols="30" rows="5"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Bio</label>
                        <textarea class="form-control" name="bio" id="technician_bio" cols="30" rows="5"></textarea>
                    </div>
                    <div class="d-flex modal-footer">
                        <button type="button" class="btn btn-outline-secondary me-auto"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary">Update Technician</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end edit technician  Modal -->

<!-- start edit technician active  Modal -->
<div class="modal fade" id="technician_update_active" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Active</h5>
                <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="bi bi-x-circle"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('technician_update_active') }}">
                    @csrf @method('PUT')
                    <input type="text" hidden id="technician_id" name="technician_id">
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
<!-- end edit technician active Modal -->

<!-- start delete technician  Modal -->
<div class="modal fade" id="delete_technician" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Technician</h5>
                <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="bi bi-x-circle"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('technician_delete') }}">
                    @csrf
                    @method('DELETE')
                    <input type="text" hidden id="technician_id" name="technician_id">
                    <p class="mb-2">Are you sure you want to delete?</p>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end delete technician Modal -->



</div>
@endsection
@section('js')
<script>
    let edit_technician = document.getElementById("edit_technician");

    edit_technician.addEventListener("shown.bs.modal", function(event) {
        let button = $(event.relatedTarget);
        let technician_id = button.data("technician_id");
        let technician_name = button.data("technician_name");
        let technician_email = button.data("technician_email");
        let technician_mobile = button.data("technician_mobile");
        let technician_address = button.data("technician_address");
        let technician_tel = button.data("technician_tel");
        let technician_identification = button.data("technician_identification");
        let technician_bio = button.data("technician_bio");
        let modal = $(this);
        modal.find(".modal-body #technician_id").val(technician_id);
        modal.find(".modal-body #technician_name").val(technician_name);
        modal.find(".modal-body #technician_email").val(technician_email);
        modal.find(".modal-body #technician_tel").val(technician_tel);
        modal.find(".modal-body #technician_mobile").val(technician_mobile);
        modal.find(".modal-body #technician_address").val(technician_address);
        modal.find(".modal-body #technician_identification").val(technician_identification);
        modal.find(".modal-body #technician_bio").val(technician_bio);
    });
</script>
<script>
    let technician_update_active = document.getElementById("technician_update_active");

    technician_update_active.addEventListener("shown.bs.modal", function(event) {
        let button = $(event.relatedTarget);
        let technician_id = button.data("technician_id");
        let modal = $(this);
        modal.find(".modal-body #technician_id").val(technician_id);
    });
</script>
<script>
    let delete_technician = document.getElementById("delete_technician");

    delete_technician.addEventListener("shown.bs.modal", function(event) {
        let button = $(event.relatedTarget);
        let technician_id = button.data("technician_id");
        let modal = $(this);
        modal.find(".modal-body #technician_id").val(technician_id);
    });
</script>
<script>
    const myFunction = () => {
        const trs = document.querySelectorAll('#technician_table tr:not(.header)')
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
