<?php

namespace App\Events;

use App\Models\ActivityLog;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActivityLogNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $log, $user_id, $user_name;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ActivityLog $log)
    {
        $this->log = $log;
        $this->user_id = $log->createable?->id;
        $this->user_name = $log->createable?->name;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {

        $channel_name = config('app.env') === 'production' ? 'activity-log' : 'activity-log-dev';

        return [$channel_name];
    }

    public function broadcastAs()
    {
        return 'create';
    }
}
