@extends('index')
@section('title')
    Courses
@endsection
@section('content')
    <div class="container-fluid" data-ng-app="myApp" data-ng-controller="myCtrl">
        <div class="row">
            <div class="col-12 col-sm-4 col-lg-3">
                <div class="card card-box">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="roleFilter">Package</label>
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
                                    role="status"></span><span>COURSES</span>
                            </h5>
                            <div>
                                <a href="/courses/editor/" type="button"
                                    class="btn btn-outline-primary btn-circle bi bi-plus-lg"></a>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>
                        </div>

                        {{-- <h5 data-ng-if="q" class="text-dark">Result of <span class="text-primary" data-ng-bind="q"></span>
                        </h5> --}}

                        <div data-ng-if="list.length" class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Cuorse Title</th>
                                        <th class="text-center">Cuorse Body</th>
                                        <th class="text-center">Cuorse Cost</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="course in list track by $index">
                                        <td data-ng-bind="course.course_code"
                                            class="text-center small font-monospace text-uppercase"></td>
                                        <td>
                                            <span data-ng-bind="course.course_title" class="fw-bold"></span>
                                        </td>
                                        <td class="text-center" data-ng-bind="course.course_body"></td>
                                        <td class="text-center" data-ng-bind="course.course_cost"></td>
                                        <td class="col-fit">
                                            <a href="/courses/editor/<% course.course_code %>"
                                                class="btn btn-outline-primary btn-circle bi bi-pencil-square"></a>
                                            {{-- <button type="button" class="btn btn-outline-success btn-circle bi bi-coin"
                                                data-ng-click="updCost($index)"></button> --}}
                                            {{-- <button type="button"
                                                class="btn btn-outline-dark btn-circle bi bi-cloud-arrow-up"
                                                data-ng-click="addFile($index)"></button> --}}
                                            <button type="button"
                                                class="btn btn-outline-danger btn-circle bi bi-trash3-fill"
                                                data-ng-click="deletePost($index)"></button>
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

        <div class="modal fade" id="delete_course" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="/courses/delete/" enctype="multipart/form-data">
                            @csrf
                            <input data-ng-if="courseUpdate !== false" type="hidden" name="_method" value="delete">
                            <input type="hidden" name="course_id"
                                data-ng-value="courseUpdate !== false ? list[courseUpdate].course_id : 0">
                            <p>are sure of the deleting process ?</p>
                            <div class="d-flex">
                                <button type="button" class="btn btn-outline-secondary me-auto"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- update cost  --}}
        <div class="modal fade" id="add_cost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="/courses/cost/" enctype="multipart/form-data">
                            @csrf
                            <input data-ng-if="courseUpdate !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="course_id"
                                data-ng-value="courseUpdate !== false ? list[courseUpdate].course_id : 0">
                            <div class="mb-3">
                                <label for="courseCost">Cost <b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="cost" required id="courseCost"
                                    data-ng-value="courseUpdate !== false ? list[courseUpdate].course_cost : 0" />
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

        {{-- add file  --}}
        <div class="modal fade" id="add_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="/courses/add_file/" enctype="multipart/form-data">
                            @csrf
                            <input data-ng-if="courseUpdate !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="course_id"
                                data-ng-value="courseUpdate !== false ? list[courseUpdate].course_id : 0">
                            <div class="mb-3">
                                <label for="Coursefile">File <b class="text-danger">&ast;</b></label>
                                <input type="file" class="form-control" name="course_file" required
                                    id="Coursefile" />
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
            $scope.noMore = false;
            $scope.loading = false;
            $scope.q = '';
            $scope.list = [];
            $courseUpdate = false;
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

                $.post("/courses/load/", {
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
                            $scope.last_id = data[ln - 1].course_id;
                        };
                    });
                }, 'json');
            }

            $scope.deletePost = (indx) => {
                $scope.courseUpdate = indx;
                $('#delete_course').modal('show');
            };

            $scope.updCost = (indx) => {
                $scope.courseUpdate = indx;
                $('#add_cost').modal('show');
            };

            $scope.addFile = (index) => {
                $scope.courseUpdate = index;
                $('#add_file').modal('show');
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

        // delete Course
        $(function() {
            $('#delete_course form').on('submit', function(e) {
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
                        toastr.success('post deleted successfully');
                        $('#delete_course').modal('hide');
                        scope.$apply(() => {
                            if (scope.psot === false) {
                                scope.list.unshift(response.data);
                                $scope.dataLoader(true);
                            } else {
                                scope.list[scope.psot] = response
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

        // add cost
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
                        toastr.success('Course update cost successfully');
                        $('#add_cost').modal('hide');
                        scope.$apply(() => {
                            if (scope.courseUpdate === false) {
                                scope.list.unshift(response.data);
                            } else {
                                scope.list[scope.courseUpdate] = response
                                    .data;
                                // $scope.dataLoader();
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
            $('#add_file form').on('submit', function(e) {
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
                        toastr.success('Course update File successfully');
                        $('#add_file').modal('hide');
                        scope.$apply(() => {
                            if (scope.courseUpdate === false) {
                                scope.list.unshift(response.data);
                                // $scope.dataLoader(true);
                            } else {
                                scope.list[scope.courseUpdate] = response
                                    .data;
                                // $scope.dataLoader();
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
