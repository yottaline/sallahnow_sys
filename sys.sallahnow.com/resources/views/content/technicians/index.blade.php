@extends('index')
@section('title')
    Technician
@endsection
@section('content')
<<<<<<< Updated upstream
    {{-- <div class="container-fluid mt-5">
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
                        <label for="exampleInputEmail1">Technician Name</label>
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



</div> --}}


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
=======
    <div class="container-fluid" data-ng-app="myApp" data-ng-controller="myCtrl">
>>>>>>> Stashed changes
        <div class="row">
            <div class="col-12 col-sm-4 col-lg-3">
                <div class="card card-box">
                    <div class="card-body">
                        <div class="mb-3">
                            {{-- <label for="roleFilter">Role</label>
                            <select name="" id="" class="form-select">
                                <option value=""></option>
                            </select> --}}
                        </div>
                        <div class="mb-3">
                            <label for="roleFilter">Canter</label>
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
                                    role="status"></span>Technician Table
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-circle bi bi-person-add"
                                    data-ng-click="setUser(false)"></button>
                                <button type="button" class="btn btn-outline-danger btn-circle bi bi-person-gear"
                                    data-bs-toggle="modal" data-bs-target="#add_conter"></button>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>
                        </div>
                        <div data-ng-if="technicians.length" class="table-responsive">
                            <table class="table table-hover" id="technician_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Tel</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="technician in technicians track by $index">
                                        <td data-ng-bind="technician.id"></td>
                                        <td data-ng-bind="technician.name"></td>
                                        <td data-ng-bind="technician.email"></td>
                                        <td data-ng-bind="technician.mobile"></td>
                                        <td data-ng-bind="technician.tel"></td>
                                        <td>
                                            <button class="btn btn-outline-success btn-circle bi bi-person-lock"
                                                data-ng-click="editActive($index)"></button>
                                            <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                data-ng-click="setUser($index)"></button>
                                            <button class="btn btn-outline-success btn-circle bi bi-journal"
                                                data-ng-click="addNote($index)"></button>
                                            <button class="btn btn-outline-dark btn-circle bi bi-eye"
                                                data-ng-click="showTechnician(technician)"></button>
                                            <button class="btn btn-outline-danger btn-circle bi bi-trash"
                                                data-ng-click="deleteTechnician($index)"></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div data-ng-if="!technicians.length" class="text-center py-5">
                            <i class="bi bi-people text-danger display-4"></i>
                            <h5 class="text-danger">No records</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- start add new technician _ edit  Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {{-- <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create New User</h5>
                    <button type="button" class="btn btn-danger close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="bi bi-x-circle"></i></span>
                    </button>
                </div> --}}
                    <div class="modal-body">
                        <form method="POST" action="{{ route('technician_store') }}">
                            @csrf
                            <input data-ng-if="updateTechnician !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="technician_id"
                                data-ng-value="updateTechnician !== false ? technicians[updateTechnician].id : 0">
                            <div class="mb-3">
                                <label for="exampleInputEmail1">Full Name<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="name" maxlength="120" required
                                    data-ng-value="updateTechnician !== false ? technicians[updateTechnician].name : ''">
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Mobile<b class="text-danger">&ast;</b></label>
                                        <input type="text" class="form-control" name="mobile" maxlength="24" required
                                            data-ng-value="updateTechnician !== false ? technicians[updateTechnician].mobile : ''">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="email" class="form-control" name="email"
                                            id="exampleInputEmail1"
                                            data-ng-value="updateTechnician !== false ? technicians[updateTechnician].email : ''">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1">Tel</label>
                                        <input type="text" class="form-control" name="tel"
                                            data-ng-value="updateTechnician !== false ? technicians[updateTechnician].tel : ''">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1">Password<b
                                                class="text-danger">&ast;</b></label>
                                        <input type="password" class="form-control" name="password"
                                            id="exampleInputPassword" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Birth Day<b class="text-danger">&ast;</b></label>
                                        <input type="date" class="form-control" name="birth"
                                            data-ng-value="updateTechnician !== false ? technicians[updateTechnician].mobile : ''">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Country<b class="text-danger">&ast;</b></label>
                                        <select name="country_id" class="form-control" required>
                                            <option value="">-- select country --</option>
                                            <option value="1">sudan</option>
                                            <option value="2">Egypt</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">State<b class="text-danger">&ast;</b></label>
                                        <select name="state_id" class="form-control" required>
                                            <option value="">-- select state --</option>
                                            <option value="1">Khartoum</option>
                                            <option value="2">Cairo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">City<b class="text-danger">&ast;</b></label>
                                        <select name="city_id" class="form-control" required>
                                            <option value="">-- select city --</option>
                                            <option value="1">Khartoum</option>
                                            <option value="2">Cairo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Arae<b class="text-danger">&ast;</b></label>
                                        <select name="area_id" class="form-control" required>
                                            <option value="">-- select area --</option>
                                            <option value="1">Khartoum, Omdurman</option>
                                            <option value="2">Cairo, Maadi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Address</label>
                                        <input type="text" class="form-control" name="address"
                                            data-ng-value="updateTechnician !== false ? technicians[updateTechnician].address : ''" />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1">Identification</label>
                                <textarea class="form-control" name="identification" cols="30" rows="3"
                                    data-ng-bind="updateTechnician !== false ? technicians[updateTechnician].identification : ''"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1">Bio</label>
                                <textarea class="form-control" name="bio" cols="30" rows="3"
                                    data-ng-bind="updateTechnician !== false ? technicians[updateTechnician].bio : ''"></textarea>
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
        <!-- end add new technician _ edit Modal -->

        <!-- start edit technician active  Modal -->
        <div class="modal fade" id="edit_active" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {{-- <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Active</h5>
                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="bi bi-x-circle"></i></span>
                    </button>
                </div> --}}
                    <div class="modal-body">
                        <form method="POST" action="{{ route('technician_update_active') }}">
                            @csrf @method('PUT')
                            <input hidden data-ng-value="technicians[technicianId].id" name="technician_id">
                            <label for="form-control">Active</label>
                            <select name="blocked" class="form-control">
                                <option value="">-- select status --</option>
                                <option value="1">Enabled</option>
                                <option value="0">Blocked</option>
                            </select>
                            <div class="d-flex mt-3">
                                <button type="button" class="btn btn-outline-secondary me-auto"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-success">Update Active</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end edit technician active Modal -->

        <!-- start add notes  Modal -->
        <div class="modal fade" id="add_note_technician" tabindex="-1" role="dialog"
            aria-labelledby="add_note_technician" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="{{ route('technician_add_note') }}">
                            @csrf
                            <input hidden data-ng-value="technicians[technicianId].id" name="technician_id">
                            <label for="form-control">Note</label>
                            <textarea name="notes" class="form-control" cols="30" rows="7"></textarea>
                            <div class="d-flex mt-3">
                                <button type="button" class="btn btn-outline-secondary me-auto"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-success">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end add notes Modal -->

        <!-- end show technician active Modal -->
        <div class="modal fade" id="show_technician" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="mb-3">
                            <p>Full Name : <span data-ng-bind="showTechnician.name"></span></p>
                        </div>
                        <div class="mb-3">
                            <p>Mobile : <span data-ng-bind="showTechnician.mobile"></span></p>
                        </div>
                        <div class="mb-3">
                            <p>Birth Day : <span data-ng-bind="showTechnician.birth"></span></p>
                        </div>
                        <div class="mb-3">
                            <p>Address : <span data-ng-bind="showTechnician.address"></span></p>
                        </div>
                        <div class="mb-3">
                            <p>Rate : <span data-ng-bind="showTechnician.rate"></span></p>
                        </div>
                        <div class="mb-3">
                            <p>Points: <span data-ng-bind="showTechnician.points"></span></p>
                        </div>
                        <div class="mb-3">
                            <p>Identification : <span data-ng-bind="showTechnician.identification"></span></p>
                        </div>
                        <div class="mb-3">
                            <p>Bio : <span data-ng-bind="showTechnician.bio"></span></p>
                        </div>
                        <div class="mb-3">
                            <p>Notes : <span data-ng-bind="showTechnician.notes"></span></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger text-center"
                                data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end show technician active Modal -->
        <!-- start delete technician  Modal -->
        <div class="modal fade" id="delete_technician" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {{-- <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                        <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="bi bi-x-circle"></i></span>
                        </button>
                    </div> --}}
                    <div class="modal-body">
                        <form method="POST" action="{{ route('technician_delete') }}">
                            @csrf
                            @method('DELETE')
                            <input hidden data-ng-value="technicians[technicianId].id" name="technician_id">
                            <p class="mb-2">Are you sure you want to delete?</p>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end delete technician Modal -->
    @endsection
    @section('js')
        <script>
            var scope, app = angular.module('myApp', []);
            app.controller('myCtrl', function($scope) {
                $('.loading-spinner').hide();
                $scope.updateTechnician = false;
                $scope.technicianId = 0;
                $scope.technicians = [];
                $scope.showTechnician = [];
                $scope.page = 1;
                $scope.dataLoader = function(reload = false) {
                    $('.loading-spinner').show();
                    if (reload) {
                        $scope.page = 1;
                    }
                    $.post("/technicians/load/", {
                        page: $scope.page,
                        limit: 24,
                        _token: '{{ csrf_token() }}'
                    }, function(data) {
                        $('.loading-spinner').hide();
                        $scope.$apply(() => {
                            $scope.technicians = data;
                            $scope.page++;
                        });
                    }, 'json');
                }
                $scope.setUser = (indx) => {
                    $scope.updateTechnician = indx;
                    $('#exampleModal').modal('show');
                };
                $scope.editActive = (index) => {
                    $scope.technicianId = index;
                    $('#edit_active').modal('show');
                };
                $scope.showTechnician = (technician) => {
                    $scope.showTechnician = technician;
                    $('#show_technician').modal('show');
                }
                $scope.addNote = (index) => {
                    $scope.technicianId = index;
                    $('#add_note_technician').modal('show');
                }
                $scope.deleteTechnician = (index) => {
                    $scope.userId = index;
                    $('#delete_technician').modal('show');
                };
                $scope.dataLoader();
                scope = $scope;
            });
        </script>
        {{-- <script>
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
</script> --}}
    @endsection
