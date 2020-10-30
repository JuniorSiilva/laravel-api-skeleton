<?php

namespace App\Models;

use App\Traits\CustomLogsActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use LogsActivity, CustomLogsActivity {
        CustomLogsActivity::bootLogsActivity insteadof LogsActivity;
    }

    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;
}
