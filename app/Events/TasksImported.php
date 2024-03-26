<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TasksImported implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    public $new, $resubmission, $date, $message;

    public function __construct($new, $resubmission, $date)
    {
        $this->date = $date;
        $this->new = $new;
        $this->resubmission = $resubmission;
        $this->message = "Daily tasks updated for ".$date.". With ".$new.($new > 1 ? " new submissions" : " new submission")." and ".$resubmission. " resubmissions.";
    }

    public function broadcastOn()
    {
        return ['tasks-imported'];
    }

    public function broadcastAs()
    {
        return 'tasks-imported';
    }
}
