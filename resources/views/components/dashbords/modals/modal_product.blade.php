{{-- edit status of product --}}
<div class="modal fade modal-sm" id="edit_active" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form method="POST" action="/markets/products/change_status">
                    @csrf @method('PUT')
                    <input hidden data-ng-value="list[updateProduct].product_id" name="product_id">
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" name="status" value="1"
                                ng-checked="+list[updateProduct].product_show" id="productsStatus">
                            <label class="form-check-label" for="productsStatus">Change status</label>
                        </div>
                    </div>
                    <div class="d-flex mt-3">
                        <button type="button" class="btn btn-outline-secondary me-auto"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success">change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $("#edit_active form").on("submit", function(e) {
        e.preventDefault();
        var form = $(this),
            formData = new FormData(this),
            action = form.attr("action"),
            method = form.attr("method"),
            controls = form.find("button, input"),
            spinner = $("#locationModal .loading-spinner");
        spinner.show();
        controls.prop("disabled", true);
        $.ajax({
                url: action,
                type: method,
                data: formData,
                processData: false,
                contentType: false,
            })
            .done(function(data, textStatus, jqXHR) {
                var response = JSON.parse(data);
                if (response.status) {
                    toastr.success("product status change successfully");
                    $("#edit_active").modal("hide");
                    scope.$apply(() => {
                        if (scope.updateProduct === false) {
                            // scope.list.unshift(response.data);
                            scope.list = response.data;
                            scope.dataLoader();
                        } else {
                            scope.list[scope.updateProduct] = response.data;
                            scope.dataLoader();
                        }
                    });
                } else toastr.error(response.message);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                toastr.error(response.message);
                controls.log(jqXHR.responseJSON.message);
                $("#useForm").modal("hide");
            })
            .always(function() {
                spinner.hide();
                controls.prop("disabled", false);
            });
    });
</script>

{{-- delete product --}}
<div class="modal fade modal-sm" id="delete_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form method="POST" action="/markets/products/delete">
                    @csrf @method('PUT')
                    <input hidden data-ng-value="list[updateProduct].product_id" name="id">
                    <p class="mb-2">Are you sure you want to delete the product ?</p>
                    <div class="d-flex mt-3">
                        <button type="button" class="btn btn-outline-secondary me-auto"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success">Sure</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $("#delete_product form").on("submit", function(e) {
        e.preventDefault();
        var form = $(this),
            formData = new FormData(this),
            action = form.attr("action"),
            method = form.attr("method"),
            controls = form.find("button, input"),
            spinner = $("#locationModal .loading-spinner");
        spinner.show();
        controls.prop("disabled", true);
        $.ajax({
                url: action,
                type: method,
                data: formData,
                processData: false,
                contentType: false,
            })
            .done(function(data, textStatus, jqXHR) {
                var response = JSON.parse(data);
                if (response.status) {
                    toastr.success("product delete successfully");
                    $("#delete_product").modal("hide");
                    scope.$apply(() => {
                        if (scope.updateProduct === false) {
                            scope.list.unshift(response.data);
                            // scope.dataLoader(true);
                        } else {
                            scope.list[scope.updateProduct] = response.data;
                            // scope.dataLoader(true);
                        }
                    });
                } else toastr.error(response.message);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                toastr.error(response.message);
                controls.log(jqXHR.responseJSON.message);
                $("#useForm").modal("hide");
            })
            .always(function() {
                spinner.hide();
                controls.prop("disabled", false);
            });
    });
</script>
