@extends('index')
@section('title')
    Models
@endsection
@section('search')
    <form action="" method="get" role="search">
        <input type="search" name="q" class="form-control my-3 my-md-0 rounded-pill" placeholder="Search..."
            value="">
    </form>
@endsection
@section('content')
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
                            <label for="roleFilter">brands Name</label>
                            <select name="" id="" class="form-select">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="roleFilter">User Name</label>
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
                                    role="status"></span>Model Table
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-circle bi bi-patch-plus-fill"
                                    data-ng-click="setModel(false)"></button>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>

                        </div>
                        <div data-ng-if="models.length" class="table-responsive">
                            <table class="table table-hover" id="brand_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Photo</th>
                                        <th>Brand Name</th>
                                        <th>User Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="model in models">
                                        <td data-ng-bind="model.id"></td>
                                        <td data-ng-bind="model.name"></td>
                                        <td>
                                            <img alt="" ng-src="<% model.photo %>" width="30px">
                                        </td>
                                        <td data-ng-bind="brandName[$index].name">
                                        </td>
                                        <td data-ng-bind="userName[$index].name"></td>
                                        <td>
                                            <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                data-ng-click="setModel($index)"></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div data-ng-if="!models.length" class="text-center py-5">
                            <i class="bi bi-people text-danger display-4"></i>
                            <h5 class="text-danger">No records</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- start add new brand  Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="{{ route('model_store') }}" enctype="multipart/form-data">
                            @csrf
                            <input data-ng-if="updateModel !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="model_id"
                                data-ng-value="updateModel !== false ? models[updateModel].id : 0">
                            <div class="mb-3">
                                <label for="exampleInputEmail1">Model Name<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="name" maxlength="120" required
                                    data-ng-value="updateModel !== false ? models[updateModel].name : ''" />
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Logo<b class="text-danger">&ast;</b></label>
                                        <input type="file" class="form-control" name="photo"
                                            accept=".pdf,.jpg, .png, image/jpeg, image/png" required />
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">URL</label>
                                        <input type="text" class="form-control" name="url"
                                            id="exampleInputEmail1"
                                            data-ng-value="updateModel !== false ? models[updateModel].url : ''">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1">Logo<b class="text-danger">&ast;</b></label>
                                <select name="brand" class="form-control">
                                    <option value="">-- SELECT BRAND NAME --</option>
                                    <option data-ng-repeat="brand in brands track by $index" data-ng-value="brand.id"
                                        data-ng-bind="brand.name">
                                    </option>

                                </select>
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
        <!-- end add new brand  Modal -->

        <!-- start edit brand active  Modal -->
        <div class="modal fade" id="edit_active" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="{{ route('user_update_active') }}">
                            @csrf @method('PUT')
                            <input hidden data-ng-value="models[userId].id" name="user_id">
                            <label for="form-control">Active</label>
                            <select name="active" class="form-control">
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
        <!-- end edit user active Modal -->



    </div>
@endsection
@section('js')
    <script>
        var scope, app = angular.module('myApp', [], function($interpolateProvider) {
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
        });
        app.controller('myCtrl', function($scope) {
            $('.loading-spinner').hide();
            $scope.updateModel = false;
            $scope.models = [];
            $scope.brands = [];
            $scope.brandName = false;
            $scope.userName = false;
            $scope.page = 1;
            $scope.dataLoader = function(reload = false) {
                $('.loading-spinner').show();
                if (reload) {
                    $scope.page = 1;
                }
                $.post("/models/load/", {
                    page: $scope.page,
                    limit: 24,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.models = data;
                        $scope.page++;
                    });
                }, 'json');

                $.post("/brands/load/", {
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.brands = data;
                    });
                }, 'json');
            }


            $scope.getBrandName = function() {
                $.post("/models/getBrandsName/", {
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.brandName = data;
                    });
                }, 'json');
            }

            $scope.getUserName = function() {
                $.post("/models/getUserName/", {
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.userName = data;
                        console.log(data)
                    });
                }, 'json');
            }


            $scope.setModel = (indx) => {
                $scope.updateModel = indx;
                $('#exampleModal').modal('show');
            };
            // $scope.editActive = (index) => {
            //     $scope.userId = index;
            //     $('#edit_active').modal('show');
            // };
            // $scope.deleletUser = (index) => {
            //     $scope.userId = index;
            //     $('#delete_user').modal('show');
            // };
            $scope.dataLoader();
            $scope.getBrandName();
            $scope.getUserName();
            scope = $scope;
        });
    </script>
    {{-- <script>
        let delete_user = document.getElementById("delete_user");

        delete_user.addEventListener("shown.bs.modal", function(event) {
            let button = $(event.relatedTarget);
            let user_id = button.data("user_id");
            let modal = $(this);
            modal.find(".modal-body #user_id").val(user_id);
        });
    </script> --}}
@endsection
