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
                                    role="status"></span><span>COMPATIBILITIES</span>
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                    data-ng-click="setCompatibility(false)"></button>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>

                        </div>
                        <h5 data-ng-if="q" class="text-dark">Result of <span class="text-primary" data-ng-bind="q"></span>
                        </h5>
                        <div data-ng-if="list.length" class="table-responsive">
                            <table class="table table-hover" id="compatibiliy_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category Name</th>
                                        <th>Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="comp in list track by $index">
                                        <td data-ng-bind="comp.id"></td>
                                        <td data-ng-bind="comp.category_name"></td>
                                        <td data-ng-bind="jsonParse(comp.compat_part)['en']"></td>
                                        <td class="col-fit">
                                            <div>
                                                <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                    data-ng-click="setCompatibility($index)"></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        @include('layouts.loade')


                    </div>
                </div>
            </div>
        </div>

        <!-- start add new compatibiliy  Modal -->
        <div class="modal fade" id="compatibilityForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="/compatibilities/submit/">
                            @csrf
                            <input data-ng-if="updateComp !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="comp_id"
                                data-ng-value="updateComp !== false ? list[updateComp].compat_id : 0">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="NamEN">Name EN<b class="text-danger">&ast;</b></label>
                                        <input type="text" class="form-control" name="name_en" maxlength="24"
                                            id="NamEN"
                                            data-ng-value="updateComp !== false ? jsonParse(list[updateComp].compat_part)['en'] : ''">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="NamAR">Name AR</label>
                                        <input type="text" class="form-control" name="name_ar" id="NamAR"
                                            data-ng-value="updateComp !== false ? jsonParse(list[updateComp].compat_part)['ar'] : ''">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="role">Categories</label>
                                        <select name="cate_id" class="form-control" id="role">
                                            <option value="">-- SELECT CATEGORY NAME</option>
                                            <option data-ng-repeat="category in categories"
                                                data-ng-value="category.category_id" data-ng-bind="category.category_name">
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <p class="text-secondary" style="margin-bottom:-2px">Models<b class="text-danger">&ast;</b>
                                </p>
                                <div class="col-12 col-md-4" data-ng-repeat="model in models">
                                    <div class="mb-3">
                                        <label data-ng-bind="model.model_name" class="m-1"></label><input type="checkbox"
                                            data-ng-value="model.model_id" name="model_id">
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
        <!-- end add new compatibiliy  Modal -->

    </div>
@endsection
@section('js')
    <script>
        var scope, app = angular.module('myApp', []);
        app.controller('myCtrl', function($scope) {
            $('.loading-spinner').hide();
            $scope.jsonParse = (str) => JSON.parse(str);
            $scope.updateComp = false;
            $scope.list = [];
            $scope.categories = <?= json_encode($categories) ?>;;
            $scope.models = <?= json_encode($models) ?>;
            $scope.q = '';
            $scope.noMore = false;
            $scope.loading = false;
            $scope.last_id = 0;
            $scope.dataLoader = function(reload = false) {

                if (reload) {
                    $scope.list = [];
                    $scope.last_id = 0;
                    $scope.noMore = false;
                }

                if ($scope.noMore) return;
                $scope.loading = true;

                $('.loading-spinner').show();

                $.post("/compatibilities/load/", {
                    last_id: $scope.last_id,
                    limit: limit,
                    q: $scope.q,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    var ln = data.length;
                    $scope.$apply(() => {
                        $scope.loading = false;
                        if (ln) {
                            $scope.noMore = ln < limit;
                            $scope.list = data;
                            console.log(data)
                            $scope.last_id = data[ln - 1].compat_id;
                        };
                    });
                }, 'json');
            }
            $scope.setCompatibility = (index) => {
                $scope.updateComp = index;
                console.log(index)
                $('#compatibilityForm').modal('show');
            };

            $scope.dataLoader();
            scope = $scope;
        });

        $(function() {
            $('#compatibilityForm form').on('submit', function(e) {
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
                        $('#compatibilityForm').modal('hide');
                        scope.$apply(() => {
                            if (scope.updateComp === false) {
                                scope.list.unshift(response.data);
                                $scope.dataLoader();
                            } else {
                                scope.list[scope.updateComp] = response.data;
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
