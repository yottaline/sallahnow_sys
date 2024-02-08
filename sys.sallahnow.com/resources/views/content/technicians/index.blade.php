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
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                            data-target="#exampleModal"><i class="bi bi-tools"></i></button>
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
                                <th scope="col">Mobile</th>
                                <th scope="col">Birth Day</th>
                                <th scope="col">Status</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($technicians as $technician)
                                <tr>
                                    <th scope="row">{{ $technician->id }}</th>
                                    <td>{{ $technician->name }}</td>
                                    <td>{{ $technician->email }}</td>
                                    <td>{{ $technician->mobile }}</td>
                                    <td>{{ $technician->mobile }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2" style="cursor:pointer"
                                            data-bs-toggle="modal" data-bs-target="#edit_active"
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
                                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit_user"
                                                    data-user_id="{{ $technician->id }}"
                                                    data-technician_name="{{ $technician->name }}"
                                                    data-technician_mobile="{{ $technician->mobile }}"
                                                    data-technician_email="{{ $technician->email }}"
                                                    data-technician_password="{{ $technician->password }}"
                                                    data-technician_active="{{ $technician->active }}">
                                                    <i class="bi bi-pencil-square"></i> Edit</a>
                                                <a class="dropdown-item text-danger" data-bs-toggle="modal"
                                                    data-bs-target="#delete_technician"
                                                    data-technician_id="{{ $technician->id }}">
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
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Technician Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <div>
                                        <label for="exampleInputEmail1" class="form-label">Tel</label>
                                        <input type="number" class="form-control" name="tel" />
                                    </div>
                                </div>
                                <div class="col-9">
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
                                        <select name="country" class="form-control">
                                            <option value="">-- select country --</option>
                                            <option value="1">sudan</option>
                                            <option value="2">Egypt</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">State</label>
                                        <select name="state" class="form-control">
                                            <option value="">-- select state --</option>
                                            <option value="1">Khartoum</option>
                                            <option value="2">Cairo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">City</label>
                                        <select name="city" class="form-control">
                                            <option value="">-- select city --</option>
                                            <option value="1">Khartoum</option>
                                            <option value="2">Cairo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Arae</label>
                                        <select name="area" class="form-control">
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



    </div>
@endsection
@section('js')
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
