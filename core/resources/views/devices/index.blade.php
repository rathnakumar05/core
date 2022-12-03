@extends("layouts.app")
@section('css')
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
@section('header')
<div>
    <h1>Devices</h1>
</div>
@endsection
@section('content')
<div class="row">
   <div id="devices_list">
   @foreach ($devices as $device)
      <div class="card col-md-12 col-lg-12 device" data-aos="fade-up" data-aos-delay="700">
         <div class="card-body row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 my-2">
               <div class="progress-widget">
                  <div class="text-center circle-progress-01 circle-progress circle-progress-primary" >
                  <img src="{{asset('/assets/images/core/logo/')}}{{$device["device_type"]=="laptop" ? "/laptop.png" : ($device["device_type"]=="pc" ? "/computer.png" : "/other.png")}}" />
                  </div>
                  <div class="progress-detail">
                     <p  class="mb-2">Device Name</p>
                     <h4 class="">{{$device["device_name"]}}</h4>
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
                     <h4 class="">{{Str::replace(array("/32"), "", $device["allowed_ip"])}}</h4>
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
                     <p  class="mb-2">Delete</p>
                  </div>
                  <div class="progress-detail">
                     <i class="bi bi-gear fs-6 d-block mb-2 pointer" data-allowed_ip="{{$device['allowed_ip']}}" data-public_key="{{$device['public_key']}}" data-action="config" onclick=getConfig(this)></i>
                     <i class="bi bi-trash fs-6 d-block mb-2 pointer" data-public_key="{{$device['public_key']}}" data-action="delete" onclick=deleteAction(this)></i>
                  </div>
               </div>
            </div>
         </div>
      </div>
   @endforeach
   </div>
   <div class="col-md-12 col-lg-12">
      <button class="btn btn-warning mb-2 w-100" data-action="modal" data-modal_target="viewdeviceModal" onclick=deviceAction(this) data-action="add" >Add New Device</button>
   </div>
</div>
@endsection
@section('modal')
<div class="modal right fade" id="viewdeviceModal" tabindex="-1" aria-labelledby="viewdeviceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content rounded-0 dark">
        <div class="modal-header border-0">
          <h5 class="modal-title" id="viewdeviceModalLabel">Add Device</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('devices.store')}}" method="POST" id="device">
            @csrf
            <div class="row m-0 mt-2">
               <div class="col-lg-12">
                  <div class="form-group">
                     <label for="full-name" class="form-label">Public key</label>
                     <input type="text" class="form-control" name="public_key" id="public_key" placeholder="" aria-label="Public key" aria-describedby="public key">
                     <div id="public_key-err" class="invalid-feedback"></div>
                  </div>
               </div>
               <div class="col-lg-12">
                  <div class="form-group">
                     <label for="full-name" class="form-label">Device Name</label>
                     <input type="text" class="form-control" name="device_name" id="device_name" placeholder="" aria-label="Device" aria-describedby="Device">
                     <div id="device_name-err" class="invalid-feedback"></div>
                  </div>
               </div>
               <div class="col-lg-12">
                  <div class="form-group">
                     <label for="full-name" class="form-label">Device Type</label>
                     <select type="text" class="form-control" name="device_type" id="device_type" aria-label="Device type" aria-describedby="Device type">
                        <option value="" selected class="d-none">Select Device</option>
                        <option value="pc">PC</option>
                        <option value="laptop">LAPTOP</option>
                        <option value="others">Others</option>   
                     </select>
                     <div id="device_type-err" class="invalid-feedback"></div>
                  </div>
               </div>
               <div class="d-flex justify-content-center mt-3">
                  <button type="submit" class="btn btn-primary w-100">ADD</button>
               </div>
            </div>
        </form>
      </div>
    </div>
</div>
<div class="modal fade" id="configModal" tabindex="-1" aria-labelledby="configModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
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
   var modal = new bootstrap.Modal(document.getElementById("viewdeviceModal"));
   var modal_1 = new bootstrap.Modal(document.getElementById("configModal"));
   $().ready(function() {
        $("#device").validate({
            errorClass: "is-invalid",
            validClass: 'is-valid',
            errorElement: 'div',
            rules: {
		    	public_key: {
		    		required: true,
		    		minlength: 2,
		    	},
		    	device_name: {
		    		required: true,
		    		minlength: 2,
		    	}
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
                                    $(`#${key}`).removeClass("is-valid");
                                    $(`#${key}-err`).html(value);
                                    $(`#${key}`).addClass("is-invalid");
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

   function deviceAction(event){
      $("#device").trigger("reset");
      $('#device input').removeClass('is-valid');
      $('#device input').removeClass('is-invalid');
      $('#device select').removeClass('is-valid');
      $('#device select').removeClass('is-invalid');
      modal.show();
   }

   function addDevice(data){
        var img = data.device_type=="laptop" ? `/laptop.png` : (data.device_type=="pc" ? `/computer.png` : `/other.png`);
        var device = `<div class="card col-md-12 col-lg-12 device" data-aos="fade-up" data-aos-delay="700">
                       <div class="card-body row">
                          <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 my-2">
                             <div class="progress-widget">
                                <div class="text-center circle-progress-01 circle-progress circle-progress-primary" >
                                <img src="{{asset('/assets/images/core/logo')}}${img}" />
                                </div>
                                <div class="progress-detail">
                                   <p  class="mb-2">Device Name</p>
                                   <h4 class="">${data.device_name}</h4>
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
                                   <h4 class="">${data.allowed_ip.replace('/32', '')}</h4>
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
                                   <p  class="mb-2">Delete</p>
                                </div>
                                <div class="progress-detail">
                                   <i class="bi bi-gear fs-6 d-block mb-2" data-allowed_ip="${data.allowed_ip}" data-public_key="${data.public_key}" data-action="config" onclick=getConfig(this) ></i>
                                   <i class="bi bi-trash fs-6 d-block mb-2" data-public_key="${data.public_key}" data-device_type="${data.device_type}" data-device_name="${data.device_name}" data-action="delete" onclick=deleteAction(this) data-modal_target="viewdeviceModal" ></i>
                                </div>
                             </div>
                          </div>
                       </div>
                  </div>`;
        $("#devices_list").append(device);
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
                                className: "dark",
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
                            className: "dark",
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
        var config = `[Interface]<br />PrivateKey = {your private key}<br />Address = ${allowed_ip}<br /><br />[Peer]<br />PublicKey = {{env('WG_HOST_PUB_KEY')}}<br />AllowedIPs = {{env('WG_HOST_IP')}}<br />Endpoint = {{env('WG_HOST_NAME')}}:{{env('WG_HOST_PORT')}}<br />PersistentKeepalive = 30`;
        $("#code").html(config);
        modal_1.show();
    }
</script>
@endsection