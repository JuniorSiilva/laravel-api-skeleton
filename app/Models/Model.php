<?php

namespace App\Models;

use App\Traits\PrimaryKeyUuid;
use App\Traits\CustomLogsActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as Eloquent;

abstract class Model extends Eloquent
{
    use PrimaryKeyUuid, SoftDeletes, LogsActivity, CustomLogsActivity {
        CustomLogsActivity::bootLogsActivity insteadof LogsActivity;
    }

    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;

    public function getClass(): string
    {
        return __CLASS__;
    }
}
