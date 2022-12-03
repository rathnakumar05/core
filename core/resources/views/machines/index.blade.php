@extends("layouts.app")
@section('header')
<div>
    <h1>Machines</h1>
</div>
@endsection
@section('content')
<div class="row">
    <div class="card col-md-12 col-lg-12 device" data-aos="fade-up" data-aos-delay="700">
        <div class="card-body row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 my-2">
               <div class="progress-widget">
                  <div class="text-center circle-progress-01 circle-progress circle-progress-primary" >
                  <img src="{{asset('/assets/images/core/logo/ubuntu.png')}}" />
                  </div>
                  <div class="progress-detail">
                     <p  class="mb-2">OS</p>
                     <h4 class="">Ubuntu</h4>
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
                     <h4 class="" id="ubuntu_ip" >{{($ubuntu!=null && $ubuntu["container_name"])=="ubuntu" ? Str::replace(array('/32'), '', $ubuntu["allowed_ip"]) : '0.0.0.0'}}</h4>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 my-2">
               <div class="progress-widget">
                  <div class="text-center circle-progress-01 circle-progress circle-progress-primary" data-min-value="0" data-max-value="100" data-value="70" data-type="percent">
                  <img src="{{asset('/assets/images/core/logo/settings.png')}}" />
                  </div>
                  <div class="progress-detail">
                     <p  class="mb-2">Get config</p>
                     <p  class="mb-2" id="ubuntu_text">
                        @if($ubuntu!=null && $ubuntu["container_name"]=="ubuntu" && $ubuntu["container_status"]=="RUNNING")
                            running
                        @elseif($ubuntu!=null && $ubuntu["container_name"]=="ubuntu" && $ubuntu["container_status"]=="STOPPED")
                            stopped
                        @else
                            shutdown
                        @endif
                     </p>
                  </div>
                  <div class="progress-detail">
                     <i class="bi bi-gear fs-6 d-block mb-2 pointer" data-allowed_ip="{{($ubuntu!=null && $ubuntu["container_name"]=="ubuntu") ? Str::replace(array('/32'), '', $ubuntu["allowed_ip"]) : ''}}" data-user_name="{{($ubuntu!=null && $ubuntu["container_name"]=="ubuntu") ? $ubuntu["user_name"] : ''}}" data-pwd="{{($ubuntu!=null && $ubuntu["container_name"]=="ubuntu") ? $ubuntu["user_name"]."123" : ''}}" data-action="config" onclick=getConfig(this) id="ubuntu_config"></i>
                     <div class="dropdown">
                         <a class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                             <i class="bi bi-caret-down-fill fs-5"></i>
                         </a>
                         <ul class="dropdown-menu" id="ubuntu_machine">
                           <li class="pointer dropdown-item {{($ubuntu!=null && $ubuntu["container_name"]=="ubuntu" && $ubuntu["container_status"]=="RUNNING") ? "disabled" : ""}}" data-machine="ubuntu" data-action="deploy" onclick=machineAction(this) >deploy</li>
                           <li class="pointer dropdown-item {{($ubuntu!=null && $ubuntu["container_name"]=="ubuntu" && ($ubuntu["container_status"]=="RUNNING" || $ubuntu["container_status"]=="STOPPED")) ? "" : "disabled"}}" data-machine="ubuntu" data-action="redeploy" onclick=machineAction(this)>redeploy</li>
                           <li class="pointer dropdown-item {{($ubuntu!=null && $ubuntu["container_name"]=="ubuntu" && $ubuntu["container_status"]=="RUNNING") ? "" : "disabled"}}" data-machine="ubuntu" data-action="shutdown" onclick=machineAction(this)>shutdown</li>
                           <li class="pointer dropdown-item {{($ubuntu!=null && $ubuntu["container_name"]=="ubuntu" && ($ubuntu["container_status"]=="RUNNING" || $ubuntu["container_status"]=="STOPPED")) ? "" : "disabled"}}" data-machine="ubuntu" data-action="delete" onclick=machineAction(this)>delete</li>
                         </ul>
                     </div> 
                  </div>
               </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="card col-md-12 col-lg-12 device" data-aos="fade-up" data-aos-delay="700">
        <div class="card-body row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 my-2">
               <div class="progress-widget">
                  <div class="text-center circle-progress-01 circle-progress circle-progress-primary" >
                  <img src="{{asset('/assets/images/core/logo/debian.png')}}" />
                  </div>
                  <div class="progress-detail">
                     <p  class="mb-2">OS</p>
                     <h4 class="">Debian</h4>
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
                     <h4 class="" id="debian_ip" >{{($debian!=null && $debian["container_name"])=="debian" ? Str::replace(array('/32'), '', $debian["allowed_ip"]) : '0.0.0.0'}}</h4>
                  </div>
               </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 my-2">
               <div class="progress-widget">
                  <div class="text-center circle-progress-01 circle-progress circle-progress-primary" data-min-value="0" data-max-value="100" data-value="70" data-type="percent">
                  <img src="{{asset('/assets/images/core/logo/settings.png')}}" />
                  </div>
                  <div class="progress-detail">
                     <p  class="mb-2">Get config</p>
                     <p  class="mb-2" id="debian_text">
                        @if($debian!=null && $debian["container_name"]=="debian" && $debian["container_status"]=="RUNNING")
                            running
                        @elseif($debian!=null && $debian["container_name"]=="debian" && $debian["container_status"]=="STOPPED")
                            stopped
                        @else
                            shutdown
                        @endif
                     </p>
                  </div>
                  <div class="progress-detail">
                     <i class="bi bi-gear fs-6 d-block mb-2 pointer" data-allowed_ip="{{($debian!=null && $debian["container_name"]=="debian") ? Str::replace(array('/32'), '', $debian["allowed_ip"]) : ''}}" data-user_name="{{($debian!=null && $debian["container_name"]=="debian") ? $debian["user_name"] : ''}}" data-pwd="{{($debian!=null && $debian["container_name"]=="debian") ? $debian["user_name"]."123" : ''}}" data-action="config" onclick=getConfig(this) id="debian_config"></i>
                     <div class="dropdown">
                         <a class="btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                             <i class="bi bi-caret-down-fill fs-5"></i>
                         </a>
                         <ul class="dropdown-menu" id="debian_machine">
                           <li class="pointer dropdown-item {{($debian!=null && $debian["container_name"]=="debian" && $debian["container_status"]=="RUNNING") ? "disabled" : ""}}" data-machine="debian" data-action="deploy" onclick=machineAction(this) >deploy</li>
                           <li class="pointer dropdown-item {{($debian!=null && $debian["container_name"]=="debian" && ($debian["container_status"]=="RUNNING" || $debian["container_status"]=="STOPPED")) ? "" : "disabled"}}" data-machine="debian" data-action="redeploy" onclick=machineAction(this)>redeploy</li>
                           <li class="pointer dropdown-item {{($debian!=null && $debian["container_name"]=="debian" && $debian["container_status"]=="RUNNING") ? "" : "disabled"}}" data-machine="debian" data-action="shutdown" onclick=machineAction(this)>shutdown</li>
                           <li class="pointer dropdown-item {{($debian!=null && $debian["container_name"]=="debian" && ($debian["container_status"]=="RUNNING" || $debian["container_status"]=="STOPPED")) ? "" : "disabled"}}" data-machine="debian" data-action="delete" onclick=machineAction(this)>delete</li>
                         </ul>
                     </div> 
                  </div>
               </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("modal")
<div class="modal fade" id="configModal" tabindex="-1" aria-labelledby="configModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"">
      <div class="modal-content dark rounded-0 border">
        <div class="modal-header border-0">
          <h5 class="modal-title" id="configModalLabel">Config</h5>
          <button type="button" class="btn"><i class="bi bi-clipboard fs-5 text-first border rounded p-1"></i></button>
        </div>
        <div class="modal-body">
          <code id="code">
          </code>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
@endsection

@section('js')
<script>
    var modal = new bootstrap.Modal(document.getElementById("configModal"));
    function machineAction(event){
        var machine = $(event).attr("data-machine");
        var action = $(event).attr("data-action");
        var _token = "{{csrf_token()}}";
        var data = {
            machine: machine,
            action: action,
            _token: _token
        };
        $.ajax({
            type: "POST",
            url: "{{route('machines.action')}}",
            data: data,
            beforeSend: function(){
                $(`#${machine}_text`).html("processing");
            },
            success: function (response) {  
                var data = response;
                if(data.result=="success"){
                    var text = "";
                    if(action=="deploy" || action=="redeploy")
                        text = "running";
                    else if(action=="shutdown")
                        text = "stopped";
                    else
                        text = "shutdown";
                    $(`#${machine}_text`).html(text);
                    $(`#${machine}_machine li`).each(function(key, item){
                        if(action=="deploy"){
                            $(item).attr("data-action")=="deploy" ? $(item).removeClass("disabled").addClass("disabled") : "";
                            $(item).attr("data-action")=="shutdown" ? $(item).removeClass("disabled") : "";
                            $(item).attr("data-action")=="redeploy" ? $(item).removeClass("disabled") : "";
                            $(item).attr("data-action")=="delete" ? $(item).removeClass("disabled") : "";
                        }
                        else if(action=="shutdown"){
                            $(item).attr("data-action")=="deploy" ? $(item).removeClass("disabled") : "";
                            $(item).attr("data-action")=="shutdown" ? $(item).removeClass("disabled").addClass("disabled") : "";
                            $(item).attr("data-action")=="redeploy" ? $(item).removeClass("disabled") : "";
                            $(item).attr("data-action")=="delete" ? $(item).removeClass("disabled") : "";    
                        }
                        else if(action=="redeploy"){
                            $(item).attr("data-action")=="deploy" ? $(item).removeClass("disabled").addClass("disabled") : "";
                            $(item).attr("data-action")=="shutdown" ? $(item).removeClass("disabled") : "";
                            $(item).attr("data-action")=="redeploy" ? $(item).removeClass("disabled") : "";
                            $(item).attr("data-action")=="delete" ? $(item).removeClass("disabled") : "";    
                        }else{
                            $(item).attr("data-action")=="deploy" ? $(item).removeClass("disabled") : "";
                            $(item).attr("data-action")=="shutdown" ? $(item).removeClass("disabled").addClass("disabled") : "";
                            $(item).attr("data-action")=="redeploy" ? $(item).removeClass("disabled").addClass("disabled") : "";
                            $(item).attr("data-action")=="delete" ? $(item).removeClass("disabled").addClass("disabled") : "";
                        }
                    }); 
                    if(action=="deploy" || action=="redeploy"){
                        $(`#${machine}_config`).attr('data-allowed_ip', data.allowed_ip.replace("/32", ""));
                        $(`#${machine}_config`).attr('data-user_name', data.user_name);
                        $(`#${machine}_config`).attr('data-pwd', (data.user_name+"123"));
                        $(`#${machine}_ip`).html(data.allowed_ip.replace("/32", ""));
                    }else if(action=="delete"){
                        $(`#${machine}_config`).attr('data-allowed_ip', "0.0.0.0");
                        $(`#${machine}_config`).attr('data-user_name', "");
                        $(`#${machine}_config`).attr('data-pwd', "");  
                        $(`#${machine}_ip`).html('0.0.0.0');  
                    }

                }
            },
            error: function(response) {
                swal({
                  title: "Something went wrong",
                  text: "",
                  icon: "error",
                  button: {
                    text: "Ok",
                    value: true,
                    visible: true,
                    className: "bg-first",
                    closeModal: true
                  }
                });
            }, 
        });
    }

    function getConfig(event){
        var allowed_ip = $(event).attr("data-allowed_ip");
        var user_name = $(event).attr("data-user_name");
        var pwd = $(event).attr("data-pwd");
        if(allowed_ip=="" || user_name=="" || pwd==""){
            swal({
                  title: "Your Machine didn't deploy yet!",
                  text: "",
                  icon: "error",
                  button: {
                    text: "Ok",
                    value: true,
                    visible: true,
                    className: "bg-dark",
                    closeModal: true
                  }
                });
        }else{
            var config = `[connect via ssh]<br />$ ssh ${user_name}@${allowed_ip}<br />$ password ${pwd}<br />Note: If you changed the password, the default password does not work!<br />`;
            $("#code").html(config);
            modal.show();
        }
    }
</script>
@endsection