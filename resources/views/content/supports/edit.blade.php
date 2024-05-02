@extends('index')
@section('title')
    Replie
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
    <div class="container-fluid" id="REPLIES" data-ng-app="ngApp" data-ng-controller="ngCtrl">
        <div class="row">
            <div class="col-12 col-sm-4 col-lg-3">
                <div class="card card-box mb-3">
                    <div class="card-body">
                        <h1 style="font-size: 70px" class="text-center my-3"><i
                                class="bi bi-file-earmark-richtext text-secondary"></i></h1>
                        <h5 ng-if="tick.ticket_code" class="text-center text-secondary font-monospace small dir-ltr mb-3"
                            data-ng-bind="tick.ticket_code"></h5>
                        <hr>
                        <p ng-if="tick.tech_name" class="small m-0"><i
                                class="bi bi-person-circle text-secondary me-2"></i><span class="d-inline-block"
                                data-ng-bind="tick.tech_name"></span></p>
                        <hr>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-8 col-lg-9">
                <div id="replyCart" class="card card-box mb-3">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold pt-1 me-auto mb-3 text-uppercase">
                            <span class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                role="status"></span><span>SUPPORT
                                TICKET REPLIES</span>
                        </h5>
                        <div class="mb-3">
                            <textarea class="form-control" data-ng-bind="tick.ticket_context" readonly></textarea>
                        </div>
                    </div>
                </div>

                <div id="replie" class="card card-box mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-8 col-lg-12">
                                <div class="d-flex mb-4 align-items-center">
                                    <h5 class="card-title fw-bold m-0 me-auto">
                                        <small class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                            role="status"></small>
                                        <span>REPLIES</span>
                                        <span class="font-monospace ms-2 badge bg-primary rounded-pill px-2"
                                            data-ng-bind="data.count"
                                            style="font-size:10px; position:relative; top:-3px"></span>
                                    </h5>
                                    <button class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                        id="replieBtn"></button>
                                </div>
                                <div class="mb-3 border rounded-2 p-2">
                                    <form id="addReplyFrom" action="/tickets/add-replie/" method="post">
                                        @csrf
                                        <input type="hidden" name="ticket_id" data-ng-value="tick.ticket_id">
                                        <div class="mb-3">
                                            <label for="addRreplyContext">
                                                <small
                                                    class="loading-spinner spinner-border spinner-border-sm text-warning me-3"
                                                    role="status"></small>
                                            </label>
                                            <textarea name="replie" id="addRreplyContext" class="form-control border-0" rows="6" maxlength="2048" required></textarea>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit"
                                                class="btn btn-outline-primary btn-sm px-3">Rreply</button>
                                        </div>
                                    </form>
                                </div>
                                <div data-ng-if="replies.data.length" data-ng-repeat="c in data"
                                    class="bg-muted-2 p-3 border rounded-2 mb-3"
                                    data-ng-class="!+c.reply_id ? 'border-danger' : 'border-success'">
                                    {{-- <h6 class="fw-bold small" data-ng-bind="!!+c.reply_user ? c.student_name : c.user_name">
                                    </h6> --}}
                                    <p class="small" data-ng-bind="c.reply_context"></p>
                                </div>
                                <h6 data-ng-if="replies.data.count && replies.data.length == replies.data.count"
                                    class="text-center my-3 small text-secondary">All reply have been uploaded</h6>
                                <div data-ng-if="!data.length" class="text-center my-5">
                                    <h1 style="font-size: 90px"><i class="bi bi-chat-dots text-secondary"></i></h1>
                                    <h5 class="text-secondary"> No Replie...</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        $(function() {
                            $('#replieBtn').on('click', e => {
                                loadRreply(true);
                            });

                            $("#addReplyFrom").on('submit', e => e.preventDefault()).validate({
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
                                            toastr.success('The reply has been completed');
                                            scope.$apply(() => {
                                                scope.data.unshift(response.data)
                                                loadRreply(true);
                                                scope.data.count++;
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

                            loadRreply(true);
                        });

                        function loadRreply(reload = false) {
                            var spinner = $('#replie .card-title>.loading-spinner'),
                                loadingBtn = $('#replie .loading-btn'),
                                request = {
                                    _token: '{{ csrf_token() }}',
                                    ticket_id: scope.tick.ticket_id,
                                };

                            spinner.show();
                            loadingBtn.prop('disabled', true);
                            $.post('/tickets/replies/', request, function(data) {
                                spinner.hide();
                                var length = data.length;
                                scope.$apply(() => {
                                    scope.replies.count = length;

                                    scope.replies.data = reload ? data : [].concat(scope.replies.data,
                                        data);
                                    scope.replies.lastId = length ? data.data[length - 1].reply_id : scope
                                        .replies.lastId;
                                });
                                loadingBtn.prop('disabled', scope.replies.data.length == scope.replies.count);
                                if (data.status) {
                                    var length = data.length;
                                    scope.$apply(() => {
                                        scope.replies.count = data.count;
                                        scope.replies.data = reload ? data.data : [].concat(scope.replies.data,
                                            data.data);
                                        scope.replies.lastId = length ? data.data[length - 1].reply_id : scope
                                            .replies.lastId;
                                    });
                                    loadingBtn.prop('disabled', scope.replies.data.length == scope.replies.count);
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

    <script>
        var scope;

        var scope, ngApp = angular.module("ngApp", ['ngSanitize'], function($interpolateProvider) {
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
        });
        ngApp.controller("ngCtrl", function($scope) {
            $('.loading-spinner').hide();
            $scope.data = <?= json_encode($replies ?? []) ?>;
            $scope.tick = <?= json_encode($tick ?? []) ?>;
            $scope.slice = (str, start, len) => str.slice(start, len);
            $scope.sepNumber = num => sepNumber(num);
            $scope.replies = {
                count: 0,
                data: [],
                lastId: 0,
                limit: 24,
            };
            scope = $scope;
        });
    </script>
@endsection
