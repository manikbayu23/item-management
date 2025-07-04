 <!-- Main navbar -->
 <div class="navbar navbar-dark bg-primary navbar-expand-lg navbar-slide-top fixed-top px-lg-0">
     <div class="container-fluid container-boxed jusitfy-content-start">
         <div class="navbar-brand flex-1 flex-lg-0">
             <a href="/" class="d-inline-flex align-items-center">
                 <img src="{{ asset(path: 'assets/img/panca-mahottama2.png') }}" class=" h-32px ms-2 rounded-circle"
                     alt="">
             </a>
         </div>

         <ul class="nav order-3 ms-lg-2">
             <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                 <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1"
                     data-bs-toggle="dropdown">
                     <div class="status-indicator-container">
                         <img src="{{ asset('assets/img/user.png') }}" class="w-32px h-32px rounded-pill"
                             alt="foto">
                         <span class="status-indicator bg-success"></span>
                     </div>
                     <span class="d-none d-lg-inline-block mx-lg-2">{{ Auth::user()->name }}</span>
                 </a>

                 <div class="dropdown-menu dropdown-menu-end">
                     @if (Auth::user()->role !== 'user')
                         <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                             <i class="ph-arrow-square-out me-2"></i>
                             Halaman Admin
                         </a>
                         <div class="dropdown-divider"></div>
                     @endif
                     <form action="{{ route('logout') }}" method="POST">
                         @csrf
                         <button type="submit" class="dropdown-item">
                             <i class="ph-sign-out me-2"></i>
                             Logout
                         </button>
                     </form>
                 </div>
             </li>
         </ul>
     </div>
 </div>
 <!-- /main navbar -->
