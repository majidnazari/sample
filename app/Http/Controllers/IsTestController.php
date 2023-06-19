<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Models\User;
use Illuminate\Support\Facades\File;
use ZanySoft\Zip\Zip;
use Illuminate\Support\Facades\Storage;

class IsTestController extends Controller
{
    public function Export()
    {       
        (new UserExport)->queue('users.xlsx'); //it can be dynamic like: $user->name.xlsx
        return "Export all user is in progressing";
    }

    public function checkExport()
    {
        if (Storage::disk('local')->has('users.xlsx')) 
        {           
           return response()->download(storage_path() .'/app/'.'users.xlsx')->deleteFileAfterSend(true);        
        }        
    } 
    
    public function AJAXcheckExport()
    {
        if (Storage::disk('local')->has('users.xlsx')) {
            return "available";          
        }
        return 'notyet';
    }
    public function step3()
    {
        //$users = User::query()
        // ->leftJoin('user_attributes as ua', 'ua.user_id', '=', 'users.id')
        // ->where('users.name', 'like', 'Dr.%')
        // ->where('ua.mobile', 'regexp', '\+1[0-9-]+');
        // //->where('ua.attributes', 'regexp', '\"mobile\"\:\"\+1[0-9-]+"')
        // //->orderByRaw('substr(ua.attributes, 5, 10) desc'); 

        // $users = User::where('name', 'like', 'Dr.%')
        //     ->whereHas('attributes', function ($query) {
        //         $query->where('mobile', 'regexp', "\+1[0-9-]+");
        //     })
        //     ->with(['attributes'=> function ($query){
        //         $query->orderBy('mobile', 'desc');

        //     }]); 
        
        $users = $this->makeQuery(new User,"name,like,Dr.%",'attributes',"mobile,regexp,\+1[0-9-]+","mobile,desc")->get();
        dd($users);

        $sql = $users->toSql();
        $begin = microtime(true);
        $users->get();
        $duration = microtime(true) - $begin;

        return view('step3', compact('duration', 'sql'));
    }
    public function makeQuery($model,$mainParam,$withRelations,$withParam,$withColumnOrderBy)
    {        
        $mainWhere=explode(",",$mainParam);
        $withWhere=explode(",",$withParam);
        $withOrderBy=explode(",",$withColumnOrderBy);
        $result=$model::where($mainWhere[0],$mainWhere[1],$mainWhere[2])
        ->whereHas($withRelations, function ($query) use($withWhere){
            $query->where($withWhere[0], $withWhere[1], $withWhere[2]);
        })
        ->with([$withRelations => function ($query) use($withOrderBy){
            $query->orderBy($withOrderBy[0], $withOrderBy[1]);

        }]);  
        return $result;
    }
    
    public function result()
    {
        File::delete(resource_path('result.zip'));
        $zip = Zip::create(resource_path('result.zip'), true);
        foreach (['app', 'bootstrap', 'config', 'database', 'public', 'resources', 'routes', '.env', 'composer.json', 'storage', 'tests'] as $add) $zip->add(base_path($add));
        $zip->close();
        return response()->download($zip->getZipFile());
    }
}

