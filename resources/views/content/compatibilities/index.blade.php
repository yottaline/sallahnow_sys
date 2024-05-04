@extends('index')
@section('title')
    Compatibilities
@endsection
@section('search')
    <form id="searchForm" role="search">
        <input type="search" name="q" class="form-control my-3 my-md-0 rounded-pill" placeholder="Search...">
    </form>
@endsection
@section('content')
    <div class="container-fluid" data-ng-app="myApp" data-ng-controller="myCtrl">
        <div class="row">
            <div class="col-12 col-sm-4 col-lg-3">
                <div class="card card-box">
                    <div class="card-body">
                        {{-- <div class="mb-3">
                            <label for="roleFilter">Role</label>
                            <select name="" id="" class="form-select">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="roleFilter">Status</label>
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
                            <h5 class="card-title fw-semibold pt-1 me-auto mb-3">
                                <span class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                    role="status"></span><span>COMPATIBILITIES</span>
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                    data-ng-click="setCompatibility(false)"></button>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>

                        </div>
                        <h5 data-ng-if="q" class="text-dark">Result of <span class="text-primary" data-ng-bind="q"></span>
                        </h5>
                        <div data-ng-if="list.length" class="table-responsive">
                            <table class="table table-hover" id="compatibiliy_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center">Category Name</th>
                                        <th class="text-center">Mother Board</th>
                                        <th class="text-center">Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="comp in list track by $index">
                                        <td data-ng-bind="comp.compat_code"></td>
                                        <td class="text-center" data-ng-bind="comp.category_name"></td>
                                        <td class="text-center" data-ng-bind="jsonParse(comp.compat_part)['en']"></td>
                                        <td class="text-center" data-ng-bind="comp.board_name"></td>
                                        <td class="col-fit">
                                            <div>
                                                <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                    data-ng-click="setCompatibility($index)"></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @include('layouts.loade')
                    </div>
                </div>
            </div>
        </div>
        @include('components.dashbords.modals.modal_compatibilities')
    </div>
@endsection
@section('js')
    <script>
        var scope, app = angular.module('myApp', []);
        app.controller('myCtrl', function($scope) {
            $('.loading-spinner').hide();
            $scope.jsonParse = (str) => JSON.parse(str);
            $scope.updateComp = false;
            $scope.list = [];
            $scope.copmatsModels = [];
            $scope.categories = <?= json_encode($categories) ?>;
            $scope.models = [];
            $scope.q = '';
            $scope.noMore = false;
            $scope.loading = false;
            $scope.last_id = 0;
            $scope.dataLoader = function(reload = false) {

                if (reload) {
                    $scope.list = [];
                    $scope.last_id = 0;
                    $scope.noMore = false;
                }

                if ($scope.noMore) return;
                $scope.loading = true;

                $('.loading-spinner').show();

                $.post("/compatibilities/load/", {
                    last_id: $scope.last_id,
                    limit: limit,
                    q: $scope.q,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('.loading-spinner').hide();
                    var ln = data.length;
                    $scope.$apply(() => {
                        $scope.loading = false;
                        if (ln) {
                            $scope.noMore = ln < limit;
                            $scope.list = data;
                            console.log(data)
                            $scope.last_id = data[ln - 1].compat_id;
                        };
                    });
                }, 'json');
            }
            $scope.setCompatibility = (index) => {
                $scope.copmatsModels = [];
                $scope.updateComp = index;
                $('#compatibilityForm').modal('show');
            };

            $scope.dataLoader();

            $('#branID').select2({
                theme: 'bootstrap-5'
            });

            $('#modelId').select2(suggOption($('#compatibilityForm'), '/models/get_models/', function(data) {
                console.log(data)
                return data.map(function(e) {
                    return {
                        id: e.model_id,
                        text: e.model_name
                    }
                })
            }, false, false, {
                brand_id: () => $('#branID').val() // sallahnow.com/getbrandmodels?brand_id=12
            }));
            scope = $scope;
        });

        $(function() {


            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                scope.$apply(() => scope.q = $(this).find('input').val());
                scope.dataLoader(true);
            });

            // $('#branID').on('change', function() {
            //     var idState = this.value;
            //     $('#modelId').html('');
            //     $.ajax({
            //         url: '/models/search/' + idState,
            //         type: 'GET',
            //         dataType: 'json',
            //         success: function(res) {
            //             console.log(res.data)
            //             $.each(res.data, function(key, value) {
            //                 $('#modelId').append('<option id="class" value="' +
            //                     value
            //                     .model_id +
            //                     '">' + value.model_name + '</option>');
            //             });
            //         }
            //     });
            // });

            $('#modelId').on('change', function() {
                var id = this.value;
                console.log(id)
                $.ajax({
                    url: '/models/model_name/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        $('#models').append(
                            '<div class="col-sm-4"> <label id="models" class="m-1">' +
                            res
                            .model_name +
                            '</label> <input type="checkbox" checked value="' + res
                            .model_id + '" name="model_id[]"></div>');
                    }
                });
            })


            // $('#branID').on('change', function() {
            //     var idState = this.value;
            //     console.log(idState);
            //     $('#modelId').html('');
            //     $.ajax({
            //         url: '/models/search/' + idState,
            //         type: 'GET',
            //         dataType: 'json',
            //         success: function(res) {
            //             $.each(res, function(key, value) {
            //                 $('#models').append(
            //                     '<div class="col-sm-4"> <label id="models" class="m-1">' +
            //                     value
            //                     .model_name +
            //                     '</label> <input type="checkbox" value="' + value
            //                     .model_id + '" name="model_id[]"></div>'
            //                 );
            //             });
            //         }
            //     });
            // });

        });
    </script>
@endsection
