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
                                <div class="col-12 col-md-12">
                                    <div class="mb-3">
                                        <input type="search" class="form-control" name="search" placeholder="Search..."
                                            id="search">
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="mb-3">
                                        <label for="TechnicianName">Technician Name<b class="text-danger">&ast;</b></label>
                                        <select class="form-control" name="technician_name" id="TechnicianName"></select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="mb-3">
                                        <label for="RoomCode">Room Code<b class="text-danger">&ast;</b></label>
                                        <select class="form-control" name="room" id="RoomCode"></select>
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
                        <div class="d-flex" data-ng-if="messages.length">
                            <h5 class="card-title fw-semibold pt-1 me-auto mb-3">The Messages :</h5>
                        </div>
                        <div>
                            <p data-ng-repeat="msg in messages" data-ng-bind="msg.msg_context"></p>
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
            $room = false;
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

            $scope.addRoom = (indx) => {
                $scope.psot = indx;
                $('#add_chat_room').modal('show');
            };
            // $scope.dataLoader();
            scope = $scope;
        });

        $(function() {
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                scope.$apply(() => scope.q = $(this).find('input').val());
                scope.dataLoader(true);
            });
        });

        // add cost
        $(function() {
            $('#add_chat_room form').on('submit', function(e) {
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
                        $('#add_chat_room').modal('hide');
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

        $('#search').on('change', function() {
            var idState = this.value;
            console.log(idState);
            $('#TechnicianName').html('');
            $.ajax({
                url: 'get-technician/' + idState,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    $.each(res, function(key, value) {
                        $('#TechnicianName').append('<option id="class" value="' + value
                            .tech_id +
                            '">' + value.tech_name + '</option>');
                    });
                }
            });
        });

        $('#TechnicianName').on('click', function() {
            var idState = this.value;
            console.log(idState);
            $('#RoomCode').html('');
            $.ajax({
                url: 'get-chat-room/' + idState,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    $.each(res, function(key, value) {
                        console.log(value)
                        $('#RoomCode').append('<option id="class" value="' + value
                            .member_id +
                            '">' + value.room_name + '</option>');
                    });
                }
            });
        });

        $('#RoomCode').on('click', function() {
            var idState = this.value;
            console.log(idState);
            $.post("get-chat-msg/" + idState, {
                _token: '{{ csrf_token() }}'
            }, function(data) {
                $('.perm').show();
                scope.$apply(() => {
                    scope.messages = data;
                    console.log(data)
                });
            }, 'json');
        });
    </script>
@endsection
