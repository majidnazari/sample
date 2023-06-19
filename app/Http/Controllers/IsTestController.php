<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Models\User;
use Illuminate\Support\Facades\File;
use ZanySoft\Zip\Zip;
use Illuminate\Support\Facades\Storage;

class IsTestController extends Controller
{
    /**
     * Summary of Export: this is export all of user into excel file
     * @return string
     */
    public function Export()
    {
        (new UserExport)->queue('users.xlsx'); //it can be dynamic like: $user->name.xlsx
        return "Export all user is in progressing";
    }

    /**
     * Summary of checkExport :check if  the file exist download then delete it
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function checkExport()
    {
        if (Storage::disk('local')->has('users.xlsx')) 
        {
            return response()->download(storage_path() . '/app/' . 'users.xlsx')->deleteFileAfterSend(true);
        }
        return null;
    }

    /**
     * Summary of AJAXcheckExport:check from client side when excek file created.
     * @return string
     */
    public function AJAXcheckExport() 
    {
        if (Storage::disk('local')->has('users.xlsx')) {
            return "available";
        }
        return 'notyet';
    }
    /**
     * Summary of step3
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
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

        $users = $this->makeQueryBuilder(new User, "name,like,Dr.%", 'attributes', "mobile,regexp,\+1[0-9-]+", "mobile,desc");
       
        $sql = $users->toSql();

        $begin = microtime(true);
        $users->get();
        $duration = microtime(true) - $begin;

        return view('step3', compact('duration', 'sql'));
    }
    /**
     * Summary of makeQuery
     * @param mixed $model //model name like User::all()
     * @param mixed $mainParam //all parameter for main model
     * @param mixed $withRelations // all parameter from relationed model
     * @param mixed $withParam //model relationed that bring to with() laravel orm
     * @param mixed $withColumnOrderBy //codition of order by 
     * @return mixed
     */
    public function makeQueryBuilder($model, $mainParam, $withRelations, $withParam, $withColumnOrderBy)
    {
        $mainWhere = explode(",", $mainParam); 
        $withWhere = explode(",", $withParam); 
        $withOrderBy = explode(",", $withColumnOrderBy); 
        $result = $model::where($mainWhere[0], $mainWhere[1], $mainWhere[2])
            ->whereHas($withRelations, function ($query) use ($withWhere) {
                $query->where($withWhere[0], $withWhere[1], $withWhere[2]);
            })
            ->with([
                $withRelations => function ($withquery) use ($withOrderBy) {
                    $withquery->orderBy($withOrderBy[0], $withOrderBy[1]);

                }
            ]);
        return $result;
    }

    /**
     * Summary of result:after all steps in gathering all of folder and download it.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function result()
    {
        File::delete(resource_path('result.zip'));
        $zip = Zip::create(resource_path('result.zip'), true);
        foreach (['app', 'bootstrap', 'config', 'database', 'public', 'resources', 'routes', '.env', 'composer.json', 'storage', 'tests'] as $add)
            $zip->add(base_path($add));
        $zip->close();
        return response()->download($zip->getZipFile());
    }
}