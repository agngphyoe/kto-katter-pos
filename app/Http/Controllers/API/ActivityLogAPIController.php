<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityLogCollection;
use App\Actions\HandlerResponse;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ActivityLogAPIController extends Controller
{
    use HandlerResponse;
    //
    public function index(Request $request)
    {
        //$activities = ActivityLog::where('createable_id', auth()->user()->id)->orderByDesc('created_at');
        $activities = User::find(auth()->user()->id)->activityLogs()->where(function ($query) use ($request) {
            if ($request->has('category')) {
                $query->where('title', 'like', '%' . $request->category . '%')->where(function ($query) use ($request) {
                    if ($request->has('filter')) {
                        $columns = Schema::getColumnListing('activity_logs');
                        foreach ($columns as $column) {
                            $query->orWhere($column, 'LIKE', '%' . $request->filter . '%');
                        }
                    }
                });
            } else if ($request->has('filter')) {
                $columns = Schema::getColumnListing('activity_logs');
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', '%' . $request->filter . '%');
                }
            }
        });

        return $this->responseCollection(data: new ActivityLogCollection($activities->paginate(10)));
    }
}
