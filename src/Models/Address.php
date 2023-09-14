<?php

namespace IlBronza\Addresses\Models;

use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends BaseModel
{
	use CRUDUseUuidTrait;

    static $deletingRelationships = [];

    protected static function boot()
    {
       parent::boot();

       static::creating(function ($model) {
            $model->type = config('addresses.default_type');
        });
    }

	public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}