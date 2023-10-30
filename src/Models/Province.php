<?php

namespace IlBronza\Addresses\Models;

use IlBronza\CRUD\Models\SluggableBaseModel;
use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;

class Province extends SluggableBaseModel
{
    use PackagedModelsTrait;

    static $packageConfigPrefix = 'addresses';
    static $modelConfigPrefix = 'province';

    static $deletingRelationships = [];

}