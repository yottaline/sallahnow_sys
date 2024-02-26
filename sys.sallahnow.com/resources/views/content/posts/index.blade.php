@extends('index')
@section('title')
    Posts
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
                                    role="status"></span><span>POSTS</span>
                            </h5>
                            <div>
                                <a href="/posts/create/" type="button"
                                    class="btn btn-outline-primary btn-circle bi bi-plus-lg"></a>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>
                        </div>

                        <h5 data-ng-if="q" class="text-dark">Result of <span class="text-primary" data-ng-bind="q"></span>
                        </h5>

                        <div data-ng-if="psots.length" class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Post Title</th>
                                        <th class="text-center">Post Body</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="post in psots track by $index">
                                        <td data-ng-bind="post.post_code"
                                            class="text-center small font-monospace text-uppercase"></td>
                                        <td>
                                            <span data-ng-bind="post.post_title" class="fw-bold"></span>
                                        </td>
                                        <td class="text-center" data-ng-bind="post.post_body">-</td>
                                        <td class="col-fit">
                                            <a href="/posts/edit/<% post.post_code %>"
                                                class="btn btn-outline-primary btn-circle bi bi-pencil-square"></a>
                                            <button type="button"
                                                class="btn btn-outline-danger btn-circle bi bi-trash3-fill"
                                                data-ng-click="deletePost($index)"></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div data-ng-if="!psots.length" class="text-center text-secondary py-5">
                            <i class="bi bi-tools display-3"></i>
                            <h5 class="">No records</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="modal fade" id="techModal" tabindex="-1" role="dialog" aria-labelledby="techModalLabel">
            <div class="modal-dialog  modal-xl">
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="techForm" method="post" action="/posts/store/">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="title">Title<b class="text-danger">&ast;</b></label>
                                        <input type="text" class="form-control" name="title" maxlength="24" required
                                            id="title" />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="body">Body</label>
                                        <textarea name="body" id="body" class="form-control" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="Attached">Attached<b class="text-danger">&ast;</b></label>
                                        <input type="file" class="form-control" name="attached"
                                            id="input-file-now-custom-2" id="Attached" />
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
                            $('#techForm').on('submit', e => e.preventDefault()).validate({
                                submitHandler: function(form) {
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
                                            $('#techModal').modal('hide');
                                            scope.$apply(() => {
                                                if (scope.updateTechnician === false) {
                                                    scope.technicians.unshift(response.data);
                                                    scope.dataLoader();
                                                } else {
                                                    scope.technicians[scope.updateTechnician] = response.data;
                                                    scope.dataLoader();
                                                }
                                            });
                                        } else toastr.error(response.message);
                                    }).fail(function(jqXHR, textStatus, errorThrown) {
                                        toastr.error("error");
                                        $('#techModal').modal('hide');
                                    }).always(function() {
                                        $(form).find('button').prop('disabled', false);
                                    });
                                }
                            });

                            $(function() {
                                $("#inputBirthdate").datetimepicker($.extend({}, dtp_opt, {
                                    showTodayButton: false,
                                    format: "YYYY-MM-DD",
                                }));
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="modal fade" id="delete_post" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="/posts/delete/" enctype="multipart/form-data">
                            @csrf
                            <input data-ng-if="updateBrand !== false" type="hidden" name="_method" value="delete">
                            <input type="hidden" name="post_id" data-ng-value="psot !== false ? psots[psot].post_id : 0">
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
            $scope.psots = [];
            $post = false;
            $scope.page = 1;
            $scope.dataLoader = function(reload = false) {
                $('.loading-spinner').show();
                if (reload) {
                    $scope.page = 1;
                }
                $.post("/posts/load/", {
                    page: $scope.page,
                    limit: 24,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.psots = data;
                        $scope.page++;
                    });
                }, 'json');
            }
            // $scope.setUser = (indx) => {
            //     $scope.updateTechnician = indx;
            //     $('#techModal').modal('show');
            // };
            $scope.deletePost = (indx) => {
                $scope.psot = indx;
                $('#delete_post').modal('show');
            };
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

        // delete post
        $(function() {
            $('#delete_post form').on('submit', function(e) {
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
                        $('#delete_post').modal('hide');
                        scope.$apply(() => {
                            if (scope.psot === false) {
                                $scope.dataLoader(true);
                            } else {
                                scope.psots[scope.psot] = response
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
