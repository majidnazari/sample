<?php

namespace App\Http\Controllers;

use App\Models\User_Attributes;
use Illuminate\Http\Request;

class UserAttributesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User_Attributes::select('id','user_id','age','mobile');
            //dd( $data);
            return \DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                           $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('step4');
    }
}
