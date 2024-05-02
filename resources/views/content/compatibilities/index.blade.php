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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
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
                                        <th class="text-center">Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="comp in list track by $index">
                                        <td data-ng-bind="comp.compat_code"></td>
                                        <td class="text-center" data-ng-bind="comp.category_name"></td>
                                        <td class="text-center" data-ng-bind="jsonParse(comp.compat_part)['en']"></td>
                                        <td class="text-center" data-ng-bind="comp.model_name"></td>
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

        <!-- start add new compatibiliy  Modal -->
        <div class="modal fade" id="compatibilityForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="/compatibilities/submit/">
                            @csrf
                            <input data-ng-if="updateComp !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="comp_id"
                                data-ng-value="updateComp !== false ? list[updateComp].compat_id : 0">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="NamEN">Name EN<b class="text-danger">&ast;</b></label>
                                        <input type="text" class="form-control" name="name_en" maxlength="24"
                                            id="NamEN"
                                            data-ng-value="updateComp !== false ? jsonParse(list[updateComp].compat_part)['en'] : ''">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="NamAR">Name AR</label>
                                        <input type="text" class="form-control" name="name_ar" id="NamAR"
                                            data-ng-value="updateComp !== false ? jsonParse(list[updateComp].compat_part)['ar'] : ''">
                                    </div>
                                </div>

                                <div class="text-center" style="margin-left:150px">
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="pills-cate-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-cate" type="button" role="tab"
                                                aria-controls="pills-cate" aria-selected="true">Categories</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-board-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-board" type="button" role="tab"
                                                aria-controls="pills-board" aria-selected="false">IC</button>
                                        </li>
                                    </ul>

                                </div>

                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-cate" role="tabpanel"
                                        aria-labelledby="pills-cate-tab">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="CategoryId">Categories</label>
                                                <select name="cate_id" class="form-control" id="CategoryId">
                                                    <option value="">-- SELECT CATEGORY NAME</option>
                                                    <option data-ng-repeat="category in categories"
                                                        data-ng-value="category.category_id"
                                                        data-ng-bind="category.category_name">
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="tab-pane fade" id="pills-board" role="tabpanel"
                                        aria-labelledby="pills-board-tab">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="motherId">Mother Boards</label>
                                                <select class="form-control select2" name="mother_board" id="motherId">
                                                    <option value="">SELECT MOTHER BOARD NAME</option>
                                                    @foreach ($mothers as $board)
                                                        <option value="{{ $board->board_id }}">
                                                            {{ $board->board_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="col-12">
                                    <h5 class="text-primary">Models</h5>
                                    <div ng-repeat="m in copmatsModels"></div>
                                </div> --}}
                                {{-- <hr>
                                <div class="col-12">
                                    <h5 class="text-primary text-center">Models</h5>
                                    <div class="mb-3 row" id="compModels">

                                    </div>
                                </div>
                                <hr> --}}
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="branID">Brands</label>
                                        <select class="form-control select2" id="branID">
                                            <option value="">SELECT BRAND NAME</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->brand_id }}">
                                                    {{ $brand->brand_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="modelId">Model</label>
                                        <select class="form-control select2" id="modelId">
                                            <option value="">-- SELECT MODEL NAME</option>
                                            <option data-ng-repeat="model in models" data-ng-value="model.model_id"
                                                data-ng-bind="model.model_name">
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                {{-- <div class="col-12">
                                    <div class="mb-3">
                                        <input type="search" name="brand" class="form-control"
                                            placeholder="secarch by brand name" id="brandId" >
                                    </div>
                                </div> --}}
                            </div>

                            <div class="row">
                                <p class="text-secondary" style="margin-bottom:-2px">Models<b
                                        class="text-danger">&ast;</b>
                                </p>
                                <div class="col-12">
                                    <div class="mb-3 row" id="models">

                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-outline-secondary me-auto"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-outline-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end add new compatibiliy  Modal -->

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
            $('#compatibilityForm form').on('submit', function(e) {
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
                    console.log(data)
                    if (response.status) {
                        toastr.success('Data processed successfully');
                        $('#compatibilityForm').modal('hide');
                        scope.$apply(() => {
                            if (scope.updateComp === false) {
                                scope.list.unshift(response.data);
                                scope.dataLoader(true);
                            } else {
                                scope.list[scope.updateComp] = response.data;
                                scope.dataLoader(true);
                            }
                        });
                    } else toastr.error(response.message);
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    // error msg
                }).always(function() {
                    spinner.hide();
                    controls.prop('disabled', false);
                });

            })

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
