<div class="modal fade" id="centerForm" tabindex="-1" role="dialog" aria-labelledby="centerFormLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form id="cenForm" method="post" action="/supports/submit" enctype="multipart/form-data">
                    @csrf
                    <input data-ng-if="cateUpdate !== false" type="hidden" name="_method" value="put">
                    <input type="hidden" name="cate_id" data-ng-value="list[cateUpdate].category_id">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="NameEN">Category Name EN<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="name_en"
                                    data-ng-value="jsonParse(list[cateUpdate].category_name)['en']" id="NameEN">
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="NameAR">Category Name AR<b class="text-danger">&ast;</b></label>
                                <input type="text" class="form-control" name="name_ar"
                                    data-ng-value="jsonParse(list[cateUpdate].category_name)['ar']" id="NameAR">
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="costCate">Cost <b class="text-danger">&ast;</b></label>
                            <input type="text" class="form-control" name="cost" required id="costCate"
                                data-ng-value="categories !== false ? list[cateUpdate].category_cost : 0" />
                        </div>
                    </div>

                    <div class="d-flex">
                        <button type="button" class="btn btn-outline-secondary me-auto btn-sm"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
                    </div>
                </form>
                <script>
                    $('#cenForm').on('submit', e => e.preventDefault()).validate({
                        rules: {
                            name_en: {
                                required: true
                            },
                            name_ar: {
                                required: true
                            }
                        },
                        submitHandler: function(form) {
                            console.log(form);
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
                                    $('#centerForm').modal('hide');
                                    scope.$apply(() => {
                                        if (scope.cateUpdate === false) {
                                            scope.list = response.data;
                                            // scope.list = unshift(response.data);
                                            // scope.dataLoader(true);
                                        } else {
                                            scope.list[scope.cateUpdate] = response.data;
                                            // scope.dataLoader();
                                        }
                                    });
                                } else toastr.error(response.message);
                            }).fail(function(jqXHR, textStatus, errorThrown) {
                                toastr.error("error");
                            }).always(function() {
                                $(form).find('button').prop('disabled', false);
                            });
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add_cost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form method="POST" action="/supports/update-cost">
                    @csrf
                    <input data-ng-if="cateUpdate !== false" type="hidden" name="_method" value="put">
                    <input type="hidden" name="cate_id"
                        data-ng-value="categories !== false ? list[cateUpdate].category_id : 0">
                    <div class="mb-3">
                        <label for="costCate">Cost <b class="text-danger">&ast;</b></label>
                        <input type="text" class="form-control" name="cost" required id="costCate"
                            data-ng-value="categories !== false ? list[cateUpdate].category_cost : 0" />
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
    $('#add_cost form').on('submit', function(e) {
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
                toastr.success('Category Update cost successfully');
                $('#add_cost').modal('hide');
                scope.$apply(() => {
                    if (scope.cateUpdate === false) {
                        scope.list.unshift(response.data)
                        // scope.dataLoader(true);
                    } else {
                        scope.list[scope.cateUpdate] = response
                            .data;
                        // scope.dataLoader(true);
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
