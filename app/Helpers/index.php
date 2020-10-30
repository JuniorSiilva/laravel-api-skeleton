<?php

use App\Services\Contracts\AuthServiceContract;

if (! function_exists('current_user_id')) {
    function current_user_id()
    {
        return app(AuthServiceContract::class)->authenticatedUserId();
    }
}
