@extends('index')
@section('title')
    Support Category
@endsection
@section('search')
    <form id="searchForm" role="search">
        <input type="search" name="q" class="form-control my-3 my-md-0 rounded-pill" placeholder="Search...">
    </form>
@endsection
@section('content')
    <div class="container-fluid" data-ng-app="myApp" data-ng-controller="myCtrl">
        <div class="row">
            <div class="col-12 col-sm-4 col-lg-3">
                <div class="card card-box">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="roleFilter">Create By</label>
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
                            <h5 class="card-title fw-semibold pt-1 me-auto mb-3 text-uppercase">
                                <span class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                    role="status"></span><span>SUPPORT CATEGORY</span>
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                    data-ng-click="setCate(false)"></button>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>
                        </div>

                        <h5 data-ng-if="q" class="text-dark">Result of <span class="text-primary" data-ng-bind="q"></span>
                        </h5>

                        <div data-ng-if="categories.length" class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Category Name(en)</th>
                                        <th class="text-center">Category Name(ar)</th>
                                        <th class="text-center">Cost</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="cate in categories track by $index">
                                        <td data-ng-bind="cate.category_id"
                                            class="text-center small font-monospace text-uppercase"></td>
                                        <td class="text-center" data-ng-bind="jsonParse(cate.category_name)['en']"></td>
                                        <td class="text-center" data-ng-bind="jsonParse(cate.category_name)['ar']"></td>
                                        <td class="text-center" data-ng-bind="cate.category_cost"></td>

                                        <td class="col-fit">
                                            <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                data-ng-click="setCenter($index)"></button>
                                            <button class="btn btn-outline-success btn-circle bi bi bi-coin"
                                                data-ng-click="addCost($index)"></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div data-ng-if="!categories.length" class="text-center text-secondary py-5">
                            <i class="bi bi-globe-central-south-asia display-3"></i>
                            <h5 class="">No records</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="centerForm" tabindex="-1" role="dialog" aria-labelledby="centerFormLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="cenForm" method="post" action="/supports/submit" enctype="multipart/form-data">
                            @csrf
                            <input data-ng-if="cateUpdate !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="cate_id" data-ng-value="categories[cateUpdate].center_id">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="NameEN">Category Name EN<b class="text-danger">&ast;</b></label>
                                        <input type="text" class="form-control" name="name_en"
                                            data-ng-value="categories[cateUpdate].center_name" id="NameEN">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="NameAR">Category Name AR<b class="text-danger">&ast;</b></label>
                                        <input type="text" class="form-control" name="name_ar"
                                            data-ng-value="categories[cateUpdate].center_name" id="NameAR">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex">
                                <button type="button" class="btn btn-outline-secondary me-auto btn-sm"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
                            </div>
                        </form>
                        <script>
                            $('#cenForm').on('submit', e => e.preventDefault()).validate({
                                rules: {
                                    name_en: {
                                        required: true
                                    },
                                    name_ar: {
                                        required: true
                                    }
                                },
                                submitHandler: function(form) {
                                    console.log(form);
                                    var formData = new FormData(form),
                                        action = $(form).attr('action'),
                                        method = $(form).attr('method');

                                    $(form).find('button').prop('disabled', true);
                                    $.ajax({
                                        url: action,
                                        type: method,
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                    }).done(function(data, textStatus, jqXHR) {
                                        var response = JSON.parse(data);
                                        if (response.status) {
                                            toastr.success('Data processed successfully');
                                            $('#centerForm').modal('hide');
                                            scope.$apply(() => {
                                                if (scope.centerUpdate === false) {
                                                    scope.centers.unshift(response.data);
                                                    scope.dataLoader();
                                                } else {
                                                    scope.centers[scope.centerUpdate] = response.data;
                                                    scope.dataLoader();
                                                }
                                            });
                                        } else toastr.error(response.message);
                                    }).fail(function(jqXHR, textStatus, errorThrown) {
                                        toastr.error("error");
                                    }).always(function() {
                                        $(form).find('button').prop('disabled', false);
                                    });
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="add_cost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="/supports/update-cost/">
                            @csrf
                            <input data-ng-if="cateUpdate !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="cate_id"
                                data-ng-value="categories !== false ? categories[cateUpdate].category_id : 0">
                            <div class="mb-3">
                                <label for="costCate">Cost <b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="cost" required id="costCate"
                                    data-ng-value="categories !== false ? categories[cateUpdate].category_cost : 0" />
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
    @endsection
    @section('js')
        <script>
            var scope, app = angular.module('myApp', [], function($interpolateProvider) {
                $interpolateProvider.startSymbol('<%');
                $interpolateProvider.endSymbol('%>');
            });

            app.controller('myCtrl', function($scope) {
                $('.loading-spinner').hide();
                $scope.jsonParse = (str) => JSON.parse(str);
                $scope.q = '';
                $scope.cateUpdate = false;
                $scope.categories = [];
                $scope.page = 1;
                $scope.dataLoader = function(reload = false) {
                    $('.loading-spinner').show();
                    if (reload) {
                        $scope.page = 1;
                    }
                    $.post("/supports/load", {
                        page: $scope.page,
                        limit: 24,
                        _token: '{{ csrf_token() }}'
                    }, function(data) {
                        $('.loading-spinner').hide();
                        $scope.$apply(() => {
                            $scope.categories = data;
                            console.log(data)
                            $scope.page++;
                        });
                    }, 'json');
                }

                $scope.setCate = (indx) => {
                    $scope.cateUpdate = indx;
                    $('#centerForm').modal('show');
                };

                $scope.addCost = (index) => {
                    $scope.cateUpdate = index;
                    $('#add_cost').modal('show');
                }
                $scope.dataLoader();
                scope = $scope;
            });

            $(function() {
                $('#searchForm').on('submit', function(e) {
                    e.preventDefault();
                    scope.$apply(() => scope.q = $(this).find('input').val());
                    scope.dataLoader(true);
                });
            });

            $(function() {
                $('#add_cost form').on('submit', function(e) {
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
                        console.log(data);
                        var response = JSON.parse(data);
                        if (response.status) {
                            toastr.success('Category Update cost successfully');
                            $('#add_cost').modal('hide');
                            scope.$apply(() => {
                                if (scope.cateUpdate === false) {
                                    $scope.dataLoader(true);
                                } else {
                                    scope.categories[scope.cateUpdate] = response
                                        .data;
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
        </script>
    @endsection
