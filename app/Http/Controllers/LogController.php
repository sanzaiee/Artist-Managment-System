<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class LogController extends BaseController
{
    public function activityLog()
    {
        $this->authorize('viewAny',Artist::class);

        $logs = Activity::latest()->paginate(10);
        return view('log.index',compact('logs'));
    }

    public function activityLogDestroy()
    {
        $this->authorize('viewAny',Artist::class);
        DB::table('activity_log')->delete();
        return back()->with('success','Deleted activity log successfully');
    }

}
