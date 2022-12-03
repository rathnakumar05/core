


<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Hope UI | Responsive Bootstrap 5 Admin Dashboard Template</title>
      
      <!-- Favicon -->
      <link rel="shortcut icon" href="{{asset('/assets/images/favicon.ico')}}" />
      
      <!-- Library / Plugin Css Build -->
      <link rel="stylesheet" href="{{asset('/assets/css/core/libs.min.css')}}" />
      
      
      <!-- Hope Ui Design System Css -->
      <link rel="stylesheet" href="{{asset('/assets/css/hope-ui.min.css?v=1.2.0')}}" />
      
      <!-- Custom Css -->
      <link rel="stylesheet" href="{{asset('/assets/css/custom.min.css?v=1.2.0')}}" />
      
      <!-- Dark Css -->
      <link rel="stylesheet" href="{{asset('/assets/css/dark.min.css')}}"/>
      
      <!-- Customizer Css -->
      <link rel="stylesheet" href="{{asset('/assets/css/customizer.min.css')}}" />
      
      <!-- RTL Css -->
      <link rel="stylesheet" href="{{asset('/assets/css/rtl.min.css')}}"/>
      
  </head>
  <body class="dark" data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">
    <!-- loader Start -->
    <div id="loading">
      <div class="loader simple-loader">
          <div class="loader-body"></div>
      </div>    </div>
    <!-- loader END -->
    
      <div class="wrapper">
      <section class="login-content">
         <div class="row m-0 align-items-center bg-white vh-100">            
            <div class="col-md-6 p-0">    
               <div class="card card-transparent auth-card shadow-none d-flex justify-content-center mb-0">
                  <div class="card-body">
                        <a href="/" class="navbar-brand d-flex align-items-center mb-3">
                           <!--Logo start-->
                           <img src="{{asset('/assets/images/core/logo/core.png')}}" height="62px"/>
                           <!--logo End-->                           <h4 class="logo-title ms-3">Core</h4>
                        </a>
                        <img src="../../assets/images/auth/mail.png" class="img-fluid" width="80" alt="">
                        <h2 class="mt-3 mb-0">Success !</h2>
                        <p class="cnf-mail mb-1">Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.</p>
                        @if (session('status') == 'verification-link-sent')
                        <p class="cnf-mail mb-1">A new verification link has been sent to the email address you provided during registration.</p>
                        @endif
                        <div class="">
                        <form method="POST" action="{{ route('verification.send') }}">
                           @csrf
                           <button type="submit" class="btn btn-primary mt-3">Resend Verification Email</button>
                        </form>
                        </div>
                        <div class="">
                        <form method="POST" action="{{ route('logout') }}">
                           @csrf
                           <button type="submit" class="btn btn-primary mt-3">Log Out</button>
                        </form>
                        </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
               <img src="../../assets/images/auth/03.png" class="img-fluid gradient-main animated-scaleX" alt="images">
            </div>
         </div>
      </section>
      </div>
    
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
    
    <!-- App Script -->
    <script src="{{asset('/assets/js/hope-ui.js')}}" defer></script>
  </body>
</html>