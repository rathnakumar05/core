<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>    
    <style>
        body{
            font-family: var(--bs-font-monospace);
        }
        
        main{
            min-height : 100vh !important;
        }

        div.card-header{
            height: 80px; margin: -1px !important;
        }

        div.card-header > span{
            border-top-left-radius: 0.2rem; 
            border-bottom-right-radius: 25px;
        }
        
        .bg-amin{
            --bs-bg-opacity: 1;
            background-image: linear-gradient(to right, #8e2de2, #4a00e0);
        }

        .bg-dark {
            background-color: #000000 !important;
        }

        a{
            color: #8e2de2 !important;
        }

        .form-control:focus{
            border-color: #8e2de2 !important;
            box-shadow: unset !important;
        }

        .toon{
            height: 500px;
            width: 100%;
            background-image: url(./core/assets/img/AlienX.png);
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }

        .pulse {
            animation: pulse 7s infinite;
            margin: 0 auto;
            display: table;
            animation-direction: alternate;
            -webkit-animation-name: pulse;
            animation-name: pulse;
        }

        @-webkit-keyframes pulse {
            0% {
              -webkit-transform: scale(1);
            }
            50% {
              -webkit-transform: scale(1.1);
            }
            100% {
              -webkit-transform: scale(1);
            }
        }

        @keyframes pulse {
            0% {
              transform: scale(1);
            }
            50% {
              transform: scale(1.1);
            }
            100% {
              transform: scale(1);
            }
        }

        .form-check-input:checked {
            background-color: #8e2de2 !important;
            border-color: #8e2de2 !important;
        }

        .form-check-input:focus {
            border-color: #8e2de2 !important;
            box-shadow: unset !important;
        }

        .form-control.error {
            border-color: #dc3545!important;
        }

        .particles-js-canvas-el{
            position: fixed;
        }
    </style>
</head>
<body>
    <div id="particles-js" class="bg-dark"></div>
    <main class="d-flex align-items-center bg-dark">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                    <form method="POST" action="{{ route('login') }}" id="login">
                        @csrf
                        <div class="card bg-dark border border-white text-white">
                            <div class="card-header position-relative border-0"><span class="position-absolute top-0 start-0 fs-1  fw-bold p-3 bg-amin text-white" >LOGIN</span></div>
                            <div class="card-body">
                                <label class="" for="email">EMAIL</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="email"><i class='bx bxs-envelope fs-5'></i></span>
                                    <input type="email" class="form-control  bg-dark text-white @error('email') error @enderror" id="email" name="email" placeholder="Email" aria-label="Email" aria-describedby="email">
                                </div>
                                <div id="email-err" class="mb-3 text-danger" style="font-size: 0.8rem;">@error('email'){{$message}}@enderror</div>
                                <label class="" for="password">PASSWORD</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="password"><i class="bx bxs-lock fs-5"></i></span>
                                    <input type="password" class="form-control  bg-dark text-white @error('password') error @enderror" id="password" name="password" placeholder="Password" aria-label="Password" aria-describedby="password">
                                </div>
                                <div id="password-err" class="mb-3 text-danger" style="font-size: 0.8rem;">@error('password'){{$message}}@enderror</div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="" id="remember_me" name="remember">
                                    <label class="form-check-label" for="remember_me">
                                        Remember me
                                    </label>
                                </div>
                                <P class="">Not have an account ? <a class="" href="{{route('register')}}">SIGN UP</a></P>
                            </div>
                            <div class="card-footer text-end border-0">
                                <button class="btn  text-white bg-amin mb-3">LOGIN!</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 d-none d-sm-none d-md-block p-5">
                    <div class="toon pulse"></div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script>particlesJS('particles-js', {"particles":{"number":{"value":160,"density":{"enable":true,"value_area":800}},"color":{"value":"#ffffff"},"shape":{"type":"circle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"img/github.svg","width":100,"height":100}},"opacity":{"value":1,"random":true,"anim":{"enable":true,"speed":1,"opacity_min":0,"sync":false}},"size":{"value":3,"random":true,"anim":{"enable":false,"speed":4,"size_min":0.3,"sync":false}},"line_linked":{"enable":false,"distance":150,"color":"#ffffff","opacity":0.4,"width":1},"move":{"enable":true,"speed":1,"direction":"none","random":true,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":600}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":false,"mode":"bubble"},"onclick":{"enable":false,"mode":"repulse"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":250,"size":0,"duration":2,"opacity":0,"speed":3},"repulse":{"distance":400,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true})</script>
    <script>
        $().ready(function() {
            $("#login").validate({
			    rules: {
                    email: {
			    		required: true,
			    		email: true
			    	},
			    	password: {
			    		required: true,
			    		minlength: 8
			    	},
			    },
                errorPlacement: function(error, element) {
                    var id = $(element).attr('id');
                    var selector = `#${id}-err`;
                    if (id) {
                        $(selector).append(error);
                    } else {
                        error.insertAfter(element);
                    }
                },
		    });
        });
    </script>
</body>
</html>