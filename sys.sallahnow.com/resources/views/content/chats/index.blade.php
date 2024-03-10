@extends('index')
@section('title')
    Chats
@endsection
@section('content')
    <div class="container-fluid" data-ng-app="myApp" data-ng-controller="myCtrl">
        <div class="row">
            <div class="col-12 col-sm-4 col-lg-3">
                <div class="card card-box">
                    <div class="card-body">
                        <div class="mb-3">
                            {{-- <div class="d-flex">
                                <h5 class="card-title fw-semibold pt-1 me-auto mb-3 text-uppercase">
                                    <span class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                        role="status"></span><span>CHATS ROOMS</span>
                                </h5>
                                <div>

                                    <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                        data-ng-click="addRoom(true)"></button>
                                    <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                        data-ng-click="dataLoader(true)"></button>
                                </div>
                            </div> --}}
                            <div class="row">
                                {{-- <div class="col-12 col-md-12">
                                    <div class="mb-3">
                                        <input type="search" class="form-control" name="search" placeholder="Search..."
                                            id="search">
                                    </div>
                                </div> --}}
                                <div class="col-12 col-md-12">
                                    <div class="mb-3">
                                        <label for="TechnicianName">Technician Name<b class="text-danger">&ast;</b></label>
                                        <select class="form-control" name="technician_name" id="technicianName">
                                            <option value="0">-- SELECT TECHNICIAN NAME--</option>
                                            <option data-ng-repeat="tech in technicians track by $index"
                                                data-ng-value="tech.tech_id" data-ng-bind="tech.tech_name"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="d-flex">
                                        <h6 class="fw-bold me-auto">
                                            <small class="spinner-border-sm text-warning" role="status"></small>
                                            <span>Rooms</span>
                                        </h6>
                                    </div>
                                    <ul data-ng-if="rooms.length" class="list-group list-group-flush">
                                        <li data-ng-repeat="room in rooms"
                                            class="list-group-item list-group-item-action d-flex bg-muted-8"
                                            data-ng-class="activeCountry == $index ? 'active' : ''">
                                            <span data-ng-bind="room.room_name" class="me-auto"></span>
                                            <a href="" class="link-primary bi bi-eye me-2"
                                                data-ng-click="toggleVisibility($index)"></a>
                                            <a href="" class="link-primary bi bi-chevron-right"
                                                data-ng-click="getMassages(room)"></a>
                                        </li>
                                    </ul>
                                    <div data-ng-if="!rooms.length" class="py-5 text-center">
                                        <h1 style="font-size: 60px"><i class="bi bi-exclamation-circle text-secondary"></i>
                                        </h1>
                                        <h6 class="text-secondary">No records</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-8 col-lg-9">
                <div class="card card-box perm">
                    <div class="card-body">
                        <div data-ng-if="messages.length" class="table-responsive">
                            <div data-ng-if="messages.length" data-ng-repeat="c in messages"
                                class="bg-muted-2 p-3 border rounded-2 mb-3"
                                data-ng-class="!+c.msg_id ? 'border-danger' : 'border-success'">
                                <h6> <i class="bi bi-person-circle text-secondary me-1"></i><span data-ng-bind="c.tech_name"
                                        class="font-monospace dir-ltr d-inline-block"></span></h6>
                                <p class="fw-bold small" data-ng-bind="c.msg_context"></p>
                                <div class="small">
                                    <i class="bi bi-clock text-secondary me-1"></i><span data-ng-bind="c.msg_create"
                                        class="font-monospace dir-ltr d-inline-block"></span>
                                </div>
                            </div>
                            <div data-ng-if="!messages.length" class="py-5 text-center">
                                <h1 style="font-size: 60px"><i class="bi bi-exclamation-circle text-secondary"></i>
                                </h1>
                                <h6 class="text-secondary">No records</h6>
                            </div>
                        </div>
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
            $scope.chats = [];
            $scope.messages = [];
            $scope.rooms = [];
            $room = false;
            $scope.technicians = <?= !empty($technicians) ? json_encode($technicians) : 'null' ?>;
            $scope.page = 1;
            // $scope.dataLoader = function(reload = false) {
            //     $('.loading-spinner').show();
            //     if (reload) {
            //         $scope.page = 1;
            //     }
            //     $.post("/chats/load/", {
            //         page: $scope.page,
            //         limit: 24,
            //         _token: '{{ csrf_token() }}'
            //     }, function(data) {
            //         $('.loading-spinner').hide();
            //         $scope.$apply(() => {
            //             $scope.chats = data;
            //             $scope.page++;
            //         });
            //     }, 'json');
            // }

            $scope.getMassages = (room) => {
                let id = room.member_id;
                $.post("get-chat-msg/" + id, {
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    scope.$apply(() => {
                        scope.messages = data;
                        console.log(data)
                    });
                }, 'json');
            };

            scope = $scope;
        });

        $(function() {
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                scope.$apply(() => scope.q = $(this).find('input').val());
                scope.dataLoader(true);
            });
        });

        $('#technicianName').on('change', function() {
            var val = $(this).val();
            console.log(val)
            $.get("get-chat-room/" + val, function(data) {
                $('.perm').show();
                scope.$apply(() => {
                    scope.rooms = data;
                    console.log(data)
                });
            }, 'json');
        });

        // $(document).ready(function() {
        //     $('#select2').select2();
        // });
    </script>
@endsection
