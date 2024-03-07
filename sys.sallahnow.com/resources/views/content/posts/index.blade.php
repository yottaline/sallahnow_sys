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
                        <div class="d-flex">
                            <h5 class="card-title fw-semibold pt-1 me-auto mb-3 text-uppercase">
                                <span class="spinner-border-sm text-warning me-2" role="status"></span><span>FILTERS</span>
                            </h5>
                            <div>
                                <button type="button"
                                    class="btn btn-outline-dark btn-circle bi bi-funnel
                                "></button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="roleFilter">Cost</label>
                            <input type="text" id="filter_cost" class="form-control">
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
                                <a href="/posts/editor/" type="button"
                                    class="btn btn-outline-primary btn-circle bi bi-plus-lg"></a>
                                <button type="button" id="load"
                                    class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
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
                                        <th class="text-center">Post Cost</th>
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
                                        <td class="text-center" data-ng-bind="post.post_body"></td>
                                        <td class="text-center" data-ng-bind="post.post_cost"></td>
                                        <td class="col-fit">
                                            <a href="/posts/editor/<% post.post_code %>"
                                                class="btn btn-outline-primary btn-circle bi bi-pencil-square"></a>
                                            <button type="button" class="btn btn-outline-success btn-circle bi bi-coin"
                                                data-ng-click="addCost($index)"></button>
                                            <button type="button"
                                                class="btn btn-outline-dark btn-circle bi bi-chat-left-text"
                                                data-ng-click="comment(post)" id="Comments"></button>
                                            <button type="button"
                                                class="btn btn-outline-danger btn-circle bi bi-trash3-fill"
                                                data-ng-click="deletePost($index)"></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div data-ng-if="!psots.length" class="text-center text-secondary py-5">
                            <i class="bi bi-exclamation-circle display-3"></i>
                            <h5 class="">No records</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

        <div class="modal fade" id="add_cost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="/posts/add_cost/" enctype="multipart/form-data">
                            @csrf
                            <input data-ng-if="post !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="post_id"
                                data-ng-value="psot !== false ? psots[psot].post_id : 0">
                            <div class="mb-3">
                                <label for="CostPost">Cost <b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="cost" maxlength="24" required
                                    id="category_id" />
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

        <div class="modal fade" id="comment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">

                        <div class="d-flex">
                            <h5 class="card-title fw-semibold pt-1 me-auto mb-3 text-uppercase">
                                <span class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                    role="status"></span><span>COMMENTS</span>
                            </h5>
                            <div>
                                <span class="font-monospace ms-2 badge bg-success rounded-pill px-2 btn-circle"
                                    data-ng-bind="comments.length"
                                    style="font-size:10px; position:relative; top:-3px"></span>
                            </div>
                        </div>

                        <div data-ng-if="comments.length" data-ng-repeat="c in comments"
                            class="bg-muted-2 p-3 border rounded-2 mb-3"
                            data-ng-class="!+c.comment_visible ? 'border-danger' : 'border-success'">
                            <h6 class="fw-bold small" data-ng-bind="!!+c.comment_usertype ? c.student_name : c.user_name">
                            </h6>
                            <p class="small" data-ng-bind="c.comment_context"></p>
                            <div class="small">
                                <i class="bi bi-clock text-secondary me-1"></i><span
                                    data-ng-bind="slice(c.comment_create, 0, 16)"
                                    class="font-monospace dir-ltr d-inline-block"></span>
                                <span data-ng-if="c.review_name"><i class="bi bi-eye text-secondary me-1"></i><span
                                        data-ng-bind="c.review_name"></span></span>
                            </div>
                        </div>
                        <div data-ng-if="!comments.length" class="text-center my-5">
                            <h1 style="font-size: 90px"><i class="bi bi-chat-dots text-secondary"></i></h1>
                            <h5 class="text-secondary"> No Comments...</h5>
                        </div>
                        <form method="POST" action="/posts/add_comment/">
                            @csrf
                            <input type="hidden" name="post_id" data-ng-value="psot.post_id">
                            <div class="mb-3">
                                <label for="CostPost">Add Comment <b class="text-danger">&ast;</b></label>
                                <textarea type="text" rows="7" cols="30" class="form-control" name="comment" required></textarea>
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
            $scope.slice = (str, start, len) => str.slice(start, len);
            $scope.psots = [];
            $scope.comments = []
            $post = false;
            $scope.page = 1;
            $scope.dataLoader = function(reload = false) {
                $('.loading-spinner').show();
                if (reload) {
                    $scope.page = 1;
                }
                var filter_cost = $('#filter_cost').val();
                $.post("/posts/load/", {
                    cost: filter_cost,
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

            $scope.deletePost = (indx) => {
                $scope.psot = indx;
                $('#delete_post').modal('show');
            };

            $scope.addCost = (indx) => {
                $scope.psot = indx;
                $('#add_cost').modal('show');
            };

            $scope.comment = (post) => {
                $.post("/posts/get_comment/", {
                    id: post.post_id,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.comments = data;
                    });
                }, 'json');
                $scope.psot = post;
                $('#comment').modal('show');
            };

            $scope.dataLoader();
            scope = $scope;
        });


        // $(function() {
        //     $('#load').on('clcik', function(e) {
        //         e.preventDefault();
        //         scope.$apply(() => scope.filter_cost = $(this).find('[id="filter_cost"]').val());
        //         scope.dataLoader(true);
        //     });
        // });

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
                        toastr.success('post update cost successfully');
                        $('#add_cost').modal('hide');
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

        // add comments
        $(function() {
            $('#comment form').on('submit', function(e) {
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
                        toastr.success('post update cost successfully');
                        $('#comment').modal('hide');
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
