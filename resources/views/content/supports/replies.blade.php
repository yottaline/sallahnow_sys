@extends('index')
@section('title')
    Centers
@endsection
@section('content')
    <div class="container-fluid" data-ng-app="myApp" data-ng-controller="myCtrl">
        <div class="row">
            <div class="col-12 col-sm-4 col-lg-3">
                <div class="card card-box">
                    <div class="card-body">
                        {{-- <div class="mb-3">
                            <label for="roleFilter">Create By</label>
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
                            <h5 class="card-title fw-semibold pt-1 me-auto mb-3 text-uppercase">
                                <span class=" spinner-border-sm text-warning me-2" role="status"></span><a href="/tickets/"
                                    class="text-dark">SUPPORT
                                    TICKET REPLIES</a>
                            </h5>
                            <div>

                            </div>
                        </div>
                        {{-- <div data-ng-if="data.length" class="table-responsive">
                            <div data-ng-if="data.length" data-ng-repeat="c in data"
                                class="bg-muted-2 p-3 border rounded-2 mb-3"
                                data-ng-class="!+c.reply_id ? 'border-danger' : 'border-success'">
                                <h6 class="fw-bold small" data-ng-bind="c.reply_context"></h6>
                                <div class="small">
                                    <i class="bi bi-clock text-secondary me-1"></i><span data-ng-bind="c.reply_create"
                                        class="font-monospace dir-ltr d-inline-block"></span>
                                </div>
                            </div>
                            <h6 data-ng-if="comments.count && comments.data.length == comments.count"
                                class="text-center my-3 small text-secondary">All comments have been uploaded</h6>
                            <div data-ng-if="!data.length" class="text-center my-5">
                                <h1 style="font-size: 90px"><i class="bi bi-chat-dots text-secondary"></i></h1>
                                <h5 class="text-secondary"> No Replies...</h5>
                            </div>
                        </div> --}}

                        <div id="commentsCard" class="card card-box mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-sm-8 col-lg-12">
                                        <div class="d-flex mb-4 align-items-center">
                                            <h5 class="card-title fw-bold m-0 me-auto">
                                                <small
                                                    class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                                    role="status"></small>
                                                <span>Rtailers</span>
                                                <span class="font-monospace ms-2 badge bg-primary rounded-pill px-2"
                                                    data-ng-bind="comments.count"
                                                    style="font-size:10px; position:relative; top:-3px"></span>
                                            </h5>
                                            <button class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                                id="commentsReloadBtn"></button>
                                        </div>
                                        <div class="mb-3 border rounded-2 p-2">
                                            <form id="addCommentForm" action="/posts/add_comment/" method="post">
                                                @csrf
                                                <input type="hidden" name="post_id" data-ng-value="data.post_id">
                                                <div class="mb-3">
                                                    <label for="addCommentContext">
                                                        <small
                                                            class="loading-spinner spinner-border spinner-border-sm text-warning me-3"
                                                            role="status"></small>
                                                    </label>
                                                    <textarea name="comment" id="addCommentContext" class="form-control border-0" rows="6" maxlength="2048" required></textarea>
                                                </div>
                                                <div class="text-end">
                                                    <button type="submit"
                                                        class="btn btn-outline-primary btn-sm px-3">Add</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div data-ng-if="data.length" data-ng-repeat="c in data"
                                            class="bg-muted-2 p-3 border rounded-2 mb-3"
                                            data-ng-class="!+c.data ? 'border-danger' : 'border-success'">
                                            <h6 class="fw-bold small"
                                                data-ng-bind="!!+c.comment_usertype ? c.student_name : c.user_name"></h6>
                                            <p class="small" data-ng-bind="c.comment_context"></p>
                                            <div class="small">
                                                <i class="bi bi-clock text-secondary me-1"></i><span
                                                    data-ng-bind="slice(c.comment_register, 0, 16)"
                                                    class="font-monospace dir-ltr d-inline-block"></span>
                                                <span data-ng-if="c.review_name"><i
                                                        class="bi bi-eye text-secondary me-1"></i><span
                                                        data-ng-bind="c.review_name"></span></span>
                                            </div>
                                        </div>
                                        <h6 data-ng-if="data.count && data.length == data.count"
                                            class="text-center my-3 small text-secondary">All comments have been uploaded
                                        </h6>
                                        <div data-ng-if="!data.length" class="text-center my-5">
                                            <h1 style="font-size: 90px"><i class="bi bi-chat-dots text-secondary"></i></h1>
                                            <h5 class="text-secondary"> No Replies...</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $(function() {
                                    $('#commentsReloadBtn').on('click', e => {
                                        loadComments(true);
                                    });

                                    $("#addCommentForm").on('submit', e => e.preventDefault()).validate({
                                        submitHandler: function(form) {
                                            var formData = new FormData(form),
                                                action = $(form).attr('action'),
                                                method = $(form).attr('method'),
                                                spinner = $(form).find('.loading-spinner'),
                                                controls = $(form).find('button, textarea');
                                            spinner.show();
                                            controls.prop('disabled', true);
                                            $.ajax({
                                                url: action,
                                                type: method,
                                                data: formData,
                                                processData: false,
                                                contentType: false,
                                            }).done(function(data) {
                                                var response = JSON.parse(data);
                                                if (response.status) {
                                                    $(form).trigger("reset");
                                                    scope.$apply(() => {
                                                        scope.comments.data.unshift(response.data)
                                                        scope.comments.count++;
                                                    });
                                                } else toastr.error(response.error ?? glob_errorMsg);
                                            }).fail(function(jqXHR, textStatus, errorThrown) {
                                                toastr.error(glob_errorMsg);
                                            }).always(function() {
                                                spinner.hide();
                                                controls.prop('disabled', false);
                                            });
                                        },
                                    });

                                    loadComments(true);
                                });

                                function loadComments(reload = false) {
                                    var spinner = $('#commentsCard .card-title>.loading-spinner'),
                                        loadingBtn = $('#commentsCard .loading-btn'),
                                        request = {
                                            _token: '{{ csrf_token() }}',
                                            post_id: scope.data.post_id,
                                        };

                                    spinner.show();
                                    loadingBtn.prop('disabled', true);
                                    $.post('/posts/get_comment/', request, function(data) {
                                        spinner.hide();
                                        var length = data.length;
                                        scope.$apply(() => {
                                            scope.comments.count = length;

                                            scope.comments.data = reload ? data : [].concat(scope.comments.data,
                                                data);
                                            scope.comments.lastId = length ? response.data[length - 1].comment_id : scope
                                                .comments.lastId;
                                        });
                                        loadingBtn.prop('disabled', scope.comments.data.length == scope.comments.count);
                                        if (response.status) {
                                            var length = response.data.length;
                                            console.log(data);
                                            scope.$apply(() => {
                                                scope.comments.count = response.count;
                                                scope.comments.data = reload ? response.data : [].concat(scope.comments.data,
                                                    response.data);
                                                scope.comments.lastId = length ? response.data[length - 1].comment_id : scope
                                                    .comments.lastId;
                                            });
                                            loadingBtn.prop('disabled', scope.comments.data.length == scope.comments.count);
                                        } else {
                                            toastr.error(glob_errorMsg);
                                            loadingBtn.prop('disabled', false);
                                        }
                                    }, 'json');
                                };
                            </script>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('js')
        <script>
            var scope, app = angular.module('myApp', []);

            app.controller('myCtrl', function($scope) {
                $('.loading-spinner').hide();
                $scope.data = <?= !empty($replies) ? json_encode($replies) : 'null' ?>;
                console.log(data);
                $('.loading-spinner').hide();
                $scope.jsonParse = (str) => JSON.parse(str);

                scope = $scope;
            });
        </script>
    @endsection
