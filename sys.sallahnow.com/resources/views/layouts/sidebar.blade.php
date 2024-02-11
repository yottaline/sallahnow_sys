 <div class="offcanvas offcanvas-start" tabindex="-1" id="navOffcanvas">
     <script>
         const navTarget = 'target';
         $(function() {
             $(`.nav-${navTarget} b`).addClass('text-danger');
         });
     </script>
     <div class="offcanvas-body">
         <ul class="list-group list-group-flush">
             <li class="list-group-item nav-dashboard">
                 <a class="link-dark d-block" href="{{ route('dashboard') }}">
                     <i class="bi bi-speedometer text-secondary me-2"></i><b>Dashboard</b>
                 </a>
             </li>
             {{-- <li class="list-group-item nav-customers">
                 <a class="link-dark d-block" href="#">
                     <i class="bi bi-people text-secondary me-2"></i><b>Customers</b>
                 </a>
             </li> --}}

             <li class="list-group-item nav-news">
                 <a class="link-dark d-block" href="{{ route('technician_index') }}">
                     <i class="bi bi-tools text-secondary me-2"></i><b>Technicians</b>
                 </a>
             </li>

             {{-- <li class="list-group-item nav-articles">
                 <a class="link-dark d-block" href="">
                     <i class="bi bi-file-earmark-richtext text-secondary me-2"></i><b>Articles</b>
                 </a>
             </li> --}}

             {{-- <li class="list-group-item nav-news">
                 <a class="link-dark d-block" href="">
                     <i class="bi bi-newspaper text-secondary me-2"></i><b>News</b>
                 </a>
             </li> --}}

             <li class="list-group-item nav-news">
                 <a class="link-dark d-block" href="{{ route('role_index') }}">
                     <i class="bi bi-person-bounding-box text-secondary me-2"></i><b>Roles</b>
                 </a>
             </li>

             <li class="list-group-item nav-news">
                 <a class="link-dark d-block" href="{{ route('permission_index') }}">
                     <i class="bi bi-ui-checks text-secondary me-2"></i><b>Permissions</b>
                 </a>
             </li>

             {{-- <li class="list-group-item nav-pages">
                 <a class="link-dark d-block" href="">
                     <i class="bi bi-file-earmark text-secondary me-2"></i><b>Web Pages</b>
                 </a>
             </li> --}}

             {{-- <li class="list-group-item">
                 <a class="link-dark d-block" data-bs-toggle="collapse" href="#paymentsCollapse" role="button"
                     aria-expanded="false" aria-controls="paymentsCollapse">
                     <i class="bi bi-wallet2 text-secondary me-2"></i><b>Finance</b>
                 </a>
                 <div class="collapse" id="paymentsCollapse">
                     <ul class="list-group list-group-flush">
                         <li class="list-group-item nav-subsc">
                             <a class="link-dark d-block" href="#">
                                 <i class="bi bi-cart-check text-secondary me-2"></i><b>Subscriptions</b>
                             </a>
                         </li>

                         <li class="list-group-item nav-trans">
                             <a class="link-dark d-block" href="#">
                                 <i class="bi bi-credit-card text-secondary me-2"></i><b>Transactions</b>
                             </a>
                         </li>

                         <li class="list-group-item nav-refunds">
                             <a class="link-dark d-block" href="">
                                 <i class="bi bi-arrow-left-right text-secondary me-2"></i><b>Refund Requests</b>
                             </a>
                         </li>

                         <li class="list-group-item nav-promos">
                             <a class="link-dark d-block" href="#">
                                 <i class="bi bi-ticket-perforated text-secondary me-2"></i><b>Promocodes</b>
                             </a>
                         </li>
                     </ul>
                 </div>
                 <script>
                     const paymentsCollapse = new bootstrap.Collapse('#paymentsCollapse', {
                         toggle: false
                     });
                     if (['subsc', 'trans', 'refunds', 'promos'].includes(navTarget))
                         paymentsCollapse.show();
                 </script>
             </li> --}}

             <li class="list-group-item nav-users">
                 <a class="link-dark d-block" href="{{ route('users') }}">
                     <i class="bi bi-fingerprint text-secondary me-2"></i><b>Users</b>
                 </a>
             </li>

             {{-- <li class="list-group-item nav-support">
                 <a class="link-dark d-block" href="">
                     <i class="bi bi-question-circle text-secondary me-2"></i><b>Help Disk</b>
                 </a>
             </li> --}}

             {{-- <li class="list-group-item">
                 <a class="link-dark d-block" data-bs-toggle="collapse" href="#reportsCollapse" role="button"
                     aria-expanded="false" aria-controls="reportsCollapse">
                     <i class="bi bi-receipt-cutoff text-secondary me-2"></i><b>Reports</b>
                 </a>
                 <div class="collapse" id="reportsCollapse">
                     <ul class="list-group list-group-flush">
                         <li class="list-group-item nav-rep-students">
                             <a class="link-dark d-block" href="#">
                                 <i class="bi bi-people text-secondary me-2"></i><b>Customers</b>
                             </a>
                         </li>

                         <li class="list-group-item nav-rep-subsc">
                             <a class="link-dark d-block" href="#">
                                 <i class="bi bi-cart-check text-secondary me-2"></i><b>Subscriptions</b>
                             </a>
                         </li>

                         <li class="list-group-item nav-rep-trans">
                             <a class="link-dark d-block" href="#">
                                 <i class="bi bi-credit-card text-secondary me-2"></i><b>Transactions</b>
                             </a>
                         </li>
                     </ul>
                 </div>
                 <script>
                     const reportsCollapse = new bootstrap.Collapse('#reportsCollapse', {
                         toggle: false
                     });
                     if (['rep-customers', 'rep-trans', 'rep-subsc'].includes(navTarget))
                         reportsCollapse.show();
                 </script>
             </li> --}}

             <li class="list-group-item nav-support">
                 <a class="link-dark d-block" href="{{ route('setting_index') }}">
                     <i class="bi bi-gear text-secondary me-2"></i><b>Settings</b>
                 </a>
             </li>

             {{-- <li class="list-group-item nav-help">
                 <a class="link-dark d-block" href="#">
                     <i class="bi bi-info-lg text-secondary me-2"></i><b>Help</b>
                 </a>
             </li> --}}
         </ul>
     </div>
     <div class="d-flex">
         <a href="{{ route('profile.edit') }}" class="d-block p-3 flex-grow-1 border-top rounded-0 link-dark">
             <i class="bi bi-person-circle text-warning me-2"></i>
             <b>{{ auth()->user()->name }}</b>
         </a>
         <form action="{{ route('logout') }}" method="post" class="d-block p-2 border-top border-start rounded-0">
             @csrf
             <button type="submit" class="btn btn-outline-primary"><i class="bi bi-power text-danger"></i></button>
         </form>
     </div>
 </div>
