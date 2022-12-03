<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Core | Sign in</title>
      
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
            <div class="col-md-6">
               <div class="row justify-content-center">
                  <div class="col-md-10">
                     <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                        <div class="card-body">
                           <a href="../../dashboard/index.html" class="navbar-brand d-flex align-items-center mb-3">
                              <!--Logo start-->
                              <img src="{{asset('/assets/images/core/logo/core.png')}}" height="62px"/>
                              <!--logo End-->                              <h4 class="logo-title ms-3">Core</h4>
                           </a>
                           <h2 class="mb-2 text-center">Sign In</h2>
                           <p class="text-center">Login to stay connected.</p>
                           <form method="POST" action="{{ route('login') }}" id="login">
                              @csrf
                              <div class="row">
                                 <div class="col-lg-12">
                                    <div class="form-group">
                                       <label for="email" class="form-label">Email</label>
                                       <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" aria-describedby="email" placeholder=" " value="{{old('email')}}" >
                                       <div id="email-err" class="invalid-feedback">@error('email'){{$message}}@enderror</div>
                                    </div>
                                 </div>
                                 <div class="col-lg-12">
                                    <div class="form-group">
                                       <label for="password" class="form-label">Password</label>
                                       <input type="password" class="form-control @error('email') is-invalid @enderror" id="password" name="password" aria-describedby="password" placeholder=" ">
                                       <div id="password-err" class="invalid-feedback">@error('password'){{$message}}@enderror</div>
                                    </div>
                                 </div>
                                 <div class="col-lg-12 d-flex justify-content-between">
                                    <div class="form-check mb-3">
                                       <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                                       <label class="form-check-label" for="customCheck1">Remember Me</label>
                                    </div>
                                    <a href="{{route('password.request')}}">Forgot Password?</a>
                                 </div>
                              </div>
                              <div class="d-flex justify-content-center">
                                 <button type="submit" class="btn btn-primary">Sign In</button>
                              </div>
                              <p class="mt-3 text-center">
                                 Don’t have an account? <a href="{{route('register')}}" class="text-underline">Click here to sign up.</a>
                              </p>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
               <img src="../../assets/images/auth/01.png" class="img-fluid gradient-main animated-scaleX" alt="images">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script>
            $("#login").validate({
                errorClass: "is-invalid",
                validClass: 'is-valid',
                errorElement: 'div',
		    	rules: {
                    email: {
		    			required: true,
		    			email: true,
		    		},
		    		password: {
		    			required: true,
		    			minlength: 8,
		    		},
		    	},
                errorPlacement: function(error, element) {
                    var id = $(element).attr('id');
                        var selector = `#${id}-err`;
                        $(selector).html(error);

                },
		    });
    </script>
  </body>
</html>