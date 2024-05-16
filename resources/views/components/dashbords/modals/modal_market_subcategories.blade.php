<div class="modal fade" id="subCategoryForm" tabindex="-1" role="dialog" aria-labelledby="subCategoryFormLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form method="POST" action="/markets/subcategories/submit">
                    @csrf
                    <input data-ng-if="updateSubCategory !== false" type="hidden" name="_method" value="put">
                    <input type="hidden" name="subcate_id" id="subcateId"
                        data-ng-value="list[updateSubCategory].subcategory_id">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="subcategoryName">
                                    Subcategiry Name AR<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="name_ar" required
                                    data-ng-value="jsonParse(list[updateSubCategory].subcategory_name).ar"
                                    id="subcategoryName" />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="subcategoryName">
                                    Subcategiry Name EN<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="name_en" required
                                    data-ng-value="jsonParse(list[updateSubCategory].subcategory_name).en"
                                    id="subcategoryName" />
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label>Categories<b class="text-danger">&ast;</b></label>
                                <select name="category" id="category" class="form-select" required>
                                    <option value="default">-- SELECT CATEGORY NAME --</option>
                                    <option data-ng-repeat="category in categories" data-ng-value="category.category_id"
                                        data-ng-bind="jsonParse(category.category_name).en +' / ' + jsonParse(category.category_name).ar">
                                    </option>
                                </select>
                            </div>
                        </div>
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
    $('#subCategoryForm form').on('submit', function(e) {
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
                $('#subCategoryForm').modal('hide');
                scope.$apply(() => {
                    if (scope.updateSubCategory === false) {
                        scope.list.unshift(response
                            .data);
                        // scope.list = response
                        //     .data;
                        scope.dataLoader();
                        subcategoyreClsForm()
                    } else {
                        scope.list[scope
                            .updateSubCategory] = response.data;
                        subcategoyreClsForm()
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

    function subcategoyreClsForm() {
        $('#subcateId').val('');
        $('#subcategoryName').val('');
    }
</script>
