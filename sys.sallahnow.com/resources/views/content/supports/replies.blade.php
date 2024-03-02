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
                        <div data-ng-if="data.length" class="table-responsive">
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
                $scope.data = <?= !empty($replies) ? json_encode($replies) : 'null' ?>;
                $('.loading-spinner').hide();
                $scope.jsonParse = (str) => JSON.parse(str);

                scope = $scope;
            });
        </script>
    @endsection
