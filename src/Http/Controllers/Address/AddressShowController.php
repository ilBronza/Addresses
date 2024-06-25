<?php

namespace IlBronza\Addresses\Http\Controllers\Address;

use IlBronza\CRUD\Traits\CRUDRelationshipTrait;
use IlBronza\CRUD\Traits\CRUDShowTrait;

class AddressShowController extends AddressCRUD
{
    use CRUDShowTrait;
    use CRUDRelationshipTrait;

    public $allowedMethods = ['show'];

    public function getGenericParametersFile() : ? string
    {
        return config('addresses.models.address.parametersFiles.show');
    }

    public function getRelationshipsManagerClass()
    {
        return config("addresses.models.{$this->configModelClassName}.relationshipsManagerClasses.show");
    }

    public function show(string $address)
    {
        $address = $this->findModel($address);

        return $this->_show($address);
    }
}
