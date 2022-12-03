<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Network;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Support\Str;
use Auth;

class MachinesController extends Controller
{
    public $machine_cmds = array(
        "deploy" => "sudo python3 /root/core_py/core.py --action deploy --machine %s --user %s",
        "shutdown" => "sudo python3 /root/core_py/core.py --action shutdown --cont_id %s",
        "delete" => "sudo python3 /root/core_py/core.py --action delete --cont_id %s",
        "start" => "sudo python3 /root/core_py/core.py --action start --cont_id %s",
        "remove" => "sudo python3 /root/core_py/core.py --action remove --peer %s",
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
        $machines = Network::where('user_id', $user_id)->where('peer_type', 'CNPEER')->get()->toArray();
        $ubuntu = null;
        $debian = null;
        foreach($machines as $machine){
            if($machine["container_name"]=="ubuntu"){
                $ubuntu = $machine;
            }
            if($machine["container_name"]=="debian"){
                $debian = $machine;
            }
        }
        $title = "Core | Machines";
        return view('machines.index', compact('ubuntu', 'debian', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function action(Request $request)
    {
        $action = trim($request->action);
        $machine = trim($request->machine);
        $action_check = array( "deploy", "shutdown", "redeploy", "delete" );
        $machine_check = array( "ubuntu", "debian" );
        if(!in_array($action, $action_check)){
            $res = array(
                "result" => "error",
                "message" => "Something went wrong"
            );
            return response()->json($res, Response::HTTP_BAD_REQUEST);
        }
        if(!in_array($machine, $machine_check)){
            $res = array(
                "result" => "error",
                "message" => "Something went wrong"
            );
            return response()->json($res, Response::HTTP_BAD_REQUEST);
        }
        $user_id = Auth::user()->id;
        $user_name = Auth::user()->name;
        $user_name = Str::slug($user_name, "_");
        if($action=="deploy"){
            $network = Network::where('user_id', $user_id)->where('container_name', $machine);
            $machine_details = $network->first();
            $machine_details = $machine_details!=null ? $machine_details->toArray() : [];
            if(count($machine_details)!=0 && $machine_details["container_status"]!="STOPPED"){
                $res = array(
                    "result" => "error",
                    "message" => "Something went wrong"
                );
                return response()->json($res, Response::HTTP_BAD_REQUEST);
            }else{
                if(isset($machine_details["container_status"]) && $machine_details["container_status"]=="STOPPED"){
                    $container_id = $machine_details["container_id"];
                    $deploy_cmd = sprintf($this->machine_cmds["start"], $container_id);
                    $deploy_cmd = Str::replace(array("|", "&", '>', '<'), "", $deploy_cmd);
                    $deploy_cmd = explode(" ", $deploy_cmd);
                    $deploy_res = json_decode(Str::replace(array("\n", "\r"), "", $this->exec($deploy_cmd)), true);
                    if(isset($deploy_res["status"]) && $deploy_res["status"]=="SUCCESS"){
                        $data = array(
                            "container_status" => "RUNNING",
                        );
                        if($network->update($data, array('upsert' => true))){
                            $res = array(
                                "result" => "success",
                                "message" => "Deployed successfully"
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

                }
            }
            $deploy_cmd = sprintf($this->machine_cmds["deploy"], $machine, $user_name);
            $deploy_cmd = Str::replace(array("|", "&", '>', '<'), "", $deploy_cmd);
            $deploy_cmd = explode(" ", $deploy_cmd);
            $deploy_res = json_decode(Str::replace(array("\n", "\r"), "", $this->exec($deploy_cmd)), true);
            if(isset($deploy_res["status"]) && $deploy_res["status"]=="SUCCESS"){
                $allowed_ip = $deploy_res["machine_details"]["allowed_ip"];
                $container_id = $deploy_res["machine_details"]["container_id"];
                $machine = $deploy_res["machine_details"]["machine"];
                $public_key = $deploy_res["machine_details"]["public_key"];
                $data = array(
                    "peer_type" => "CNPEER",
                    "device_type" => null,
                    "device_name" => null,
                    "allowed_ip" => $allowed_ip,
                    "container_id" => $container_id,
                    "container_name" => $machine,
                    "user_name" => $user_name,
                    "container_status" => "RUNNING",
                    "created_at" => new \MongoDB\BSON\UTCDateTime(new \DateTime())
                );
                if(Network::where("user_id", $user_id)->where("public_key", $public_key)->update($data, array('upsert' => true))){
                    $res = array(
                        "result" => "success",
                        "message" => "Deployed successfully",
                        "allowed_ip" => $allowed_ip,
                        "user_name" => $user_name,
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
        }else if($action=="shutdown"){
            $network = Network::where("user_id", $user_id)->where("container_name", $machine)->first();
            $machine_details = $network!=null ? $network->toArray() : [];
            if(count($machine_details)==0){
                $res = array(
                    "result" => "error",
                    "message" => "Something went wrong"
                );
                return response()->json($res, Response::HTTP_BAD_REQUEST);
            }
            $container_id = trim($machine_details['container_id']);
            $shutdown_cmd = sprintf($this->machine_cmds["shutdown"], $container_id);
            $shutdown_cmd = Str::replace(array("|", "&", '>', '<'), "", $shutdown_cmd);
            $shutdown_cmd = explode(" ", $shutdown_cmd);
            $shutdown_res = json_decode(Str::replace(array("\n", "\r"), "", $this->exec($shutdown_cmd)), true);
            if(isset($shutdown_res["status"]) && ($shutdown_res["status"]=="SUCCESS")){
                $data = array(
                    "container_status" => "STOPPED",
                );
                if(Network::where("user_id", $user_id)->where("container_name", $machine)->update($data, array('upsert' => true))){
                    $res = array(
                        "result" => "success",
                        "message" => "Stopped successfully"
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
        }else if($action=="redeploy"){
            $network = Network::where("user_id", $user_id)->where("container_name", $machine)->first();
            $machine_details = $network!=null ? $network->toArray() : [];
            if(count($machine_details)==0){
                $res = array(
                    "result" => "error",
                    "message" => "Something went wrong"
                );
                return response()->json($res, Response::HTTP_BAD_REQUEST);
            }
            $container_id = trim($machine_details['container_id']);
            $public_key = trim($machine_details["public_key"]);

            $flag = 0;

            //pr --> peer
            $pr_rm_cmd = sprintf($this->machine_cmds["remove"], $public_key);
            $pr_rm_cmd = Str::replace(array("|", "&", '>', '<'), "", $pr_rm_cmd);
            $pr_rm_cmd = explode(" ", $pr_rm_cmd);
            $pr_rm_res = json_decode(Str::replace(array("\n", "\r"), "", $this->exec($pr_rm_cmd)), true);

            if(!isset($pr_rm_res["status"]) && ($pr_rm_res["status"]!="SUCCESS")){
                $flag = 1;
            }

            $delete_cmd = sprintf($this->machine_cmds["delete"], $container_id);
            $delete_cmd = Str::replace(array("|", "&", '>', '<'), "", $delete_cmd);
            $delete_cmd = explode(" ", $delete_cmd);
            $delete_res = json_decode(Str::replace(array("\n", "\r"), "", $this->exec($delete_cmd)), true);

            if(!isset($delete_res["status"]) && ($delete_res["status"]!="SUCCESS")){
                $flag = 1;
            }

            $deploy_cmd = sprintf($this->machine_cmds["deploy"], $machine, $user_name);
            $deploy_cmd = Str::replace(array("|", "&", '>', '<'), "", $deploy_cmd);
            $deploy_cmd = explode(" ", $deploy_cmd);
            $deploy_res = json_decode(Str::replace(array("\n", "\r"), "", $this->exec($deploy_cmd)), true);

            if(!isset($deploy_res["status"]) && ($deploy_res["status"]!="SUCCESS")){
                $flag = 1;
            }

            if(isset($deploy_res["status"]) && $deploy_res["status"]=="SUCCESS" && $flag==0){
                $allowed_ip = $deploy_res["machine_details"]["allowed_ip"];
                $container_id = $deploy_res["machine_details"]["container_id"];
                $machine = $deploy_res["machine_details"]["machine"];
                $public_key = $deploy_res["machine_details"]["public_key"];
                $data = array(
                    "public_key" => $public_key,
                    "peer_type" => "CNPEER",
                    "device_type" => null,
                    "device_name" => null,
                    "allowed_ip" => $allowed_ip,
                    "container_id" => $container_id,
                    "container_name" => $machine,
                    "user_name" => $user_name,
                    "container_status" => "RUNNING",
                );
                if($network->update($data, array('upsert' => true))){
                    $res = array(
                        "result" => "success",
                        "message" => "Redeployed successfully",
                        "allowed_ip" => $allowed_ip,
                        "user_name" => $user_name,
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
        }else if($action=="delete"){
            $network = Network::where("user_id", $user_id)->where("container_name", $machine)->first();
            $machine_details = $network ? $network->toArray() : [];
            $container_id = trim($machine_details['container_id']);
            $public_key = trim($machine_details["public_key"]);

            $flag = 0;

            $pr_rm_cmd = sprintf($this->machine_cmds["remove"], $public_key);
            $pr_rm_cmd = Str::replace(array("|", "&", '>', '<'), "", $pr_rm_cmd);
            $pr_rm_cmd = explode(" ", $pr_rm_cmd);
            $pr_rm_res = json_decode(Str::replace(array("\n", "\r"), "", $this->exec($pr_rm_cmd)), true);

            if(!isset($pr_rm_res["status"]) && ($pr_rm_res["status"]!="SUCCESS")){
                $flag = 1;
            }

            $delete_cmd = sprintf($this->machine_cmds["delete"], $container_id);
            $delete_cmd = Str::replace(array("|", "&", '>', '<'), "", $delete_cmd);
            $delete_cmd = explode(" ", $delete_cmd);
            $delete_res = json_decode(Str::replace(array("\n", "\r"), "", $this->exec($delete_cmd)), true);

            if(!isset($delete_res["status"]) && ($delete_res["status"]!="SUCCESS")){
                $flag = 1;
            }

            if($flag==0){
                if($network->delete()){
                    $res = array(
                        "result" => "success",
                        "message" => "Deleted successfully"
                    );
                    return response()->json($res, Response::HTTP_CREATED);
                }else{
                    $res = array(
                        "result" => "error",
                        "message" => "Something went wrong"
                    );
                    return response()->json($res, Response::HTTP_BAD_REQUEST);   
                }
            }
        }
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
