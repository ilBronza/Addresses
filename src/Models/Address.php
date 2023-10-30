<?php

namespace IlBronza\Addresses\Models;

use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends BaseModel
{
    use PackagedModelsTrait;
	use CRUDUseUuidTrait;

    static $packageConfigPrefix = 'addresses';
    static $modelConfigPrefix = 'address';

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