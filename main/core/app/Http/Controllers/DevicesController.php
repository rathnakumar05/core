<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Devices;
use App\Models\Network;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Support\Str;
use Auth;

class DevicesController extends Controller
{
    public $peer_cmds = array(
        "check_peer" => "sudo /bin/python3 /root/core_py/core.py --action check --peerchk %s",
        "peer_add" => "sudo /bin/python3 /root/core_py/core.py --action add --peer %s",
        "peer_remove" => "sudo /bin/python3 /root/core_py/core.py --action remove --peer %s",
    );

    public function exec($cmd){
        $process = new Process($cmd);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return $process->getOutput();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $devices = Devices::where('user_id', $user_id);
        $devices_get = $devices->get()->toArray();
        $devices = array();
        if(!empty($devices_get)){
            $devices = $devices_get[0]["devices"];
        }
        $title = "Core | Devices";
        return view('devices.index', compact('devices', 'title'));
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
        $request->validate([
            'public_key' => ['required', 'string', 'max:50', 'min:2'],
            'device_type' => ['required', 'string', 'max:50'],
            'device_name' => ['required', 'string', 'max:50', 'min:2'],
        ]);
        if (isset($validator) && $validator->fails()) {    
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        $public_key = trim($request->public_key);
        $device_type = trim($request->device_type);
        $device_name = trim($request->device_name);
        $user_id = Auth::user()->id;
        $devices = Devices::where('user_id', (int)$user_id);
        $devices_get = $devices->get()->toArray();
        if(empty($devices_get)){
            $pr_chk_cmd = sprintf($this->peer_cmds["check_peer"], $public_key);
            $pr_chk_cmd = Str::replace(array("|", "&", '>', '<'), "", $pr_chk_cmd);
            $pr_chk_cmd = explode(" ", $pr_chk_cmd);
            $pr_chk_res = json_decode(Str::replace(array("\n", "\r"), "", $this->exec($pr_chk_cmd)), true);
            if(isset($pr_chk_res["status"]) && $pr_chk_res["status"]=="ERROR"){
                $pr_add_cmd = sprintf($this->peer_cmds["peer_add"], $public_key);
                $pr_add_cmd = Str::replace(array("|", "&", '>', '<'), "", $pr_add_cmd);
                $pr_add_cmd = explode(" ", $pr_add_cmd);
                $pr_add_res = json_decode(Str::replace(array("\n", "\r"), "", $this->exec($pr_add_cmd)), true);
                if(isset($pr_add_res["status"]) && $pr_add_res["status"]=="SUCCESS"){
                    $allowed_ip = $pr_add_res["peer_details"]["allowed_ip"];
                    $public_key = $pr_add_res["peer_details"]["public_key"];
                    $device = array(
                        "public_key" => $public_key,
                        "device_name" => $device_name,
                        "device_type" => $device_type,
                        "allowed_ip" => $allowed_ip,
                    );
                    $devices = new Devices();
                    $devices->user_id = $user_id;
                    $devices->devices = array(
                        $device
                    );
                    if($devices->save()){
                        $data = array(
                            "peer_type" => "RLPEER", //real peer
                            "device_type" => $device_type,
                            "device_name" => $device_name,
                            "allowed_ip" => $allowed_ip,
                            "container_id" => null,
                            "container_name" => null,
                            "container_status" => null,
                            "created_at" => new \MongoDB\BSON\UTCDateTime(new \DateTime())
                        );
                        Network::where("user_id", $user_id)->where("public_key", $public_key)->update($data, array('upsert' => true));
                        $res = array(
                            "result" => "success",
                            "message" => "Device addded successfully",
                            "allowed_ip" => $allowed_ip,
                            "public_key" => $public_key,
                            "device_name" => $device_name,
                            "device_type" => $device_type,
                        );
                        return response()->json($res, Response::HTTP_CREATED);
                    }else{
                        $res = array(
                            "result" => "error",
                            "message" => "Something went wrong"
                        );
                        return response()->json($res, Response::HTTP_BAD_REQUEST);
                    }
                }else{
                    $res = array(
                        "result" => "error",
                        "message" => "Something went wrong"
                    );
                    return response()->json($res, Response::HTTP_BAD_REQUEST);
                }
            }else{
                $res = array(
                    "result" => "error",
                    "message" => "Device already added"
                );
                return response()->json($res, Response::HTTP_BAD_REQUEST);
            }
        }else{
            $devices = $devices_get[0]["devices"];
            $key = array_search($public_key, array_column($devices, 'public_key'));
            if(!($key===false)){
                $res = array(
                    "result" => "error",
                    "message" => "Device already added"
                );
                return response()->json($res, Response::HTTP_BAD_REQUEST);
            }else{
                $pr_chk_cmd = sprintf($this->peer_cmds["check_peer"], $public_key);
                $pr_chk_cmd = Str::replace(array("|", "&", '>', '<'), "", $pr_chk_cmd);
                $pr_chk_cmd = explode(" ", $pr_chk_cmd);
                $pr_chk_res = json_decode(Str::replace(array("\n", "\r"), "", $this->exec($pr_chk_cmd)), true);
                if(isset($pr_chk_res["status"]) && $pr_chk_res["status"]=="ERROR"){
                    $pr_add_cmd = sprintf($this->peer_cmds["peer_add"], $public_key);
                    $pr_add_cmd = Str::replace(array("|", "&", '>', '<'), "", $pr_add_cmd);
                    $pr_add_cmd = explode(" ", $pr_add_cmd);
                    $pr_add_res = json_decode(Str::replace(array("\n", "\r"), "", $this->exec($pr_add_cmd)), true);
                    if(isset($pr_add_res["status"]) && $pr_add_res["status"]=="SUCCESS"){
                        $allowed_ip = $pr_add_res["peer_details"]["allowed_ip"];
                        $public_key = $pr_add_res["peer_details"]["public_key"];
                        $device = array(
                            "public_key" => $public_key,
                            "device_name" => $device_name,
                            "device_type" => $device_type,
                            "allowed_ip" => $allowed_ip,
                        );
                        $devices_res = Devices::where('user_id', $user_id)->push('devices', $device);
                        if($devices_res){
                            $data = array(
                                "peer_type" => "RLPEER",
                                "device_type" => $device_type,
                                "device_name" => $device_name,
                                "allowed_ip" => $allowed_ip,
                                "container_id" => null,
                                "container_name" => null,
                                "container_status" => null,
                                "created_at" => new \MongoDB\BSON\UTCDateTime(new \DateTime())
                            );
                            Network::where("user_id", $user_id)->where("public_key", $public_key)->update($data, array('upsert' => true));
                            $res = array(
                                "result" => "success",
                                "message" => "Device addded successfully",
                                "allowed_ip" => $allowed_ip,
                                "public_key" => $public_key,
                                "device_name" => $device_name,
                                "device_type" => $device_type,
                            );
                            return response()->json($res, Response::HTTP_CREATED);
                        }else{
                            $res = array(
                                "result" => "error",
                                "message" => "Something went wrong"
                            );
                            return response()->json($res, Response::HTTP_BAD_REQUEST);  
                        }
                    }else{
                        $res = array(
                            "result" => "error",
                            "message" => "Something went wrong"
                        );
                        return response()->json($res, Response::HTTP_BAD_REQUEST);  
                    }
                }else{
                    $res = array(
                        "result" => "error",
                        "message" => "Device already added"
                    );
                    return response()->json($res, Response::HTTP_BAD_REQUEST);
                }
            }
        }
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
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'public_key' => ['required', 'string', 'max:50'],
        ]);
        if (isset($validator) && $validator->fails()) {    
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }
        $public_key = trim($request->public_key);
        $user_id  = Auth::user()->id;
        $pr_chk_cmd = sprintf($this->peer_cmds["check_peer"], $public_key);
        $pr_chk_cmd = Str::replace(array("|", "&", '>', '<'), "", $pr_chk_cmd);
        $pr_chk_cmd = explode(" ", $pr_chk_cmd);
        $pr_chk_res = json_decode(Str::replace(array("\n", "\r"), "", $this->exec($pr_chk_cmd)), true);
        if(isset($pr_chk_res["status"]) && $pr_chk_res["status"]=="SUCCESS"){
            $pr_rm_cmd = sprintf($this->peer_cmds["peer_remove"], $public_key);
            $pr_rm_cmd = Str::replace(array("|", "&", '>', '<'), "", $pr_rm_cmd);
            $pr_rm_cmd = explode(" ", $pr_rm_cmd);
            $pr_rm_res = json_decode(Str::replace(array("\n", "\r"), "", $this->exec($pr_rm_cmd)), true);
            if(isset($pr_chk_res["status"]) && $pr_chk_res["status"]=="SUCCESS"){
                $result = Devices::where('user_id', $user_id)->pull("devices" , array( "public_key" => $public_key ));
                $result_1 = Network::where("user_id", $user_id)->where("public_key", $public_key)->delete();
                if($result){
                    $res = array(
                        "result" => "success",
                        "message" => "Device deleted successfully",
                    );
                    return response()->json($res, Response::HTTP_CREATED);
                }else{
                    $res = array(
                        "result" => "error",
                        "message" => "Something went wrong"
                    );
                    return response()->json($res, Response::HTTP_BAD_REQUEST); 
                }
            }else{
                $res = array(
                    "result" => "error",
                    "message" => "Something went wrong"
                );
                return response()->json($res, Response::HTTP_BAD_REQUEST); 
            }
        }else{
            $res = array(
                "result" => "error",
                "message" => "Something went wrong"
            );
            return response()->json($res, Response::HTTP_BAD_REQUEST); 
        }
    }
}
