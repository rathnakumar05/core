<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Services;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use DB;
use Auth;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Core | Services";
        return view('services.index', compact('title'));
    }

    public function mysql()
    {
        $user_id = Auth::user()->id;
        $services = Services::where('user_id', (int)$user_id);
        $service_details = $services->first();
        $service_details = $service_details!=null ? $service_details->toArray() : [];
        $users = [];
        $databases = [];
        if(count($service_details)!=0 && isset($service_details["mysql"])){
            if(isset($service_details["mysql"]["users"])){
                $users = $service_details["mysql"]["users"];
            }
            if(isset($service_details["mysql"]["databases"])){
                $databases = $service_details["mysql"]["databases"];    
            }
        }
        $title = "Core | Services | Mysql";
        return view('services.mysql', compact('users', 'databases', 'title'));
    }

    public function mysqladdu(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:50', 'min:2'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        if (isset($validator) && $validator->fails()) {    
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        $username = trim(Str::lower($request->username));
        $password = trim($request->password);
        $user_details = array("username" => $username, "password" => $password);
        $user_id = Auth::user()->id;
        $services_obj = new Services();
        $services = Services::where('user_id', (int)$user_id);
        $service_details = $services->first();
        $service_details = $service_details!=null ? $service_details->toArray() : [];

        if(isset($service_details["mysql"]["users"]) && count($service_details["mysql"]["users"]) >= 4){
            $res = array(
                "result" => "error",
                "message" => "User addition exceeds the limit"
            );
            return response()->json($res, Response::HTTP_BAD_REQUEST);
        }
        $check_user = DB::connection('mysqlser')->select("SELECT * FROM mysql.user WHERE user='$username'");
        if(count($check_user)!=0){
            $res = array(
                "result" => "error",
                "message" => "User already exist"
            );
            return response()->json($res, Response::HTTP_BAD_REQUEST);
        }
        $add_user = DB::connection('mysqlser')->statement("CREATE USER '$username'@'%' IDENTIFIED BY '$password'");
        if($add_user===true){
            if(count($service_details)!=0){
                if(isset($service_details["mysql"])){
                    if(isset($service_details["mysql"]["users"])){
                        if($services->push("mysql.users", $user_details)){
                            $res = array(
                                "result" => "success",
                                "message" => "user added!!"
                            );
                            return response()->json($res, Response::HTTP_CREATED);
                        }else{
                            $res = array(
                                "result" => "error",
                                "message" => "something went wrong!!"
                            );
                            return response()->json($res, Response::HTTP_BAD_REQUEST);
                        }
                    }else{
                        $data = array(
                            "mysql.users" => array(
                                $user_details
                            )
                        );
                        if($services->update($data, ['upsert' => true])){
                            $res = array(
                                "result" => "success",
                                "message" => "user added!!"
                            );
                            return response()->json($res, Response::HTTP_CREATED);
                        }else{
                            $res = array(
                                "result" => "error",
                                "message" => "something went wrong!!"
                            );
                            return response()->json($res, Response::HTTP_BAD_REQUEST);
                        }
                    }
                }else{
                    $data = array(
                        "mysql.users" => array(
                            $user_details
                        )
                    );
                    if($services->update($data, ['upsert' => true])){
                        $res = array(
                            "result" => "success",
                            "message" => "user added!!"
                        );
                        return response()->json($res, Response::HTTP_CREATED);
                    }else{
                        $res = array(
                            "result" => "error",
                            "message" => "something went wrong!!"
                        );
                        return response()->json($res, Response::HTTP_BAD_REQUEST);
                    }
                }
            }else{
                $services_obj->user_id = $user_id;
                $services_obj->mysql = array(
                    "users" => array(
                        $user_details
                    ),
                );
                if($services_obj->save()){
                    $res = array(
                        "result" => "success",
                        "message" => "user added!!"
                    );
                    return response()->json($res, Response::HTTP_CREATED);
                }else{
                    $res = array(
                        "result" => "error",
                        "message" => "something went wrong!!"
                    );
                    return response()->json($res, Response::HTTP_BAD_REQUEST);
                }
            }

        }
    }

    public function mysqladdd(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:50', 'min:2'],
            'dbname' => ['required', 'string', 'max:50', 'min:2'],
        ]);
        if (isset($validator) && $validator->fails()) {    
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $username = trim(Str::lower($request->username));
        $db_name = trim(Str::lower($request->dbname));
        $user_id = Auth::user()->id;
        $user_name = Auth::user()->name;
        $db_name = $user_name."_".$db_name;
        $db_details = array("username" => $username, "db_name" => $db_name);
        $services_obj = new Services();
        $services = Services::where('user_id', (int)$user_id);
        $service_details = $services->first();
        $service_details = $service_details!=null ? $service_details->toArray() : [];

        if(isset($service_details["mysql"]["databases"]) && count($service_details["mysql"]["databases"]) >=4 ){
            $res = array(
                "result" => "error",
                "message" => "Database addition exceeds the limit"
            );
            return response()->json($res, Response::HTTP_BAD_REQUEST);
        }

        $check_db = DB::connection('mysqlser')->select("SELECT * FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$db_name'");
        if(count($check_db)!=0){
            $res = array(
                "result" => "error",
                "message" => "Database already exist !!"
            );
            return response()->json($res, Response::HTTP_BAD_REQUEST);
        }
        $create_db = DB::connection('mysqlser')->statement("CREATE DATABASE $db_name");
        if($create_db!==true){
            $res = array(
                "result" => "error",
                "message" => "something went wrong!!"
            );
            return response()->json($res, Response::HTTP_BAD_REQUEST);
        }
        $add_db = DB::connection('mysqlser')->statement("GRANT ALL PRIVILEGES ON $db_name.* TO '$username'@'%' WITH GRANT OPTION");
        if($add_db===true){
            if(count($service_details)!=0){
                if(isset($service_details["mysql"])){
                    if(isset($service_details["mysql"]["databases"])){
                        if($services->push("mysql.databases", $db_details)){
                            $res = array(
                                "result" => "success",
                                "message" => "Database added!!"
                            );
                            return response()->json($res, Response::HTTP_CREATED);
                        }else{
                            $res = array(
                                "result" => "error",
                                "message" => "something went wrong!!"
                            );
                            return response()->json($res, Response::HTTP_BAD_REQUEST);
                        }
                    }else{
                        $data = array(
                            "mysql.databases" => array(
                                    $db_details
                                )
                        );
                        if($services->update($data, ['upsert' => true])){
                            $res = array(
                                "result" => "success",
                                "message" => "Database added!!"
                            );
                            return response()->json($res, Response::HTTP_CREATED);
                        }else{
                            $res = array(
                                "result" => "error",
                                "message" => "something went wrong!!"
                            );
                            return response()->json($res, Response::HTTP_BAD_REQUEST);
                        }
                    }
                }else{
                    $data = array(
                        "mysql.databases" => array(
                                $db_details
                            )
                    );
                    if($services->update($data, ['upsert' => true])){
                        $res = array(
                            "result" => "success",
                            "message" => "Database added!!"
                        );
                        return response()->json($res, Response::HTTP_CREATED);
                    }else{
                        $res = array(
                            "result" => "error",
                            "message" => "something went wrong!!"
                        );
                        return response()->json($res, Response::HTTP_BAD_REQUEST);
                    }
                }
            }else{
                $services_obj->user_id = $user_id;
                $services_obj->mysql = array(
                    "databases" => array(
                        $db_details
                    ),
                );
                if($services_obj->save()){
                    $res = array(
                        "result" => "success",
                        "message" => "Database added!!"
                    );
                    return response()->json($res, Response::HTTP_CREATED);
                }else{
                    $res = array(
                        "result" => "error",
                        "message" => "something went wrong!!"
                    );
                    return response()->json($res, Response::HTTP_BAD_REQUEST);
                }
            }

        }else{
            $res = array(
                "result" => "error",
                "message" => "something went wrong !!"
            );
            return response()->json($res, Response::HTTP_BAD_REQUEST);
        }
    }

    public function mysqldelu(Request $request){
        $request->validate([
            'username' => ['required', 'string', 'max:50', 'min:2'],
        ]);
        if (isset($validator) && $validator->fails()) {    
            $res = array(
                "result" => "error",
                "message" => "something went wrong !!"
            );
            return response()->json($res, Response::HTTP_BAD_REQUEST);
        }
        $username = trim(Str::lower($request->username));
        $user_id = Auth::user()->id;
        $services_obj = new Services();
        $services = Services::where('user_id', (int)$user_id);
        $service_details = $services->first();
        $service_details = $service_details!=null ? $service_details->toArray() : [];

        if(count($service_details)!=0){
            if(isset($service_details["mysql"]["users"])){
                if(array_search($username, array_column($service_details["mysql"]["users"], "username"))!==false){
                    $check_user = DB::connection('mysqlser')->select("SELECT * FROM mysql.user WHERE user='$username'");
                    if(count($check_user)==0){
                        $res = array(
                            "result" => "error",
                            "message" => "User doesn't exist"
                        );
                        return response()->json($res, Response::HTTP_BAD_REQUEST);
                    }
                    $delete_user = DB::connection('mysqlser')->statement("DROP USER $username");
                    if($delete_user===true){
                        if($services->pull("mysql.users" , array( "username" => $username ))){
                            $res = array(
                                "result" => "success",
                                "message" => "User deleted successfully",
                            );
                            return response()->json($res, Response::HTTP_CREATED);
                        }else{
                            $res = array(
                                "result" => "error",
                                "message" => "something went wrong !!"
                            );
                            return response()->json($res, Response::HTTP_BAD_REQUEST);
                        }
                    }else{
                        $res = array(
                            "result" => "error",
                            "message" => "something went wrong !!"
                        );
                        return response()->json($res, Response::HTTP_BAD_REQUEST);
                    }
                }else{
                    $res = array(
                        "result" => "error",
                        "message" => "something went wrong !!"
                    );
                    return response()->json($res, Response::HTTP_BAD_REQUEST);
                }
            }else{
                $res = array(
                    "result" => "error",
                    "message" => "something went wrong !!"
                );
                return response()->json($res, Response::HTTP_BAD_REQUEST);
            }
        }else{
            $res = array(
                "result" => "error",
                "message" => "something went wrong !!"
            );
            return response()->json($res, Response::HTTP_BAD_REQUEST);
        }
    }

    public function mysqldeld(Request $request){
        $request->validate([
            'dbname' => ['required', 'string', 'max:50', 'min:2'],
        ]);
        if (isset($validator) && $validator->fails()) {    
            $res = array(
                "result" => "error",
                "message" => "something went wrong !!"
            );
            return response()->json($res, Response::HTTP_BAD_REQUEST);
        }

        $dbname = trim(Str::lower($request->dbname));
        $user_id = Auth::user()->id;
        $services_obj = new Services();
        $services = Services::where('user_id', (int)$user_id);
        $service_details = $services->first();
        $service_details = $service_details!=null ? $service_details->toArray() : [];

        if(count($service_details)!=0){
            if(isset($service_details["mysql"]["databases"])){
                if(array_search($dbname, array_column($service_details["mysql"]["databases"], "db_name"))!==false){
                    $delete_db = DB::connection('mysqlser')->statement("DROP DATABASE $dbname");
                    if($delete_db===true){
                        if($services->pull("mysql.databases" , array( "db_name" => $dbname ))){
                            $res = array(
                                "result" => "success",
                                "message" => "User deleted successfully",
                            );
                            return response()->json($res, Response::HTTP_CREATED);
                        }else{
                            $res = array(
                                "result" => "error",
                                "message" => "something went wrong !!"
                            );
                            return response()->json($res, Response::HTTP_BAD_REQUEST);
                        }
                    }else{
                        $res = array(
                            "result" => "error",
                            "message" => "something went wrong !!"
                        );
                        return response()->json($res, Response::HTTP_BAD_REQUEST);
                    }
                }else{
                    $res = array(
                        "result" => "error",
                        "message" => "something went wrong !!"
                    );
                    return response()->json($res, Response::HTTP_BAD_REQUEST);
                }
            }else{
                $res = array(
                    "result" => "error",
                    "message" => "something went wrong !!"
                );
                return response()->json($res, Response::HTTP_BAD_REQUEST);
            }
        }else{
            $res = array(
                "result" => "error",
                "message" => "something went wrong !!"
            );
            return response()->json($res, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
