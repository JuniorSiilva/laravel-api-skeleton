<?php

namespace App\Models;

use App\Traits\CustomLogsActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use LogsActivity, CustomLogsActivity {
        CustomLogsActivity::bootLogsActivity insteadof LogsActivity;
    }

    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;
}
