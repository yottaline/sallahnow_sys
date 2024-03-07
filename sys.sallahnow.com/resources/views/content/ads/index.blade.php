@extends('index')
@section('title')
    Ads
@endsection
@section('content')
    <div class="container-fluid" data-ng-app="myApp" data-ng-controller="myCtrl">
        <div class="row">
            <div class="col-12 col-sm-4 col-lg-3">
                <div class="card card-box">
                    <div class="card-body">
                        {{-- It will be worked on soon --}}
                        <div class="mb-3">
                            <label for="roleFilter">Status</label>
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
                            <h5 class="card-title fw-semibold pt-1 me-auto mb-3">
                                <span class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                    role="status"></span><span>ADS</span>
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                    data-ng-click="setUser(false)"></button>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>

                        </div>
                        <div data-ng-if="ads.length" class="table-responsive">
                            <table class="table table-hover" id="user_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tilte</th>
                                        <th>Body</th>
                                        <th>Photo</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Use Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="ad in ads track by $index">
                                        <td data-ng-bind="ad.ads_id"></td>
                                        <td data-ng-bind="ad.ads_title"></td>
                                        <td data-ng-bind="ad.ads_body"></td>
                                        <td>
                                            <img src="{{ asset('Image/Ads/') }}/<%ad.ads_photo%>" alt="ads_photo"
                                                width="30px">
                                        </td>
                                        <td data-ng-bind="ad.ads_start"></td>
                                        <td data-ng-bind="ad.ads_end"></td>
                                        <td data-ng-bind="ad.user_name"></td>
                                        <td class="col-fit">
                                            <div>
                                                <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                    data-ng-click="setUser($index)"></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div data-ng-if="!ads.length" class="text-center text-secondary py-5">
                            <i class="bi bi-exclamation-circle  display-4"></i>
                            <h5>No records</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- start add new ads  Modal -->
        <div class="modal fade" id="useForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="/ads/submit/">
                            @csrf
                            <input data-ng-if="adUpdate !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="ads_id"
                                data-ng-value="adUpdate !== false ? ads[adUpdate].ads_id : 0">
                            <div class="mb-3">
                                <label for="Title">Title<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="title" id="Title" required
                                    data-ng-value="adUpdate !== false ? ads[adUpdate].ads_title : ''">
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="photo">Photo<b class="text-danger">&ast;</b></label>
                                        <input type="file" class="form-control" name="photo" id="photo">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="URL">Url</label>
                                        <input type="text" class="form-control" name="url" id="URL"
                                            data-ng-value="adUpdate !== false ? ads[adUpdate].ads_url : ''">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label>Ads Start<b class="text-danger">&ast;</b></label>
                                        <input id="subStart" type="text" class="form-control text-center" name="start"
                                            maxlength="10" data-ng-value="ads[adUpdate].ads_start" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label>Ads End<b class="text-danger">&ast;</b></label>
                                        <input id="subEnd" type="text" class="form-control text-center"
                                            name="end" maxlength="10"
                                            data-ng-value="adUpdate !== false ? ads[adUpdate].ads_end : ''">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label>Body<b class="text-danger">&ast;</b></label>
                                        <textarea class="form-control" rows="7" cols="30"
                                            data-ng-value="adUpdate !== false ? ads[adUpdate].ads_body : ''" name="body"></textarea>
                                    </div>
                                </div>
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
        <!-- end add new ads  Modal -->


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
            $scope.adUpdate = false;
            $scope.ads = [];
            $scope.page = 1;
            $scope.dataLoader = function(reload = false) {
                $('.loading-spinner').show();
                if (reload) {
                    $scope.page = 1;
                }
                $.post("/ads/load/", {
                    page: $scope.page,
                    limit: 24,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    $scope.$apply(() => {
                        $scope.ads = data;
                        $scope.page++;
                    });
                }, 'json');
            }
            $scope.setUser = (indx) => {
                $scope.adUpdate = indx;
                $('#useForm').modal('show');
            };
            $scope.dataLoader();
            scope = $scope;
        });

        $(function() {
            $('#useForm form').on('submit', function(e) {
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
                    if (response.status) {
                        toastr.success('Data processed successfully');
                        $('#useForm').modal('hide');
                        scope.$apply(() => {
                            if (scope.adUpdate === false) {
                                scope.ads.unshift(response.data);
                                scope.dataLoader(true);
                            } else {
                                scope.ads[scope.adUpdate] = response.data;
                                scope.dataLoader(true);
                            }
                        });
                    } else toastr.error("Error");
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    toastr.error("error");
                    controls.log(jqXHR.responseJSON.message);
                    $('#useForm').modal('hide');
                }).always(function() {
                    spinner.hide();
                    controls.prop('disabled', false);
                });

            })
        });

        $(function() {
            $('#edit_active form').on('submit', function(e) {
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
                    if (response.status) {
                        toastr.success('Data processed successfully');
                        $('#edit_active').modal('hide');
                        scope.$apply(() => {
                            if (scope.adUpdate === false) {
                                scope.ads.unshift(response.data);
                                scope.dataLoader(true);
                            } else {
                                scope.ads[scope.adUpdate] = response.data;
                                scope.dataLoader(true);
                            }
                        });
                    } else toastr.error("Error");
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    toastr.error("error");
                    controls.log(jqXHR.responseJSON.message);
                    $('#useForm').modal('hide');
                }).always(function() {
                    spinner.hide();
                    controls.prop('disabled', false);
                });

            })
        });

        $(function() {
            $("#subStart").datetimepicker($.extend({}, dtp_opt, {
                showTodayButton: false,
                format: "YYYY-MM-DD",
            }));
        });

        $(function() {
            $("#subEnd").datetimepicker($.extend({}, dtp_opt, {
                showTodayButton: false,
                format: "YYYY-MM-DD",
            }));
        });
    </script>
@endsection
