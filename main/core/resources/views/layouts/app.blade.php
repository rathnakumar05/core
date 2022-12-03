<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>{{isset($title) ? $title : "Core"}}</title>
      
      <!-- Favicon -->
      <link rel="shortcut icon" href="{{asset('/assets/images/favicon.ico')}}" />
      
      <!-- Library / Plugin Css Build -->
      <link rel="stylesheet" href="{{asset('/assets/css/core/libs.min.css')}}" />
      
      <!-- Aos Animation Css -->
      <link rel="stylesheet" href="{{asset('/assets/vendor/aos/dist/aos.css')}}" />
      
      <!-- Hope Ui Design System Css -->
      <link rel="stylesheet" href="{{asset('/assets/css/hope-ui.min.css?v=1.2.0')}}" />
      
      <!-- Custom Css -->
      <link rel="stylesheet" href="{{asset('/assets/css/custom.min.css?v=1.2.0')}}" />
      
      <!-- Dark Css -->
      <link rel="stylesheet" href="{{asset('/assets/css/dark.min.css')}}"/>
      
      <!-- Customizer Css -->
      <link rel="stylesheet" href="{{asset('/assets/css/customizer.min.css')}}" />

      <link rel="stylesheet" href="{{asset('/assets/css/style.css')}}"/>

      <link rel="stylesheet" href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css' />
      <style>
        #btn-back-to-top {
          position: fixed;
          bottom: 40px;
          right: 20px;
          display: none;
          z-index: 1000;
        }
      </style>
      @yield('css')
  </head>
  <body class="dark">
  <button
        type="button"
        class="btn btn-primary btn-floating p-2"
        id="btn-back-to-top"
        >
  <i class="bi bi-arrow-up"></i>
</button>
    <!-- loader Start -->
    <div id="loading">
      <div class="loader simple-loader">
          <div class="loader-body"></div>
      </div>    </div>
    <!-- loader END -->
    
    <aside class="sidebar sidebar-default navs-pill">
        <div class="sidebar-header d-flex align-items-center justify-content-start">
            <a href="{{route('dashboard', ['dashboard' => 'dashboard'])}}" class="navbar-brand align-items-center">
                <!--Logo start-->
                <img src="{{asset('/assets/images/core/logo/core.png')}}" height="62px"/>
                <!--logo End-->            <h4 class="logo-title">Core</h4>
            </a>
            <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </i>
            </div>
        </div>
        <div class="sidebar-body pt-0 data-scrollbar">
            <div class="sidebar-list">
                <!-- Sidebar Menu Start -->
                <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" tabindex="-1">
                            <span class="default-icon">Home</span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('/') || request()->is('dashboard')) ? 'active' : '' }}" aria-current="page" href="{{route('dashboard', ['dashboard' => 'dashboard'])}}">
                            <i class="icon">
                            <img src="{{asset('/assets/images/core/icon/dashboard.png')}}" />
                            </i>
                            <span class="item-name">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('devices')) ? 'active' : '' }}" aria-current="page" href="{{route('devices.index')}}">
                            <i class="icon">
                            <img src="{{asset('/assets/images/core/icon/device.png')}}" />
                            </i>
                            <span class="item-name">Devices</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('machines')) ? 'active' : '' }}" aria-current="page" href="{{route('machines.index')}}">
                            <i class="icon">
                            <img src="{{asset('/assets/images/core/icon/server.png')}}" />
                            </i>
                            <span class="item-name">Machines</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('services*')) ? 'active' : '' }}" aria-current="page" href="{{route('services.index')}}">
                            <i class="icon">
                            <img src="{{asset('/assets/images/core/icon/service.png')}}" />
                            </i>
                            <span class="item-name">Services</span>
                        </a>
                    </li>
                </ul>
                <!-- Sidebar Menu End -->        
            </div>
        </div>
        <div class="sidebar-footer"></div>
    </aside>    
    <main class="main-content">
      <div class="position-relative iq-banner">
        <!--Nav Start-->
        <nav class="nav navbar navbar-expand-lg navbar-light iq-navbar">
          <div class="container-fluid navbar-inner">
            <a href="../dashboard/index.html" class="navbar-brand">
                <!--Logo start-->
                <svg width="30" class="text-primary" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2" transform="rotate(-45 -0.757324 19.2427)" fill="currentColor"/>
                    <rect x="7.72803" y="27.728" width="28" height="4" rx="2" transform="rotate(-45 7.72803 27.728)" fill="currentColor"/>
                    <rect x="10.5366" y="16.3945" width="16" height="4" rx="2" transform="rotate(45 10.5366 16.3945)" fill="currentColor"/>
                    <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2" transform="rotate(45 10.5562 -0.556152)" fill="currentColor"/>
                </svg>
                <!--logo End-->        <h4 class="logo-title">Core</h4>
            </a>
            <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="icon">
                 <svg width="20px" height="20px" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                </svg>
                </i>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon">
                  <span class="mt-2 navbar-toggler-bar bar1"></span>
                  <span class="navbar-toggler-bar bar2"></span>
                  <span class="navbar-toggler-bar bar3"></span>
                </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0">
                <li class="nav-item dropdown">
                  <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../assets/images/avatars/01.png" alt="User-Profile" class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded">
                    <div class="caption ms-3 d-none d-md-block ">
                        <h6 class="mb-0 caption-title">{{ auth()->user()->name }}</h6>
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <!-- <li><a class="dropdown-item" href="../dashboard/app/user-profile.html">Profile</a></li>
                    <li><a class="dropdown-item" href="../dashboard/app/user-privacy-setting.html">Privacy Setting</a></li> -->
                    <li><hr class="dropdown-divider"></li>
                    <li><form method="POST" action="{{route('logout')}}" >@csrf<input type="submit" class="dropdown-item" value="Logout"></form></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>          <!-- Nav Header Component Start -->
          <div class="iq-navbar-header" style="height: 215px;">
              <div class="container-fluid iq-container">
                  <div class="row">
                      <div class="col-md-12">
                          <div class="flex-wrap d-flex justify-content-between align-items-center">
                              @yield('header')
                          </div>
                      </div>
                  </div>
              </div>
              <div class="iq-header-img">
                  <img src="{{asset('/assets/images/dashboard/top-header.png')}}" alt="header" class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
              </div>
          </div>          <!-- Nav Header Component End -->
        <!--Nav End-->
      </div>
      <div class="conatiner-fluid content-inner mt-n5 py-0">
      @yield('content')
      </div>
      </div>
      <!-- Footer Section Start -->
      <footer class="footer">
          <div class="footer-body">
              <ul class="left-panel list-inline mb-0 p-0">
              </ul>
              <div class="right-panel">
                  ©<script>document.write(new Date().getFullYear())</script> CORE, Made with
                  <span class="text-gray">
                      <svg width="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M15.85 2.50065C16.481 2.50065 17.111 2.58965 17.71 2.79065C21.401 3.99065 22.731 8.04065 21.62 11.5806C20.99 13.3896 19.96 15.0406 18.611 16.3896C16.68 18.2596 14.561 19.9196 12.28 21.3496L12.03 21.5006L11.77 21.3396C9.48102 19.9196 7.35002 18.2596 5.40102 16.3796C4.06102 15.0306 3.03002 13.3896 2.39002 11.5806C1.26002 8.04065 2.59002 3.99065 6.32102 2.76965C6.61102 2.66965 6.91002 2.59965 7.21002 2.56065H7.33002C7.61102 2.51965 7.89002 2.50065 8.17002 2.50065H8.28002C8.91002 2.51965 9.52002 2.62965 10.111 2.83065H10.17C10.21 2.84965 10.24 2.87065 10.26 2.88965C10.481 2.96065 10.69 3.04065 10.89 3.15065L11.27 3.32065C11.3618 3.36962 11.4649 3.44445 11.554 3.50912C11.6104 3.55009 11.6612 3.58699 11.7 3.61065C11.7163 3.62028 11.7329 3.62996 11.7496 3.63972C11.8354 3.68977 11.9247 3.74191 12 3.79965C13.111 2.95065 14.46 2.49065 15.85 2.50065ZM18.51 9.70065C18.92 9.68965 19.27 9.36065 19.3 8.93965V8.82065C19.33 7.41965 18.481 6.15065 17.19 5.66065C16.78 5.51965 16.33 5.74065 16.18 6.16065C16.04 6.58065 16.26 7.04065 16.68 7.18965C17.321 7.42965 17.75 8.06065 17.75 8.75965V8.79065C17.731 9.01965 17.8 9.24065 17.94 9.41065C18.08 9.58065 18.29 9.67965 18.51 9.70065Z" fill="currentColor"></path>
                      </svg>
                  </span> by <a href="https://iqonic.design/">Core</a>.
              </div>
          </div>
      </footer>
      <!-- Footer Section End -->    
    </main>
    @yield("modal")


    <!-- Library Bundle Script -->
    <script src="{{asset('/assets/js/core/libs.min.js')}}"></script>
    
    <!-- External Library Bundle Script -->
    <script src="{{asset('/assets/js/core/external.min.js')}}"></script>
    
    <!-- Widgetchart Script -->
    <script src="{{asset('/assets/js/charts/widgetcharts.js')}}"></script>
    
    <!-- mapchart Script -->
    <script src="{{asset('/assets/js/charts/vectore-chart.js')}}"></script>
    <script src="{{asset('/assets/js/charts/dashboard.js')}}" ></script>
    
    <!-- fslightbox Script -->
    <script src="{{asset('/assets/js/plugins/fslightbox.js')}}"></script>
    
    <!-- Settings Script -->
    <script src="{{asset('/assets/js/plugins/setting.js')}}"></script>
    
    <!-- Slider-tab Script -->
    <script src="{{asset('/assets/js/plugins/slider-tabs.js')}}"></script>
    
    <!-- Form Wizard Script -->
    <script src="{{asset('/assets/js/plugins/form-wizard.js')}}"></script>
    
    <!-- AOS Animation Plugin-->
    <script src="{{asset('/assets/vendor/aos/dist/aos.js')}}"></script>
    
    <!-- App Script -->
    <script src="{{asset('/assets/js/hope-ui.js')}}" defer></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
      //Get the button
      let mybutton = document.getElementById("btn-back-to-top");
            
      // When the user scrolls down 20px from the top of the document, show the button
      window.onscroll = function () {
        scrollFunction();
      };
      
      function scrollFunction() {
        if (
          document.body.scrollTop > 20 ||
          document.documentElement.scrollTop > 20
        ) {
          mybutton.style.display = "block";
        } else {
          mybutton.style.display = "none";
        }
      }
      // When the user clicks on the button, scroll to the top of the document
      mybutton.addEventListener("click", backToTop1);
      
      function backToTop1() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
      }
    </script>
    @yield('js')
  </body>
</html>