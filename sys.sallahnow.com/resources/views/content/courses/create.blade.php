@extends('index')
@section('title')
    Cuorse
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
                            data-ng-bind="data.course_code"></h5>
                        <p ng-if="data.course_title" class="fw-bold text-center m-0 small" data-ng-bind="data.post_title">
                        </p>
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
                        {{-- ng-if="data.course_archived" --}}
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="articleArchived" name="archived"
                                ng-value="data.course_archived" data-ng-model="archived"
                                data-ng-change="toggle('archived', archived)">
                            <label class="form-check-label" for="articleArchived">Archive the course</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-8 col-lg-9">
                <div id="postCard" class="card card-box mb-3">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold pt-1 me-auto mb-3 text-uppercase">
                            <span class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                role="status"></span><span>CUORSES</span>
                        </h5>

                        <form id="editForm" action="/courses/submit/" method="post" autocomplete="off">
                            @csrf
                            <input type="hidden" name="course_id" ng-value="data.course_id_id">
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
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="mb-3">
                                                        <label for="titleAr-input">Title<b
                                                                class="text-danger form-conter">&ast;</b></label>
                                                        <input id="titleAr-input" name="title" type="text"
                                                            class="one-space form-control" maxlength="120"
                                                            data-ng-value="data.course_title" required>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="mb-3">
                                                        <label for="titleAr-input">Cost<b
                                                                class="text-danger form-conter">&ast;</b></label>
                                                        <input id="titleAr-input" name="cost" type="text"
                                                            class="one-space form-control" maxlength="120"
                                                            data-ng-value="data.course_cost" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12">
                                            <div class="mb-3">
                                                <label for="briefAr-input">Body<b class="text-danger">&ast;</b></label>
                                                <textarea id="briefAr-input" name="body" rows="5" class="one-space form-control" maxlength="500"
                                                    data-ng-bind="data.course_body" required></textarea>
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
                                    rules: {
                                        identification: {
                                            digits: true
                                        },
                                        tel: {
                                            digits: true
                                        },
                                        mobile: {
                                            digits: true
                                        },
                                    },
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
                rules: {
                    title: {
                        required: true,
                    },
                    body: {
                        required: true
                    },
                    cost: {
                        digits: true
                    },
                },
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

            $scope.sepNumber = num => sepNumber(num);
            $scope.comments = {
                count: 0,
                data: [],
                lastId: 0,
                limit: 24,
            };

            $scope.reset = () => {
                $scope.archived = !!+$scope.data.course_archived;
            };

            $scope.toggle = function(target, val) {
                var input = $(`input[name=${target}]`),
                    key = `post_${target}`;
                input.prop('disabled', true);
                $.post('/courses/update_archived/', {
                    _token: '{{ csrf_token() }}',
                    id: $scope.data.course_id,
                    key: key,
                    val: +val,
                }, function(response) {
                    input.prop('disabled', false);
                    $scope.$apply(function() {
                        $scope[target] = (response.status ? val : !val);
                        $scope.data[key] = (response.status ? +val : +!val);
                    });
                    if (response.status) toastr.success(
                        'The course status has been updated successfully');
                    else toastr.error('An error occurred in the operation, try again');
                }, 'json');
            };
            $scope.reset();
            scope = $scope;
        });
    </script>
@endsection
