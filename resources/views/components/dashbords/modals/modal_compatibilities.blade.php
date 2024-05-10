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
                                <input type="text" class="form-control" name="name_en" maxlength="24" id="NamEN"
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
                        <p class="text-secondary" style="margin-bottom:-2px">Models<b class="text-danger">&ast;</b>
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
<script>
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
                        // scope.list.unshift(response.data);
                        scope.list = response.data;
                        clsForm();
                        // scope.dataLoader(true);
                    } else {
                        scope.list[scope.updateComp] = response.data;
                        // scope.dataLoader(true);
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

    function clsForm() {
        $('#NamEN').val('');
        $('#NamAR').val('');
    }
</script>
<!-- end add new compatibiliy  Modal -->
