<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_Attributes;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserAttributesController extends Controller
{
    /**
     * Summary of index: get column names of table and sent it to front-end side 
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function index(Request $request)
    {       
        if ($request->ajax()) { 
           $data = User_Attributes::with('user'); 
                    
            return \Yajra\DataTables\DataTables::of($data)
                    ->addIndexColumn()                   
                    ->make(true);
        }
        
        return view('step4');
    }
    public function AddCredit(User $user)
    {         
       $msg="The Is A Problem";   
       $credit=[
        "old" =>"",
        "new" => ""
       ] ;  
       $user_attributes= User_Attributes::where('user_id',$user['id'])->first();
       $credit["old"]=$user_attributes->credit;
       $result=$user_attributes->update([
            "credit" => $user_attributes->credit +config('global.charge')
        ]);
        $credit["new"]=$user_attributes->credit;
       if($result){
        $msg="The user: ". $user->name." with id:".$user->id.PHP_EOL;
        $msg.="the value should be added is: " .config('global.charge') . PHP_EOL;
        $msg.="the old credit was:".$credit["old"] . " and new one is:". $credit["new"];
       }
       return view('step5', compact('msg')); 
    }

}

// <?php
	
// 	interface HandlerInterface{

// 		public function  setNext(HandlerInterface $next);
// 		public function Handle($data=null);
// 		public function Next($data=null);

// 	}

// 	abstract class HandlerAbstract implements HandlerInterface
// 	{
// 		protected $next;

// 		public function  setNext(HandlerInterface $next)
// 		{
// 			$this->next=$next;

// 		}		
// 		public function Next($data=null)
// 		{
// 			if($this->next){
// 				return $this->next->Handle($data);
// 			}
// 			else
// 			echo "the end of chain".PHP_EOL;
// 		}
// 	}

// 	 class CheckIp extends HandlerAbstract
// 	 {
// 		const banned_ip=["192.168.1.1"];		
// 		public function Handle($data=null){
// 			if(in_array($data['ip'],self::banned_ip)){
// 				throw new Exception("the ip is not valid!.");
// 			}

// 			return $this->Next($data);
// 		}	
// 	 }

// 	 /**
// 	  * Summary of CheckUrl
// 	  */
// 	 class CheckUrl  extends HandlerAbstract
// 	 {
// 		protected $url;		
// 		public function Handle($data=null){
// 			if($data['url']!="/home"){
// 				throw new Exception("the url is not valid!.");
// 			}
// 			return $this->Next($data);
// 		}	

// 	 }

// 	 class CheckAdmin  extends HandlerAbstract
// 	 {
// 		protected $is_admin;		
// 		public function Handle($data=null){
// 			if($data['IsAdmin']!=true){
// 				throw new Exception("the user is not admin!.");
// 			}

// 			return $this->Next($data);
// 		}	

// 	 }

// 	$request=[
// 		"ip"=>"192.168.1.25",
// 		"url" => "/home",
// 		"user_id" => "159",
// 		"IsAdmin" =>true
// 	];



// 	$ip_request= new CheckIp();	
// 	$url_request= new CheckUrl();
// 	$admin_request= new CheckAdmin();

// 	$ip_request->setNext($url_request);
// 	$url_request->setNext($admin_request);

// 	$ip_request->Handle($request);
