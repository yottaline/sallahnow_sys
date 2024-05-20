<div class="modal fade" id="categoryForm" tabindex="-1" role="dialog" aria-labelledby="categoryFormLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form method="POST" action="/markets/categories/submit">
                    @csrf
                    <input data-ng-if="updateCategory !== false" type="hidden" name="_method" value="put">
                    <input type="hidden" name="cate_id" id="CateId"
                        data-ng-value="list[updateCategory].category_id">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="categoriesName">
                                    Categiry Name AR<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="name_ar" required
                                    data-ng-value="jsonParse(list[updateCategory].category_name).ar"
                                    id="categoriesName" />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="categoriesName">
                                    Categiry Name EN<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="name_en" required
                                    data-ng-value="jsonParse(list[updateCategory].category_name).en"
                                    id="categoriesName" />
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
    $('#categoryForm form').on('submit', function(e) {
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
                $('#categoryForm').modal('hide');
                scope.$apply(() => {
                    if (scope.updateCategory === false) {
                        // scope.compatibility_categories.unshift(response
                        //     .data);
                        scope.list = response
                            .data;
                        scope.dataLoader();
                        // scope.
                        categoyreClsForm()
                    } else {
                        scope.list[scope
                            .updateCategory] = response.data;
                        categoyreClsForm()
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

    function categoyreClsForm() {
        $('#CateId').val('');
        $('#categoriesName').val('');
    }
</script>
