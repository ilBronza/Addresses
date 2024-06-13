<?php

namespace IlBronza\Addresses\Models;

use IlBronza\CRUD\Models\SluggableBaseModel;
use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;

class City extends SluggableBaseModel
{
    use PackagedModelsTrait;

    static $packageConfigPrefix = 'addresses';
    static $modelConfigPrefix = 'city';

    static $deletingRelationships = [];

    public function scopeByZipcode($query, string $zipcode)
    {
        return $query->where('zip', $zipcode);
    }
}