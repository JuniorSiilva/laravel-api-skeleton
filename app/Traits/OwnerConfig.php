<?php

namespace App\Traits;

use App\Models\User;
use App\Scopes\FilterFromOwner;
use Illuminate\Database\Eloquent\Model;

trait OwnerConfig
{
    protected $ownerKey = 'owner_id';

    public static function bootOwnerConfig()
    {
        static::addGlobalScope(new FilterFromOwner);

        static::creating(function (Model $model) {
            $model->owner()->associate(current_user_id());
        });
    }

    public function owner()
    {
        return $this->belongsTo(User::class, $this->ownerKey);
    }

    public function getOwnerId()
    {
        return $this->{$this->ownerKey};
    }

    public function getOwnerKey()
    {
        return $this->ownerKey;
    }
}
