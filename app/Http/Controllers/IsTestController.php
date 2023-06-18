<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Models\User;
use Illuminate\Support\Facades\File;
use ZanySoft\Zip\Zip;
use Illuminate\Support\Facades\Storage;

class IsTestController extends Controller
{
    public function startExport()
    {
        (new InvoicesExport)->queue('invoices.xlsx');
        return "Export all user in here";
    }

    public function checkExport()
    {
        if (Storage::disk('local')->has('invoices.xlsx')) {
            return Storage::disk('local')->download('invoices.xlsx');
        }
        return 'ongoing';
    }

    public function step3()
    {
        //$users = User::query()
        // ->leftJoin('user_attributes as ua', 'ua.user_id', '=', 'users.id')
        // ->where('users.name', 'like', 'Dr.%')
        // ->where('ua.mobile', 'regexp', '\+1[0-9-]+');
        // //->where('ua.attributes', 'regexp', '\"mobile\"\:\"\+1[0-9-]+"')
        // //->orderByRaw('substr(ua.attributes, 5, 10) desc');
        // dd($users->count());


        $users = User::where('name', 'like', 'Dr.%')
            ->whereHas('attributes', function ($query) {
                $query->where('mobile', 'regexp', "\+1[0-9-]+");
            })
            ->with('attributes');
        //dd( $users->count());
        // ->leftJoin('user_attributes as ua', 'ua.user_id', '=', 'users.id')
        // ->where('users.name', 'like', 'Dr.%')
        // ->where('ua.attributes', 'regexp', '\"mobile\"\:\"\+1[0-9-]+"')
        // ->orderByRaw('substr(ua.attributes, 5, 10) desc');


        $sql = $users->toSql();

        $begin = microtime(true);
        $users->get();
        $duration = microtime(true) - $begin;

        return view('step3', compact('duration', 'sql'));
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
