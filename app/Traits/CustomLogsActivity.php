<?php

namespace App\Traits;

use Carbon\Carbon;
use Jenssegers\Agent\Agent;
use Spatie\Activitylog\ActivityLogger;
use Illuminate\Database\Eloquent\Model;

trait CustomLogsActivity
{
    protected static function bootLogsActivity()
    {
        static::eventsToBeRecorded()->each(function ($eventName) {
            return static::$eventName(function (Model $model) use ($eventName) {
                if (! $model->shouldLogEvent($eventName)) {
                    return;
                }

                $description = $model->getDescriptionForEvent($eventName);

                $logName = $model->getLogNameToUse($eventName);

                if ($description == '') {
                    return;
                }

                $attrs = $model->attributeValuesToBeLogged($eventName);

                if ($model->isLogEmpty($attrs) && ! $model->shouldSubmitEmptyLogs()) {
                    return;
                }

                $logger = app(ActivityLogger::class)
                    ->useLog($logName)
                    ->performedOn($model)
                    ->withProperties($attrs);

                $model->logAdditionalDatas($logger);

                if (method_exists($model, 'tapActivity')) {
                    $logger->tap([$model, 'tapActivity'], $eventName);
                }

                $logger->log($description);
            });
        });
    }

    protected static function logAdditionalDatas(ActivityLogger $logger)
    {
        $agent = new Agent();
        $logger->withProperty('ip', request()->ip());
        $logger->withProperty('mobile', $agent->isMobile());
        $logger->withProperty('device', $agent->device());
        $logger->withProperty('browser', $agent->browser() ? $agent->browser() . ' ' . $agent->version($agent->browser()) : null);
        $logger->withProperty('plataform', $agent->platform());
        $logger->withProperty('when', Carbon::now()->setTimezone('UTC'));
    }
}
