@extends('index')
@section('title')
    Posts
@endsection
@section('style')
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/dropify-master/dist/css/dropify.min.css') }}">
    <script src="{{ asset('assets/dropify-master/dist/js/dropify.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom_functions.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <style>
        .dropify-wrapper {
            border: 1px solid #ced4da;
            border-radius: .375rem;
        }

        .dropify-wrapper .dropify-errors-container ul {
            left: auto;
            right: 5px;
        }

        .dropify-wrapper .dropify-message p {
            font-size: 12px;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid" id="POSTI" data-ng-app="ngApp" data-ng-controller="ngCtrl">
        <div class="row">
            <div class="col-12 col-sm-4 col-lg-3">
                <div class="card card-box mb-3">
                    <div class="card-body">
                        <h1 style="font-size: 70px" class="text-center my-3"><i
                                class="bi bi-file-earmark-richtext text-secondary"></i></h1>
                        <h5 ng-if="data.code" class="text-center text-secondary font-monospace small dir-ltr mb-3"
                            data-ng-bind="data.post_code"></h5>
                        <p ng-if="data.post_title" class="fw-bold text-center m-0 small" data-ng-bind="data.post_title"></p>
                        <hr>
                        <p ng-if="data.tech_name" class="small m-0"><i
                                class="bi bi-person-circle text-secondary me-2"></i><span class="d-inline-block"
                                data-ng-bind="data.tech_name"></span></p>
                        <p ng-if="data.user_name" class="small m-0"><i
                                class="bi bi-person-circle text-secondary me-2"></i><span class="d-inline-block"
                                data-ng-bind="data.user_name"></span></p>
                        <p ng-if="data.post_create_user" class="small m-0"><i
                                class="bi bi-pencil-square text-secondary me-2"></i><span
                                class="dir-ltr d-inline-block font-monospace"
                                data-ng-bind="slice(data.post_create_user, 0, 16)"></span></p>
                        <hr>
                        <p ng-if="data.post_create_user" class="small m-0"><i
                                class="bi bi-eye text-secondary me-2"></i><span
                                class="dir-ltr d-inline-block font-monospace"
                                data-ng-bind="sepNumber(data.post_create_user)"></span></p>
                        <p ng-if="data.post_likes" class="small m-0"><i
                                class="bi bi-hand-thumbs-up text-secondary me-2"></i><span
                                class="dir-ltr d-inline-block font-monospace"
                                data-ng-bind="sepNumber(data.post_likes)"></span></p>
                        <hr>

                        <div ng-if="data.post_archived" class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="articleArchived" name="archived"
                                ng-value="data.post_archived" data-ng-model="archived"
                                data-ng-change="toggle('archived', archived)">
                            <label class="form-check-label" for="articleArchived">Archive the article</label>
                        </div>
                        <div ng-if="data.post_allow_comments" class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="allowComments" name="allow_comment"
                                ng-value="data.post_allow_comments" data-ng-model="allow_comment"
                                data-ng-change="toggle('allow_comment', allow_comment)">
                            <label class="form-check-label" for="allowComments">Allow comments</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-8 col-lg-9">
                <div id="postCard" class="card card-box mb-3">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold pt-1 me-auto mb-3 text-uppercase">
                            <span class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                role="status"></span><span>Post</span>
                        </h5>

                        <form id="editForm" action="/posts/submit/" method="post" autocomplete="off">
                            @csrf
                            <input type="hidden" name="id" ng-value="data.post_id">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="mb-4">
                                        <input id="cover" type="file" name="photo" src="" class="dropify"
                                            data-default-file="<% data.post_photo %>">
                                    </div>
                                </div>

                                <div class="col-12 col-md-8">
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div class="mb-3">
                                                <label for="titleAr-input">Title<b
                                                        class="text-danger form-conter">&ast;</b></label>
                                                <input id="titleAr-input" name="title" type="text"
                                                    class="one-space form-control" maxlength="120"
                                                    data-ng-value="data.post_title" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12">
                                            <div class="mb-3">
                                                <label for="briefAr-input">Body<b class="text-danger">&ast;</b></label>
                                                <textarea id="briefAr-input" name="body" rows="5" class="one-space form-control" maxlength="500"
                                                    data-ng-bind="data.post_body" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-outline-primary btn-sm px-4">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- data-ng-if="!data.length" --}}
                <div class="card crad-box mb-3">
                    <div class="card-body">
                        <h6 class="fw-bold small">ADD FILE</h6>
                        <form id="addFileForm" action="/posts/file_submit/" method="post">
                            @csrf
                            <input type="hidden" name="post_id" data-ng-value="data.post_id">
                            <textarea name="context" class="d-none"></textarea>
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <div id="editorContext"><?= $file ?></div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-outline-primary btn-sm px-4">Submit</button>
                                </div>
                            </div>
                        </form>
                        <script>
                            $(function() {
                                $("#addFileForm").on('submit', e => e.preventDefault()).validate({
                                    submitHandler: function(form) {
                                        var formData, action = $(form).attr('action'),
                                            method = $(form).attr('method'),
                                            spinner = $(form).find('.loading-spinner'),
                                            controls = $(form).find('button');
                                        spinner.show();

                                        $(form).find('textarea[name=context]').val($('#editorContext').summernote('code'));
                                        formData = new FormData(form);

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
                                                toastr.success('create file successfully');
                                            } else toastr.error(response.error ?? glob_errorMsg);
                                        }).fail(function(jqXHR, textStatus, errorThrown) {
                                            toastr.error(glob_errorMsg);
                                        }).always(function() {
                                            spinner.hide();
                                            controls.prop('disabled', false);
                                        });
                                    },
                                });
                            });
                        </script>
                    </div>
                </div>

                {{-- <div class="card card-box mb-3">
                    <div class="card-body">
                        <ul class="nav nav-tabs fw-bold border-0">
                            <li class="nav-item">
                                <a class="file-edit nav-link active" href="#" data-lang="ar" data-dir="rtl">النص
                                    العربي</a>
                            </li>
                            <li class="nav-item">
                                <a class="file-edit nav-link" href="#" data-lang="en" data-dir="ltr">النص
                                    الانجليزي</a>
                            </li>
                        </ul>
                        <script>
                            $('.file-edit').on('click', function(e) {
                                e.preventDefault();
                                var editorCard = $('#editorCard'),
                                    form = $('#editorForm'),
                                    // lang = $(this).data('lang'),
                                    // dir = $(this).data('dir');

                                    // form.find('[name=code]').val(code);
                                    // form.find('[name=lang]').val(lang);
                                    // $('.file-edit').removeClass('active');
                                    // $(this).addClass('active');
                                    // $('#editorContext').summernote('reset');
                                    editorCard.find('.loading-spinner').show();
                                editorCard.find('.note-editable').css("direction", dir);
                                $.post('/articles/context_load/', {
                                    code: code,
                                    lang: lang,
                                }, function(data, status) {
                                    editorCard.find('.loading-spinner').hide();
                                    if (data) $('#editorContext').summernote('pasteHTML', data);
                                }, 'html');
                            });
                            $('.file-edit.active').trigger('click');
                        </script>
                    </div>
                </div> --}}

                <div id="commentsCard" class="card card-box mb-3">
                    <div class="card-body">
                        <div class="row">
                            {{-- <div class="col-12 col-sm-4 col-lg-3">
                                <div class="mb-3">
                                    <label for="commentsSearch">بحث</label>
                                    <input type="search" id="commentsSearch" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="commentsuserType">بواسطة</label>
                                    <select id="commentsuserType" class="form-select">
                                        <option value="0">الجميع</option>
                                        <option value="1">مشرف</option>
                                        <option value="2">طالب</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="commentsReviewed">المراجعة</label>
                                    <select id="commentsReviewed" class="form-select">
                                        <option value="0">الجميع</option>
                                        <option value="2">تمت مراجعتها</option>
                                        <option value="1">لم تتم مراجعتها</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="commentsVisible">الحالة</label>
                                    <select id="commentsVisible" class="form-select">
                                        <option value="0">الجميع</option>
                                        <option value="1">مخفي</option>
                                        <option value="2">ظاهر</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-12 col-sm-8 col-lg-12">
                                <div class="d-flex mb-4 align-items-center">
                                    <h5 class="card-title fw-bold m-0 me-auto">
                                        <small class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                            role="status"></small>
                                        <span>Comments</span>
                                        <span class="font-monospace ms-2 badge bg-primary rounded-pill px-2"
                                            data-ng-bind="comments.count"
                                            style="font-size:10px; position:relative; top:-3px"></span>
                                    </h5>
                                    <button class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                        id="commentsReloadBtn"></button>
                                </div>
                                <div class="mb-3 border rounded-2 p-2">
                                    <form id="addCommentForm" action="/posts/add-comment/" method="post">
                                        @csrf
                                        <input type="hidden" name="post_id" data-ng-value="data.post_id">
                                        <div class="mb-3">
                                            {{-- <label for="addCommentContext">
                                                <small
                                                    class="loading-spinner spinner-border spinner-border-sm text-warning me-3"
                                                    role="status"></small>
                                                <span>add comment</span>
                                            </label> --}}
                                            <textarea name="comment" id="addCommentContext" class="form-control border-0" rows="6" maxlength="2048"
                                                required></textarea>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit"
                                                class="btn btn-outline-primary btn-sm px-3">Add</button>
                                        </div>
                                    </form>
                                </div>
                                <div data-ng-if="comments.data.length" data-ng-repeat="c in comments.data"
                                    class="bg-muted-2 p-3 border rounded-2 mb-3"
                                    data-ng-class="!+c.comment_visible ? 'border-danger' : 'border-success'">
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
                                <h6 data-ng-if="comments.count && comments.data.length == comments.count"
                                    class="text-center my-3 small text-secondary">All comments have been uploaded</h6>
                                <div data-ng-if="!comments.data.length" class="text-center my-5">
                                    <h1 style="font-size: 90px"><i class="bi bi-chat-dots text-secondary"></i></h1>
                                    <h5 class="text-secondary"> No Comments...</h5>
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
                            $.post('/posts/get-comment/', request, function(data) {
                                spinner.hide();
                                var length = data.length;
                                scope.$apply(() => {
                                    scope.comments.count = length;

                                    scope.comments.data = reload ? data : [].concat(scope.comments.data,
                                        data);
                                    // scope.comments.lastId = length ? response.data[length - 1].comment_id : scope
                                    //     .comments.lastId;
                                });
                                // loadingBtn.prop('disabled', scope.comments.data.length == scope.comments.count);
                                // if (response.status) {
                                //     var length = response.data.length;
                                //     console.log(data);
                                //     scope.$apply(() => {
                                //         scope.comments.count = response.count;
                                //         scope.comments.data = reload ? response.data : [].concat(scope.comments.data,
                                //             response.data);
                                //         scope.comments.lastId = length ? response.data[length - 1].comment_id : scope
                                //             .comments.lastId;
                                //     });
                                //     loadingBtn.prop('disabled', scope.comments.data.length == scope.comments.count);
                                // } else {
                                //     toastr.error(glob_errorMsg);
                                //     loadingBtn.prop('disabled', false);
                                // }
                            }, 'json');
                        };
                    </script>
                </div>
            </div>
        </div>
    </div>

    <script>
        var scope;
        $(function() {
            $('#editorContext').summernote({
                tabsize: 2,
                height: 300
            });

            $('.dropify').dropify({
                allowedFileExtensions: 'jpg jpeg png webp',
                fileSize: '1M',
                minWidth: '500',
                maxWidth: '1200',
                minHeight: '300',
                maxHeight: '800',
                showRemove: false,
            });

            $('.one-space').on('change', function() {
                oneSpace($(this));
            });

            $("#editForm").on('submit', e => e.preventDefault()).validate({
                submitHandler: function(form) {
                    var formData = new FormData(form),
                        action = $(form).attr('action'),
                        method = $(form).attr('method'),
                        submitBtn = $(form).find('button[type=submit]'),
                        spinner = $('#postCard .loading-spinner');

                    spinner.show();
                    submitBtn.prop('disabled', true);
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

                            scope.$apply(() => {
                                scope.data = response.data;
                                scope.reset();
                            });
                        } else toastr.error(response.error ?? glob_errorMsg);
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        toastr.error(glob_errorMsg);
                    }).always(function() {
                        spinner.hide();
                        submitBtn.prop('disabled', false);
                    });
                },
            });
        });

        var scope, ngApp = angular.module("ngApp", ['ngSanitize'], function($interpolateProvider) {
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
        });
        ngApp.controller("ngCtrl", function($scope) {
            $('.loading-spinner').hide();
            $scope.data = <?= json_encode($data ?? []) ?>;
            // $scope.arrayColumn = (array, column) => array.map(item => item[column]);
            $scope.slice = (str, start, len) => str.slice(start, len);
            // $scope.jsonParse = name => JSON.parse(name);
            $scope.sepNumber = num => sepNumber(num);
            $scope.comments = {
                count: 0,
                data: [],
                lastId: 0,
                limit: 24,
            };

            $scope.reset = () => {
                // $scope.visible = !!+$scope.data.article_visible;
                $scope.archived = !!+$scope.data.post_archived;
                $scope.allow_comment = !!+$scope.data.post_allow_comments;
                // $scope.cover = $scope.data.article_cover ? coversPath + $scope.data.article_cover : '';
            };

            $scope.toggle = function(target, val) {
                var input = $(`input[name=${target}]`),
                    key = `post_${target}`;
                input.prop('disabled', true);
                $.post('/posts/update-data/', {
                    _token: '{{ csrf_token() }}',
                    id: $scope.data.post_id,
                    key: key,
                    val: +val,
                }, function(response) {
                    input.prop('disabled', false);
                    $scope.$apply(function() {
                        $scope[target] = (response.status ? val : !val);
                        $scope.data[key] = (response.status ? +val : +!val);
                    });
                    if (response.status) toastr.success(
                        'The article status has been updated successfully');
                    else toastr.error('An error occurred in the operation, try again');
                }, 'json');
            };
            $scope.reset();
            scope = $scope;
        });
    </script>
@endsection
