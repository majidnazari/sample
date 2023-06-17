<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_Attributes;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserAttributesController extends Controller
{
    public function index(Request $request)
    {       
        if ($request->ajax()) {   
            
                        //$data = User::select('id','name','email');
           $data = User_Attributes::with('user'); 
            // return \Yajra\DataTables\DataTables::eloquent( $data)
            // ->addColumn('attributes', function (User $user) {
            //      //return $user->attributes;
            // })
            // ->make(true);           
            return \Yajra\DataTables\DataTables::of($data)
                    ->addIndexColumn()
                    // ->addColumn('action', function($row){
     
                    //        $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
    
                    //         return $btn;
                    // })
                    // ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('step4');
    }
}
