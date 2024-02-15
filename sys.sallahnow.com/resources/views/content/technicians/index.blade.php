@extends('index')
@section('title')
    Technician
@endsection
@section('search')
    <form id="searchForm" role="search">
        <input type="search" name="q" class="form-control my-3 my-md-0 rounded-pill" placeholder="Search...">
    </form>
@endsection
@section('content')
      
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
    <script src="{{ asset('/assets/js/jquery_validator/extend.js?v=1.1.0') }}"></script>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        toastr.options.closeButton = true;
        toastr.options.progressBar = true;
        toastr.options.positionClass = "toast-bottom-left";
        toastr.options.timeOut = 5000;
        toastr.options.preventDuplicates = true;
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <link rel='stylesheet'
        href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css'>
    <script
        src='https://cdnjs.cloudflare.com/ajax/libs/eonasdan-bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js'>
    </script>
    <script>
        const dtp_opt = {
            icons: {
                time: 'bi bi-clock',
                date: 'bi bi-calendar',
                up: 'bi bi-chevron-up',
                down: 'bi bi-chevron-down',
                previous: 'bi bi-chevron-left',
                next: 'bi bi-chevron-right',
                today: 'bi bi-calendar2-event',
                clear: 'bi bi-eraser',
                close: 'bi bi-x'
            },
            format: "YYYY-MM-DD",
        };
    </script>
    <div class="container-fluid" data-ng-app="myApp" data-ng-controller="myCtrl">
        <div class="row">
            <div class="col-12 col-sm-4 col-lg-3">
                <div class="card card-box">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="roleFilter">Package</label>
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
                            <h5 class="card-title fw-semibold pt-1 me-auto mb-3 text-uppercase">
                                <span class="loading-spinner spinner-border spinner-border-sm text-warning me-2"
                                    role="status"></span><span>Technicians</span>
                            </h5>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-circle bi bi-plus-lg"
                                    data-ng-click="setUser(false)"></button>
                                <button type="button" class="btn btn-outline-dark btn-circle bi bi-arrow-repeat"
                                    data-ng-click="dataLoader(true)"></button>
                            </div>
                        </div>

                        <h5 data-ng-if="q" class="text-dark">Result of <span class="text-primary" data-ng-bind="q"></span>
                        </h5>

                        <div data-ng-if="technicians.length" class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Technician</th>
                                        <th class="text-center">Package</th>
                                        <th class="text-center">Register</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-repeat="technician in technicians track by $index">
                                        <td data-ng-bind="technician.code"
                                            class="text-center small font-monospace text-uppercase"></td>
                                        <td>
                                            <span data-ng-bind="technician.name" class="fw-bold"></span><br>
                                            <small data-ng-if="+technician.mobile"
                                                class="me-1 db-inline-block dir-ltr font-monospace badge bg-primary">
                                                <i class="bi bi-phone me-1"></i>
                                                <span data-ng-bind="technician.mobile" class="fw-normal"></span>
                                            </small>
                                            <small data-ng-if="+technician.tel"
                                                class="me-1 db-inline-block dir-ltr font-monospace badge bg-primary">
                                                <i class="bi bi-telephone me-1"></i>
                                                <span data-ng-bind="technician.tel" class="fw-normal"></span>
                                            </small>
                                            <small data-ng-if="+technician.email"
                                                class="db-inline-block dir-ltr font-monospace badge bg-primary">
                                                <i class="bi bi-envelope-at me-1"></i>
                                                <span data-ng-bind="technician.email" class="fw-normal"></span>
                                            </small>
                                        </td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <td class="col-fit">
                                            <a class="btn btn-outline-dark btn-circle bi bi-link-45deg"
                                                href="/technicians/profile/<% technician.code %>" target="_blank"></a>
                                            <button class="btn btn-outline-primary btn-circle bi bi-pencil-square"
                                                data-ng-click="setUser($index)"></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div data-ng-if="!technicians.length" class="text-center text-secondary py-5">
                            <i class="bi bi-tools display-3"></i>
                            <h5 class="">No records</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="techModal" tabindex="-1" role="dialog" aria-labelledby="techModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="techForm" method="post" action="/technicians/submit">
                            @csrf
                            <input data-ng-if="updateTechnician !== false" type="hidden" name="_method" value="put">
                            <input type="hidden" name="technician_id" data-ng-value="technicians[updateTechnician].id">
                            <div class="row">
                                {{-- name --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Full Name<b class="text-danger">&ast;</b></label>
                                        <input type="text" class="form-control" name="name" maxlength="120"
                                            data-ng-value="technicians[updateTechnician].name" required>
                                    </div>
                                </div>
                                {{-- identification --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Identification</label>
                                        <input class="form-control" name="identification" type="text"
                                            data-ng-bind="technicians[updateTechnician].identification">
                                    </div>
                                </div>

                                {{-- mobile --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Mobile<b class="text-danger">&ast;</b></label>
                                        <input type="text" class="form-control" name="mobile" maxlength="24"
                                            data-ng-value="technicians[updateTechnician].mobile" required>
                                    </div>
                                </div>
                                {{-- email --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="email" class="form-control" name="email"
                                            id="exampleInputEmail1"
                                            data-ng-value="updateTechnician !== false ? technicians[updateTechnician].email : ''">
                                    </div>
                                </div>

                                {{-- phone --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1">Phone</label>
                                        <input type="text" class="form-control" name="tel" maxlength="24"
                                            data-ng-value="technicians[updateTechnician].tel">
                                    </div>
                                </div>
                                {{-- birthday --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Birthday<b class="text-danger">&ast;</b></label>
                                        <input id="inputBirthdate" type="text" class="form-control text-center"
                                            name="birth" maxlength="10"
                                            data-ng-value="technicians[updateTechnician].mobile">
                                    </div>
                                </div>

                                {{-- country --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Country<b class="text-danger">&ast;</b></label>
                                        <select name="country_id" class="form-control" required>
                                            <option value="">-- select country --</option>
                                            <option value="1">sudan</option>
                                            <option value="2">Egypt</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- state --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">State<b class="text-danger">&ast;</b></label>
                                        <select name="state_id" class="form-control" required>
                                            <option value="">-- select state --</option>
                                            <option value="1">Khartoum</option>
                                            <option value="2">Cairo</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- city --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">City<b class="text-danger">&ast;</b></label>
                                        <select name="city_id" class="form-control" required>
                                            <option value="">-- select city --</option>
                                            <option value="1">Khartoum</option>
                                            <option value="2">Cairo</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- area --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Arae<b class="text-danger">&ast;</b></label>
                                        <select name="area_id" class="form-control" required>
                                            <option value="">-- select area --</option>
                                            <option value="1">Khartoum, Omdurman</option>
                                            <option value="2">Cairo, Maadi</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- address --}}
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Address</label>
                                        <input type="text" class="form-control" name="address"
                                            data-ng-value="updateTechnician !== false ? technicians[updateTechnician].address : ''" />
                                    </div>
                                </div>

                                {{-- note --}}
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1">Notes</label>
                                        <textarea class="form-control" name="notes" rows="3"
                                            data-ng-bind="updateTechnician !== false ? technicians[updateTechnician].notes : ''"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex">
                                <button type="button" class="btn btn-outline-secondary me-auto btn-sm"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
                            </div>
                        </form>
                        <script>
                            $('#techForm').on('submit', e => e.preventDefault()).validate({
                                rules: {
                                    identification: {
                                        digits: true
                                    },
                                    tel: {
                                        digits: true
                                    },
                                    mobile: {
                                        digits: true
                                    },
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
                                                if (updateTechnician === false) {
                                                    scope.technicians.unshift(response.data);
                                                } else {
                                                    scope.technicians[updateTechnician] = response.data;
                                                }
                                            });
                                        } else toastr.error("Error");
                                    }).fail(function(jqXHR, textStatus, errorThrown) {
                                        toastr.error("Error");
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
        </div>

        <div class="modal fade" id="show_technician" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="mb-3">
                            <p>Full Name : <span data-ng-bind="showTechnician.name"></span></p>
                        </div>
                        <div class="mb-3">
                            <p>Mobile : <span data-ng-bind="showTechnician.mobile"></span></p>
                        </div>
                        <div class="mb-3">
                            <p>Birth Day : <span data-ng-bind="showTechnician.birth"></span></p>
                        </div>
                        <div class="mb-3">
                            <p>Address : <span data-ng-bind="showTechnician.address"></span></p>
                        </div>
                        <div class="mb-3">
                            <p>Rate : <span data-ng-bind="showTechnician.rate"></span></p>
                        </div>
                        <div class="mb-3">
                            <p>Points: <span data-ng-bind="showTechnician.points"></span></p>
                        </div>
                        <div class="mb-3">
                            <p>Identification : <span data-ng-bind="showTechnician.identification"></span></p>
                        </div>
                        <div class="mb-3">
                            <p>Bio : <span data-ng-bind="showTechnician.bio"></span></p>
                        </div>
                        <div class="mb-3">
                            <p>Notes : <span data-ng-bind="showTechnician.notes"></span></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger text-center"
                                data-bs-dismiss="modal">Close</button>
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
                $scope.q = '';
                $scope.updateTechnician = false;
                $scope.technicianId = 0;
                $scope.technicians = [];
                $scope.showTechnician = [];
                $scope.page = 1;
                $scope.dataLoader = function(reload = false) {
                    $('.loading-spinner').show();
                    if (reload) {
                        $scope.page = 1;
                    }
                    $.post("/technicians/load", {
                        q: $scope.q,
                        page: $scope.page,
                        limit: 24,
                        _token: '{{ csrf_token() }}'
                    }, function(data) {
                        $('.loading-spinner').hide();
                        $scope.$apply(() => {
                            $scope.technicians = data;
                            $scope.page++;
                        });
                    }, 'json');
                }
                $scope.setUser = (indx) => {
                    $scope.updateTechnician = indx;
                    $('#techModal').modal('show');
                };
                $scope.editActive = (index) => {
                    $scope.technicianId = index;
                    $('#edit_active').modal('show');
                };
                $scope.showTechnician = (technician) => {
                    $scope.showTechnician = technician;
                    $('#show_technician').modal('show');
                }
                $scope.addNote = (index) => {
                    $scope.technicianId = index;
                    $('#add_note_technician').modal('show');
                }
                $scope.deleteTechnician = (index) => {
                    $scope.userId = index;
                    $('#delete_technician').modal('show');
                };
                $scope.dataLoader();
                scope = $scope;
            });

            $(function() {
                $('#searchForm').on('submit', function(e) {
                    e.preventDefault();
                    scope.$apply(() => scope.q = $(this).find('input').val());
                    scope.dataLoader(true);
                });
            });
        </script>
    @endsection
