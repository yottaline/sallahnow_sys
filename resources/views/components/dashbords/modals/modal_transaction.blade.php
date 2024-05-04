        <!-- start add new suggestion  Modal -->
        <div class="modal fade" id="tranForm" tabindex="-1" role="dialog" aria-labelledby="tranFormLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="/transactions/submit/">
                            @csrf
                            <input data-ng-if="updateTransactions !== false" type="hidden" name="_method"
                                value="put">
                            <input type="hidden" name="tran_id"
                                data-ng-value="updateTransactions !== false ? list[updateTransactions].trans_id : 0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="method">Method</label>
                                        <select name="method" class="form-control" id="method">
                                            <option value="">-- SELECT METHOD NAME --</option>
                                            </option>
                                            {{-- <option value="1">Gateway</option> --}}
                                            <option value="2">Cash</option>
                                            <option value="3">Wallet</option>
                                            {{-- <option value="4">Cobon</option> --}}
                                            {{-- <option value="5">Transfer</option> --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="mb-3">
                                        <label>Search Technician By code</label>
                                        <input type="search" class="form-control" name="search" id="search"
                                            data-ng-value="list[updateTransactions].tech_code">
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="mb-3">
                                        <label for="TechnicianName">Technician Name<b
                                                class="text-danger">&ast;</b></label>
                                        <select class="form-control" name="technician_id" id="TechnicianName">
                                            <option data-ng-if="updateTransactions !== false"
                                                data-ng-value="list[updateTransactions].tech_id"
                                                data-ng-bind="list[updateTransactions].tech_name">
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label>Amount<b class="text-danger">&ast;</b></label>
                                        <input id="amount" type="text" class="form-control" name="amount"
                                            data-ng-value="list[updateTransactions].trans_amount" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label>Process<b class="text-danger">&ast;</b></label>
                                        <select name="process" class="form-control" id="process">
                                            <option value="">-- SELECT PROCESS NAME --</option>
                                            <option value="1">Spend</option>
                                            <option value="2">Earn</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
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
            $('#tranForm form').on('submit', function(e) {
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
                        $('#tranForm').modal('hide');
                        scope.$apply(() => {
                            if (scope.updateTransactions === false) {
                                clerForm();
                                scope.list = response.data;
                                // scope.dataLoader(true);
                            } else {
                                scope.list[scope.updateTransactions] = response
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
        <!-- end add new suggestion  Modal -->


        <!-- start change process  Modal -->
        {{-- <div class="modal fade" id="changePerotus" tabindex="-1" role="dialog" aria-labelledby="changePerotusLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="/transactions/change/">
                            @csrf @method('PUT')
                            <input type="hidden" name="tran_id" data-ng-value="transactions[updateSubscription].id">
                            <p>Are you sure the subscription Process has changed?</p>
                            <div class="row">
                                <div class="d-flex">
                                    <button type="button" class="btn btn-outline-secondary me-auto"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-outline-primary">Sure</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}

        <script>
            $('#changePerotus form').on('submit', function(e) {
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
                        toastr.success('Status change successfully');
                        $('#changePerotus').modal('hide');
                        scope.$apply(() => {
                            if (scope.updateSubscription === false) {
                                // $scope.dataLoader(true);
                                scope.list.unshift(require.data)
                            } else {
                                scope.list[scope.updateSubscription] = response
                                    .data;
                                scope.list.unshift(require.data)
                                // $scope.dataLoader(true);
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
        <!-- end change process  Modal -->
