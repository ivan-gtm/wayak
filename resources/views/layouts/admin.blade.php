<!-- https://coderthemes.com/hyper/ -->
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    
    <link rel="stylesheet" href="{{ asset('assets/admin/tags/bootstrap-tagsinput.css') }}">
    
    <link rel="stylesheet" href="{{ asset('assets/admin/css/theme.css') }}">

    <title>@yield('title') | WAYAK</title>
    
    @yield('css')

  </head>
  <body class="" data-layout-config="{&quot;leftSideBarTheme&quot;:&quot;dark&quot;,&quot;layoutBoxed&quot;:false, &quot;leftSidebarCondensed&quot;:false, &quot;leftSidebarScrollable&quot;:false,&quot;darkMode&quot;:false, &quot;showRightSidebarOnStart&quot;: true}" data-leftbar-theme="dark">
   <!-- Begin page -->
   <div class="wrapper mm-active">
      <!-- ========== Left Sidebar Start ========== -->
      <div class="left-side-menu mm-show">
         <!-- LOGO -->
         <a href="{{ route('admin.home') }}" class="logo text-center logo-light">
            <span class="logo-lg" style="color: white;font-size: 39px;">
                <!-- <img src="https://coderthemes.com/hyper/saas/assets/images/logo.png" alt="" height="16"> -->
                WAYAK
            </span>
            <span class="logo-sm">
                WAYAK
                <!-- <img src="https://coderthemes.com/hyper/saas/assets/images/logo_sm.png" alt="" height="16"> -->
            </span>
         </a>
         <!-- LOGO -->
         <a href="{{ route('admin.home') }}" class="logo text-center logo-dark">
         <span class="logo-lg">
         <img src="https://coderthemes.com/hyper/saas/assets/images/logo-dark.png" alt="" height="16">
         </span>
         <span class="logo-sm">
         <img src="https://coderthemes.com/hyper/saas/assets/images/logo_sm_dark.png" alt="" height="16">
         </span>
         </a>
         <div class="h-100 mm-active" id="left-side-menu-container" data-simplebar="init">
            <div class="simplebar-wrapper" style="margin: 0px;">
               <div class="simplebar-height-auto-observer-wrapper">
                  <div class="simplebar-height-auto-observer"></div>
               </div>
               <div class="simplebar-mask">
                  <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                     <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;">
                        <div class="simplebar-content" style="padding: 0px;">
                           <!--- Sidemenu -->
                           <ul class="metismenu side-nav mm-show">
                              <li class="side-nav-title side-nav-item">Navigation</li>
                              <li class="side-nav-item mm-active">
                                 <a href="/admin/categories" class="side-nav-link active">
                                    <i class="uil-home-alt"></i>
                                    <!-- <span class="badge badge-success float-right">4</span> -->
                                    <span> Categories </span>
                                 </a>
                              </li>
                              <li class="side-nav-item mm-active">
                                 <a href="/admin/metadata/keywords/manage" class="side-nav-link active">
                                    <i class="uil-home-alt"></i>
                                    <!-- <span class="badge badge-success float-right">4</span> -->
                                    <span> Keywords </span>
                                 </a>
                              </li>
                              
                              <li class="side-nav-item mm-active">
                                 <a href="/admin/metadata/product" class="side-nav-link active">
                                    <i class="uil-home-alt"></i>
                                    <!-- <span class="badge badge-success float-right">4</span> -->
                                    <span> Template metadata </span>
                                 </a>
                              </li>
                              <li class="side-nav-item mm-active">
                                 <a href="/admin/us/manage-codes" class="side-nav-link active">
                                    <i class="uil-home-alt"></i>
                                    <!-- <span class="badge badge-success float-right">4</span> -->
                                    <span> Promocodes</span>
                                 </a>
                              </li>
                              <li class="side-nav-item mm-active">
                                 <a href="/admin/etsy/gallery" class="side-nav-link active">
                                    <i class="uil-home-alt"></i>
                                    <!-- <span class="badge badge-success float-right">4</span> -->
                                    <span> Etsy Template Gallery</span>
                                 </a>
                              </li>
                              <li class="side-nav-item mm-active">
                                 <a href="/admin/assets-gallery/static" class="side-nav-link active">
                                    <i class="uil-home-alt"></i>
                                    <!-- <span class="badge badge-success float-right">4</span> -->
                                    <span> Assets Gallery</span>
                                 </a>
                              </li>
                              
                              <!-- <li class="side-nav-item mm-active">
                                 <a href="#" class="side-nav-link active">
                                    <i class="uil-home-alt"></i>
                                    <span> Carousels </span>
                                 </a>
                              </li>
                              <li class="side-nav-item mm-active">
                                 <a href="{{ route('admin.manageCodes', ['country'=>'us']) }}" class="side-nav-link active">
                                    <i class="uil-home-alt"></i>
                                    <span> Promocode </span>
                                 </a>
                              </li>
                              <li class="side-nav-item mm-active">
                                 <a href="{{ route('admin.category.manage') }}" class="side-nav-link active">
                                    <i class="uil-home-alt"></i>
                                    <span> Categories </span>
                                 </a>
                              </li>
                              <li class="side-nav-title side-nav-item">Navigation</li>
                              <li class="side-nav-item mm-active">
                                 <a href="javascript: void(0);" class="side-nav-link active">
                                    <i class="uil-home-alt"></i>
                                    <span class="badge badge-success float-right">4</span>
                                    <span> Mercado Pago </span>
                                 </a>
                                 <ul class="side-nav-second-level mm-collapse mm-show" aria-expanded="false">
                                    <li class="mm-active">
                                       <a href="index.html" class="active">Packt</a>
                                    </li>
                                    <li>
                                       <a href="index.html" class="active">Over</a>
                                    </li>
                                    <li>
                                       <a href="index.html" class="active">Foco</a>
                                    </li>
                                    <li>
                                       <a href="index.html" class="active">Canva</a>
                                    </li>
                                    <li>
                                       <a href="index.html" class="active">Corjl</a>
                                    </li>
                                    <li>
                                       <a href="index.html" class="active">Templett</a>
                                    </li>
                                    <li>
                                       <a href="index.html" class="active">Desygner</a>
                                    </li>
                                    <li>
                                       <a href="index.html" class="active">Crello</a>
                                    </li>
                                    <li>
                                       <a href="index.html" class="active">Green</a>
                                    </li>
                                    <li>
                                       <a href="index.html" class="active">Placeit</a>
                                    </li>
                                    <li>
                                       <a href="index.html" class="active">Etsy</a>
                                    </li>
                                 </ul>
                              </li>
                              <li class="side-nav-item mm-active">
                                 <a href="javascript: void(0);" class="side-nav-link active">
                                    <i class="uil-home-alt"></i>
                                    <span> Templett</span>
                                 </a>
                              </li> -->
                           </ul>
                           <!-- End Sidebar -->
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="simplebar-placeholder" style="width: 260px; height: 1612px;"></div>
            </div>
            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
               <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
            </div>
            <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
               <div class="simplebar-scrollbar" style="height: 67px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
            </div>
         </div>
         <!-- Sidebar -left -->
      </div>
      <!-- Left Sidebar End -->
      <!-- ============================================================== -->
      <!-- Start Page Content here -->
      <!-- ============================================================== -->
      <div class="content-page">
         <div class="content">
            <!-- Topbar Start -->
            <div class="navbar-custom">
               <ul class="list-unstyled topbar-right-menu float-right mb-0">
                  
                  
                  
                  <li class="dropdown notification-list">
                     <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                     <span class="account-user-avatar"> 
                        <img src="https://coderthemes.com/hyper/saas/assets/images/users/avatar-1.jpg" alt="user-image" class="rounded-circle">
                     </span>
                     <span>
                     <span class="account-user-name">Daniel Gutierrez</span>
                     <span class="account-position">Admin</span>
                     </span>
                     </a>
                     <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                        <!-- item-->
                        <div class=" dropdown-header noti-title">
                           <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="mdi mdi-account-circle mr-1"></i>
                        <span>My Account</span>
                        </a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="mdi mdi-account-edit mr-1"></i>
                        <span>Settings</span>
                        </a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="mdi mdi-lifebuoy mr-1"></i>
                        <span>Support</span>
                        </a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="mdi mdi-lock-outline mr-1"></i>
                        <span>Lock Screen</span>
                        </a>
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="mdi mdi-logout mr-1"></i>
                        <span>Logout</span>
                        </a>
                     </div>
                  </li>
               </ul>
               <button class="button-menu-mobile open-left disable-btn">
                <i class="mdi mdi-menu"></i>
               </button>
               
            </div>
            <!-- end Topbar -->
            <!-- Start Content-->
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- container -->
         </div>
         <!-- content -->
         <!-- Footer Start -->
         <footer class="footer">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-6">
                     2020 © Wayak
                  </div>
                  <div class="col-md-6">
                     <div class="text-md-right footer-links d-none d-md-block">
                        <a href="javascript: void(0);">Acerca de</a>
                        <a href="javascript: void(0);">Ayuda</a>
                        <a href="javascript: void(0);">Contactanos</a>
                     </div>
                  </div>
               </div>
            </div>
         </footer>
         <!-- end Footer -->
      </div>
      <!-- ============================================================== -->
      <!-- End Page content -->
      <!-- ============================================================== -->
   </div>
   <!-- END wrapper -->
   <!-- Right Sidebar -->
   <div class="right-bar">
      <div class="rightbar-title">
         <a href="javascript:void(0);" class="right-bar-toggle float-right">
         <i class="dripicons-cross noti-icon"></i>
         </a>
         <h5 class="m-0">Settings</h5>
      </div>
      <div class="rightbar-content h-100" data-simplebar="init">
         <div class="simplebar-wrapper" style="margin: 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
               <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
               <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                  <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;">
                     <div class="simplebar-content" style="padding: 0px;">
                        <div class="p-3">
                           <div class="alert alert-warning" role="alert">
                              <strong>Customize </strong> the overall color scheme, sidebar menu, etc.
                           </div>
                           <!-- Settings -->
                           <h5 class="mt-3">Color Scheme</h5>
                           <hr class="mt-1">
                           <div class="custom-control custom-switch mb-1">
                              <input type="radio" class="custom-control-input" name="color-scheme-mode" value="light" id="light-mode-check" checked="">
                              <label class="custom-control-label" for="light-mode-check">Light Mode</label>
                           </div>
                           <div class="custom-control custom-switch mb-1">
                              <input type="radio" class="custom-control-input" name="color-scheme-mode" value="dark" id="dark-mode-check">
                              <label class="custom-control-label" for="dark-mode-check">Dark Mode</label>
                           </div>
                           <!-- Width -->
                           <h5 class="mt-4">Width</h5>
                           <hr class="mt-1">
                           <div class="custom-control custom-switch mb-1">
                              <input type="radio" class="custom-control-input" name="width" value="fluid" id="fluid-check" checked="">
                              <label class="custom-control-label" for="fluid-check">Fluid</label>
                           </div>
                           <div class="custom-control custom-switch mb-1">
                              <input type="radio" class="custom-control-input" name="width" value="boxed" id="boxed-check">
                              <label class="custom-control-label" for="boxed-check">Boxed</label>
                           </div>
                           <!-- Left Sidebar-->
                           <h5 class="mt-4">Left Sidebar</h5>
                           <hr class="mt-1">
                           <div class="custom-control custom-switch mb-1">
                              <input type="radio" class="custom-control-input" name="theme" value="default" id="default-check" checked="">
                              <label class="custom-control-label" for="default-check">Default</label>
                           </div>
                           <div class="custom-control custom-switch mb-1">
                              <input type="radio" class="custom-control-input" name="theme" value="light" id="light-check">
                              <label class="custom-control-label" for="light-check">Light</label>
                           </div>
                           <div class="custom-control custom-switch mb-3">
                              <input type="radio" class="custom-control-input" name="theme" value="dark" id="dark-check">
                              <label class="custom-control-label" for="dark-check">Dark</label>
                           </div>
                           <div class="custom-control custom-switch mb-1">
                              <input type="radio" class="custom-control-input" name="compact" value="fixed" id="fixed-check" checked="">
                              <label class="custom-control-label" for="fixed-check">Fixed</label>
                           </div>
                           <div class="custom-control custom-switch mb-1">
                              <input type="radio" class="custom-control-input" name="compact" value="condensed" id="condensed-check">
                              <label class="custom-control-label" for="condensed-check">Condensed</label>
                           </div>
                           <div class="custom-control custom-switch mb-1">
                              <input type="radio" class="custom-control-input" name="compact" value="scrollable" id="scrollable-check">
                              <label class="custom-control-label" for="scrollable-check">Scrollable</label>
                           </div>
                           <button class="btn btn-primary btn-block mt-4" id="resetBtn">Reset to Default</button>
                           <a href="https://themes.getbootstrap.com/product/hyper-responsive-admin-dashboard-template/" class="btn btn-danger btn-block mt-3" target="_blank"><i class="mdi mdi-basket mr-1"></i> Purchase Now</a>
                        </div>
                        <!-- end padding-->
                     </div>
                  </div>
               </div>
            </div>
            <div class="simplebar-placeholder" style="width: 280px; height: 752px;"></div>
         </div>
         <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
         </div>
         <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
            <div class="simplebar-scrollbar" style="height: 136px; display: block; transform: translate3d(0px, 0px, 0px);"></div>
         </div>
      </div>
   </div>
   <div class="rightbar-overlay"></div>
   <!-- /Right-bar -->
   <!-- bundle -->
   <!-- third party js -->
   <!-- third party js ends -->
   <!-- demo app -->
   <!-- end demo js-->
   <svg id="SvgjsSvg1001" width="2" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;">
      <defs id="SvgjsDefs1002"></defs>
      <polyline id="SvgjsPolyline1003" points="0,0"></polyline>
      <path id="SvgjsPath1004" d="M0 0 "></path>
   </svg>
   <div class="daterangepicker ltr single opensright">
      <div class="ranges"></div>
      <div class="drp-calendar left single" style="display: block;">
         <div class="calendar-table"></div>
         <div class="calendar-time" style="display: none;"></div>
      </div>
      <div class="drp-calendar right" style="display: none;">
         <div class="calendar-table"></div>
         <div class="calendar-time" style="display: none;"></div>
      </div>
      <div class="drp-buttons"><span class="drp-selected"></span><button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button><button class="applyBtn btn btn-sm btn-primary" disabled="disabled" type="button">Apply</button> </div>
   </div>
   <div class="jvectormap-label"></div>

    
    

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper.js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js" integrity="sha384-BOsAfwzjNJHrJ8cZidOg56tcQWfp6y72vEJ8xQ9w6Quywb24iOsW913URv1IS4GD" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper.js and Bootstrap JS
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script>
    -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/admin/tags/bootstrap-tagsinput.min.js') }}"></script>
     -->
  </body>
</html>