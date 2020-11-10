<?php

namespace App\Models;

use Jenssegers\Agent\Agent;
use App\Traits\PrimaryKeyUuid;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as Eloquent;

abstract class Model extends Eloquent
{
    use PrimaryKeyUuid, SoftDeletes, LogsActivity;

    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;

    protected static $logAttributesToIgnore = ['created_at', 'updated_at', 'deleted_at'];

    public function tapActivity(ActivityLog $activity, string $eventName)
    {
        $agent = new Agent();

        $activity->setProperty('ip', request()->ip());
        $activity->setProperty('mobile', $agent->isMobile());
        $activity->setProperty('device', $agent->device());
        $activity->setProperty('browser', $agent->browser() ? $agent->browser() . ' ' . $agent->version($agent->browser()) : null);
        $activity->setProperty('plataform', $agent->platform());
    }

    public function getClass(): string
    {
        return __CLASS__;
    }
}
