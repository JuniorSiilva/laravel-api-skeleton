<?php

namespace App\Models;

use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Activity
{
    public function setProperty(string $key, $value)
    {
        $this->properties = $this->properties->put($key, $value);
    }
}
