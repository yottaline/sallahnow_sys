@extends('index')
@section('title')
    Technician profile
@endsection
@section('content')
    <div class="container-fluid" data-ng-app="myApp" data-ng-controller="myCtrl">
        <div class="row">
            <div class="col-12">
                <div class="card card-box">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="card card-box" style="border-right:2px solid rgb(152, 152, 152); height: 500px;">
                                    <div class="card-body">
                                        <form id="notForm" action="/technicians/add_note/" method="post">
                                            @csrf
                                            <input type="text" hidden name="tech_id" ng-value="technician.tech_id">
                                            <div class="mb-3">
                                                <label for="noteTehnc">Note<b class="text-danger">&ast;</b></label>
                                                <textarea name="note" id="noteTehnc" cols="30" class="form-control" rows="10"><% technician.tech_notes %></textarea>
                                            </div>
                                            <div class="text-end">
                                                <button type="submit"
                                                    class="btn btn-outline-primary btn-sm px-4">Submit</button>
                                            </div>
                                        </form>
                                        <script>
                                            $('#notForm').on('submit', e => e.preventDefault()).validate({
                                                rules: {
                                                    note: {
                                                        required: true
                                                    }
                                                },
                                                submitHandler: function(form) {
                                                    var formData = new FormData(form),
                                                        action = $(form).attr('action'),
                                                        method = $(form).attr('method');

                                                    $(form).find('button').prop('disabled', true);
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
                                                            $('#techModal').modal('hide');
                                                            scope.$apply(() => {
                                                                if (scope.technician === false) {
                                                                    scope.technician = response.data

                                                                } else {
                                                                    scope.technician = response.data;
                                                                    scope.dataLoader();
                                                                }
                                                            });
                                                        } else toastr.error(response.message);
                                                    }).fail(function(jqXHR, textStatus, errorThrown) {
                                                        // console.log()
                                                        toastr.error(jqXHR.responseJSON.message);
                                                        // $('#techModal').modal('hide');
                                                    }).always(function() {
                                                        $(form).find('button').prop('disabled', false);
                                                    });
                                                }
                                            });

                                            $(function() {
                                                $("#inputBirthdate").datetimepicker($.extend({}, dtp_opt, {
                                                    showTodayButton: false,
                                                    format: "YYYY-MM-DD",
                                                }));
                                            });
                                        </script>
                                    </div>
                                </div>

                            </div>

                            <div class="col-8">
                                <div class="row">
                                    <div class="col-12">
                                        <div>
                                            <div>
                                                <h1 style="font-size: 70px" class="text-center my-3"><i
                                                        class="bi bi-person-circle text-secondary"></i></h1>
                                                <h5 class="text-center text-secondary font-monospace small dir-ltr mb-3">
                                                    Technician Code
                                                    :
                                                    <% technician.tech_code %></h5>
                                                <h4 class="fw-bold text-center m-0 small  mb-2">Technician name :
                                                    <% technician.tech_name %>
                                                </h4>
                                                <h4 class="fw-bold text-center m-0 small  mb-2">Technician email :
                                                    <% technician.tech_email %>
                                                </h4>
                                                <h4 class="fw-bold text-center m-0 small  mb-2">Technician mobile :
                                                    <% technician.tech_mobile %>
                                                </h4>
                                                <h5 class="text-center text-secondary font-monospace small dir-ltr mb-3">
                                                    Technician
                                                    identification
                                                    :
                                                    <span class="text-dark"><% technician.tech_identification %></span>
                                                </h5>
                                            </div>
                                            <div class="row m-5">
                                                <div class="col-6" style="padding-left:160px">

                                                    <h4 class="fw-bold  m-0 small  mb-3 ">Center name
                                                        :
                                                        <span class=""> <% technician.tech_center %></span>
                                                    </h4>
                                                    <h4 class="fw-bold  m-0 small  mb-3">Technician Telephone :
                                                        <span class="text-left"> <% technician.tech_tel %></span>
                                                    </h4>
                                                    <h4 class="fw-bold  m-0 small  mb-3">Technician Dirth Day :
                                                        <% technician.tech_birth %>
                                                    </h4>
                                                    <h4 class="fw-boldr m-0 small  mb-2">Technician Bio :
                                                        <% technician.tech_bio %>
                                                    </h4>

                                                </div>
                                                <div class="col-6" style="padding-left:160px">

                                                    <h5 class=" text-secondary font-monospace small dir-ltr">
                                                        Technician
                                                        Point
                                                        :
                                                        <span class="text-dark"><% technician.tech_points %></span>
                                                    </h5>
                                                    <h4 class="fw-bold  m-0 small  mb-3">Technician Rate :
                                                        {{-- <% technician.tech_rate %> --}}<i class="bi bi-star"></i> <i
                                                            class="bi bi-star"></i>
                                                    </h4>
                                                    <h4 class="fw-bold  m-0 small  mb-3">Technician Package :
                                                        <% technician.tech_pkg %>
                                                    </h4>
                                                    <h4 class="fw-bold  m-0 small  mb-2">Technician Address :
                                                        <% technician.tech_address %>
                                                    </h4>
                                                    <h4 class="fw-bold  m-0 small  mb-3">Technician Country :

                                                        <span class="text-secondary">
                                                            <%jsonParse(country.location_name)['en']  %> ,
                                                            <%jsonParse(state.location_name)['en'] %>,
                                                            <% jsonParse(city.location_name)['en'] %> ,
                                                            <% jsonParse(area.location_name)['en'] %></span>
                                                    </h4>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

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
        var app = angular.module("myApp", [], function($interpolateProvider) {
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
        });

        app.controller("myCtrl", function($scope) {
            $scope.jsonParse = str => JSON.parse(str);
            $scope.technician = <?= !empty($technician) ? json_encode($technician) : 'null' ?>;
            $scope.country = <?= !empty($country) ? json_encode($country) : 'null' ?>;
            $scope.state = <?= !empty($state) ? json_encode($state) : 'null' ?>;
            $scope.city = <?= !empty($city) ? json_encode($city) : 'null' ?>;
            $scope.area = <?= !empty($area) ? json_encode($area) : 'null' ?>;
            // $scope.techRate = {
            //     ''
            // }
        });
    </script>
@endsection
