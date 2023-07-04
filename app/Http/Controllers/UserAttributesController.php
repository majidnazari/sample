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

