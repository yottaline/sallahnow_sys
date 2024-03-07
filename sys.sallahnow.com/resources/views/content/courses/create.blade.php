@extends('index')
@section('title')
    Courses
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/dropify.css') }}">
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
                        <h5 class="text-center text-secondary font-monospace small dir-ltr mb-3"
                            data-ng-bind="data.course_code"></h5>
                        <p class="fw-bold text-center m-0 small" data-ng-bind="data.course_title"></p>
                        <hr>
                        <p class="small m-0"><i class="bi bi-person-circle text-secondary me-2"></i><span
                                class="d-inline-block" data-ng-bind="data.user_name"></span></p>
                        <p class="small m-0"><i class="bi bi-eye text-secondary me-2"></i><span
                                class="dir-ltr d-inline-block font-monospace" data-ng-bind="data.course_views"></span></p>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="articleArchived" name="archived"
                                ng-value="data.course_archived" data-ng-model="archived"
                                data-ng-change="toggle('archived', archived)">
                            <label class="form-check-label" for="articleArchived">Archive the article</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-8 col-lg-9">
                <div id="articleCard" class="card card-box mb-3">
                    <div class="card-body">
                        <a href="/courses/" class="card-title fw-bold mb-4">
                            <small class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                role="status"></small>
                            <span>Courses</span>
                        </a>
                        <form id="editForm" action="/courses/submit/" method="post" autocomplete="off">
                            @csrf
                            <input type="hidden" name="id" ng-value="data.post_id">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="mb-4">
                                        <input id="cover" type="file" name="photo" class="dropify">
                                    </div>
                                </div>

                                <div class="col-12 col-md-8">
                                    <div class="row">
                                        <div class="col-6 col-md-12">
                                            <div class="mb-3">
                                                <label for="titleAr-input">Title<b
                                                        class="text-danger form-conter">&ast;</b></label>
                                                <input id="titleAr-input" name="title" type="text"
                                                    class="one-space form-control" maxlength="120"
                                                    data-ng-value="data.course_title" required>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-12">
                                            <div class="mb-3">
                                                <label for="titleAr-input">Cost <b
                                                        class="text-danger form-conter">&ast;</b></label>
                                                <input id="titleAr-input" name="cost" type="text"
                                                    class="one-space form-control" maxlength="120"
                                                    data-ng-value="data.course_cost" required>
                                            </div>
                                        </div>
                                        {{-- <div class="col-12 col-md-12">
                                            <div class="mb-3">
                                                <label>File</label>
                                                <input type="file" name="files" class="form-control">
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-4">
                                        <label for="briefAr-input">Body<b class="text-danger">&ast;</b></label>
                                        <textarea id="briefAr-input" name="body" rows="10" class="one-space form-control" maxlength="500"
                                            data-ng-bind="data.course_title" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-outline-primary btn-sm px-4">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        var scope;
        $(function() {
            $('.dropify').dropify({
                allowedFileExtensions: 'jpg jpeg png webp',
                // fileSize: '1M',
                // minWidth: '500',
                // maxWidth: '1200',
                // minHeight: '300',
                // maxHeight: '800',
                showRemove: false,
                messages: {
                    'default': 'Attach a picture',
                    'replace': 'يمكنك سحب وإفلات الصورة هنا لاستبدالها',
                    'remove': 'حذف',
                    'error': 'هناك خطأ في الملف'
                }
            });

            $('.one-space').on('change', function() {
                oneSpace($(this));
            });

            $("#editForm").on('submit', e => e.preventDefault()).validate({
                rules: {
                    title: {
                        required: true
                    },
                    body: {
                        required: true
                    },
                    cost: {
                        required: true,
                        digits: true
                    }
                },
                submitHandler: function(form) {
                    var formData = new FormData(form),
                        action = $(form).attr('action'),
                        method = $(form).attr('method'),
                        submitBtn = $(form).find('button[type=submit]'),
                        spinner = $('#articleCard .loading-spinner');

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
                            var scope = angular.element($('#POSTI')).scope();
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

        var ngApp = angular.module("ngApp", ['ngSanitize'], function($interpolateProvider) {
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
        });
        ngApp.controller("ngCtrl", function($scope) {
            $('.loading-spinner').hide();
            $scope.data = <?= !empty($data) ? json_encode($data) : 'null' ?>;
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
                        'The article status has been updated successfully');
                    else toastr.error('An error occurred in the operation, try again');
                }, 'json');
            };
            $scope.reset();
            scope = $scope;
        });
    </script>
    <script src="{{ asset('assets/js/dropify.js') }}"></script>
@endsection
