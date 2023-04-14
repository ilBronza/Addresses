<?php

namespace IlBronza\Addresses\Models;

use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends BaseModel
{
	use CRUDUseUuidTrait;

	public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}