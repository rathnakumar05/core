@extends("layouts.app")

@section("css")
@endsection

@section("custom_css")
@endsection

@section("content")
    <h4 class="p-2 fs-3 fw-bold text-uppercase">Devices</h4>
    <div class="mb-4"></div>
    <div class="bg-first border card d-flex flex-row align-items-center justify-content-between mb-4 flex-wrap" style="min-height: 100px;">
        <div class="d-flex flex-column align-items-center mx-4 my-1"><img src="./core/assets/img/logos/ubuntu_logo.png" class="mx-4" style="height: 65px;" /></div>
        <div class="mx-4"><span class="fs-5 p-2 border rounded">Ubuntu</span></div>
        <div class="mx-4"><span class="bg-second text-first fs-5 p-2 rounded" id="ubuntu_ip">{{($ubuntu!=null && $ubuntu["container_name"])=="ubuntu" ? Str::replace(array('/32'), '', $ubuntu["allowed_ip"]) : '0.0.0.0'}}</span><i class="bi bi-clipboard fs-5 ms-2"></i></div>
        <div class="d-flex flex-column align-items-center mx-4"><span class="badge">Get config</span>
            <span class="pointer" data-allowed_ip="{{($ubuntu!=null && $ubuntu["container_name"]=="ubuntu") ? Str::replace(array('/32'), '', $ubuntu["allowed_ip"]) : ''}}" data-user_name="{{($ubuntu!=null && $ubuntu["container_name"]=="ubuntu") ? $ubuntu["user_name"] : ''}}" data-pwd="{{($ubuntu!=null && $ubuntu["container_name"]=="ubuntu") ? $ubuntu["user_name"]."123" : ''}}" data-action="config" onclick=getConfig(this) id="ubuntu_config" ><i class="bi bi-gear fs-6"></i></span>
        </div>
        <div class="mx-4 d-flex align-items-center">
            <span class="bg-second text-first fs-6 p-1 px-2 rounded" id="ubuntu_text">
                <!-- <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> shutdown -->
                @if($ubuntu!=null && $ubuntu["container_name"]=="ubuntu" && $ubuntu["container_status"]=="RUNNING")
                    running
                @elseif($ubuntu!=null && $ubuntu["container_name"]=="ubuntu" && $ubuntu["container_status"]=="STOPPED")
                    stopped
                @else
                    shutdown
                @endif
            </span>
            <div class="dropdown">
                <a class="btn text-second" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-caret-down-fill fs-5 ms-1"></i>
                </a>
                <ul class="dropdown-menu" id="ubuntu_machine">
                  <li><a class="dropdown-item pointer {{($ubuntu!=null && $ubuntu["container_name"]=="ubuntu" && $ubuntu["container_status"]=="RUNNING") ? "disabled" : ""}}" data-machine="ubuntu" data-action="deploy" onclick=machineAction(this)>deploy</a></li>
                  <li><a class="dropdown-item pointer {{($ubuntu!=null && $ubuntu["container_name"]=="ubuntu" && ($ubuntu["container_status"]=="RUNNING" || $ubuntu["container_status"]=="STOPPED")) ? "" : "disabled"}}" data-machine="ubuntu" data-action="redeploy" onclick=machineAction(this)>redeploy</a></li>
                  <li><a class="dropdown-item pointer {{($ubuntu!=null && $ubuntu["container_name"]=="ubuntu" && $ubuntu["container_status"]=="RUNNING") ? "" : "disabled"}}" data-machine="ubuntu" data-action="shutdown" onclick=machineAction(this)>shutdown</a></li>
                  <li><a class="dropdown-item pointer {{($ubuntu!=null && $ubuntu["container_name"]=="ubuntu" && ($ubuntu["container_status"]=="RUNNING" || $ubuntu["container_status"]=="STOPPED")) ? "" : "disabled"}}" data-machine="ubuntu" data-action="delete" onclick=machineAction(this)>delete</a></li>
                </ul>
            </div> 
        </div>
    </div>
@endsection

@section("modal")
<div class="modal fade" id="configModal" tabindex="-1" aria-labelledby="configModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"">
      <div class="modal-content bg-second text-first rounded-0 border">
        <div class="modal-header">
          <h5 class="modal-title" id="configModalLabel">Config</h5>
          <button type="button" class="btn"><i class="bi bi-clipboard fs-5 text-first border rounded p-1"></i></button>
        </div>
        <div class="modal-body">
          <code id="code">
          </code>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn bg-first text-second" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
@endsection

@section('custom_script')
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
                $(`#${machine}_text`).html(`<div class="spinner-grow text-primary" role="status">
    <span class="visually-hidden">Loading...</span>
</div>processing`);
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
                    $(`#${machine}_machine li a`).each(function(key, item){
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
                  title: "Your Machine doesn't deployed yet!",
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
        }else{
            var config = `[connect via ssh]<br />$ ssh ${user_name}@${allowed_ip}<br />$ password ${pwd}<br />Note: If you changed the password, the default password does not work!<br />`;
            $("#code").html(config);
            modal.show();
        }
    }
</script>
@endsection