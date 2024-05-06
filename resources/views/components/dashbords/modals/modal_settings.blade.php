<!-- start add new brand  Modal -->
<div class="modal fade" id="brandForm" tabindex="-1" role="dialog" aria-labelledby="brandFormLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form method="POST" action="/brands/submit/" enctype="multipart/form-data">
                    @csrf
                    <input data-ng-if="updateBrand !== false" type="hidden" name="_method" value="put">
                    <input type="hidden" name="brand_id" id="brandId"
                        data-ng-value="updateBrand !== false ? brands[updateBrand].brand_id : 0">
                    <div class="mb-3">
                        <label for="brandName">Brand Name<b class="text-danger">&ast;</b></label>
                        <input type="text" class="form-control" name="name" maxlength="120" required
                            data-ng-value="updateBrand !== false ? brands[updateBrand].brand_name : ''"
                            id="brandName" />
                    </div>
                    <div class="mb-3">
                        <label for="logoBrand">Logo<b class="text-danger">&ast;</b></label>
                        <input type="file" class="form-control" name="logo"
                            accept=".pdf,.jpg, .png, image/jpeg, image/png" data-height="70" required id="logoBrand" />
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

<script>
    $('#brandForm form').on('submit', function(e) {
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
                $('#brandForm').modal('hide');
                scope.$apply(() => {
                    if (scope.updateBrand === false) {
                        scope.brands = response.data;
                        brandClsForm()
                        // scope.loadBrandsData(true);
                    } else {
                        scope.brands[scope.updateBrand] = response.data;
                        // scope.loadBrandsData(true);
                    }
                });
            } else toastr.error("Error");
        }).fail(function(jqXHR, textStatus, errorThrown) {
            // error msg
        }).always(function() {
            spinner.hide();
            controls.prop('disabled', false);
        });
    });

    function brandClsForm() {
        $('#brandId').val('');
        $('#brandName').val('');
        $('#logoBrand').val('')
    };
</script>
<!-- end add new brand  Modal -->

<!-- start add new brand  Modal -->
<div class="modal fade" id="modelForm" tabindex="-1" role="dialog" aria-labelledby="modelFormLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form method="POST" action="/models/submit/" enctype="multipart/form-data">
                    @csrf
                    <input data-ng-if="updateModel !== false" type="hidden" name="_method" value="put">
                    <input type="hidden" name="model_id" id="modelId"
                        data-ng-value="updateModel !== false ? models[updateModel].model_id : 0">
                    <div class="mb-3">
                        <label for="Modelname">Model Name<b class="text-danger">&ast;</b></label>
                        <input type="text" class="form-control" name="name" maxlength="120" required
                            data-ng-value=" models[updateModel].model_name" id="Modelname" />
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="modelPhoto">Photo<b class="text-danger">&ast;</b></label>
                                <input type="file" class="form-control" name="photo"
                                    accept=".pdf,.jpg, .png, image/jpeg, image/png" required id="modelPhoto" />
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="ModleUrl">URL</label>
                                <input type="text" class="form-control" name="url" id="ModleUrl"
                                    data-ng-value="models[updateModel].model_url">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="ModelBrandName">Brand Name<b class="text-danger">&ast;</b></label>
                        <select name="brand" class="form-control" id="ModelBrandName">
                            <option value="">-- SELECT BRAND NAME --</option>
                            <option data-ng-repeat="brand in brands track by $index" data-ng-value="brand.brand_id"
                                data-ng-bind="brand.brand_name">
                            </option>

                        </select>
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
<script>
    $('#modelForm form').on('submit', function(e) {
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
                $('#modelForm').modal('hide');
                scope.$apply(() => {
                    if (scope.updateModel === false) {
                        scope.models = response.data;
                        modalsClsForm();
                        // scope.lodaModelsData(true);
                    } else {
                        scope.models[scope.updateModel] = response.data;
                        // scope.lodaModelsData(true);
                    }
                });
            } else toastr.error("Error");
        }).fail(function(jqXHR, textStatus, errorThrown) {
            // error msg
        }).always(function() {
            spinner.hide();
            controls.prop('disabled', false);
        });
    });

    function modalsClsForm() {
        $('#modelId').val('');
        $('#Modelname').val('');
        $('#modelPhoto').val('');
        $('#ModleUrl').val('');
    }
</script>
<!-- end add new brand  Modal -->


<!-- start add new compatibility_categories  Modal -->
<div class="modal fade" id="CompatibilityCategoriesForm" tabindex="-1" role="dialog"
    aria-labelledby="CompatibilityCategoriesFormLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form method="POST" action="/CompatibilityCategories/submit/"> @csrf
                    <input data-ng-if="updateCompCate !== false" type="hidden" name="_method" value="put">
                    <input type="hidden" name="cate_id" id="CateId"
                        data-ng-value="updateCompCate !== false ? compatibility_categories[updateCompCate].category_id : 0">
                    <div class="mb-3">
                        <label for="CompatibilityCategoriesName">Compatibility
                            Categories Name<b class="text-danger">&ast;</b></label>
                        <input type="text" class="form-control" name="name" maxlength="120" required
                            data-ng-value="updateCompCate !== false ? compatibility_categories[updateCompCate].category_name : ''"
                            id="CompatibilityCategoriesName" />
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
<script>
    $('#CompatibilityCategoriesForm form').on('submit', function(e) {
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
                $('#CompatibilityCategoriesForm').modal('hide');
                scope.$apply(() => {
                    if (scope.updateCompCate === false) {
                        // scope.compatibility_categories.unshift(response
                        //     .data);
                        scope.compatibility_categories = response
                            .data;
                        compaCategoyreClsForm()
                    } else {
                        scope.compatibility_categories[scope
                            .updateCompCate] = response.data;
                        compaCategoyreClsForm()
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

    function compaCategoyreClsForm() {
        $('#CateId').val('');
        $('#CompatibilityCategoriesName').val('');
    }
</script>
<!-- end add new compatibility_categories  Modal -->



<!-- start add new compatibility_motherboard  Modal -->
<div class="modal fade" id="CompatibilityMotherBoardForm" tabindex="-1" role="dialog"
    aria-labelledby="CompatibilityMotherBoardFormLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form method="POST" action="/compatibilityMotherBoard/submit/"> @csrf
                    <input data-ng-if="updateMotherBoard !== false" type="hidden" name="_method" value="put">
                    <input type="hidden" name="board_id" id="boardId"
                        data-ng-value="updateMotherBoard !== false ? compatibility_motherBoard[updateMotherBoard].board_id : 0">
                    <div class="mb-3">
                        <label for="motherBoardName">Compatibility
                            Mother Board Name<b class="text-danger">&ast;</b></label>
                        <input type="text" class="form-control" name="board_name" maxlength="120" required
                            data-ng-value="compatibility_motherBoard[updateMotherBoard].board_name"
                            id="motherBoardName" />
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
<script>
    $('#CompatibilityMotherBoardForm form').on('submit', function(e) {
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
                $('#CompatibilityMotherBoardForm').modal('hide');
                scope.$apply(() => {
                    if (scope.updateMotherBoard === false) {
                        // scope.compatibility_motherBoard.unshift(response
                        //     .data);
                        console.log(response.data)
                        scope.compatibility_motherBoard = response
                            .data
                        boardClsForm()
                    } else {
                        scope.compatibility_motherBoard[scope
                            .updateMotherBoard] = response.data;
                        // scope.loadMotherBoard(true);
                        boardClsForm()
                    }
                });
            } else toastr.error("Error");
        }).fail(function(jqXHR, textStatus, errorThrown) {
            // error msg
        }).always(function() {
            spinner.hide();
            controls.prop('disabled', false);
        });
    });

    function boardClsForm() {
        $('#boardId').val('');
        $('#motherBoardName').val('');
    };
</script>
<!-- end add new compatibility_motherboard  Modal -->


<!-- start add new package  Modal -->
<div class="modal fade" id="PackageForm" tabindex="-1" role="dialog" aria-labelledby="PackageFormLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form method="POST" action="/packages/submit/" enctype="multipart/form-data">
                    @csrf
                    <input data-ng-if="updatePackage !== false" type="hidden" name="_method" value="put">
                    <input type="hidden" name="package_id"
                        data-ng-value="updatePackage !== false ? packages[updatePackage].id : 0">
                    <div class="mb-3">
                        <label for="packageType">Type<b class="text-danger">&ast;</b></label>
                        <select name="type" class="form-control" id="packageType" required>
                            <option value=""> -- SELECT TYPE NAME --
                            </option>
                            <option value="1">Free</option>
                            <option value="2">Silver</option>
                            <option value="3">Gold</option>
                            <option value="4">Diamond</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="period">Period<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="period" required id="period"
                                    data-ng-value="updatePackage !== false ? packages[updatePackage].period : ''" />
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="cost">Cost</label>
                                <input type="text" class="form-control" name="cost" id="cost"
                                    data-ng-value="updatePackage !== false ? packages[updatePackage].cost : ''">
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="point">Points<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="point" id="point"
                                    data-ng-value="updatePackage !== false ? packages[updatePackage].points : ''">
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="priv">Priv<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="priv" id="priv"
                                    data-ng-value="updatePackage !== false ? packages[updatePackage].prive : ''">
                                </select>
                            </div>
                        </div>

                    </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#PackageForm form').on('submit', function(e) {
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
                $('#PackageForm').modal('hide');
                scope.$apply(() => {
                    if (scope.updatePackage === false) {
                        scope.packages.unshift(response.data);
                        scope.loadPackageData(true);
                    } else {
                        scope.packages[scope.updatePackage] = response
                            .data;
                        scope.loadPackageData(true);
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
</script>
<!-- end add new package  Modal -->
