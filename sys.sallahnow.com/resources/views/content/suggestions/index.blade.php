@extends('index')
@section('title')
    Compatibilities
@endsection
@section('search')
    <form id="searchForm" role="search">
        <input type="search" name="q" class="form-control my-3 my-md-0 rounded-pill" placeholder="Search...">
    </form>
@endsection
@section('content')
    <div class="container-fluid" data-ng-app="myApp" data-ng-controller="myCtrl">
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
                        {{-- <div class="mb-3">
                            <label for="roleFilter">Role</label>
                            <select name="" id="" class="form-select">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="roleFilter">Status</label>
                            <select name="" id="" class="form-select">
                                <option value=""></option>
                            </select>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-8 col-lg-9">
                <div class="card card-box">
                    <div class="card-body">
                        <div class="d-flex">
                            <h5 class="card-title fw-semibold pt-1 me-auto mb-3">
                                <span class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                    role="status"></span><span>SUGGESTIONS</span>
                            </h5>
                            <div>
                                {{-- <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                    data-ng-click="setSuggestion(false)"></button> --}}
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>

                        </div>
                        <h5 data-ng-if="q" class="text-dark">Result of <span class="text-primary" data-ng-bind="q"></span>
                        </h5>
                        <div data-ng-if="suggestions.length" class="table-responsive">
                            <table class="table table-hover" id="suggestions_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category Name</th>
                                        <th>Technician Name</th>
                                        <th>User Name</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="sugg in suggestions track by $index">
                                        <td data-ng-bind="sugg.sugg_id"></td>
                                        <td data-ng-bind="sugg.category_name"></td>
                                        <td data-ng-bind="sugg.tech_name"></td>
                                        <td data-ng-bind="sugg.name"></td>
                                        <td>
                                            <span
                                                class="badge bg-<%statusObj.color[sugg.status]%> rounded-pill font-monospace"><%statusObj.name[sugg.status]%></span>

                                        </td>
                                        <td>
                                            <div class="col-fit">
                                                <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                    data-ng-click="setSuggestion($index)"></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div data-ng-if="!suggestions.length" class="text-center text-secondary py-5">
                            <i class="bi bi-people  display-4"></i>
                            <h5>No records</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- start add new suggestion  Modal -->
        <div class="modal fade" id="suggestionForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="/suggestions/submit/">
                            @csrf
                            <input data-ng-if="updateUser !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="comp_id"
                                data-ng-value="updateUser !== false ? users[updateUser].id : 0">
                            <div class="btn-group">
                                <div class="m-3">
                                    <input type="radio" class="btn-check" name="status" value="1" id="Accepted"
                                        autocomplete="off" checked>
                                    <label class="btn btn-outline-success" for="Accepted"
                                        aria-expanded="true">Accepted</label>
                                </div>

                                <div class="m-3">
                                    <input type="radio" class="btn-check" value="2" name="status" id="Rejected"
                                        autocomplete="off">
                                    <label class="btn btn-outline-danger" for="Rejected" data-bs-toggle="collapse"
                                        data-bs-target="#collapseWidthExample">Rejected</label>
                                </div>
                            </div>
                            <div class="row">
                                <div>
                                    <div class="collapse collapse-horizontal" id="collapseWidthExample">
                                        <p class="text-warning">the reason of Rejected <b class="text-danger">&ast;</b></p>
                                        <div class="card mb-2">
                                            <textarea name="" id="" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-outline-secondary me-auto"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-outline-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end add new suggestion  Modal -->


        {{-- <div class="modal fade" id="compatibilityForm" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="{{ route('i.suggestions') }}">
                            @csrf @method('POST')
                            <input data-ng-if="updateUser !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="comp_id"
                                data-ng-value="updateUser !== false ? users[updateUser].id : 0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="role">Categories</label>
                                        <select name="cate_id" class="form-control" id="role">
                                            <option value="">-- SELECT CATEGORY NAME</option>
                                            <option data-ng-repeat="cate in categories" data-ng-value="cate.id"
                                                data-ng-bind="cate.name"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="role">Technicians</label>
                                        <select name="technician_id" class="form-control" id="role">
                                            <option value="">-- SELECT CATEGORY NAME</option>
                                            <option data-ng-repeat="cate in technicians" data-ng-value="cate.id"
                                                data-ng-bind="cate.name"></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex">
                                    <button type="button" class="btn btn-outline-secondary me-auto"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-outline-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}



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
            $scope.statusObj = {
                name: ['New', 'Approved', 'Rejected'],
                color: ['secondary', 'success', 'danger']
            }
            $scope.suggestionId = false;
            $scope.technicianName = false;
            $scope.cateName = false;
            $scope.userName = false;
            $scope.suggestions = [];
            $scope.categories = [];
            $scope.technicians = [];
            $scope.page = 1;
            $scope.dataLoader = function(reload = false) {
                $('.loading-spinner').show();
                if (reload) {
                    $scope.page = 1;
                }
                $.post("/suggestions/load/", {
                    page: $scope.page,
                    limit: 24,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.suggestions = data;
                        $scope.page++;
                    });
                }, 'json');

                // $.post("/CompatibilityCategories/load/", {
                //     _token: '{{ csrf_token() }}'
                // }, function(data) {
                //     $('.loading-spinner').hide();
                //     $scope.$apply(() => {
                //         $scope.categories = data;
                //     });
                // }, 'json');

                // $.post("/technicians/load/", {
                //     _token: '{{ csrf_token() }}'
                // }, function(data) {
                //     $('.loading-spinner').hide();
                //     $scope.$apply(() => {
                //         $scope.technicians = data;
                //     });
                // }, 'json');
            }

            $scope.setSuggestion = (indx) => {
                $scope.suggestionId = indx;
                $('#suggestionForm').modal('show');
            };

            $scope.dataLoader();
        });

        $(function() {
            $('#suggestionForm form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this),
                    formData = new FormData(this),
                    action = form.attr('action'),
                    method = form.attr('method'),
                    controls = form.find('button, input'),
                    spinner = $('#locationModal .loading-spinner');
                spinner.show();
                controls.prop('disabled', true);
                $.ajax({
                    url: action,
                    type: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                }).done(function(data, textStatus, jqXHR) {
                    var response = JSON.parse(data);
                    console.log(data)
                    if (response.status) {
                        toastr.success('Data processed successfully');
                        $('#modelForm').modal('hide');
                        scope.$apply(() => {
                            if (scope.suggestionId === false) {
                                scope.suggestions.unshift(response.data);
                                $scope.dataLoader();
                            } else {
                                scope.suggestions[scope.suggestionId] = response.data;
                                $scope.dataLoader();
                            }
                        });
                    } else toastr.error("Error");
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    // error msg
                }).always(function() {
                    spinner.hide();
                    controls.prop('disabled', false);
                });

            })
        });
        $(function() {
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                scope.$apply(() => scope.q = $(this).find('input').val());
                scope.dataLoader(true);
            });
        });
    </script>
@endsection
