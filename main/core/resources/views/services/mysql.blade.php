@extends("layouts.app")
@section('header')
<div>
    <h1>Mysql</h1>
</div>
@endsection

@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="card">
         <div class="card-body">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
               <div class="d-flex flex-wrap align-items-center">
                  <div class="profile-img position-relative me-3 mb-3 mb-lg-0 profile-logo profile-logo1">
                     <img src="{{asset('/assets/images/core/logo/mysql.png')}}" alt="User-Profile" class="theme-color-default-img img-fluid rounded-pill avatar-100">
                  </div>
                  <div class="d-flex flex-wrap align-items-center mb-3 mb-sm-0">
                     <h4 class="me-2 h4">Mysql</h4>
                     <span> - Relational Database</span>
                  </div>
               </div>
               <ul class="d-flex nav nav-pills mb-0 text-center profile-tab" data-toggle="slider-tab" id="profile-pills-tab" role="tablist">
                  <li class="nav-item">
                     <a class="nav-link active show" data-bs-toggle="tab" href="#general" role="tab" aria-selected="false">General</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" data-bs-toggle="tab" href="#user" role="tab" aria-selected="false">User & Database</a>
                  </li>
               </ul>
            </div>
         </div>
      </div>
      <div class="col-lg-12">
         <div class="profile-content tab-content">
            <div id="general" class="tab-pane fade active show">
               <div class="card">
                  <div class="card-header">
                     <div class="header-title">
                        <h4 class="card-title">Basic commands</h4>
                     </div>
                  </div>
                  <div class="card-body">
                     <div class="user-bio">
                        <p>SELECT - extracts data from a database</p>
                     </div>
                     <div class="user-bio">
                        <p>UPDATE - updates data in a database</p>
                     </div>
                     <div class="user-bio">
                        <p>DELETE - deletes data from a database</p>
                     </div>
                     <div class="user-bio">
                        <p>INSERT INTO - inserts new data into a database</p>
                     </div>
                     <div class="user-bio">
                        <p>CREATE DATABASE - creates a new database</p>
                     </div>
                     <div class="user-bio">
                        <p>ALTER DATABASE - modifies a database</p>
                     </div>
                     <div class="user-bio">
                        <p>CREATE TABLE - creates a new table</p>
                     </div>
                     <div class="user-bio">
                        <p>ALTER TABLE - modifies a table</p>
                     </div>
                     <div class="user-bio">
                        <p>DROP TABLE - deletes a table</p>
                     </div>
                     <div class="user-bio">
                        <p>CREATE INDEX - creates an index (search key)</p>
                     </div>
                     <div class="user-bio">
                        <p>DROP INDEX - deletes an index</p>
                     </div>
                  </div>
               </div>
            </div>
            <div id="user" class="tab-pane fade">
               <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">Add User (<span id="users_count">{{count($users)}}</span>/4)</h4>
                     </div>
                  </div>
                  <div class="card-body">
                    <form class="w-50" id="user_form" method="POST" action="{{route('services.mysqladdu')}}" >
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="email">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" >
                            <div id="username-err" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="pwd">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" >
                            <div id="password-err" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="pwd">Confirm Password:</label>
                            <input type="password" class="form-control" id="cpassword" name="password_confirmation" >
                            <div id="cpassword-err" class="invalid-feedback"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
               </div>
               <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">List Users</h4>
                     </div>
                  </div>
                  <div class="card-body" id="users_list">
                     @foreach ($users as $user)
                     <div class="p-4 border rounded d-flex justify-content-between align-items-center mb-2 user_list">
                        <div class="">
                           <label class="form-label">Username:</label>
                           <div class="input-group">
                              <span class="input-group-text">@</span>
                              <input type="text" class="form-control" value="{{$user["username"]}}" readonly>
                           </div>
                        </div>
                        <div>
                           <label class="form-label">Password:</label>
                           <div class="input-group">
                              <span class="input-group-text">@</span>
                              <input type="password" class="form-control" value="{{$user["password"]}}" readonly>
                           </div>
                        </div>
                        <div>
                        <button class="p-2 btn btn-danger text-uppercase" data-username="{{$user["username"]}}" onclick=deleteUser(this)>Delete</button>
                        </div>
                     </div>
                     @endforeach
                  </div>
               </div>
               <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">Add Database (<span id="db_count" >{{count($databases)}}</span>/4)</h4>
                     </div>
                  </div>
                  <div class="card-body">
                    <form class="w-50" id="db_form" method="POST" action="{{route('services.mysqladdd')}}" >
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="email">User:</label>
                            <select type="text" class="form-control" id="user_name" name="username" >
                            <option value="" selected>Select user</option>
                            @foreach ($users as $user)
                            <option value="{{$user["username"]}}" >{{$user["username"]}}</option>
                            @endforeach
                            </select>
                            <div id="user_name-err" class="invalid-feedback" ></div>
                        </div>
                        <label class="form-label">Database name:</label>
                        <div class="input-group mb-3">
                           <span class="input-group-text">{{Auth::user()->name}}_</span>
                           <input type="text" class="form-control" id="dbname" name="dbname">
                           <div id="dbname-err" class="invalid-feedback" ></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
               </div>
               <div class="card">
                  <div class="card-header d-flex justify-content-between">
                     <div class="header-title">
                        <h4 class="card-title">List Database</h4>
                     </div>
                  </div>
                  <div class="card-body" id="db_list">
                     @foreach($databases as $database)
                     <div class="p-4 border rounded d-flex justify-content-between align-items-center mb-2 db_list">
                        <div class="">
                           <label class="form-label">Username:</label>
                           <div class="input-group">
                              <span class="input-group-text">@</span>
                              <input type="text" class="form-control" value="{{$database["username"]}}" readonly>
                           </div>
                        </div>
                        <div>
                           <label class="form-label">Database name:</label>
                           <div class="input-group">
                              <span class="input-group-text">@</span>
                              <input type="text" class="form-control" value="{{$database["db_name"]}}" readonly>
                           </div>
                        </div>
                        <div>
                        <button class="p-2 btn btn-danger text-uppercase" data-dbname="{{$database["db_name"]}}" onclick="deleteDB(this)" >Delete</button>
                        </div>
                     </div>
                     @endforeach
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section("js")
<script>
   $().ready(function() {
        $("#user_form").validate({
            errorClass: "is-invalid",
            validClass: 'is-valid',
            errorElement: 'div',
		    	rules: {
		    		username: {
		    			required: true,
		    			minlength: 2,
		    		},
		    		password: {
		    			required: true,
		    			minlength: 8,
		    		},
		    		password_confirmation: {
		    			required: true,
		    			minlength: 8,
		    			equalTo: "#password"
		    		}
		    	},
            errorPlacement: function(error, element) {
               var id = $(element).attr('id');
               var selector = `#${id}-err`;
               $(selector).html(error);

            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        var data = response;
                        if(data.result=="success"){
                           var username = $(`#user_form input[name="username"]`).val().toLowerCase();
                           var password = $(`#user_form input[name="password"]`).val();
                           var list = `<div class="p-4 border rounded d-flex justify-content-between align-items-center mb-2 user_list">
                                       <div class="">
                                          <label class="form-label">Username:</label>
                                          <div class="input-group">
                                             <span class="input-group-text">@</span>
                                             <input type="text" class="form-control" value="${username}" readonly>
                                          </div>
                                       </div>
                                       <div>
                                          <label class="form-label">Password:</label>
                                          <div class="input-group">
                                             <span class="input-group-text">@</span>
                                             <input type="password" class="form-control" value="${password}" readonly>
                                          </div>
                                       </div>
                                       <div>
                                       <button class="p-2 btn btn-danger text-uppercase" data-username="${username}" onclick="deleteUser(this)" >Delete</button>
                                       </div>
                                    </div>`;
                           $("#users_list").append(list);
                           $("#user_name").append(`<option value="${username}">${username}</option>`);
                           $("#users_count").html($(".user_list").length)
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
                        }else if(data.result=="error"){
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
                           swal({
                                 title: "something went wrong !!",
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
                     }        
                });
            }
        });
        $("#db_form").validate({
            errorClass: "is-invalid",
            validClass: 'is-valid',
            errorElement: 'div',
		    	rules: {
               username: {
		    			required: true,
		    		},
		    		dbname: {
		    			required: true,
		    			minlength: 2,
		    		},
		    	},
            errorPlacement: function(error, element) {
               var id = $(element).attr('id');
               var selector = `#${id}-err`;
               $(selector).html(error);

            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        var data = response;
                        if(data.result=="success"){
                           var username = $('#db_form select').find(":selected").text().toLowerCase();
                           var database = "{{Auth::user()->name}}_"+$('#db_form input[name="dbname"]').val().toLowerCase();
                           var list = `<div class="p-4 border rounded d-flex justify-content-between align-items-center mb-2 db_list">
                                       <div class="">
                                          <label class="form-label">Username:</label>
                                          <div class="input-group">
                                             <span class="input-group-text">@</span>
                                             <input type="text" class="form-control" value="${username}" readonly>
                                          </div>
                                       </div>
                                       <div>
                                          <label class="form-label">Database name:</label>
                                          <div class="input-group">
                                             <span class="input-group-text">@</span>
                                             <input type="text" class="form-control" value="${database}" readonly>
                                          </div>
                                       </div>
                                       <div>
                                       <button class="p-2 btn btn-danger text-uppercase" data-dbname="${database}" onclick="deleteDB(this)" >Delete</button>
                                       </div>
                                    </div>`;
                           $("#db_list").append(list);
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
                        }else if(data.result=="error"){
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
                           swal({
                                 title: "something went wrong !!",
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
                     }        
                });
            }
        });
    });
</script>
<script>
   function deleteUser(event){
      var username = $(event).attr("data-username").toLowerCase();
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
               url: '{{route("services.mysqldelu")}}',
               type: 'POST',
               data: { "_token": "{{ csrf_token() }}", "username": username},
               success: function(response) {
                  $(event).closest(".user_list").remove();
                  $(`#user_name option[value="${username}"]`).remove();
                  var data = response;
                  if(data.result=="success"){
                     $("#users_count").html($(".user_list").length)
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
                  }else if(data.result=="error"){
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
                  }
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
               }
            });
         }
      });
   }

   function deleteDB(event){
      var dbname = $(event).attr("data-dbname").toLowerCase();
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
               url: '{{route("services.mysqldeld")}}',
               type: 'POST',
               data: { "_token": "{{ csrf_token() }}", "dbname": dbname},
               success: function(response) {
                  $(event).closest(".db_list").remove();
                  var data = response;
                  if(data.result=="success"){
                     $("#db_count").html($(".db_list").length)
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
                  }else if(data.result=="error"){
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
                  }
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
               }
            });
         }
      });
   }
</script>
@endsection


