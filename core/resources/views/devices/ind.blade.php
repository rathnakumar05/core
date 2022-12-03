@extends("layouts.app_2")
@section("css")
<link rel="stylesheet" href="./core/assets/css/adddevice.css">
@endsection
@section("custom_css")
<style>
    .modal.right .modal-dialog {
		position: fixed;
		margin: auto;
		width: 500px;
		height: 100%;
		-webkit-transform: translate3d(0%, 0, 0);
		    -ms-transform: translate3d(0%, 0, 0);
		     -o-transform: translate3d(0%, 0, 0);
		        transform: translate3d(0%, 0, 0);
	}

    .modal.right .modal-content {
		height: 100%;
		overflow-y: auto;
	}

    .modal.right.fade .modal-dialog {
        right: -500px;
		-webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
		   -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
		     -o-transition: opacity 0.3s linear, right 0.3s ease-out;
		        transition: opacity 0.3s linear, right 0.3s ease-out;
	}
    
	.modal.right.fade.show .modal-dialog {
		right: 0;
	}

    .form-control.error {
        border-color: #dc3545!important;
    }

    @media (max-width: 768px){
        .modal.right .modal-dialog {
            width: 100%;
            max-width: unset;
	    }
    }
</style>
@endsection
@section("content")
    <h4 class="p-2 fs-3 fw-bold text-uppercase">Devices</h4>
    <div class="mb-4"></div>
    <div id="devices_list">
    @foreach ($devices as $device)
        <div class="bg-first border card d-flex flex-row align-items-center justify-content-between mb-4 flex-wrap device" style="min-height: 100px;">
            <div class="d-flex flex-column align-items-center mx-4"><span class="badge">{{$device["device_name"]}}</span><i class="bi {{ $device["device_type"]=="laptop" ? "bi-laptop" : ($device["device_type"]=="pc" ? "bi-pc-display" : "bi-pc-display-horizontal") }} fs-1 mx-4"></i></div>
            <div class="mx-4"><span class="bg-second text-first fs-5 p-2 rounded">{{Str::replace(array("/32"), "", $device["allowed_ip"])}}</span><i class="bi bi-clipboard fs-5 ms-2"></i></div>
            <div class="d-flex flex-column align-items-center mx-4"><span class="badge">Get config</span>
                <span class="pointer" data-allowed_ip="{{$device['allowed_ip']}}" data-public_key="{{$device['public_key']}}" data-action="config" onclick=getConfig(this)><i class="bi bi-gear fs-6"></i></span>
            </div>
            <div class="d-flex flex-column align-items-center mx-4"><span class="badge">Delete</span>
                <span class="pointer" data-public_key="{{$device['public_key']}}" data-action="delete" onclick=deleteAction(this)><i class="bi bi-trash fs-6"></i></span>   
            </div>
        </div>
    @endforeach
    </div>
    <button class="btn bg-second text-first w-100 fs-5 fw-bold" data-action="modal" data-modal_target="viewdeviceModal" onclick=deviceAction(this) data-action="add" >Add device</button>
@endsection

@section("modal")
<div class="modal right fade" id="viewdeviceModal" tabindex="-1" aria-labelledby="viewdeviceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content rounded-0  bg-first">
        <div class="modal-header">
          <h5 class="modal-title" id="viewdeviceModalLabel">Add device</h5>
          <button type="button" class="btn-close bg-second" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('devices.store')}}" method="POST" id="device">
            @csrf
            <div class="modal-body card bg-first text-white p-0">
                <div class="card-body">
                    <label class="" for="key">PUBLIC KEY</label>
                    <div class="input-group">
                        <span class="input-group-text" id="key"><i class='bx bxs-key fs-5'></i></span>
                        <input type="text" class="form-control  bg-first text-white add-device-form" name="public_key" id="public_key" placeholder="Public key" aria-label="Public key" aria-describedby="public key">
                    </div>
                    <div id="public_key-err" class="mb-2 text-danger" style="font-size: 0.8rem;"></div>
                    <label class="" for="device">DEVICE NAME</label>
                    <div class="input-group">
                        <span class="input-group-text" id="device"><i class='bx bx-devices fs-5'></i></span>
                        <input type="text" class="form-control  bg-first text-white add-device-form" name="device_name" id="device_name" placeholder="Device" aria-label="Device" aria-describedby="Device">
                    </div>
                    <div id="device_name-err" class="mb-2 text-danger" style="font-size: 0.8rem;"></div>
                    <label class="" for="device_type">DEVICE TYPE</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-pc-horizontal fs-5"></i></span>
                        <select class="form-control  bg-first text-white add-device-form" name="device_type" id="device_type" aria-label="Device type" aria-describedby="Device type">
                            <option value="" selected class="d-none">Select Device</option>
                            <option value="pc">PC</option>
                            <option value="laptop">LAPTOP</option>
                            <option value="others">Others</option>
                        </select>
                    </div>
                    <div id="device_type-err" class="mb-2 text-danger" style="font-size: 0.8rem;"></div>
                </div>
            </div>
            <div class="modal-footer position-fixed bottom-0 w-100 bg-first">
                <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn text-dark bg-second fw-bold">ADD</button>
            </div>
        </form>
      </div>
    </div>
</div>
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
    var modal = new bootstrap.Modal(document.getElementById("viewdeviceModal"));
    var modal_1 = new bootstrap.Modal(document.getElementById("configModal"));
    $().ready(function() {
        $("#device").validate({
            // rules: {
            //     public_key: {
		    // 		required: true,
		    // 		minlength: 3,
		    // 	},
            //     device_name: {
		    // 		required: true,
            //         minlength: 3,
		    // 	},
		    // 	device_type: {
		    // 		required: true,
		    // 	},
            // },
            errorPlacement: function(error, element) {
                var id = $(element).attr('id');
                var selector = `#${id}-err`;
                if (id) {
                    $(selector).append(error);
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        var data = response;
                        if(data.result=="success"){
                            addDevice(data);
                        }
                    },  
                    error: function(response) {
                        var data = response.responseJSON;
                        if(data.result!=undefined && data.result=="error"){
                            swal({
                              title: data.message,
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
                            if(data.errors!=undefined){
                                for (const [key, value] of Object.entries(data.errors)) {
                                    $(`#${key}-err`).html(value);
                                    $(`#${key}`).addClass("error");
                                }
                            }else{
                                swal({
                                    title: "something went wrong",
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
                            }
                        }
                    },         
                });
            }
        });
    });

    function addDevice(data){
        $device =  `<div class="bg-first border card d-flex flex-row align-items-center justify-content-between mb-4 flex-wrap device" style="min-height: 100px;" >
                    <div class="d-flex flex-column align-items-center mx-4"><span class="badge">${data.device_name}</span><i class="bi bi-laptop fs-1 mx-4"></i></div>
                    <div class="mx-4"><span class="bg-second text-first fs-5 p-2 rounded">${data.allowed_ip.replace('/32', '')}</span><i class="bi bi-clipboard fs-5 ms-2"></i></div>
                    <div class="d-flex flex-column align-items-center mx-4"><span class="badge">Get config</span>
                        <span class="pointer" data-allowed_ip="${data.allowed_ip}" data-public_key="${data.public_key}" data-action="config" onclick=getConfig(this)><i class="bi bi-gear fs-6"></i></span>
                    </div>
                    <div class="d-flex flex-column align-items-center mx-4"><span class="badge">Delete</span>
                        <span class="pointer" data-public_key="${data.public_key}" data-device_type="${data.device_type}" data-device_name="${data.device_name}" data-action="delete" onclick=deleteAction(this) data-modal_target="viewdeviceModal"><i class="bi bi-trash fs-6"></i></span>   
                    </div>
                </div>`;
        $("#devices_list").append($device);
        modal.hide();
        swal({
            title: data.message,
            text: "",
            icon: "success",
            button: {
                text: "Ok",
                value: true,
                visible: true,
                className: "bg-first",
                closeModal: true
            }
        });
    }

    function deviceAction(event){
        // var action = $(event).attr('data-action');
        // if(action=="edit"){
        //     var public_key = $(event).attr('data-public_key');
        //     var device_type = $(event).attr('data-device_type');
        //     var device_name = $(event).attr('data-device_name');
        //     var input = document.createElement("input");
        //     input.value = public_key;
        //     input.setAttribute("name", "old_public_key");
        //     input.setAttribute("type", "hidden");
        //     $("#device").append(input);
        //     $("#device #public_key").val(public_key);
        //     $("#device #device_name").val(device_name);
        //     $("#device #device_type").val(device_type.toLowerCase());
        // }else{
            // if($('input[name="old_public_key"]').length > 0){
            //     $('input[name="old_public_key"]').remove();
            // }
        //     $("#device").trigger("reset");
        // }
        $("#device").trigger("reset");
        modal.show();
    }

    function deleteAction(event){
        var public_key = $(event).attr('data-public_key');
        var _token = $('input[name="_token"]').val();
        var data = {
            public_key: public_key,
            _token: _token,
        };
        swal({
            title: "Are you sure about the deletion?",
            text: "",
            icon: "warning",
            buttons: {
                cancel: "cancel",
                confirm: {
                    text: "confirm",
                    className: "bg-danger"
                }
            },
            dangerMode: true,
        }).then(function(confirm){
            if(confirm){
                $.ajax({
                    type: "POST",
                    url: "{{route('devices.delete')}}",
                    data: data,
                    success: function (response) {
                        var data = response;
                        $(event).closest('div.device').remove();
                        swal({
                            title: data.message,
                            text: "",
                            icon: "success",
                            button: {
                                text: "Ok",
                                value: true,
                                visible: true,
                                className: "bg-first",
                                closeModal: true
                            }
                        });
                    },
                    error: function(response) {
                        var data = response.responseJSON;
                        swal({
                          title: data.message,
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
        });
    }

    function getConfig(event){
        var allowed_ip = $(event).attr("data-allowed_ip");
        var public_key = $(event).attr("data-public_key");
        var config = `[Interface]<br />PrivateKey = {your private key}<br />Address = ${allowed_ip}<br /><br />[Peer]<br />PublicKey = JTvjLkLrIjtpbPPYiRrZ9UJmFQJC1uaFYIHjEEv3MCI=<br />AllowedIPs = 10.8.0.2/24<br />Endpoint = 94.237.73.122:51820<br />PersistentKeepalive = 30`;
        $("#code").html(config);
        modal_1.show();
    }
</script>
@endsection