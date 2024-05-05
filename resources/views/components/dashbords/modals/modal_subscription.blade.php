     <!-- start add new suggestion  Modal -->
     <div class="modal fade" id="subscriotionForm" tabindex="-1" role="dialog" aria-labelledby="subscriotionFormLabel">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-body">
                     <form method="POST" action="/subscriptions/submit/">
                         @csrf @method('POST')
                         <input data-ng-if="updateSubscription !== false" type="hidden" name="_method" value="put">
                         <input type="hidden" name="sub_id"
                             data-ng-value="updateSubscription !== false ? list[updateSubscription].sub_id : 0">
                         <div class="row">
                             <div class="col-12">
                                 <div class="mb-3">
                                     <label for="packageName">Package</label>
                                     <select name="package_id" class="form-control" id="packageName">
                                         <option value="">-- SELECT PACKAGE NAME</option>
                                         <option value="1">Free</option>
                                         <option value="2">Silver | 1 Month</option>
                                         <option value="3">Silver | 6 Month</option>
                                         <option value="4">Silver | 1 Year</option>
                                         <option value="5">Gold | 6 Month</option>
                                         <option value="6">Gold | 1 Year</option>
                                         <option value="7">Diamond | 1 Year</option>
                                     </select>
                                 </div>
                             </div>
                             <div class="col-12 col-md-12">
                                 <div class="mb-3">
                                     <input type="search" class="form-control" name="search"
                                         placeholder="Search Technician By code" id="search">
                                 </div>
                             </div>
                             <div class="col-12 col-md-12">
                                 <div class="mb-3">
                                     <label for="TechnicianName">Technician Name<b class="text-danger">&ast;</b></label>
                                     <select class="form-control" name="technician_name" id="TechnicianName"></select>
                                 </div>
                             </div>
                             <div class="col-12 col-md-6">
                                 <div class="mb-3">
                                     <label>Subscription Start<b class="text-danger">&ast;</b></label>
                                     <input id="subStart" type="text" class="form-control text-center"
                                         name="start" maxlength="10"
                                         data-ng-value="list[updateSubscription].sub_start" />
                                 </div>
                             </div>
                             <div class="col-12 col-md-6">
                                 <div class="mb-3">
                                     <label>Subscription End<b class="text-danger">&ast;</b></label>
                                     <input id="subEnd" type="text" class="form-control text-center"
                                         name="end" maxlength="10" data-ng-value="list[updateSubscription].sub_end">
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
         $('#subscriotionForm form').on('submit', function(e) {
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
                     $('#subscriotionForm').modal('hide');
                     scope.$apply(() => {
                         if (scope.updateSubscription === false) {
                             scope.list.unshift(response.data);
                             scope.dataLoader(true);
                         } else {
                             scope.list[scope.updateSubscription] = response
                                 .data;
                             scope.dataLoader(true);
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


     <!-- start change status  Modal -->
     <div class="modal fade" id="changeStatus" tabindex="-1" role="dialog" aria-labelledby="changeStatusLabel">
         <div class="modal-dialog modal-sm" role="document">
             <div class="modal-content">
                 <div class="modal-body">
                     <form method="POST" action="/subscriptions/change/">
                         @csrf @method('PUT')
                         <input type="hidden" name="sub_id" data-ng-value="list[updateSubscription].sub_id">
                         <p>Are you sure the subscription status has changed?</p>
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
     </div>

     <script>
         $('#changeStatus form').on('submit', function(e) {
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
                     $('#changeStatus').modal('hide');
                     scope.$apply(() => {
                         if (scope.updateSubscription === false) {
                             $cope.dataLoader(true);
                         } else {
                             scope.list[scope.updateSubscription] = response
                                 .data;
                             scope.dataLoader(true);
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
     <!-- end change status  Modal -->
