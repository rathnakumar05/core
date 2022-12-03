@extends("layouts.app")
@section('header')
<div>
    <h1>Services</h1>
</div>
@endsection
@section('content')
<div class="row">
    <div class="card col-md-12 col-lg-12 device" data-aos="fade-up" data-aos-delay="700">
        <div class="card-body row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 my-2">
               <div class="progress-widget">
                  <div class="text-center circle-progress-01 circle-progress circle-progress-primary" >
                  <img src="{{asset('/assets/images/core/logo/mysql.png')}}" height="64px" width="64px" />
                  </div>
                  <div class="progress-detail">
                     <p  class="mb-2">Service</p>
                     <h4 class="">Mysql</h4>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 my-2">
               <div class="progress-widget">
                  <div class="text-center circle-progress-01 circle-progress circle-progress-info" data-min-value="0" data-max-value="100" data-value="80" data-type="percent">
                  <img src="{{asset('/assets/images/core/logo/ip.png')}}" />
                  </div>
                  <div class="progress-detail">
                     <p  class="mb-2">Allocated IP</p>
                     <h4 class="" id="ubuntu_ip" >10.8.0.100<span class="fs-6">:3306</span></h4>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 my-2">
               <div class="progress-widget">
                  <div class="text-center circle-progress-01 circle-progress circle-progress-primary" data-min-value="0" data-max-value="100" data-value="70" data-type="percent">
                  <img src="{{asset('/assets/images/core/logo/settings.png')}}" />
                  </div>
                  <div class="progress-detail">
                     <p  class="mb-2">Manage</p>
                  </div>
                  <div class="progress-detail">
                     <a href="{{route('services.mysql')}}"><i class="bi bi-box-arrow-up-right fs-6 d-block mb-2"></i></a>
                  </div>
               </div>
            </div>
        </div>
   </div>
   <div class="card col-md-12 col-lg-12 device" data-aos="fade-up" data-aos-delay="700">
        <div class="card-body row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 my-2">
               <div class="progress-widget">
                  <div class="text-center circle-progress-01 circle-progress circle-progress-primary" >
                  <img src="{{asset('/assets/images/core/logo/phpmyadmin.png')}}" height="64px" width="64px" />
                  </div>
                  <div class="progress-detail">
                     <p  class="mb-2">Service</p>
                     <h4 class="">Phpmyadmin</h4>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 my-2">
               <div class="progress-widget">
                  <div class="text-center circle-progress-01 circle-progress circle-progress-info" data-min-value="0" data-max-value="100" data-value="80" data-type="percent">
                  <img src="{{asset('/assets/images/core/logo/ip.png')}}" />
                  </div>
                  <div class="progress-detail">
                     <p  class="mb-2">Allocated IP</p>
                     <h4 class="" >10.8.0.101</h4>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 my-2">
               <div class="progress-widget">
                  <div class="text-center circle-progress-01 circle-progress circle-progress-primary" data-min-value="0" data-max-value="100" data-value="70" data-type="percent">
                  <img src="{{asset('/assets/images/core/logo/settings.png')}}" />
                  </div>
                  <div class="progress-detail">
                     <p  class="mb-2">Manage</p>
                  </div>
                  <div class="progress-detail">
                     <a href="http://10.8.0.101" target="_blank"><i class="bi bi-box-arrow-up-right fs-6 d-block mb-2"></i></a>
                  </div>
               </div>
            </div>
        </div>
   </div>
</div>
@endsection
