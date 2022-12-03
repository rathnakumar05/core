<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Core | Rest password</title>
      
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
            <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
               <img src="../../assets/images/auth/02.png" class="img-fluid gradient-main animated-scaleX" alt="images">
            </div>
            <div class="col-md-6 p-0">               
               <div class="card card-transparent auth-card shadow-none d-flex justify-content-center mb-0">
                  <div class="card-body">
                     <a href="/" class="navbar-brand d-flex align-items-center mb-3">
                        <!--Logo start-->
                        <img src="{{asset('/assets/images/core/logo/core.png')}}" height="62px"/>
                        <!--logo End-->                        <h4 class="logo-title ms-3">Core</h4>
                     </a>
                     <h2 class="mb-2">Confirm Password</h2>
                     <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="floating-label form-group">
                                 <label for="email" class="form-label">Email</label>
                                 <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email', $request->email)}}" aria-describedby="email" placeholder=" ">
                                 <div id="email-err" class="invalid-feedback">@error('email'){{$message}}@enderror</div>
                              </div>
                           </div>
                           <div class="col-lg-12">
                              <div class="floating-label form-group">
                                 <label for="password" class="form-label">Password</label>
                                 <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" aria-describedby="password" placeholder=" ">
                                 <div id="password-err" class="invalid-feedback">@error('email'){{$message}}@enderror</div>
                              </div>
                           </div>
                           <div class="col-lg-12">
                              <div class="floating-label form-group">
                                 <label for="password_confirmation" class="form-label">Confrim password</label>
                                 <input class="form-control" id="password_confirmation" type="password"
                                    name="password_confirmation" aria-describedby="password_confirmation" placeholder=" ">
                              </div>
                           </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Email Password Reset Link</button>
                     </form>
                  </div>
               </div>               
               <div class="sign-bg sign-bg-right">
                  <svg width="280" height="230" viewBox="0 0 431 398" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <g opacity="0.05">
                     <rect x="-157.085" y="193.773" width="543" height="77.5714" rx="38.7857" transform="rotate(-45 -157.085 193.773)" fill="#3B8AFF"/>
                     <rect x="7.46875" y="358.327" width="543" height="77.5714" rx="38.7857" transform="rotate(-45 7.46875 358.327)" fill="#3B8AFF"/>
                     <rect x="61.9355" y="138.545" width="310.286" height="77.5714" rx="38.7857" transform="rotate(45 61.9355 138.545)" fill="#3B8AFF"/>
                     <rect x="62.3154" y="-190.173" width="543" height="77.5714" rx="38.7857" transform="rotate(45 62.3154 -190.173)" fill="#3B8AFF"/>
                     </g>
                  </svg>
               </div>
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