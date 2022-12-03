<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Core</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'> 
    <link rel="stylesheet" href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css' />
    @yield('css')
    <link rel="stylesheet" href="./core/assets/css/style.css">
    @yield('custom_css')
</head>
<body id="body" class="bg-dark">
    <header class="header" id="header"> 
        <div class="header_toggle mt-2"> 
            <i class='bx bx-menu header-toggle' id="header-toggle-1"></i> 
        </div>
        <div class="header_img"> 
            <img src="https://i.imgur.com/hczKIze.jpg" alt=""> 
        </div>
    </header>
    <div class="l-navbar" id="nav-bar">
        <div class="nav_c">
            <div id="sidebar-scroll">
                <a href="#" class="nav_logo position-sticky top-0 bg-first"> 
                    <i class='bx bx-layer nav_logo-icon'></i> 
                    <span class="nav_logo-name">CORE</span> 
                    <div class="header_toggle" data-close="1" id="close" > 
                        <i class='bx bx-x d-none' data-close="1" id="header-toggle-2"></i> 
                    </div>
                </a>
                <a class="nav_link bg-first mb-2 {{ (request()->is('/') || request()->is('dashboard')) ? 'active' : '' }}" href="{{route('dashboard', ['dashboard' => 'dashboard'])}}">
                    <i class='bx bx-grid-alt nav_icon'></i><span class="nav_name">Dashboard</span>
                </a>
                <a class="nav_link bg-first mb-2 {{ (request()->is('devices')) ? 'active' : '' }}" href="{{route('devices.index')}}">
                    <i class='bx bx-devices nav_icon'></i><span class="nav_name">Devices</span>
                </a>
                <a class="nav_link bg-first mb-2 {{ (request()->is('machines')) ? 'active' : '' }}" href="{{route('machines.index')}}">
                    <i class="bi bi-window-dock nav_icon"></i><span class="nav_name">Machines</span>
                </a>
            </div>
            <form action="{{route('logout')}}" method="post" id="logout">
                @csrf
                <a class="nav_link bg-light" id="logoutBtn">
                    <i class='bx bx-log-out nav_icon nav_icon text-dark'></i><span class="nav_name text-dark">SignOut</span>
                </a>
            </form>
        </div>
     </div>
    <!--Container Main start-->
    <div class="container-fluid">
        @yield('content')
    </div>
    @yield('modal')
    <!--Container Main end-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @yield('script')
    <script src="./core/assets/js/index.js"></script>
    @yield('custom_script')
</body>
</html>