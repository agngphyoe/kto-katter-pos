<?php

namespace App\Actions;

use App\Events\ActivityLogNotification;
use App\Models\ActivityLog;
use App\Models\User;

class StoreActivityLog
{
    public static function store($model, string $title, string $activity)
    {

        $log            = new ActivityLog();

        $log->createable_type = get_class(auth()->user());
        $log->createable_id = auth()->user()?->id;
        $log->title     = $title;
        $log->activity  = $activity;
        // $log->company_id = auth()->user()->company_id;

        $model->activityLogs()->save($log);

        self::sendNotiToOtherAdmin($log);

        return $log;
    }

    public static function sendNotiToOtherAdmin(ActivityLog $log)
    {

        User::where('id', '!=', auth()->user()?->id)->increment('noti_unread_count');

        broadcast(new ActivityLogNotification($log))->toOthers();
    }
}
