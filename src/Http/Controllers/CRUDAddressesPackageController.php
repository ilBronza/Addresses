<?php

namespace IlBronza\Addresses\Http\Controllers;

use IlBronza\CRUD\CRUD;

class CRUDAddressesPackageController extends CRUD
{
    public function getRouteBaseNamePrefix() : ? string
    {
        return config('addresses.routePrefix');
    }

    public function setModelClass()
    {
        $this->modelClass = config("addresses.models.{$this->configModelClassName}.class");
    }
}
