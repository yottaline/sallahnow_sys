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
                                <h1 style="font-size: 70px" class="text-center my-3"><i
                                        class="bi bi-person-circle text-secondary"></i></h1>
                                <h5 class="text-center text-secondary font-monospace small dir-ltr mb-3">Technician Code :
                                    <% technician.tech_code %></h5>
                                <h4 class="fw-bold text-center m-0 small  mb-2">Technician name : <% technician.tech_name %>
                                </h4>
                                <h4 class="fw-bold text-center m-0 small  mb-2">Technician email :
                                    <% technician.tech_email %>
                                </h4>
                                <h4 class="fw-bold text-center m-0 small  mb-2">Technician mobile :
                                    <% technician.tech_mobile %>
                                </h4>
                                <hr>
                            </div>

                            <div class="col-8" style="margin-top: 100px">
                                <div class="row">
                                    <div class="col-6">
                                        <h5 class="text-center text-secondary font-monospace small dir-ltr mb-3">Technician
                                            identification
                                            :
                                            <span class="text-dark"><% technician.tech_identification %></span>
                                        </h5>
                                        <h4 class="fw-bold text-center m-0 small  mb-3">Center name :
                                            <% technician.tech_center %>
                                        </h4>
                                        <h4 class="fw-bold text-center m-0 small  mb-3">Technician Telephone :
                                            <% technician.tech_tel %>
                                        </h4>
                                        <h4 class="fw-bold text-center m-0 small  mb-3">Technician Dirth Day :
                                            <% technician.tech_birth %>
                                        </h4>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="text-center text-secondary font-monospace small dir-ltr mb-3">Technician
                                            Point
                                            :
                                            <span class="text-dark"><% technician.tech_points %></span>
                                        </h5>
                                        <h4 class="fw-bold text-center m-0 small  mb-3">Technician Rate :
                                            {{-- <% technician.tech_rate %> --}}<i class="bi bi-star"></i> <i class="bi bi-star"></i>
                                        </h4>
                                        <h4 class="fw-bold text-center m-0 small  mb-3">Technician Package :
                                            <% technician.tech_pkg %>
                                        </h4>
                                        <h4 class="fw-bold text-center m-0 small  mb-3">Technician Country :
                                            {{-- <% technician.tech_country %> , <% technician.tech_state %>,
                                            <% technician.tech_city %> , <% technician.tech_area %> --}}
                                            <span class="text-secondary">Sudan, Khartoum, Khartoum , Riyadh</span>
                                        </h4>
                                    </div>
                                    <div class="col-12 mt-5">
                                        <h4 class="fw-bold text-center m-0 small  mb-2">Technician Address :
                                            <% technician.tech_address %>
                                        </h4>
                                        <h4 class="fw-bold text-center m-0 small  mb-2">Technician Bio :
                                            <% technician.tech_bio %>
                                        </h4>
                                        <h4 class="fw-bold text-center m-0 small  mb-2">Technician Note :
                                            <% technician.tech_notes %>
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
@endsection
@section('js')
    <script>
        var app = angular.module("myApp", [], function($interpolateProvider) {
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
        });

        app.controller("myCtrl", function($scope) {
            $scope.technician = <?= !empty($technician) ? json_encode($technician) : 'null' ?>;
            // $scope.techRate = {
            //     ''
            // }
        });
    </script>
@endsection
