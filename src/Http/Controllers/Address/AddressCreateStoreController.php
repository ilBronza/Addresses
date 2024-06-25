<?php

namespace IlBronza\Addresses\Http\Controllers\Address;

use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;
use IlBronza\CRUD\Traits\CRUDRelationshipTrait;
// use IlBronza\CRUD\Traits\CRUDShowTrait;

class AddressCreateStoreController extends AddressCRUD
{
    use CRUDCreateStoreTrait;
    // use CRUDShowTrait;
    use CRUDRelationshipTrait;

    public $allowedMethods = [
        'create',
        'store',
        // 'edit',
        // 'update',
        // 'show'
    ];

    public function getGenericParametersFile() : ? string
    {
        return config('addresses.models.address.parametersFiles.create');
    }

    // public function getRelationshipsManagerClass()
    // {
    //     return config("addresses.models.{$this->configModelClassName}.relationshipsManagerClasses.show");
    // }

    // public function show(string $address)
    // {
    //     $address = $this->findModel($address);

    //     return $this->_show($address);
    // }
}
